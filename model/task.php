<?

class Task extends dmModel {
    static function GetTableName() {
        return 'tasks';
    }

static function fetchNotMappedTasksData(
        $company,
        $data_form, 
        $tag_name,
        $rule_list
    ) {

        // $data_form = $request->get('open_tasks_report');
        $limit = (int) $data_form['limit'];
        $user_id = (int) $data_form['user'];
        if(! $limit) $limit = 256; //$this->default_limit;
        // $xstart = $this->GetDate3($data_form['xstart']);
        $xstart = $data_form['xstart'];

        $orderby = OpenTasksReportType::getOrderBy($data_form['orderby']);

        $isrules = $data_form['isrules'] ?? false;
        
        if($isrules) {

            $rule_list = Rulestw::findOneBy([
                'company' => $company, 
                'name' => $tag_name, 
                'field'=> $rule_list['id']]);
            if($rule_list) {
                $rules_ids = explode(',', $rule_list['value']);
            } else {
                $rules_ids = [];
            }
            $rules = OpenTasksReportType::getRulesSQL($rules_ids);
        } else {

            $rules = [];
        }

        $developer = User::find($user_id);
        $trackingid = $developer ? $developer['trackingid'] : 0;

        $Items = self::GetNotMappedTasksReportData(
            $trackingid,
            $xstart,
            $company, 
            $orderby,
            $limit 
        );

        $keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
        if($keys) {
            $site_root = $keys['key1']; //'ibl82';
        } else {
            $site_root = '';
        }

        return [ $Items, $site_root ];


    }

static function GetNotMappedTasksReportData(
        $trackingid,
        $xstart,
        $company,
        $orderby,
        $limit
    ) {

        $where = '';
        if($trackingid) {
            $where = ' AND t.trackingid LIKE \'%' . $trackingid .'%\'';
        }

        $order_by = '';
        if($orderby) {
            $order_by = ' ORDER BY ';
            foreach ($orderby as $field => $order) {
                $order_by .= $field .' '. $order . ',';
            }
            $order_by = chop($order_by,',');
        }
        $sql_limit = '';
        if((int)$limit > 0) {
            $sql_limit = ' LIMIT '. $limit;
        }

        $sql =
        "SELECT
            t.id as id,
            t.tid as tid,
            t.task as task,
            t.parent_tid as parentTid,
            t.stop as stop,
            t.tags as tags,
            t.trackingid as trackingid,
            t.priority as priority,
            t.parenttaskcontent as parenttaskcontent,
            np.name as projecten,
            MAX(tl.name) as tasklist,
            MAX(te.project_id) as project,
            MAX(te.projectid) as projectid
        FROM tasks AS t
        LEFT JOIN time_entry AS te ON te.tid = t.tid
        LEFT JOIN project AS tl ON tl.id = te.project_id
        LEFT JOIN projecten AS np ON np.id = t.projecten_id
        WHERE 
        t.company_id = :company 
        -- AND (t.project_id IS NULL OR t.projecten_id IS NULL) 
        AND (te.customer_id IS NULL) 
        AND t.stop >= :xstart
        {$where}
        GROUP BY t.id
        {$order_by}
        {$sql_limit}
        ";
// dd($sql);
        $params = [];
        $params['company'] = $company['id'];
        $params['xstart'] = $xstart;

        // $conn = $this->getEntityManager()->getConnection();
        // $DBSQL = $conn->prepare($sql);
        // $DBSQL->execute($params);
        // $Items = $DBSQL->fetchAll();

        $Items = Database::ExecuteQuery($sql, 'array', $params);


        foreach($Items as $key => $item) {
            $Items[$key]['TagsHtml'] = Task::getTagsHtml($item['tags']);  
        }

        return $Items;

    }

static function fetchOpenTasksData(
        $company,
        $data_form, 
        $tag_name,
        $rule_list
    ) {
        // $data_form = $request->get('open_tasks_report');
        $limit = (int) $data_form['limit'];
        $user_id = (int) $data_form['user'];
        if(! $limit) $limit = 256; //$this->default_limit;
        // $xstart = $this->GetDate3($data_form['xstart']);
        $xstart = $data_form['xstart'];

        $orderby = OpenTasksReportType::getOrderBy($data_form['orderby']);

        $isrules = $data_form['isrules'] ?? false;
        
        if($isrules) {

            $rule_list = Rulestw::findOneBy([
                'company' => $company, 
                'name' => $tag_name, 
                'field'=> $rule_list['id']]);
            if($rule_list) {
                $rules_ids = explode(',', $rule_list['value']);
            } else {
                $rules_ids = [];
            }
            $rules = OpenTasksReportType::getRulesSQL($rules_ids);
        } else {

            $rules = [];
        }

        $developer = User::find($user_id);
        $trackingid = $developer ? $developer['trackingid'] : 0;

        $Items = self::GetOpenTasksReportData(
            $trackingid,
            $rules,
            $xstart,
            $company, 
            $orderby,
            $limit 
        );

        $keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
        if($keys) {
            $site_root = $keys['key1']; //'ibl82';
        } else {
            $site_root = '';
        }

        return [ $Items, $site_root ];
    }

