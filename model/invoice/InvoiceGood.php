<?

class InvoiceGood extends dmModel {
    static function GetTableName() {
        return 'invoice_goods';
    }

    static function IsInitEntry( $entry ) {
        return !($entry['level'] == '+' or $entry['score'] == '-');
    }

    static private function fetchTimeMatches2( $company, $period_mon) {
        try {

            $where = '';
            $sql = "SELECT
                        t.project_id as project,
                        t.customer_id as customer,
                        t.tid as tid,
                        t.description as task,
                        SUM(t.quantity) as hours,
                        substring(t.period,1,7) as period_day
                    FROM time_entry AS t
                    WHERE 
                        t.company_id = :company AND 
                        t.period LIKE :period AND
                        t.project_id IS NOT NULL AND
                        t.description IS NOT NULL
                        {$where}
                    GROUP BY customer,project,tid,task,period_day
                    ";

            $params = [
                'company' => $company['id'],
                'period' => '%'.$period_mon.'%'
            ];

            $data = DataBase::ExecuteQuery($sql, 'array', $params); //$DBSQL->fetchAll();


        } catch(Exception $e) {
            $data = $e->getMessage();
            dd('Time = ',$data);
        }

        return $data;
    }
    static private function fetchGoodsToCheck2( $company, $period_mon) {
        $where = '';
        try {
            $sql = "SELECT
                    substring(t.period,1,7) as period_day,
                    t.tid as tid,
                    t.task as task,
                    t.customer_id as customer,
                    t.project_id as project,
                    SUM(IF(i.status = 'submitted', t.quantity, 0)) as submitted,
                    SUM(t.quantityplan) as init_hours,
                    SUM(t.quantity) as hours
                FROM invoice_goods AS t
                LEFT JOIN invoice AS i ON t.invoice_id = i.id
                WHERE 
                    t.company_id = :company and 
                    (t.level <> '+' or t.level IS NULL) and 
                    t.period LIKE :period AND
                    t.task IS NOT NULL
                    {$where}
                GROUP BY customer,project,tid,task,period_day
                ";

            $params = [
                'company' => $company['id'],
                'period' => '%'.$period_mon.'%'
            ];

            $data = DataBase::ExecuteQuery($sql, 'array', $params); //$DBSQL->fetchAll();

        } catch(Exception $e) {
            $data = $e->getMessage();
            dd('Goods = ',$data);
        }
        return $data;
    }

