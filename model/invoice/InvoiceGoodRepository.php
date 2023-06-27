<?

class InvoiceGoodRepository extends Repository {
    static function GetTableName() {
        return 'invoice_goods';
    }

    static function RemoveOldItems($invoice_id, $updated_at) {

        $sql = "SELECT * FROM invoice_goods AS i WHERE i.invoice_id = $invoice_id AND (i.updated_at <> '$updated_at' OR i.updated_at IS NULL)";

        $toRelease = DataBase::ExecuteQuery($sql, 'array');
dymp('toRelease', $toRelease);        
        if($toRelease) {
            foreach($toRelease as $item) {
                if($item['source'] == 'new' or $item['level'] == '+') { // manually added record - delete it, independent of session (!)
                    InvoiceGood::Delete($item['id']);
                } else { // Toggl or Teamwork - release it for future handling
                    $item['invoice_id']     = null;
                    $item['artikul_id']     = null;
                    $item['quantity']       = $item['quantityplan'];
                    $item['quantitylost']   = 0;
                    $item['price']          = 0;
                    $item['total']          = 0;
                    $item['updated']        = $updated_at;
                    $item['status']         = 'removed';

                    $id_item = InvoiceGood::Commit($item);
dymp('RELEASED item id', $id_item);        

                }
            }
        }
    }

    static function getLastPosition(&$invoice)
    {
        return count($invoice['rows']);
    }

    static function addNewItem(
        array &$invoice, 
        array $itemGood,
        array $customer, 
        bool $isrounded, 
        bool $keepHours 
        )
    {
        //
        // $item = new InvoiceGoods;
        // $item->copyData($itemGood); //, $invoice);
        
        // $item = $itemGood;
        // dump(empty($itemGood->getQuantityplan()), $itemGood->getQuantityplan() == 0, $itemGood->getQuantityplan());
        $customer_id = $customer['id'];
        if ($keepHours == false) {

            if($itemGood['quantityplan'] == 0) {
                $itemGood['quantityplan'] = $itemGood['quantity']; // init hours preserved, and only for 0 datum
                $itemGood['quantitylost'] = 0; // init hours preserved, and only for 0 datum
            }

            // non-billable hours    
            // $trueHours = $itemGood->getQuantity() - $itemGood->getQuantitylost();
            $trueHours = $itemGood['quantityplan'] - $itemGood['quantitylost'];
            $itemGood['quantity'] = $trueHours;
        }

        // it is rounded later
        // if ($isrounded) {
        //     $itemGood->roundHours();
        // }

        if(!isset($invoice['rows'])) $invoice['rows'] = [];
        $itemGood['position'] = self::getLastPosition($invoice) + 1;
        $itemGood['customer_id']    = $customer_id;
        $itemGood['invoice_id']     = $invoice['id'];
        
        self::prepareItemGood($itemGood, $customer);
        Invoice::addInvoiceitems($invoice, $itemGood);

        InvoiceGood::Commit($itemGood);
    }
    static function prepareItemGood(&$itemGood, $customer) {

        if(empty($customer)) return false;
        $root = substr($itemGood['tasknl'],0,10);
        if(strpos($root, ' #') !== false) return false;
        
        $prefix = '';
        if($customer['plustaskdate']) {
            $prefix = $itemGood['created_at'] .' '; //()->format('d/m/y') . ' ';
        }
        if($customer['plustaskid']) {
            $prefix .= "#". $itemGood['tid'] . ' ';
        }
        $itemGood['tasknl'] = $prefix . trim($itemGood['tasknl']);
        return true; 
    }

    static function setFixedHours(&$Items) {
        $norma = [];

        foreach ($Items as $item) {
            if (! InvoiceGood::IsInitEntry($item)) continue;
            $tid = $item['tid'];
            if($tid) {
                $quantity   = $item['quantity'];
                $fixedHours = Task::getFixedHours($tid);
                if($fixedHours) {
                    $quantity0 = self::calcTidQuantityPlan($tid, $Items);
                    // Error!!
                    if($quantity0) {
                        $coeff = $fixedHours / $quantity0;
                        $norma[$tid] = $coeff;
                    // } else {
                    //     $coeff = 1;
                    }
                }
            }
        }
        foreach ($Items as $item) {
            if (! InvoiceGood::IsInitEntry($item) ) continue;
            $tid = $item['tid'];
            if($tid and isset($norma[$tid]) and $item['quantityplan']) {
                $quantity = $item['quantityplan'] * $norma[$tid];
                $item['quantity'] = $quantity;
                $item['quantitylost'] = $item['quantityplan'] - $quantity;
                $item['status'] = 'fixed';
            }
        }
    }