    static function GetOpenTasksReportData(
        $trackingid,
        $rules,
        $xstart,
        $company,
        $orderby,
        $limit
    ) {

        $where = '';
        if($trackingid) {
            $where = ' AND t.trackingid LIKE \'%' . $trackingid .'%\'';
        }
        if($rules) {
            foreach ($rules as $rule) {
                $where .= ' AND ' . $rule;
            }
        }

        $order_by = '';
        if($orderby) {
            $order_by = ' ORDER BY ';
            foreach ($orderby as $field => $order) {
                $order_by .= $field .' '. $order . ',';
            }
            $order_by = chop($order_by,',');
        }
        $sql_limit = '';
        if((int)$limit > 0) {
            $sql_limit = ' LIMIT '. $limit;
        }

        $sql =
        "SELECT
            t.id as id,
            t.tid as tid,
            t.task as task,
            t.parent_tid as parentTid,
            t.stop as stop,
            t.duedate as duedate,
            t.tags as tags,
            t.trackingid as trackingid,
            t.priority as priority,
            t.parenttaskcontent as parenttaskcontent
        FROM tasks AS t
        WHERE 
        t.company_id = :company AND t.completed = false AND t.stop >= :xstart
        {$where}
        {$order_by}
        {$sql_limit}
        ";
// dd($sql);
        $params = [];
        $params['company'] = $company['id'];
        $params['xstart'] = $xstart;

        // $conn = $this->getEntityManager()->getConnection();
        // $DBSQL = $conn->prepare($sql);
        // $DBSQL->execute($params);
        // $Items = $DBSQL->fetchAll();

        $Items = Database::ExecuteQuery($sql, 'array', $params);

        $today = date('Ymd');
        foreach($Items as $key => $item) {
            $Items[$key]['TagsHtml'] = Task::getTagsHtml($item['tags']);  
            if($Items[$key]['duedate']) {
                $Items[$key]['background'] = ($item['duedate'] < $today);
                $Items[$key]['duedate'] = (DateTime::createFromFormat('Ymd',$item['duedate']))->format('d/m/Y');
            } else {
                $Items[$key]['background'] = false;
            }
        }
        return $Items;
    }



    static function getFixedHours($tid) {
        $task = self::findOneBy(['tid' => $tid]);
        if($task and $task['estimated']) 
            return $task['planquantity'];
        return 0;    
    }

    static function fetchEstimatedTasks($company, $customer_id = null, $completed = 'all', $limit = 4 ) {

        $pick_params = [];
        $pick_params['company'] = $company['id'];
        
        $andWhere = '';
        if($customer_id) {
            $andWhere = 'AND t.customer_id = :customer_id';
            $pick_params['customer_id'] = $customer_id;
        }

        // if($completed == 'all')
            
        if($completed == 'completed')
            $andWhere .= ' AND t.completed = TRUE';
        elseif($completed == 'not-completed')    
            $andWhere .= ' AND t.completed = FALSE';

        $andWhere .= ' AND t.estimated = TRUE';

        $limitClause = '';
        if($limit) {
            $limitClause = " LIMIT {$limit}"; 
        }
        $sql = "SELECT
                t.id as id,
                t.planstart as planstart,
                t.planstop as planstop,
                t.planquantity as planhours,
                t.task as task,
                t.completed as completed

                FROM tasks AS t
                WHERE t.company_id = :company AND t.planquantity > 0 {$andWhere}
                ORDER BY t.planquantity DESC
                {$limitClause}
                ";

        $sql_total = "SELECT
        SUM(t.planquantity) as fixedtotal
        FROM tasks AS t
                WHERE t.company_id = :company AND t.planquantity > 0 {$andWhere}
        ";

        $data = DataBase::ExecuteQuery($sql, 'array', $pick_params);

        $total = DataBase::ExecuteQuery($sql_total, 'array', $pick_params);
        $r_total = $total[0]['fixedtotal'] ? round($total[0]['fixedtotal'],2) : 0;
        return [ $data, $r_total ];
    }
    
