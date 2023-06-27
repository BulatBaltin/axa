<?php

class Importdata {
    static $company;
    static $boss;

    static function fetchDataQueue(array $boss, string $impList)
    {
        // $company = User::GetCompany($boss);
        // if ($company->getJobqueue()) {
        //     $qm = new QueueManager($boss, $em);
        //     $params['importList'] = $impList;
        //     $response = $qm->putJobIntoQueue('import_all_data', $params);
        // } else {

            $response = self::fetchData($boss, $impList);
        // }
        return $response;
    }

    // public function fetchData(string $impList, User $boss, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    static function fetchData(array $boss, string $impList)
    {
        self::$boss = $boss;
        self::$company = User::GetCompany($boss);

        if (!self::$company) {
            $response['return'] = 'error';
            $response['mssg'] = "Company is not defined. Action aborted; ";
            return $response;
        }
        // $company = self::$company;

        // $id_list = $request->request->get('import');
        $id_list = $impList;
        $a_list = explode(",", $id_list);

        // IT s wrong! $em = Client::getDoctrine()->getManager();

        $status = 'success';
        $mssg = Messager::renderSuccess();
        $response = ['return' => $status, 'mssg' => $mssg];

        set_time_limit(0);
    try {

        // Messager::log($id_list, true);
        foreach ($a_list as $item) {

            // Messager::log('Step=' . $item, true);
            if ($item === "1") { // Import Users
                try {
                    $response = self::userImport($response);
                } catch(Exception $e) {
                    $response['error'] = 'Step # '.$item. ' : '.$e->getMessage();
                    Messager::log( $response['error'] );
                }
            }
            if ($item === "2") { // Import Clients
                $response = self::customerImport($response);
            }
            if ($item === "3") { // Import Tasklists aka Projects
                // /** @var ProjectRepository */
                // $repo = $em->getRepository(Tasklist::class);
                $response = self::tasklistImport($response);
                // if ($io) $io->note('Done. Step: 3');
            }
            if ($item === "4") { // Import Products
                $response = self::productImport($response);
            }
            if ($item === "5") { // Import Hours
                $response = self::InvoiceGoodImport( $response);
            }
            if ($item === "6") { // Import Tasks
                $response = self::taskImport($response);
            }
            if ($item === "7") { // Create / Update Invoices
                // // <DEBUG
                // $repoInvoice = $em->getRepository(Invoice::class);
                // $company = $boss->getCompany();
                // Messager::log('Start removing...', true);
                // $repoInvoice->removeOpenInvoices( '2020-07', $company );
                // Messager::log('End removing...', true);
                // // DEBUG />
                // Messager::log('Start creating...', true);
                
                $response = InvoiceRepository::invoiceManager('auto', self::$boss, $response );

                // Messager::log('End creating...', true);
                // if ($io) $io->note('Done. Step: 5');
            }
            if ($item === "8") { // Refresh Dashboard
                // /** @var DashboardRepository */
                // $repo = $em->getRepository(Dashboard::class);
                // $response = $repo->refreshDashboard($boss, $response, false);
                // if ($io) $io->note('Done. Step: 5');
            }
        }
    } catch(Exception $e) {
        $response['error'] = 'Step # '.$item. ' : '.$e->getMessage();
        Messager::log( $response['error'] );
    }
    return $response;
    }

    static function taskImport( array $response) {

        $event = '6';
        $company = self::$company;
        $timeStamp = date('Y-m-d H:i:s');
        $trackings = CompanyRepository::getTrackinglstArr($company);
        
        if (empty($trackings)) {
            $response['return'] = 'error';
            $response['mssg' . $event] .= 'No tracking apps';
            return $response;
        }

        foreach ($trackings as $trackingName) {
            if (strtolower($trackingName) == 'teamwork') {

                $keys = Trackingmap::findCredentials('company', $company, $trackingName, $company['id']);

                if (empty($keys['token'])) {
                    continue;
                }

                try {
                    $tracking  = Trackingapp::App($trackingName, $keys, self::$boss);
                } catch (Exception $e) {

                }

                // due date duedate tasks
                $duedate    = date('Ymd');
                $mssg       = 'Due date ' . $duedate;
                $tasks      = $tracking->getTasksDueDate($duedate, $mssg);
                $startFrom  = date('Ymd000000', strtotime("-15 days")); // Yesterday
                $updatedTasks = $tracking->getTasksUpdatedFrom($startFrom, $mssg);

                $tasks = array_merge($tasks, $updatedTasks);

                foreach ($tasks as $task) {
                    self::UpdateOneTask(
                        $task, 
                        $company, 
                        $trackingName,
                        $timeStamp
                    );
                }
            }
        }
        
        return $response;
    }