    static function calcTidQuantityPlan( $tid, $Items ): float
    {
        $quantity = 0;
        foreach ( $Items as $item ) {
            if ($item['tid'] <> $tid or $item['level'] == "+" or $item['score'] == '-') continue;
            $quantity += $item['quantityplan'];
        }
        return $quantity;
    }

    static function createInvoiceGoods(
        $company, 
        $timeStamp, 
        $timeEntries = null)
    {
        //
        $position = 0;

        if(!$timeEntries) {
            $timeEntries = TimeEntry::findBy([
                'company_id' => $company['id'], 
                'import' => $timeStamp]);
        }    
        // $translator = $company['translatetask'] ? new TranslateGoogle($boss) : null;
        $translator = $company['translatetask'] ? new TranslateGoogle() : null;

        foreach ($timeEntries as $entry) { 
            $customer_id    = $entry['customer_id'];
            $project_id     = $entry['project_id'];
            $user_id        = $entry['user_id'];
            $tid            = $entry['tid'];
            $period_day     = substr($entry['period'], 0, 10); // yyyy-mm-dd
            $task           = $entry['description'];

            if (strlen($task) > 500) { // it's a task
                $task = substr($task, 0, 500);
            }

            // $item = $this->findOneBy(
            //     ['customer' => $customer, 'user' => $user, 'period' => $period_day, 'project' => $project, 'task' => $task]
            // );
            $itemsBy = InvoiceGood::findBy(
                [
                    'customer_id'   => $customer_id, 
                    'project_id'    => $project_id, 
                    'user_id'       => $user_id, 
                    'tid'           => $tid, 
                    'period'        => $period_day, 
                    // 'task'      => $task
                ]
            );
            if($itemsBy) {
                if(count($itemsBy) > 1) {
                    Messager::log('Invoice goods: Multiple records: task = ' . $task . ' #'. $tid. '; period = ' . $period_day .'; user = ' . $user_id, true);
                }
                $item = $itemsBy[0]; 
            }  else {
                $item = null; 
            }    

            if (!$item) {
                $item = InvoiceGood::GetDefault();
                $item['customer_id'] = $customer_id;
                $item['project_id'] = $project_id;
                $item['user_id']    = $user_id;
                $item['tid']        = $tid;
                $item['period']     = $period_day;
                $item['task']       = $task;
                $item['tag']        = '';
            } 
            $item['quantity'] = 0;
            $item['quantityplan'] = 0;
            $item['quantitylost'] = 0;
            
            if ($translator) {
                $tasknl = $translator->translate($task);
                if ($tasknl) {
                    $item['tasknl'] = $tasknl;
                } else {
                    $item['tasknl'] = $task;
                }
            } else if(!$item['tasknl']) {
                $item['tasknl'] = $task;
            }
            // #tasknl
            if($customer_id)
                $customer = Client::find($customer_id);
            else     
                $customer = null;

            self::prepareItemGood($item, $customer);

            $item['updated_at'] = $timeStamp;
            $item['import']     = $timeStamp;
            $item['position']   = $position;
            
            $item['source']     = $entry['source'];
            $item['level']      = '=';
            $item['score']      = '1';
            $item['company_id'] = $company['id'];
dlLog::WriteDump('Before: InvoiceGood::Commit', $item);
            InvoiceGood::Commit($item);
dlLog::WriteDump('After: InvoiceGood::Commit', $item);

        }

        $goods = InvoiceGood::findBy(['import' => $timeStamp, 'company_id' => $company['id']]);

        foreach ($goods as $item) {
            $entries = TimeEntry::findBy([
                'company_id' => $company['id'],
                'customer_id' => $item['customer_id'],                
                'project_id' => $item['project_id'],                
                'user_id' => $item['user_id'],                
                'period' => $item['period'], 
                'tid' => $item['tid'],                
                // 'description' => $item['task'],                
            ]);

            if(count($entries)) {
                $secs = 0;
                $dateStop = '';
                $dateLogged = '';
                $quantitylost = 0; // Add calculation to use billable flag
                foreach($entries as $timeEntry) {
                    $secs += $timeEntry['duration'];
                    $dateLogged = $dateLogged ? min($timeEntry['start'], $dateLogged) : $timeEntry['start'];
                    $dateStop = $dateStop ? max($timeEntry['stop'], $dateStop) : $timeEntry['stop'];
                }

                $hours = round( $secs / 3600, 3 );

                $item['start'] = $dateLogged;
                $item['stop'] = $dateStop;
                $item['quantity'] = $hours;
                $item['quantityplan'] = $hours;
                $item['quantitylost'] = $quantitylost;

                InvoiceGood::Commit($item);
            }    
        }

        return;
    }