    static function doTimeInvoiceMatch(
        $company,
        string $period
    ) {
        $target = [];
        $debug = '';
        try {
            $period = substr( $period, 0, 7); // yyyy-mm // Month

            $timeRollUp = self::fetchTimeMatches2($company, $period);
// dd($timeRollUp);

            $goods = self::fetchGoodsToCheck2($company, $period);
            
            $debug = '<br>timeRollUp =' . count($timeRollUp);
            $debug .= '<br>goods =' . count($goods);
            
            $lenGoods = count($goods);
            
            foreach($timeRollUp as $item) {

                $ifound = null;
                for($i = 0; $i < $lenGoods; ++ $i) {
                    try {
                        $good = $goods[$i];
                        if (!$good) continue;
                        if(
                            // $good['customer'] == $item['customer'] and 
                            $good['period_day'] == $item['period_day'] and 
                            $good['task'] == $item['task'] and 
                            $good['project'] == $item['project'] 
                            // and $good['user'] == $item['user'] 
                        )
                        {
                            $ifound = $i;
                            $goods[$ifound] = null;
                            $mssg = "";
                            $tid = $item['tid'];
                            $h0 = roundEx($item['hours'],2);
                            $h1 = roundEx($good['init_hours'],2); // quantityplan
                            $h2 = roundEx($good['hours'],2);
                            $submitted = roundEx($good['submitted'],2);
                            $delta1 = abs($h0 - $h1);
                            $delta2 = abs($h0 - $h2);
                            if($delta1 > 0.25 or $delta2 > 0.25) {
                                $target[] = [
                                    'customer' => $good['customer'],
                                    'project' => $good['project'],
                                    'task' => $good['task'],
                                    'hours0' => $h0,
                                    'hours1' => $h1,
                                    'hours2' => $h2,
                                    'delta1' => $h0 - $h1,
                                    'delta2' => $h0 - $h2,
                                    'submitted' => $submitted
                                ];
                            }    
                            break;
                        }
                    } catch(Exception $qe) {
                        $debug .= '<br>Loop-ext :' . $qe->getMessage() . '<br> i=' . $i; 
                    }
                }

// $debug .= '<br>Step 1';
                if($ifound === null) {
                    $h0 = roundEx($item['hours'],2);
                    $target[] = [
                        'customer' => $item['customer'],
                        'project' => $item['project'],
                        'task' => $item['task'],
                        'hours0' => $h0,
                        'hours1' => 0,
                        'hours2' => 0,
                        'delta1' => $h0,
                        'delta2' => $h0,
                        'submitted' => 0
                    ];
// $debug .= '<br>Step 2 ('.count($goods). ") {$ifound}";
// $debug .= '<br>Step 3 ('.count($goods). ") {$ifound}";
                }
// $debug .= '<br>Step 4 ('.count($goods). ") {$ifound}";
            }
            
            foreach($goods as $good) {
                if($good) {
                    $h1 = roundEx($good['init_hours'],2); // quantityplan
                    $h2 = roundEx($good['hours'],2);
                    $submitted = roundEx($good['submitted'],2);
                    $target[] = [
                        'customer' => $good['customer'],
                        'project' => $good['project'],
                        'task' => $good['task'],
                        'hours0' => 0,
                        'hours1' => $h1,
                        'hours2' => $h2,
                        'delta1' => -$h1,
                        'delta2' => -$h2,
                        'submitted' => $submitted
                    ];
                }
            }

            if($target) {
                for ($i = 0; $i < count($target); $i++) {
                    $entry = $target[$i];
                    if($entry['customer']) {
                        $client = Client::find($entry['customer']);
                        if($client)  {
                            $target[$i]['customer_name'] = $client['name'];
                        } else {
                            $target[$i]['customer_name'] = '()';
                        }
                    } else {
                        $target[$i]['customer_name'] = '()';
                    }
                }

                usort($target, function ($a, $b) {
                    if ($a['customer_name'] > $b['customer_name']) return 1;
                    if ($a['customer_name'] < $b['customer_name']) return -1;
                    return 0;
                });
        
                // dd($target);
            }
        } catch(Exception $e) {

            $text = print_r($target, true);
            $mssg = Messager::renderError("{$debug} Error: " . $e->getMessage().'<br>'. $text);
            dd($mssg);
        }
        // return new Response($mssg);
        return $target;
    }    

    // Client's dashboard, call from TimeEntryRepository TimeEntryRepository
    static function getUnpaidAllHours( $company, $customer = null, $period = null) {

        $pick_params = [];
        $pick_params['company'] = $company['id'];

        $andWhere = ''; 
        if ($customer) {
            // $pick_params['customer'] = $customer->getId();
            $andWhere = 'AND t.customer_id = '. $customer['id']; //:customer'; 
        }

        if($period) {
            [$startDate, $endDate, $say_period] = ToolKit::getPeriodParams($period);
            if($startDate) {
                $where_start = ' AND t.period >= :fstday ';
                $pick_params['fstday'] = $startDate->format('Y-m-d');
            } else {
                $where_start = '';
            }
            if($endDate) {
                $where_end = ' AND t.period <= :lstday ';
                $pick_params['lstday'] = $endDate->format('Y-m-d');
            } else {
                $where_end = '';
            }
        } else {
            $where_start = '';
            $where_end = '';
        }

        $sql = "SELECT
SUM(IF(t.invoice_id IS NULL, t.quantity, 0)) as q_not_invoiced,
SUM(IF(t.invoice_id IS NULL, 0, t.quantity)) as q_invoiced,
SUM( t.quantitylost ) as q_lost,
                    SUM(IF(i.status = 'not ready', t.quantity, 0)) as q_not_ready,
                    SUM(IF(i.status = 'not submitted', t.quantity, 0)) as q_not_submitted,
                    SUM(IF(i.status = 'submitted', t.quantity, 0)) as q_submitted,
                    SUM(IF(i.status = 'not submitted' OR i.status = 'not ready' OR t.invoice_id IS NULL, t.quantity, 0)) as q_not_paid,
                    SUM( t.quantity ) as q_all,
                    SUM( t.total ) as t_all
                FROM invoice_goods AS t
                LEFT JOIN invoice AS i ON i.id = t.invoice_id 
                WHERE t.company_id = :company 
                {$andWhere}
                {$where_start}
                {$where_end}
                AND (t.period IS NOT NULL) 
                AND (t.level <> '+' OR t.level IS NULL) 
            ";
// dump($sql);
        // $conn = $this->getEntityManager()->getConnection();
        // $DBSQL = $conn->prepare($sql);
        // $DBSQL->execute($pick_params);
        // $DBSQL->fetchAll();

        $data = Database::ExecuteQuery($sql, 'array', $pick_params); 

        return $data;
    }