    static function UpdateOneTask(
        $Taskdata, 
        $company, 
        $trackingName,
        $timeStamp 
        ) {

        $task = Task::findOneBy([
            'tid'           => $Taskdata['id'],
            'company_id'    => $company['id']
        ]);

        if (!$task) {
            $task = Task::GetDefault();
            $task['tid']        = $Taskdata['id'];
            $task['parent_tid'] = (int)$Taskdata['parentTid'];
            $task['task']       = $Taskdata['task'];
            $task['start']      = $Taskdata['start'];
            $task['estimated']  = false;
            $task['projectid']  = $Taskdata['projectId'];
            $task['projectname']= $Taskdata['projectName'];
            $task['userid']     = $Taskdata['creatorId'];

            $task['company_id'] = $company['id'];
            $task['source']     = $trackingName;
        }

        $task['import']     = $timeStamp;
        $task['priority']   = $Taskdata['priority'];
        $task['tags']       = $Taskdata['tags'];
        $task['parenttaskcontent'] = $Taskdata['parent_task_content'];
        $task['trackingid'] = $Taskdata['responsible_party_id'];

        $task['startdate']  = $Taskdata['start_date'];
        $task['duedate']    = $Taskdata['due_date'];
        $task['stop']       = $Taskdata['stop'];
        $task['completed']  = $Taskdata['completed'];
        $task['duration']   = $Taskdata['numMinutesLogged'] * 60;
        $task['quantity']   = round($Taskdata['numMinutesLogged'] / 60, 3);
        $task['planduration'] = $Taskdata['numEstMins'] * 60;
        $task['planquantity'] = round($Taskdata['numEstMins'] / 60, 3);

        $map = Trackingmap::findOneBy([
            'company_id'    => $company['id'], 
            'objecttype'    => 'project', 
            'importid'      => $task['projectid']
        ]);

        if($map) {
            $project = Tasklist::find($map['objectid']);
            $task['project_id']     = $project['id'];
            $task['customer_id']    = $project['customer_id'];
        } else {
            $project = null;
        }

        Task::Commit($task);

    }