    // static function calcSubTotal(&$result, $item,  $icashe,  $repoCache = null) {
    //     $pos = $item['level'];
    //     if ($pos !== '=') {
    //         $recs = $icashe->findBy(['level' => $pos]);
    //         $q = 0;
    //         $p = 0;
    //         $t = 0;
    //         foreach ($recs as $rec) {
    //             $q += $rec['quantity'];
    //             $p += $rec['quantityplan'];
    //             $t += $rec['total'];
    //         }
    //         $subtotal = $icashe->findOneBy(['position' => $pos]);
    //         $price = 0;
    //         if ($subtotal) {
    //             $subtotal['quantity']       = $q;
    //             $subtotal['quantityplan']   = $p;
    //             $subtotal['quantitylost']   = $p - $q;

    //             $subtotal['total'] = $t;
    //             $price = $q !== 0 ? round($t / $q, 2) : 0;
    //             $subtotal['price'] = $price;

    //             if (!$subtotal['score']) $subtotal['score'] = '+';
    //             $subtotal['changed'] = true;
    //             $icashe->update($subtotal);
    //         }
    //         $result['subtotal'] = true;
    //         $result['subtotal_total'] = $t;
    //         $result['subtotal_price'] = $price;
    //         $result['subtotal_quantity'] = $q;
    //     } else {

    //         $result['subtotal'] = false;
    //     }

    // }

    // static function saveItem(&$item)
    // {
    //     if (!$item['score']) $item['score'] = '+'; // new record $item->setScore('2')
    //     $item['changed'] = true;
    //     // itemsCache::Commit($item, null, 'idcache');
    // }


    static function mapEmptyCustomers($params)
    {
        $entries = InvoiceGood::findBy($params);
        foreach ($entries as $entry) {
            if (!$entry['customer_id']) {
                try{
                    $project = Tasklist::find($entry['project_id']);
                    if ($project) {
                        $entry['customer_id'] = $project['customer_id'];
                    } else {
                        $entry['customer_id'] = null;
                    }
                    InvoiceGood::Commit($entry, ['customer_id']);
                    // $em->persist($entry);
                    
                } catch(Exception $e) {
                    // Messager::log('Project ID ' . $entry['Project() .PHP_EOL.
                    // "tid= ". $entry['Tid() .PHP_EOL.
                    // "secs= ". $entry['Quantity().PHP_EOL.
                    // "user= ". $entry['User());

                    // $entry['Customer(null);    
                }
                // $em->persist($entry);
            }
        }
    }

    static function getInvoiceItems(array $invoice) //, ?array $formData = null )
    {
        $Items = self::getItemsFromData($invoice);
        // dd("TEST-1",$Items);

        $invoice['rows'] = $Items;

        InvoiceRepository::calcInvoiceTotals($invoice, $Items);

        return $Items;
    }

    private static function getItemsFromData(array $invoice)
    {
        $fromCache = false;
        if(isset($invoice['rows'])) {
            $rawData = $invoice['rows'];
        } else {
            $rawData = InvoiceGood::findBy([
                'invoice_id' => $invoice['id']
                ],
                null,
                [
                    'project_id'    => 'project', // left join ...
                    'user_id'       => 'user',
                    'artikul_id'    => 'products',
                ]
            );
            // dump($rawData);
        }

        $Data = [];
        foreach ($rawData as $entry) {
            if ($entry['level'] == "+" or $entry['score'] == '-') continue;
            $Data[] = $entry; // Only initial data 
        }
        $Items = [];
//  dump($Data);

        if (count($Data) > 0) {
            $Data = self::addLevels($Data);
// var_dump($Data);            
// dump($Data);

            $pos = 0; // 0..n-1
            foreach ($Data as $entry) {
                $position = $pos + 1; // 1..n
                // $record = InvoiceGood::GetDefault();
                // $record['project_name'] = '';
                // $record['user_name'] = '';
                $record = [];
                if (count($entry) > 1) { // create a subtotal record
                    CopyMerge($record, $entry[0]);
                    $record['position'] = $position; // $pos;
                    $record['level'] ='+';
                    $record['score'] = '3';
                    $record['changed'] = true;
                    $record['quantity'] = 0;
                    $record['quantityplan'] = 0;
                    $record['quantitylost'] = 0;
                    $record['total'] = 0;
                    $sub_pos = $pos;

                    foreach ($entry as $item) {
                        $pos++;
                        $position = $pos + 1;

                        $subrecord = []; //InvoiceGood::GetDefault();
                        // $subrecord['project_name'] = '';
                        // $subrecord['user_name'] = '';
                        CopyMerge($subrecord, $item);
                        // $subrecord['score'] = $item['score'];
                        if(!$fromCache) {
                            $subrecord['changed'] = false;
                        }
                        $subrecord['position'] = $position; // $pos;
                        $subrecord['level'] = "$sub_pos";
                        $subrecord['mark'] = true;

                        self::add2parent($record, $subrecord);
                        
                        $Items[] = $subrecord;
                    }
                } else {
                    // $item = $entry[0];
                    CopyMerge($record, $entry[0]);
                    // $record['score']    = $item['score'];
                    $record['level']    = '=';
                    $record['position'] = $position;
                    $record['mark']     = true;
                    if(!$fromCache) {
                        $record['changed'] = false;
                    }
                }
                $Items[] = $record;
                $pos++;
            }
        }

        usort($Items, function($a, $b){
            if($a['position'] > $b['position']) return 1;
            if($a['position'] < $b['position']) return -1;
            return 0;
        });

        // $vcache->table = [];
        // for($i = 0; $i < count($Items); $i++) {
        //     $Items[$i]['idcache'] = $i;
        //     $Items[$i]['rec_key'] = $i;
        //     $vcache->add($Items[$i]);
        // }

        return $Items;
    }
    private static function add2parent(array &$record, array &$subrecord)
    {
        $record['quantity']     = floatval( $record['quantity'] ) + floatval( $subrecord['quantity'] );
        $record['quantityplan'] = floatval( $record['quantityplan'] ) + floatval( $subrecord['quantityplan'] );
        $record['quantitylost'] = floatval( $record['quantitylost'] ) + floatval( $subrecord['quantitylost'] );
        $record['total']        = floatval( $record['total'] ) + floatval( $subrecord['total'] );
    }