    static function fetchTasksByCustomer($customer_id) : array {

        $task_list = self::findBy(['customer_id'=> $customer_id]); 

        $tasks = [];
        foreach ($task_list as $task) {
            $tasks[$task['tid']] = $task['task'] . ' ('. $task['tid'] .')'; 
        }
        return $tasks;
    }

    static function GetTasksWithSubtasks($tasks, $company) : array {

        if(!$tasks) return [];
        $tids = '';
        foreach($tasks as $task) {
            $tids .= $task['id'].',';
        }
        $tids = chop($tids,',');
        $company_id = $company['id'];

        $sql = 
        "SELECT
            t0.id as t0_id,
            t1.id as t1_id,
            t2.id as t2_id
        FROM tasks AS t0
        LEFT JOIN tasks AS t1 ON t1.parent_tid = t0.tid 
        LEFT JOIN tasks AS t2 ON t2.parent_tid = t1.tid 
        WHERE t0.company_id = {$company_id}
        AND (t0.tid IN ({$tids})) 
                ";

        $data = DataBase::ExecuteQuery($sql, "array");

        $result = [];
        foreach($data as $task) {
            if($task['t0_id']) $result[$task['t0_id']] = $task['t0_id'];
            if($task['t1_id']) $result[$task['t1_id']] = $task['t1_id'];
            if($task['t2_id']) $result[$task['t2_id']] = $task['t2_id'];
        }

        return array_keys($result);
    }

// Entity ======== ]

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tid;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parentTid;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $task;

    /**
     * @ORM\Column(type="integer")
     */
    private $planduration;
    /**
     * @ORM\Column(type="integer")
     */
    private $duration;
    /**
     * @ORM\Column(type="decimal", precision=12, scale=3, nullable=true)
     */
    private $planquantity;
    /**
     * @ORM\Column(type="decimal", precision=12, scale=3, nullable=true)
     */
    private $quantity;
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $start;
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $stop;
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $startdate; // taken from Teamwork
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $duedate; // taken from Teamwork
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $planstart;
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $planstop;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userid; // creator trackingid
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $trackingid; // responsible-party-id
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wid;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $projectid;
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $projectname;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pid;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $completed;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $billable;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estimated;
    // --------------
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $source;
    /**
     * @ORM\Column(type="string", length=256)
     */
    private $priority;
    /**
     * @ORM\Column(type="string", length=256)
     */
    private $tags;
    /**
     * @ORM\Column(type="string", length=256)
     */
    private $parenttaskcontent;
    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $period;
    