    static function invoiceGoodImport( array $content) {
    // // Import Hours Data. Cron [+ -------------------------------------- +]

        // $val1 = sql_value(0);
        // dd($val1);

        set_time_limit(0);
        $event = '5';
        $company = self::$company;

        $trackings = CompanyRepository::getTrackinglstArr($company);

        if (empty($trackings)) {
            $response['return'] = 'error';
            $response['mssg' . $event] .= 'No tracking apps';
            return $response;
        }
        $limitDate = '2022-01-01 00:00:00'; 
        $timeStamp = date('Y-m-d H:i:s');

        foreach ($trackings as $trackingName) {
            if($trackingName !== 'Teamwork') {
                continue;
            }

            $workersList = User::findBy([
                'company_id'  => $company['id'],
                // 'id'          => 79, // Александр Мутский //BANG!!!
            ]);

            $removeTags = $company['removehtml'];

            $companyTime = Trackingmap::findOneBy([
                'company_id'    => $company['id'],
                'objecttype'    => 'company',
                'trackingname'  => $trackingName,
            ]);
            if($companyTime) {
                if($companyTime['startdate'] < $limitDate ) {
                    $companyTime['startdate'] = $limitDate;
                    $companyTime['finishdate'] = $limitDate;
                    // $companyStartUnix = $limitDate->getTimestamp();
                } else {
                    // $companyStartUnix = $companyTime->getStartdate()->getTimestamp();
                }
            }
            $projs = Trackingmap::findBy([
                'company_id' => $company['id'],
                'objecttype' => 'project',
                'trackingname' => $trackingName,
            ]);
            $pids = [];
            foreach ($projs as $proj) {
                $pid = $proj['importid'];
                if ($pid) {
                    $pids[$pid] = $pid;
                }
            }

            $rec_counter = 0;
            $messg = "";
            $missedTime = 0;
            foreach ($workersList as $worker) {

            try {
                $keys = Trackingmap::findCredentials('user', $worker, $trackingName, $company['id']);

                if (empty($keys['token'])) {
                    continue;
                }
            
                $tracking  = Trackingapp::App($trackingName, $keys, $worker);
                $tracking->initOptions();

                $trackingRec = $keys['map'];
                if ($trackingRec['startdate'] < $limitDate) {
                    $trackingRec['startdate'] = $limitDate;
                    $trackingRec['finishdate'] = $limitDate;
                }
                
                $time_progress = '';
                $timeStartUnix = max(
                    self::getStartUnix($trackingRec['startdate']), 
                    self::getStartUnix($trackingRec['finishdate']) 
                    );
                    $timeEntries = $tracking->getTimeEntriesUnixPids($timeStartUnix, $pids);

                if (!$timeEntries) {
                    continue;
                }
                
                foreach ($timeEntries as $timeEntry) {

                    if (!$timeEntry['duration'] or $timeEntry['duration'] <= 0 or !isset($timeEntry['description']) or !$timeEntry['tid']) {

                        if ($timeEntry['duration'] > 0) $missedTime += $timeEntry['duration'];

                        $messg .= $worker['name'] . ". No some of the task properties; ";

                        continue;
                    }
                    
                    $time_progress = max($time_progress, $timeEntry['stop']);
                    $period_day = substr($timeEntry['start'], 0, 10);

                    // Task mapping to data
                    $task = $timeEntry['description']; 
                    $ntask = $removeTags ? self::stripTagsHtml($task) : $task;

                    if (strlen($ntask) > 500) { // it's a task
                        $ntask = substr($ntask, 0, 500);
                    }

                    $itemsBy = TimeEntry::findBy([
                        'sysid'     => $timeEntry['id'],
                        'user_id'   => $worker['id'], 
                        'period'    => $period_day, 
                        'company_id'=> $company['id']]);


                    if($itemsBy) {

                        if(count($itemsBy) > 1) {
                            Messager::log('Time Entries: Multiple records: sysid = ' .$timeEntry['id'], true);
                        }
                        $item = $itemsBy[0]; 
                    }  else {
                        $item = null; 
                    }    

                    $rec_counter++;
                    
                    if (!$item) {
                        $item = TimeEntry::GetDefault();
                    }
                    $tracking->fillTimeEntry($item, $timeEntry);
                    $item['description']    = $ntask;
                    $item['period']         = $period_day;
                    $item['usertoken']      = $tracking->getUserToken();

                    $item['source']     = $trackingName;
                    $item['user_id']    = $worker['id'];
                    $item['import']     = $timeStamp;
                    $item['company_id'] = $company['id'];
                    // $item['customer_id'] = null;

                    self::setProjectFromTask($item, $timeEntry);
                    TimeEntry::Commit($item);
                }
                $trackingRec['Startdate'] = $trackingRec['finishdate'];
                if($time_progress) {
                    $toTime = InvoiceGood::getDateTimeFromString($time_progress);
                    $trackingRec['finishdate'] = $toTime;
                }

                Trackingmap::Commit($trackingRec);
            } catch (Exception $e) {
                Messager::log('(B)Error: ' . $e->getMessage());
                continue;
                }
            } // foreach $workersList
        }  // foreach $trackings

        try {
            self::mapEmptyProjects(['company_id' => $company['id']]);

        } catch (Exception $e) {
            $mssg = "(D)Error: " . $e->getMessage();
            Messager::log($mssg, true);
        }

        try {
            InvoiceGoodRepository::createInvoiceGoods($company, $timeStamp);

        } catch (Exception $e) {
            $mssg = "(A)Error: " . $e->getMessage();
            Messager::log($mssg, true);
        }
        try {

            InvoiceGoodRepository::mapEmptyCustomers( ['company_id' => $company['id']]);
            $note = "($rec_counter)";
            $warn = InvoiceGood::count(['customer_id' => null, 'company_id' => $company['id']]);
            if ($warn > 0) {
                $note .= "[$warn]";
            }

            if ($missedTime > 0) {
                $missedHours = round($missedTime / 60 / 60, 2);
                $mssg = $missedHours . ' hours could not be added to invoices due to No task description';
            }

        } catch (Exception $e) {
            $mssg = "(E)Error: " . $e->getMessage();
            Messager::log($mssg, true);

        }

        $content['mssg' . $event] = $note;
        $content['time' . $event] = date('d/m/Y H:i:s');
        return $content;
    }

