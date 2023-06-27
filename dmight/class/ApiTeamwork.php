<?php

class ApiTeamwork extends ApiService
{
    // // Define company/organization TeamworkPM URL.
    // define('TW_API_URL', 'your-company-api-url-here');
    // // Define the API Token of the user.
    // define('TW_API_TOKEN', 'your-api-token-here');

    private $user_email;
    private $projectNames; // synonyms
    private $projectTasks; // synonyms

    private $api_token_url;
    private $api_token_user;
    private $api_user_id;
    private $options;
    private $arrayWorkSpacesIds; // Projects in TW
    private $company; // Projects in TW
    private $companyId; // Projects in TW
    private $syns; // synonyms

    
    // function __construct(User $user = null, $token = "", $url = "")
    function __construct(array $credentials, array $user)
    {
        if ($credentials['token']) {
            $this->api_token_user = $credentials['token'];
        } else {
            Messager::log("No Teamwork token for user " . $user['name'] .'; id '. $user['id'], true);
            // throw new Exception("No Teamwork token for user " . $user['Name() .' id '. $user['Id() );
            $this->api_token_user = "twp_cF9aVGBaqFFTfQsloHwkBA76OLEq"; // MJ; my id = 101359
        }
        // $this->api_token_user = "twp_XfaHGH8dCp1uie9XgDP2MfJWve38"; // Dimochka

        if ($credentials['key1']) {
            $this->api_token_url = "https://{$credentials['key1']}.teamwork.com/";
        } else {
            $this->api_token_url = "https://ibl82.teamwork.com/"; // Bulat
        }

        if ($credentials['key2']) {
            $this->api_user_id = $credentials['key2'];
        } else {
            Messager::log("No Teamwork ID for user " . $user['name'] ." with token " . $this->api_token_user , true);
            // throw new Exception("No Teamwork ID for user " .$user['Name() ." with token " . $this->api_token_user);
            $this->api_user_id = 101359; //$this->getCurrentUserId(); // '222590';
        }

        if ($user) {
            $this->user_email   = $user['email']; //'bulat.baltin@gmail.com';
            // $company_id         = $user['company_id'];
            $this->company      = User::GetCompany($user);
        }

        $this->projectNames = [];
        $this->projectTasks = [];
        $this->options = [];
        $this->arrayWorkSpacesIds = ['242343', '117982', '258358', '404876']; // Business Events, Maije Jelmer 117982, Hairkapper, GPToday
        $this->companyId = '49688'; // DianSoftware

    }
    static function Factory(array $user) {

        $keys = Trackingmap::findCredentials('user', $user, 'Teamwork', $user['company_id']);
        if (empty($keys['token'])) {
            return null;
        }
        $tracking  = Trackingapp::App('Teamwork', $keys, $user);
        return $tracking;
    }

    public function checkProjects($Project, $keys)
    {
        return true;
    }
    function addOption(
        $key,
        $value
    ) {
        $this->options[$key] = $value;
        return $this->options;
    }
    /**
     * Runs a Teamwork GET Action
     * 
     * @param string $action
     * @param array $options (optional)
     * @todo Error checking!
     * @return JSON response as an associative array
     */
    private function TeamworkAction($action, $options = array(), $put_get = 'GET')
    {
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }

        // Convert options array into param list.