    // Client's dashboard, call from TimeEntryRepository TimeEntryRepository
    static function GetAllHours( $company, $customer = null,  $period = null) {
        
        $target = self::getUnpaidAllHours( $company, $customer, $period);
    // dd($target);
        if($target) {
            $target = $target[0];

            $total = roundEx($target['q_all'],2);
            $notpaid  = roundEx($target['q_not_paid'],2);
            $invoiced_task_done = roundEx($target['q_invoiced'],2);
            $not_invoiced = roundEx($target['q_not_invoiced'],2);
            $submitted = roundEx($target['q_submitted'],2);
            $not_submitted = roundEx($target['q_not_submitted'],2);
            $not_ready = roundEx($target['q_not_ready'],2);
            $nonbillable = roundEx($target['q_lost'],2);
        } else {
            $total = 0;
            $notpaid  = 0;
            $submitted = 0;
            $not_submitted = 0;
            $not_ready = 0;
            $invoiced_task_done = 0;
            $not_invoiced = 0;
            $nonbillable = 0;
        }
        // dd($target);

        $payhours = [
['title' =>'Hours worked', 'hours' => $total, 'color'=>'grey', 'padding'=>5 ],
['title' =>'Invoiced hours', 'hours' => -$invoiced_task_done, 'color'=>'grey', 'padding'=>5 ],
['title' =>'Submitted hours', 'hours' => "($submitted)", 'color'=>'blue', 'padding'=>8 ],
['title' =>'Not submitted hours', 'hours' => "($not_submitted)", 'color'=>'blue', 'padding'=>8 ],
['title' =>'Not ready hours', 'hours' => "($not_ready)", 'color'=>'blue', 'padding'=>8 ],
['title' =>'Not invoiced hours', 'hours' => -$not_invoiced, 'color'=>'red', 'padding'=>5 ],
['title' =>'Hours to pay (not submitted + not ready + not invoiced)', 'hours' => $notpaid, 'color'=>'red', 'padding'=>5 ],
        ];     

        return $payhours;
    }