    static function getStartUnix($str_date): ?int
    {
        return $str_date ? strtotime($str_date) : 0;
    }


    static function mapEmptyProjects( $params )
    {
        $timeEntries = TimeEntry::findBy($params);
        foreach($timeEntries as $entry) {
            if(!$entry['project_id'] or !$entry['customer_id'] ) {
                self::setProjectFromTask($entry);
                TimeEntry::Commit($entry);
            }
        }
    }
    // TimeEntry
    static function setProjectFromTask(&$item, $Task = null)
    {

        $projectMap = Trackingmap::findOneBy(['importid' => $item['pid']]); // 117982
        if($projectMap) {
            $project = Tasklist::find($projectMap['objectid']);
        } elseif($Task) {
            try {

                $projectMap = Trackingmap::findOneBy([
                    'name' => $Task['projectName'],
                    'objecttype'=>'project',
                    'company_id'=> $item['company_id']]);
                    
                    if($projectMap) {
                        $project = Tasklist::find($projectMap['objectid']);
                    } else {
                        $project = null;
                    }
                } catch(Exception $e) {
                    $project = null;
                }
        } else {
            $project = null;
        }
        
        if ($project) {
            $item['project_id']     = $project['id'];
            $item['customer_id']    = $project['customer_id'];
        } else {
            $item['project_id']     = null;
            $item['customer_id']    = null;
        }
        return ;
    }

    static function stripTagsHtml(string $stroka)
    {
        $stroka = strip_tags($stroka);
        $stroka = str_replace('http://', '', $stroka);
        $stroka = str_replace('https://', '', $stroka);
        return $stroka;
    }