        $curl = curl_init();
        // Set curl options
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // NEW
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if($put_get == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->options));
            curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Content-Length: 0', 'Authorization: BASIC ' . base64_encode($this->api_token_user . ':xxx')));
            $url = $this->api_token_url . $action . '.json';
            
        } else {  // GET
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // NEW
            $params = empty($this->options) ? '' : '?' . http_build_query($this->options);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Authorization: BASIC ' . base64_encode($this->api_token_user . ':xxx')));
            $url = $this->api_token_url . $action . '.json' . $params;
            // Messager::log($url, true);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        // ----------------------------------------------------------
        //dd($url);
        // Run the HTTP request and decode the result.
        $output = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err) {
            return ['error' => 'Curl Error:' . $err ];
        }

        return json_decode($output, true);
    }
    private function TeamworkGet($action, $options = array())
    {
        return $this->TeamworkAction($action, $options, 'GET');
    }
    private function TeamworkPut($action, $options = array())
    {
        $data = $this->TeamworkAction($action, $options, 'PUT');
        // dd($data);
        return $data;

    }

    public function initOptions() {
        $this->syns = Rulestw::findBy(['company_id' => $this->company['id']]);
    }
    public function initOptionsTest($em) {
        $this->options = array_merge($this->options, ['creator-ids' => $this->api_user_id]);
        $this->syns = Rulestw::findBy(['company' => $this->company]);
    }

    public function getOptions() {
        return $this->options;
    }
    function fillTimeEntry(&$target, $entry) {

        try {
            $target['tid']      = $entry['tid'] ? $entry['tid'] : -1;
            // $target['ParentTid( $entry['parentTid'] );
            $target['sysid']    = $entry['id'];
            $target['userid']   = $entry['userId'];
            $target['pid']      = $entry['pid'] ? $entry['pid'] : -2;
            $target['wid']      = $entry['wid'] ? $entry['wid'] : -3;
            $target['billable'] = $entry['billable'];
            $target['start']    = $entry['start'];
            $target['stop']     = $entry['stop'];
            $duration = $entry['duration'];
            $target['duration'] = $duration;
            $target['quantity'] = floatval( $duration / 3600 );

            $target['projectid'] = $entry['projectId'];
            $target['projectname'] = $entry['projectName'];
        // $this->projectname   = $source->projectName;
        } catch(Exception $e) {
            $mssg = 'ApiTeamwork: fillTimeEntry<br>'.$e->getMessage();
            throw new Exception($mssg, 9002);
        }
    }

    public function getTimeEntryById($id)
    { 
        $data = $this->TeamworkGet("time_entries/{$id}");
        return $data;
    }

    public function getTimeEntriesUnixPids(
        $startTimeUnix = null,
        $pids = null,
        $cargo = null,
        $exclude_projs = null
    ) {
        try {

            if ($startTimeUnix) {

                $startDate = date( "YmdHis", $startTimeUnix);
                $options = ['updatedAfterDate' => $startDate];

            } else {
                $options = null;
            }
            if ($cargo) {
                $options = array_merge($options, $cargo);
            }
            if (!$exclude_projs) {
                $exclude_projs = ['117987']; // -> Tasks 
            }

            $data = $this->getTimeEntries($options, $exclude_projs);

        } catch(Exception $e) {
            $data = [];
            Messager::log('Teamwork error: '. $e->getMessage());
        }
        return $data;
    }
    public function getTimeEntries($options = [], $exclude_projs = [] )
    {
        $result = [];
        $options = array_merge($options, ['userId' => $this->api_user_id ]);
        for( $iPage = 1; $iPage < 10; ++$iPage ) {

            $options = array_merge($options, ['page' => $iPage]);
            $data = $this->TeamworkGet('time_entries', $options);

            if(isset($data['time-entries']) and count($data['time-entries']) > 0) {

                foreach ($data['time-entries'] as $entry) {

                    if( in_array($entry['project-id'], $exclude_projs ) ) continue;

                    // dd($entry);
/*
                    array:38 [
                        "avatarUrl" => "https://s3.amazonaws.com/TWFiles/167699/userAvatar/twia_0ec505fbc82d6b48ef2c06ecccc0d07c.png"
                        "canEdit" => true
                        "company-id" => "49688"
                        "company-name" => "ibl82"
                        "createdAt" => "2022-05-06T15:43:06Z"
                        "date" => "2022-05-06T15:13:00Z"
                        "dateUserPerspective" => "2022-05-06T11:13:00Z"
                        "description" => ""
                        "has-start-time" => "1"
                        "hours" => "1"
                        "hoursDecimal" => "1"
                        "id" => "12939736"
                        "invoiceNo" => ""
                        "invoiceStatus" => ""
                        "isbillable" => "1"
                        "isbilled" => "0"
                        "minutes" => "0"
                        "parentTaskId" => "0"
                        "parentTaskName" => ""
                        "project-id" => "117982"
                        "project-name" => "Maije Jelmer"
                        "project-status" => "active"
                        "tags" => []
                        "taskEstimatedTime" => "0"
                        "todo-item-id" => "19786548"
                        "taskIsPrivate" => "0"
                        "taskIsSubTask" => "0"
                        "todo-item-name" => "configure configurator"
                        "task-tags" => []
                        "todo-list-id" => "358531"
                        "tasklistId" => "358531"
                        "todo-list-name" => "Sptoolseurope"
                        "ticket-id" => ""
                        "updated-date" => "2022-05-06T15:43:06Z"
                        "userDeleted" => false
                        "person-first-name" => "Maije"
                        "person-id" => "101359"
                        "person-last-name" => "Jelmer"
                      ]
*/
                    // $record = new class
                    // {
                    //     public $id;
                    //     public $userId;
                    //     public $description;
                    //     public $duration;
                    //     public $minutes;
                    //     public $start;
                    //     public $stop;
                    //     public $wid;
                    //     public $projectId;
                    //     public $projectName;
                    //     public $pid;
                    //     public $tid;
                    //     public $billable;
                    // };

                    // $record->id = $entry['id'];
                    // $record->tid  = $entry['todo-item-id'];
                    // $record->description = $entry['todo-item-name'];
                    // $record->minutes = $entry['minutes'];
                    // $record->duration = $entry['minutes'] * 60;
                    // $record->start = $entry['date']; //dateCreated;
                    // $record->stop = $entry['updated-date']; //dateEdited;
                    // $record->userId  = $entry['person-id'];
                    // $record->projectName = $entry['project-name'];
                    // $record->projectId  = $entry['project-id'];
                    // $record->pid = $entry['tasklistId'];
                    // $record->wid  = $entry['person-id'];
                    // $record->billable  = $entry['isbillable'];

                    $record = [];
                    $record['id'] = $entry['id'];
                    $record['tid']  = $entry['todo-item-id'];
                    $record['description'] = $entry['todo-item-name'];
                    $record['minutes'] = $entry['hours'] * 60 + $entry['minutes'];
                    $record['duration'] = $record['minutes'] * 60;
                    $record['start'] = $entry['date']; //dateCreated;
                    $record['stop'] = $entry['updated-date']; //dateEdited;
                    $record['userId']  = $entry['person-id'];
                    $record['projectName'] = $entry['project-name'];
                    $record['projectId']  = $entry['project-id'];
                    $record['pid'] = $entry['tasklistId'];
                    
                    $record['wid']  = $entry['person-id'];
                    $record['billable']  = $entry['isbillable'];
                    // This property is 
                    // $record['parentTid']  = $entry['parentTaskId'];
                    // $record['taskIsSubTask']  = $entry['taskIsSubTask'];

                    $result[] = $record;
                }
            } else {
                break;
            }
        }
        // dd('iPage=', $iPage, count($result), $result);
        // Messager::log('iPage=' . $iPage . ' Count =' . count($result) . ' User= ' . $this->api_user_id );
        return $result;
    }