    // Client's dashboard, call from TimeEntryRepository TimeEntryRepository
    static function getInvoicedHoursMons( $company, $customer = null) {

        $pick_params = [];
        $pick_params['company'] = $company['id']; //->getId();

        $dateNow = new DateTime('first day of this month');
        $mons = 4;

        for( $i = 1; $i <= $mons; $i++ ) {
            $fstDate = 'date'.$i.'1';
            $lstDate = 'date'.$i.'2';
    
            $pick_params[$fstDate] = ToolKit::firstDayOfMonth($dateNow)->format('Y-m-d');
            $pick_params[$lstDate] = ToolKit::lastDayOfMonth($dateNow)->format('Y-m-d');

            $dateNow->modify('-1 month');
        }

        $andWhere = ''; 
        if ($customer) {
            $andWhere = 'AND i.customer_id = :customer'; 
            $pick_params['customer'] = $customer['id'];
        }

        $sql = "SELECT * FROM (
            SELECT
    SUM(IF(t.invoice_id IS NULL, t.quantity, 0)) as q_not_invoiced,
    SUM(IF(t.invoice_id IS NULL, t.total, 0)) as t_not_invoiced,

    SUM(IF(i.status = 'submitted', t.quantity, 0)) as q_submitted,
    SUM(IF(i.status = 'submitted', t.total, 0)) as t_submitted,

    SUM(IF(i.status = 'not submitted', t.quantity, 0)) as q_not_submitted,
    SUM(IF(i.status = 'not submitted', t.total, 0)) as t_not_submitted,

    SUM(IF(i.status = 'not ready', t.quantity, 0)) as q_not_ready,
    SUM(IF(i.status = 'not ready', t.total, 0)) as t_not_ready,

    SUM( t.quantitylost ) as q_lost,
    SUM( t.quantity ) as q_all,
    SUM( t.total ) as t_all,

    IF(t.period >= :date11 AND t.period <= :date12, 0,
    IF(t.period >= :date21 AND t.period <= :date22, 1,
    IF(t.period >= :date31 AND t.period <= :date32, 2,
    IF(t.period >= :date41 AND t.period <= :date42, 3, 4 )))) as mon,
    '1' as grand_row

FROM invoice_goods AS t
LEFT JOIN invoice AS i ON i.id = t.invoice_id 
WHERE t.company_id = :company {$andWhere}
AND t.period >= :date41 AND t.period <= :date12
AND (t.period IS NOT NULL) 
AND (t.level <> '+' OR t.level IS NULL) 
GROUP BY mon, grand_row WITH ROLLUP
            ) AS a WHERE grand_row IS NULL ORDER BY mon
            ";

        $data = DataBase::ExecuteQuery($sql, 'array', $pick_params);
        return $data;
    }

    static function GetProjectenTasksData( 
        $tasks, // basic tasks
        $company,
        $budget 
        ) {

        if (!$tasks) return [
            'q_not_invoiced'=>0,
            'q_submitted'=>0,
            'q_not_submitted'=>0,
            'q_lost'=>0,
            'q_not_ready'=>0,
            'q_all'=>0,
            'percent'=>0,
        ];

        $ids = '';
        foreach($tasks as $task_id) {
            $ids .= $task_id.',';
        }
        $ids = chop($ids,',');
    
        $company_id = $company->getId();

        $sql = 
        "SELECT
            SUM(IF(i.invoice_id IS NULL, i.quantity - i.quantitylost, 0)) as q_not_invoiced,

            SUM(IF(ii.status = 'submitted', i.quantity - i.quantitylost, 0)) as q_submitted,

            SUM(IF(ii.status = 'not submitted', i.quantity - i.quantitylost, 0)) as q_not_submitted,

            SUM(IF(ii.status = 'not ready', i.quantity, 0)) as q_not_ready,

            SUM( i.quantitylost ) as q_lost,
            SUM( i.quantity ) as q_all

        FROM tasks AS t
        LEFT JOIN invoice_goods AS i ON i.tid = t.tid 
        LEFT JOIN invoice AS ii ON ii.id = i.invoice_id
        WHERE t.company_id = {$company_id}
        AND (t.id IN ({$ids})) 
        AND (i.level <> '+' OR i.level IS NULL) 
        ";

// -- AND (i.invoice_id IS NULL) 

// FROM invoice_goods AS t
// LEFT JOIN invoice AS i ON i.id = t.invoice_id 
// WHERE t.company_id = :company
// AND (t.level <> '+' OR t.level IS NULL) 
// AND (t.id IN ({$ids})) 

        // $conn = $this->getEntityManager()->getConnection();
        // $DBSQL = $conn->prepare($sql);
        // $DBSQL->execute($pick_params);
        // $data = $DBSQL->fetchAll();

        $data = DataBase::ExecuteQuery($sql, "array");

        $tasks_total = $data[0];

        foreach(array_keys($tasks_total) as $key) {
            $tasks_total[$key] = roundEx($tasks_total[$key],2);
        }

        $tasks_total['percent'] = roundEx($tasks_total['q_all'] / $budget * 100, 2);

        return $tasks_total; //$data[0];
    }