    static function productImport( array $content) {
        $event = '4';
        $company = self::$company;

        if (!$company) {
            $content['return'] = 'error';
            $content['mssg' . $event] .= "Company is not defined. Action aborted; ";
            return $content;
        }

        $acc_login  = $company['accountlogin'];
        $acc_key1   = $company['accountkey1'];
        $acc_key2   = $company['accountkey2'];

        $accounting = new SOAPAccounting($acc_login, $acc_key1, $acc_key2);

        $artikel = $accounting->GetArtikelen();
        $accounting->CloseSession();

        $products = $artikel
            ->GetArtikelenResult
            ->Artikelen  // +"ErrorMsg": {#686}
            ->cArtikel; // array

        $rec_counter = 0;
        foreach ($products as $product) {
            $good = Product::findOneBy(['accountid' => intval($product->ArtikelID), 'company_id' => $company['id']]);
            if (!$good) {
                $good = Product::GetDefault();
                $good['accountid'] = $product->ArtikelID;
                $good['code'] = $product->ArtikelCode;
                $good['name'] = $product->ArtikelOmschrijving;
                $good['unit'] = $product->Eenheid;

                $good['price'] = $product->VerkoopprijsExclBTW;
                $good['pricevat'] = $product->VerkoopprijsInclBTW;
                $good['taxcode'] = $product->BTWCode;
                $good['taxrate'] = $product->BtwPercentage;
                $good['coaccount'] = $product->TegenrekeningCode;
                $good['active'] = $product->Actief;

                $good['company_id'] = $company['id'];
                $rec_counter++;
                Product::Commit($good);
            }
        }

        $note = "($rec_counter)";
        $warn = Product::count(['price' => null, 'company_id' => $company['id']]);
        if ($warn > 0) $note .= "[$warn]";
        // $log_item = Transactions::logEvent($event, 'Products refreshed', $note, $company['id']);

        $content['mssg' . $event] = $note;
        $content['time' . $event] = date('d/m/Y H:i:s'); //$log_item['logtime'];
        return $content;

    }
    static function tasklistImport( array $response, bool $customers = false)
    {
        $event = '3';
        $company = self::$company;
        $trackings = CompanyRepository::getTrackinglstArr($company);
        
        if (empty($trackings)) {
            $response['return'] = 'error';
            $response['mssg' . $event] .= 'No tracking apps';
            return $response;
        }

        foreach ($trackings as $trackingName) {
            if($trackingName !== 'Teamwork') continue;
             
            $rec_counter = 0;
            $keys = Trackingmap::findCredentials('company', $company, $trackingName, $company['id']);
            if (empty($keys['token'])) {
                continue;
            }
            try {
                $tracking       = Trackingapp::App($trackingName, $keys, self::$boss);
                $trackingApp    = Trackingapp::findOneBy(['name'=>$trackingName]);
            } catch (Exception $e) {
            }
            $projects = $tracking->getWorkspaceProjects();
            if (!$projects) {
                continue;
            }
            $projects = $tracking->applyProjectRules($projects);

            foreach ($projects as $Project) {

                if (!$tracking->checkProjects($Project, $keys)) {
                    continue;
                }
                $proj = null;
                $map_project = Trackingmap::findOneBy([
                    // 'key' => $worker->email,
                    'objecttype' => 'project',
                    'importid' => $Project->id,
                    'name' => $Project->name,
                    'company_id' => $company['id'],
                ]);

                if ($map_project) {
                    $proj = Tasklist::find($map_project['objectid']);
                }

                if (!$proj) {
                    $proj = Tasklist::findOneBy(['name' => $Project->name]);
                    if (!$proj) {
                        $proj = Tasklist::GetDefault();
                        $proj['name'] = $Project->name;
                        $proj['company_id'] = $company['id'];
                        // Ok, let it be the 1st import source
                        $proj['pid'] = $Project->id;
                        $rec_counter++;
                        Tasklist::Commit($proj);
                    }
                }
                // So, we defined project - $proj.
                if (!$map_project) {
                    $map_project = Trackingmap::GetDefault();
                    $map_project['name'] = $Project->name;
                    // key should be set manually
                    // $map_human['Key($worker['email);
                    $map_project['importid'] = $Project->id;
                    $map_project['objecttype'] = 'project';
                    $map_project['objectid'] = $proj['id'];
                    $map_project['trackingapp_id'] = $trackingApp['id'];
                    $map_project['trackingname'] = $trackingName;
                    $map_project['startdate'] = $company['startdate'];
                    $map_project['finishdate'] = date('Y-m-d H:i:s'); 
                    $map_project['company_id'] = $company['id'];
                    Trackingmap::Commit($map_project);

                }
            }
        }
        if ($customers == true) {

            InvoiceGoodRepository::mapEmptyCustomers(['company_id' => $company['id']]);
        }

        $unmapped = Tasklist::count(['customer_id' => null, 'company_id' => $company['id']]);
        $note = ($unmapped > 0) ? "($rec_counter) [$unmapped]" : "($rec_counter)";
        // $log_item = Transactions::logEvent($event, 'Projects refreshed', $note, $company['id']);

        $response['mssg' . $event] = $note;
        $response['time' . $event] = date('d/m/Y H:i:s');

        return $response;
    }
    