    private static function addLevels($items)
    {
        $result = [];
        foreach ($items as $item) {

            // $task = $item['tid']; // en task
            $task = $item['task']; // en task
            $proj = $item['project_id'];
            $key = $proj . $task;
            if (isset($result[$key])) {
                $result[$key][] = $item;
            } else {
                $result[$key] = [$item];
            }
        }
        return $result;
    }


// =============    // 
    // Client's dashboard, call from TimeEntryRepository TimeEntryRepository
    static function getInvoicedHoursMonsDevs( 
        array $company, 
        array $developer) {

        $pick_params = [];
        $pick_params['company'] = $company['id'];

        $dateNow = new DateTime('first day of this month');
        $mons = 4;

        for( $i = 1; $i <= $mons; $i++ ) {
            $fstDate = 'date'.$i.'1';
            $lstDate = 'date'.$i.'2';
    
            $pick_params[$fstDate] = ToolKit::firstDayOfMonth($dateNow)->format('Y-m-d');
            $pick_params[$lstDate] = ToolKit::lastDayOfMonth($dateNow)->format('Y-m-d');

            $dateNow->modify('-1 month');
        }

        $andWhere = 'AND t.user_id = :developer'; 
        $pick_params['developer'] = $developer['id'];

        $sql = "SELECT
                    SUM(IF(t.invoice_id IS NULL, t.quantity - t.quantitylost, 0)) as q_not_invoiced,
                    SUM(IF(t.invoice_id IS NULL, t.total, 0)) as t_not_invoiced,

                    SUM(IF(i.status = 'submitted', t.quantity - t.quantitylost, 0)) as q_submitted,
                    SUM(IF(i.status = 'submitted', t.total, 0)) as t_submitted,

                    SUM(IF(i.status = 'not submitted', t.quantity - t.quantitylost, 0)) as q_not_submitted,
                    SUM(IF(i.status = 'not submitted', t.total, 0)) as t_not_submitted,

                    SUM(IF(i.status = 'not ready', t.quantity - t.quantitylost, 0)) as q_not_ready,
                    SUM(IF(i.status = 'not ready', t.total, 0)) as t_not_ready,

                    SUM( t.quantitylost ) as q_lost,
                    SUM( t.quantity ) as q_all,
                    SUM( t.total ) as t_all,

                    IF(t.period >= :date11 AND t.period <= :date12, 0,
                    IF(t.period >= :date21 AND t.period <= :date22, 1,
                    IF(t.period >= :date31 AND t.period <= :date32, 2,
                    IF(t.period >= :date41 AND t.period <= :date42, 3, 4 )))) as mon

                FROM invoice_goods AS t
                LEFT JOIN invoice AS i ON i.id = t.invoice_id 
                WHERE t.company_id = :company {$andWhere}
                AND t.period >= :date41 AND t.period <= :date12
                AND (t.period IS NOT NULL) 
                AND (t.level <> '+' OR t.level IS NULL) 
                GROUP BY mon WITH ROLLUP
                ";

        $data = DataBase::ExecuteQuery($sql, 'array', $pick_params);

        return $data;
    }
    // Client's dashboard, call from TimeEntryRepository TimeEntryRepository
    static function getInvoicedHoursMons( array $company, ?array $customer = null) {

        $pick_params = [];
        $pick_params['company'] = $company['id'];

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
}