// Entity    
        private $id;
        private $invoice_id;
        private $customer_id;
        private $artikul_id;
        private $project_id;
        private $user_id;
        private $company_id;
        private $position;
        private $tid;
        private $task;
        private $tasknl;
        private $quantity;
        private $quantityplan;
        private $quantitylost;
        private $price;
        private $total;
        private $start;
        private $stop;
        private $period;
        private $updated_at;
        private $status;
        private $score;
        private $level;
        private $source;
        private $import;
        private $tag;
        
        // + ------------------------- Private vars -------------- +
        private $completed;
    
        public function getCompleted(): ?int
        {
            return $this->completed;
        }
        public function setCompleted( $repoTask ): self
        {
            $task = $repoTask->findOneBy(['tid'=> $this->tid]);
            if($task) {
                $this->completed = $task->getCompleted();
            } else {
                $this->completed = false;
            }
            return $this;
        }
    
        public function getId(): ?int
        {
            return $this->id;
        }
    
        public function getInvoiceId(): ?int
        {
            return $this->invoice_id;
        }
        public function setInvoiceId(int $invoice_id): self
        {
            $this->invoice_id = $invoice_id;
            return $this;
        }
        public function getTag(): ?string
        {
            return $this->tag;
        }
        public function setTag(?string $value): self
        {
            $this->tag = $value;
            return $this;
        }
    
        public function getQuantity()
        {
            return $this->quantity;
        }
        public function setQuantity($value): self
        {
            $this->quantity = $value;
            return $this;
        }
        public function getQuantityplan()
        {
            return $this->quantityplan;
        }
        public function setQuantityplan($value): self
        {
            $this->quantityplan = $value;
            return $this;
        }
        public function getQuantitylost()
        {
            // return abs($this->quantitylost);
            return $this->quantitylost;
        }
    
        public function setQuantitylost($value): self
        {
            $this->quantitylost = $value;
            return $this;
        }
    
        public function getPrice()
        {
            return $this->price;
        }
    
        public function setPrice($price): self
        {
            $this->price = $price;
            return $this;
        }
    
        public function getTotal()
        {
            return $this->total;
        }
    
        public function setTotal($total): self
        {
            $this->total = $total;
            return $this;
        }
    
        public function getPosition(): ?int
        {
            return $this->position;
        }
    
        public function setPosition(int $position): self
        {
            $this->position = $position;
            return $this;
        }
        public function getCustomer()
        {
            return $this->customer_id;
        }
    
        public function setCustomer($customer_id): self
        {
            $this->customer_id = $customer_id;
            return $this;
        }
    
        public function getProject()
        {
            return $this->project_id;
        }
    
        public function setProject($project_id): self
        {
            $this->project_id = $project_id;
    
            return $this;
        }
    
        public function getArtikul()
        {
            return $this->artikul_id;
        }
    
        public function setArtikul($artikul): self
        {
            $this->artikul_id = $artikul;
            return $this;
        }
    
        public function getInvoice()
        {
            return $this->invoice_id;
        }
    
        public function setInvoice($invoice_id): self
        {
            $this->invoice_id = $invoice_id;
            return $this;
        }
    
        public function getTid(): ?int
        {
            return $this->tid;
        }
        public function setTid(?int $value): self
        {
            $this->tid = $value;
            return $this;
        }
        public function getTask(): ?string
        {
            return $this->task;
        }
        public function setTask(?string $value): self
        {
            $this->task = $value;
            return $this;
        }
        public function getTasknl(): ?string
        {
            return $this->tasknl;
        }
    
        public function setTasknl(?string $tasknl): self
        {
            $this->tasknl = $tasknl;
    
            return $this;
        }
    
    
        public function getPeriod(): ?string
        {
            return $this->period;
        }
        public function setPeriod(?string $value): self
        {
            $this->period = $value;
            return $this;
        }
        public function getStart(): ?string
        {
            return $this->start;
        }
        public function setStart(?string $start): self
        {
            $this->start = $start;
            return $this;
        }
    
        public function getStop(): ?string
        {
            return $this->stop;
        }
        public function setStop(?string $stop): self
        {
            $this->stop = $stop;
            return $this;
        }
        public function get_created(): ?\DateTimeInterface
        {
            return $this->updated_at;
        }
        public function getUpdated(): ?\DateTimeInterface
        {
            return $this->updated_at;
        }
        public function setUpdated(?\DateTimeInterface $value): self
        {
            $this->updated_at = $value;
            return $this;
        }
        public function getCreatedAt(): ?\DateTimeInterface
        {
            $value = InvoiceGood::getDateTimeFromString($this->start);
            return $value;
        }
        public function setCreatedAt(?\DateTimeInterface $value): self
        {
            $this->start = InvoiceGood::getStringFromDateTime($value);
            return $this;
        }
    
        public function getUpdatedAt(): ?\DateTimeInterface
        {
            // return $this->updated_at;
            $value = InvoiceGood::getDateTimeFromString($this->stop);
            return $value;
        }
        public function setUpdatedAt(?\DateTimeInterface $value): self
        {
            // $this->updated_at = $value;
            $this->stop = InvoiceGood::getStringFromDateTime($value);
            return $this;
        }
    
        public function getUser(): ?User
        {
            return $this->user_id;
        }
    
        public function setUser($value): self
        {
            $this->user_id = $value;
            return $this;
        }
    
        public function getCompany()
        {
            return $this->company_id;
        }
    
        public function setCompany($value): self
        {
            $this->company_id = $value;
            return $this;
        }
    
        public function getScore(): ?string
        {
            return $this->score;
        }
    
        public function setScore(?string $value): self
        {
            $this->score = $value;
            return $this;
        }
        public function getStatus(): ?string
        {
            return $this->status;
        }
    
        public function setStatus(?string $status): self
        {
            $this->status = $status;
    
            return $this;
        }
        public function getImport(): ?\DateTimeInterface
        {
            return $this->import;
        }
    
        public function setImport(?\DateTimeInterface $value): self
        {
            $this->import = $value;
            return $this;
        }
        public function getLevel(): ?string
        {
            return $this->level;
        }
        public function setLevel(string $value): self
        {
            $this->level = $value;
            return $this;
        }
        public function getSource(): ?string
        {
            return $this->source;
        }
        public function setSource(string $value): self
        {
            $this->source = $value;
            return $this;
        }
        public function copyFromCache( $cache ): self
        {
            $this->tid  = $cache->getTid();   // task
            $this->task = $cache->getTask();   // task
            $this->tasknl   = $cache->getTaskNl();    // translate !!
            $this->invoice_id  = $cache->getInvoice();
            $this->project_id  = $cache->getProject();
            $this->user_id     = $cache->getUser();
            $this->artikul_id  = $cache->getArtikul();
            $this->position = $cache->getPosition();
            $this->quantity = $cache->getQuantity();
            $this->quantityplan = $cache->getQuantityplan();
            $this->quantitylost = $cache->getQuantitylost();
            $this->status   = $cache->getStatus();
            $this->price    = $cache->getPrice();
            $this->total    = $cache->getTotal();
            $this->level    = $cache->getLevel();
            $this->source   = $cache->getSource();
    
            return $this;
        }

        static function roundHours(&$item): array
        {
            $hBase = floor($item['quantity']);
            $hMod = $item['quantity'] - $hBase;
            if ($hMod == 0) {
                $hMod = 0;
            } elseif ($hMod < 0.38) {
                $hMod = 0.25;
            } elseif ($hMod < 0.63) {
                $hMod = 0.50;
            } elseif ($hMod < 0.88) {
                $hMod = 0.75;
            } else {
                $hMod = 1.00;
            }
            $hBase += $hMod;
            $item['quantity'] = $hBase;
            // $this->quantityplan = $hBase;
    
            return $item;
        }
    
        static function getDateTimeFromString( $value ) {
            if(!$value) return null;
            $value = substr($value, 0, 19); // 2021-01-04T22:15:00Z+00 2020-11-03T14:09:00
            $value = str_replace('T', ' ', $value);
            return DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }
        static function getStringFromDateTime( $value ) {
            if(!$value) return '';
            $cdate = $value->format('Y-m-d H:i:s');
            $cdate = str_replace(' ','T', $cdate);
            return $cdate;
        }
}
    