    static function userImport($response) {
        $event      = "1";
        $company    = self::$company;
        $boss       = self::$boss;

        $trackings = CompanyRepository::getTrackinglstArr($company);
        if (empty($trackings)) {
            $response['return'] = 'error';
            $response['mssg' . $event] .= 'No tracking apps';
            return $response;
        }

        foreach ($trackings as $trackingName) {
            try {

                $keys = Trackingmap::findCredentials('company', $company, $trackingName,$company['id']);
                $tracking  = Trackingapp::App($trackingName, $keys, $boss);
                $trackingApp  = Trackingapp::findOneBy(['name' => $trackingName]);
            } catch (Exception $e) {
                continue;
            }

            $workers = $tracking->getWorkspaceUsers();

            $rec_counter = 0;
            if ($workers) {
                foreach ($workers as $worker) {
                    try {

                        $human = User::findOneBy(['email' => $worker->email]);

                        if (!$human) {
                            $human = User::GetDefault();
                            $human['toggl_id'] = $worker->id;
                            $human['username'] = $worker->fullname;
                            $human['hash'] = '';
                            $human['name'] = $worker->fullname;
                            $human['email'] = $worker->email;
                            $human['chatemail'] = $worker->email;
                            $password = '0000';
                            // $encoded = $encoder->encodePassword($human, $password);
                            $encoded = User::encodePassword($password);
                            $human['password'] = $encoded;
                            $human['company_id'] = $company['id'];
                            $human['dailygoal'] = 0;
                            $human['sendmail'] = false;

                            Messager::log("Try to add a new user: " . $worker->email);

                            User::Commit($human);
                            $rec_counter++;
                        } else {
                            if(! User::isTrackable($human)) continue;
                        }

                        $map_human = Trackingmap::findOneBy([
                            // 'key' => $worker->email,
                            'objecttype'    => 'user',
                            'importid'      => $worker->id,
                            'trackingname'  => $trackingName,
                            'company_id'    => $company['id'],
                        ]);

                        if (!$map_human) {
                            $map_human = Trackingmap::GetDefault();
                            $map_human['name'] = $worker->fullname;
                            $map_human['importid'] = $worker->id;
                            $map_human['objecttype'] = 'user';
                            $map_human['objectid'] = $human['id'];
                            $map_human['trackingapp_id'] = $trackingApp['id'];
                            $map_human['trackingname'] = $trackingName;
                            $map_human['startdate'] = $company['startdate'];
                            $map_human['finishdate'] = $company['startdate'];
                            $map_human['company_id'] = $company['id'];

                            Trackingmap::Commit($map_human);
                        }
                    } catch(Exception $e){
                        Messager::log("Error: " . $worker->email . ' : '.$e->getMessage());
                        continue;
                    }
                }
            }

            $note = "($rec_counter)";
            // $warn = User::count(['usertoken' => null, 'company' => $company]);
            $warn = 'xxx';
            if ($warn > 0) $note .= "[$warn]";
            // $log_item = Transactions::logEvent($event, 'Users refreshed', $note, $company['id']);

        } // end big loop

        $response['mssg' . $event] = $note;
        $response['time' . $event] = date('d/m/Y H:i:s');

        return $response;
    }
    static function customerImport(array $content)
    {
        $event = '2';
        $company = self::$company;
        $note = 'Default';

        $acc_client = $company['accountparm1'];
        $acc_login  = $company['accountlogin'];
        $acc_key1   = $company['accountkey1'];
        $acc_key2   = $company['accountkey2'];
        $accounting = new SOAPAccounting($acc_login, $acc_key1, $acc_key2, $acc_client);

        $response = $accounting->getRelations();
        $accounting->CloseSession();

        $customers = $response
            ->GetRelatiesResult
            ->Relaties  // +"ErrorMsg": {#686}
            ->cRelatie; // array

        $rec_counter = 0;

        try {
            foreach ($customers as $client) {
                $customer = Client::findOneBy(['toggl_id' => intval($client->ID)]);
                if (!$customer) {
                    $customer = Client::GetDefault();
                    $customer['toggl_id']   = $client->ID;
                    $customer['name']       = $client->Bedrijf;
                    $customer['add_datum']  = $client->AddDatum;
                    $customer['code']       = $client->Code;
                    $customer['address']    = $client->Adres;
                    $customer['postcode']   = $client->Postcode;
                    $customer['person']     = $client->Contactpersoon;

                    $customer['Hash']       = uniqid();
                    $customer['pilot']      = 0;
                    $customer['plustaskid'] = 1;
                    $customer['plustaskdate'] = 1;
                    $customer['linktrack']  = 1;
                    $customer['password']   = $client->Code;
                    $customer['company_id'] = $company['id'];
                    $rec_counter++;
                    Client::Commit($customer);
                    // $em->persist($customer);
                }
            }
            
            $note = "($rec_counter)";
            // $log_item = Transactions::logEvent($event, 'Clients refreshed', $note, $company['id']);
            
        } catch (Exception $e) {
            if(isset($client->Bedrijf)) {
                $error = 'Error: Import customer (Client) :'. $client->Bedrijf . ' ' . $e->getMessage();
            } else {
                $error = 'Error: Import customer :'. $e->getMessage();
            }
            Messager::log($error);
        }
        $content['mssg' . $event] = $note;
        $content['time' . $event] = date('d/m/Y H:i:s');

        return $content;
    }

}