//
    function putTaskCompleteMark($taskId, $options = null) {

        // PUT /tasks/{id}/complete.json
        $data = $this->TeamworkPut("tasks/{$taskId}/complete");
        return $data;
       
    }
    function putTaskUncompleteMark($taskId, $options = null) {

        // PUT /tasks/{id}/uncomplete.json
        $data = $this->TeamworkPut("tasks/{$taskId}/uncomplete");
        return $data;
       
    }
    // Interface functions (methods) 
    // Moon river wider than a mile I'm crossing you in style some day.
    // USER : Get user data
    public function getUser($userId, $field = null)
    {
        // 222590
        $action  = 'people';
        $this->addOption('userIds', $userId);
        $data  = $this->TeamworkGet($action);

        if ($field) {
            return (isset($data->people->$field)) ? $data->people->$field : "";
        } else if (isset($data->people)) {
            return $data->people;
        }
        return $data;
    }
    // USER : Get current user data
    private function getCurrentUserId()
    {
        // 222590
        $action  = 'me';
        $data  = $this->TeamworkGet($action);
        // dump($data);
        return (isset($data['person']['id'])) ? $data['person']['id'] : "";
    }
    public function applyProjectRules(?array $projectObjs)
    {
        $result = [];
        $this->syns = Rulestw::findBy([
            'company_id' => $this->company['id'],
            'field' => 'name'
        ]);

        if (!empty($this->syns)) {
            foreach ($this->syns as $match) {
                foreach ($projectObjs as $project) {

                    if (stripos($project->project, $match['value']) !== false) {
                        $project->name = $project->project;
                    }
                    $result[$project->id] = $project;
                }
            }
        } else {
            foreach ($projectObjs as $project) {
                $result[$project->id] = $project;
            }
        }
        // dd($result);
        return $result;
    }

    public function getProjectField($projectId, $field = null)
    {
        // GET /projects/api/v2/projects/{projectId}.json
        $action = "projects/api/v3/projects/:{$projectId}";
        $data = $this->TeamworkGet($action);
        if ($field) {
            return (isset($data['project'][$field])) ? $data['project'][$field] : "";
        } else if (isset($data['project'])) {
            return $data['project'];
        }
        return $data;
    }
    public function getTaskField($taskId, $fields = null)
    {
        // $action = "task/{$taskId}"; // V1 API Bad request
        // $action = "projects/api/v3/tasks/:{$taskId}"; // V3 does not work
        // numMinutesLogged (integer)
        // numEstMins (integer)

        $action = "projects/api/v2/tasks/{$taskId}"; // V2
        $data = $this->TeamworkGet($action);
        // dump($data);
        if ($fields) {
            $result = [];
            foreach($fields as $field) {
                $result[] = isset($data['task'][$field]) ? $data['task'][$field] : ""; 
            }
            // dd($result);
            return $result;
        }
        return ['',''];
    }


    public function getCompanyUsers($options = null)
    {
        $companyId = $this->companyId;
        $data = $this->TeamworkGet("companies/{$companyId}/people", $options); // V1 API
        return $data;
    }

    public function getWorkspaceUsers($options = null)
    {
        // /companies/{id}/people.json        
        // $data = $this->TeamworkGet('people', $options);

        $result = [];
        foreach ($this->arrayWorkSpacesIds as $spaceId) {

            $data = $this->TeamworkGet("projects/{$spaceId}/people", $options);
            if ($data) {
                foreach ($data['people'] as $user) {
                    $record = new class {
                        public $id;
                        public $fullname;
                        public $email;
                    };
                    $record->id   = $user['id'];
                    $record->fullname = $user['first-name'] . " " . $user['last-name']; // $user['user-name'];
                    $record->email = $user['email-address'];

                    $result[$record->id] = $record;
                }
            }
        }

        return $result;
    }
    private function setTaskBasic( &$record, $task) {
        $record['id'] = $task['id'];
        $record['task'] = $task['content'];
        $record['parentTid'] = $task['parentTaskId'];
        $record['completed'] = $task['completed'];
        $record['numEstMins'] = $task['estimated-minutes'];
        $record['numMinutesLogged'] = 0;
        $record['start_date'] = $task['start-date'];
        $record['due_date'] = $task['due-date'];
        $record['start'] = $task['created-on'];
        $record['stop'] = $task['last-changed-on'];
        $record['creatorId'] = $task['creator-id'];

        $record['priority'] = $task['priority'];
        $record['responsible_party_id'] = isset($task['responsible-party-id']) ? $task['responsible-party-id'] : (isset($task['responsible-party-ids']) ? $task['responsible-party-ids'] : '');

        $tags = '';

// dump($task);

        if(isset($task['tags']) and is_array($task['tags'])) {
            foreach($task['tags'] as $tag) {
                $tags .= $tag['name'].'>'.$tag['id'].'>'.$tag['color'].';';
            }
        } 
        
        $record['tags'] = $tags;

        // "parent-task" => array:2 [
        //     "content" => "Archived"
        //     "id" => "19915969"
        //   ]
        if(isset($task['parent-task']) and is_array($task['parent-task'])) {
            $record['parent_task_content'] = $task['parent-task']['content'];
        } else {
            $record['parent_task_content'] = '';
        }

// dd($record);

    }

    public function getSubTasks(&$result, $tid, $options = null) {
        // tasks/{parentTaskId}/subtasks.json
        $data = $this->TeamworkGet("tasks/{$tid}/subtasks", $options);
        if($data) {
            foreach ($data['todo-items'] as $task) {
                $record = [];
                $this->setTaskBasic($record, $task);

                if($task['project-id'] == '242343') {
                    $record['projectId'] = $task['project-id'];
                    $record['projectName'] = $task['project-name'];

                } else {

                    $record['projectId'] = $task['todo-list-id'];
                    $record['projectName'] = $task['todo-list-name'];
                }
                $result[] = $record;
            }
        }
        return $result;
    }
    public function getTaskByTid($tid, $options = null)
    { 
        if(!$tid) return false;
        $data = $this->TeamworkGet("tasks/{$tid}", $options);
/*
        ApiTeamwork.php on line 514:
        array:2 [
          "STATUS" => "OK"
          "todo-item" => array:68 [
            "id" => 11498108
            "boardColumn" => array:3 [
              "id" => 80735
              "name" => "Postponed"
              "color" => "#34495E"
            ]
            "cardId" => 502594
            "canComplete" => true
            "comments-count" => 19
            "description" => """
              We have to build a login for wholesale customers with the following features:\n
              \n
              1.Business customers should login using the url vitrinemasters.com/zakelijk\n
              2.Admin should be able to create discount % per category per customer. After login wholesale customer should see normal VM price and his discount price\n
              3.Modify quotation module front end so wholesaler can style the quotation with own logo and colors. \n
              4.Wholesaler should be able to set price/discount on quotations on front end\n
              5.Instead of VM address quotation should contain address of wholesaler\n
              6.Wholesaler should be able to print the quotation and the purchase pdf(this purchase pdf should contain the discounted wholesale prices, the prices of the quotation could be higher)\n
              \n
              Please start with point 1 and 2. The other points need extra information I think.
              """
            "has-reminders" => false
            "has-unread-comments" => true
            "private" => 0
            "content" => "Wholesale part"
            "order" => 1239
            "decimalOrder" => 0
            "project-id" => 117982
            "project-name" => "Maije Jelmer"
            "todo-list-id" => 381834
            "todo-list-name" => "Vitrine Masters"
            "tasklist-private" => false
            "tasklist-isTemplate" => false
            "status" => "new"
            "company-name" => "ibl82"
            "company-id" => 49688
            "creator-id" => 101359
            "creator-firstname" => "Maije"
            "creator-lastname" => "Jelmer"
            "updater-id" => 101359
            "updater-firstname" => "Maije"
            "updater-lastname" => "Jelmer"
            "completed" => false
            "start-date" => ""
            "due-date-base" => ""
            "due-date" => ""
            "created-on" => "2018-02-21T19:57:17Z"
            "last-changed-on" => "2022-05-28T12:41:31Z"
            "position" => 1239
            "decimal-position" => 0
            "estimated-minutes" => 0
            "priority" => ""
            "progress" => 0
            "harvest-enabled" => false
            "parentTaskId" => "19915969"
            "lockdownId" => ""
            "tasklist-lockdownId" => ""
            "has-dependencies" => 2
            "has-predecessors" => 2
            "hasTickets" => false
            "tags" => array:1 [
              0 => array:4 [
                "id" => 31034
                "name" => "User Story"
                "color" => "#53c944"
                "projectId" => 0
              ]
            ]
            "timeIsLogged" => "1"
            "attachments-count" => 0
            "responsible-party-ids" => "101050"
            "responsible-party-id" => "101050"
            "responsible-party-names" => "Sergey Daniyev"
            "responsible-party-type" => "Person"
            "responsible-party-firstname" => "Sergey"
            "responsible-party-lastname" => "Daniyev"
            "responsible-party-summary" => "Sergey Daniyev"
            "predecessors" => array:1 [
              0 => array:3 [
                "id" => 13660174
                "type" => "complete"
                "name" => "Multiple groups created after changing discount"
              ]
            ]
            "attachments" => []
            "parent-task" => array:2 [
              "content" => "Archived"
              "id" => "19915969"
            ]
            "canEdit" => true
            "viewEstimatedTime" => true
            "creator-avatar-url" => "https://s3.amazonaws.com/TWFiles/167699/userAvatar/twia_0ec505fbc82d6b48ef2c06ecccc0d07c.png"
            "canLogTime" => true
            "commentFollowerSummary" => "Maije Jelmer + 1 other"
            "commentFollowerIds" => "101050,101359"
            "changeFollowerIds" => ""
            "userFollowingComments" => false
            "userFollowingChanges" => false
            "DLM" => 0
          ]
        ]
*/
        if ($data and isset($data['todo-item'])) {
            $record = [];
            $task = $data['todo-item'];
            $this->setTaskBasic($record, $task);

            if($task['project-id'] == '242343') { // What is it ?
                $record['projectId'] = $task['project-id'];
                $record['projectName'] = $task['project-name'];

            } else {

                $record['projectId'] = $task['todo-list-id'];
                $record['projectName'] = $task['todo-list-name'];
            }
            return $record;
        }
        return false;
    }

    public function getTasksWithTids($listTids) {
        $tasks = [];
        foreach($listTids as $tid) {
            if($tid['tid']) {
                $result = $this->getTaskByTid( $tid['tid'] );
                if($result) {
                    $tasks[] = $result;  
                }
            }
        }
        return $tasks;
    }
    // (2023-01-28)
    public function getTasksDueDate(string $duedate, &$msg) : array
    {
        if(!$duedate) $duedate = date('Ymd'); 

        $options = [
            'startdate' => $duedate,
            'enddate' => $duedate,
        ];
        // $msg .= '<br>'.$duedate;
        $tasks = $this->getTasks($msg, $options);
        $result = [];
        // Do not know why but it returned all future and even empty (?)
        foreach ($tasks as $task) {
            if($task['due_date'] == $duedate) {
                $result[] = $task; 
            }
        } 
        return $result;
    }
    // (2023-02-10)
    public function getTasksUpdatedFrom(string $updatedFrom, &$msg) : array
    {
        // date format = YYYYMMDDHHMMSS
        if(!$updatedFrom) $updatedFrom = date('YmdHis'); 

        $options = [
            'updatedAfterDate' => $updatedFrom,
        ];
        $tasks = $this->getTasks($msg, $options);
        return $tasks;
    }

    // (2023-01-28)
    public function getTasks(&$msg, $options = null) : array
    { 
        // Messager::log( $list );
        $result = [];
        
        foreach ($this->arrayWorkSpacesIds as $spaceId) {

            for($iPage = 1; $iPage < 5; $iPage++) {
                $options['page'] = $iPage;

                $data = $this->TeamworkGet("projects/{$spaceId}/tasks", $options);
                if ($data) {
                    if(!isset($data['todo-items']) or count($data['todo-items']) == 0) break;
                    if($spaceId == '242343') { // Business Events
                        foreach ($data['todo-items'] as $task) {
                            $record = [];
                            $this->setTaskBasic($record, $task);

                            $record['projectId'] = $task['project-id'];
                            $record['projectName'] = $task['project-name'];
                            $result[] = $record;
                            // }
                        }
        
                    } else {
                        foreach ($data['todo-items'] as $task) {
                            $record = [];
                            $this->setTaskBasic($record, $task);

                            $record['projectId'] = $task['todo-list-id'];
                            $record['projectName'] = $task['todo-list-name'];
                            $result[] = $record;
                        }
                    }
                } else {
                    $iPage = 10;
                }
            }
        }
        return $result;
    }

    // $projects = $toggl->getWorkspaceProjects();
    // PROJECTS: Get workspace projects
    public function getWorkspaceProjects($options = null)
    {
        $result = [];
        // $repoRulestw = '';
        foreach ($this->arrayWorkSpacesIds as $spaceId) {
            $tw_project = $this->getProjectField($spaceId, 'name');

            $data = $this->TeamworkGet("projects/{$spaceId}/tasklists", $options);
            if ($data) {
                foreach ($data['tasklists'] as $proj) { 
                    // taskList is a project in our system
                    // dd($proj);
                    $record = new class
                    {
                        public $id;
                        public $cid;
                        public $name;
                        public $projectId;
                        public $project;
                    };
                    $record->cid  = $this->companyId;
                    $record->id   = $proj['id'];
                    $record->name = $proj['name'];
                    $record->projectId = $proj['projectId'];
                    $record->project = $proj['projectName'];

                    $result[$record->id] = $record;
                }
            }
        }
        return $result;
    }

    public function getWorkspaces($options = null, $companyId = null)
    {

        if ($companyId) {
            $this->addOption('companyId', $companyId);
        } else {
            $this->addOption('companyId', $this->companyId);
        }

        $data = $this->TeamworkGet('projects', $options);
        return $data;
    }

    public function getUserToken()
    {
        return $this->api_token_user; // ??? Yes !!!
    }

    // ===============================

    // $projects = $toggl->getWorkspaceProjects();
    // PROJECTS: Get workspace projects
    public function getProjectsTasks($options = null)
    {
        // Tasklist
        // {
        //   "eventCreator": {
        //     "id": 1,
        //     "firstName": "John",
        //     "lastName": "Doe",
        //     "avatar": "https://www.teamwork.com/users/1/avatar.png"
        //   },
        //   "taskList": {
        //     "id": 4321,
        //     "name": "Important Tasks",
        //     "description": "Tasks that are very important",
        //     "status": "new",
        //     "milestoneId": 0,
        //     "projectId": 1234,
        //     "tags": []
        //   }
        // }
        $data = $this->TeamworkGet('tasks', $options);
        return $data;
    }

    // =========================================================
}