    // ==============
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="timeEntries")
     */
    private $customer;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="timeEntries")
     */
    private $project;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     */
    private $company;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $import;

    /**
     * @ORM\ManyToOne(targetEntity=Projecten::class)
     */
    private $projecten;

    static function getTagsHtml($tags): ?string
    {
        $result = '';
        $tags = explode(';',$tags);
        if($tags) {
            foreach($tags as $tag) {
                $atoms = explode('>',$tag);
                if(count($atoms) > 2) {
                    $result .= '<div style="display:inline;color:white;border-radius:0.8rem;margin-right:0.2rem;padding:0.2rem 0.5rem;background-color:'.$atoms[2].';">';
                    $result .= $atoms[0] .'</div>';
                }
            }
        } else {
            $result .= 'No tags';
        }
        // $result .= '';
        return $result;
    }
    public function getTagsHtml__(): ?string
    {
        $result = '';
        $tags = explode(';',$this->tags);
        if($tags) {
            foreach($tags as $tag) {
                $atoms = explode('>',$tag);
                if(count($atoms) > 2) {
                    $result .= '<div style="display:inline;color:white;border-radius:0.8rem;margin-right:0.2rem;padding:0.2rem 0.5rem;background-color:'.$atoms[2].';">';
                    $result .= $atoms[0] .'</div>';
                }
            }
        } else {
            $result .= 'No tags';
        }
        // $result .= '';
        return $result;
    }


    public function getId(): ?int
    {
        return $this->id;
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
    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(?string $value): self
    {
        $this->task = $value;
        return $this;
    }
    public function getTags(): ?string
    {
        return $this->tags;
    }
    public function setTags(?string $value): self
    {
        $this->tags = $value;
        return $this;
    }
    public function getPriority(): ?string
    {
        return $this->priority;
    }
    public function setPriority(?string $value): self
    {
        $this->priority = $value;
        return $this;
    }
    public function getParentTaskContent(): ?string
    {
        return $this->parenttaskcontent;
    }
    public function setParentTaskContent(?string $value): self
    {
        $this->parenttaskcontent = $value;
        return $this;
    }

    public function getWid(): ?int
    {
        return $this->wid;
    }

    public function setWid(?int $wid): self
    {
        $this->wid = $wid;

        return $this;
    }

    public function getPid(): ?int
    {
        return $this->pid;
    }

    public function setPid(?int $pid): self
    {
        $this->pid = $pid;
        return $this;
    }

    public function getTid(): ?int
    {
        return $this->tid;
    }
    public function setTid(?int $tid): self
    {
        $this->tid = $tid;
        return $this;
    }
    public function getParentTid(): ?int
    {
        return $this->parentTid;
    }
    public function setParentTid(?int $tid): self
    {
        $this->parentTid = $tid;
        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $value): self
    {
        $this->completed = $value;
        return $this;
    }
    public function getBillable(): ?bool
    {
        return $this->billable;
    }

    public function setBillable(?bool $value): self
    {
        $this->billable = $value;
        return $this;
    }
    public function getEstimated(): ?bool
    {
        return $this->estimated;
    }

    public function setEstimated(?bool $value): self
    {
        $this->estimated = $value;
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
    public function getPlanstart(): ?string
    {
        return $this->planstart;
    }
    public function setPlanstart(?string $value): self
    {
        $this->planstart = $value;
        return $this;
    }

    public function getStartdate(): ?string
    {
        return $this->startdate;
    }
    public function setStartdate(?string $value): self
    {
        $this->startdate = $value;
        return $this;
    }
    public function getDuedate(): ?string
    {
        return $this->duedate;
    }
    public function setDuedate(?string $value): self
    {
        $this->duedate = $value;
        return $this;
    }

    public function getStop(): ?string
    {
        return $this->stop;
    }

    public function setStop(?string $value): self
    {
        $this->stop = $value;
        return $this;
    }
    public function getPlanstop(): ?string
    {
        return $this->planstop;
    }
    public function setPlanstop(?string $value): self
    {
        $this->planstop = $value;
        return $this;
    }
    public function getProjectname(): ?string
    {
        return $this->projectname;
    }
    public function setProjectname(?string $value): self
    {
        $this->projectname = $value;
        return $this;
    }
    public function getPeriod(): ?string
    {
        return $this->period;
    }
    public function setPeriod(?string $day): self
    {
        $this->period = $day;
        return $this;
    }
    public function getProjectid(): ?int
    {
        return $this->projectid;
    }
    public function setProjectid(int $value): self
    {
        $this->projectid = $value;
        return $this;
    }
    public function getUserid(): ?int
    {
        return $this->userid;
    }
    public function setUserid(int $value): self
    {
        $this->userid = $value;
        return $this;
    }
    public function getTrackingid(): ?string
    {
        return $this->trackingid;
    }
    public function setTrackingid(?string $value): self
    {
        $this->trackingid = $value;
        return $this;
    }
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }
    public function setQuantity(float $value): self
    {
        $this->quantity = $value;
        return $this;
    }
    public function getPlanquantity(): ?float
    {
        return $this->planquantity;
    }
    public function setPlanquantity(float $value): self
    {
        $this->planquantity = $value;
        return $this;
    }
    public function getDuration(): ?int
    {
        return $this->duration;
    }
    public function setDuration(int $value): self
    {
        $this->duration = $value;
        // $this->quantity = $value / 3600; // hours

        return $this;
    }
    public function getPlanduration(): ?int
    {
        return $this->planduration;
    }
    public function setPlanduration(int $value): self
    {
        $this->planduration = $value;
        // $this->planquantity = $value / 3600; // hours

        return $this;
    }
    public function copyData($source): self
    {
        try {
            // $this->tid      = $source->tid; // For Toggl
            // $this->sysid    = $source->id;
            $this->userid   = $source->userId;
            $this->pid      = $source->pid;
            $this->wid      = $source->wid;
            $this->billable = $source->billable;
            $this->completed = $source->completed;
            $this->estimated = $source->estimated;
            $this->start    = $source->start;
            $this->setDuration($source->duration);
            $this->stop     = $source->stop;
            // $this->projectid     = $source->projectId;
            // $this->projectname   = $source->projectName;
        } catch (Exception $e) {
            // dd($source);
        }

        return $this;
    }

    public function getCustomer(): ?Client
    {
        return $this->customer;
    }

    public function setCustomer(?Client $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
    
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

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

    public function getProjecten(): ?Projecten
    {
        return $this->projecten;
    }

    public function setProjecten(?Projecten $Projecten): self
    {
        $this->projecten = $Projecten;

        return $this;
    }
    public function __toString()
    {
        $name = $this->getTask();
        return '('.$this->getTid().') '.$name;
    }
}
