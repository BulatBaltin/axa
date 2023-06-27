<?php

class InvoiceRepository extends Repository {

    // Create invoices: Called from ToolsKitController. And from hours controller
    static function invoiceManager(
        string  $action,
        array   $boss,
        array   $content,
        array   $invoiceGoods = null,
        bool    $isrounded = false,
        array   $invoice = null,
        string  $status1 = 'auto',
        bool    $keepHours = false
        ) {
            
// dump(1,2,3,4,5, ['apple' => 'Редиска', 'orange'=>'fruit', 'more' => ['apple2' => 'Редиска', 'orange2'=>'fruit','tomorrow'=> new DateTime('tomorrow')]], new DateTime('yesterday'));
// // die;
// dlLog::WriteDump(1,2,3,4,5, ['apple' => 'Редиска', 'orange'=>'fruit', 'more' => ['apple2' => 'Редиска', 'orange2'=>'fruit','tomorrow'=> new DateTime('tomorrow')]], new DateTime('yesterday'));
// die;

// $stru = Invoice::GetDefault();
// dd($stru);

// dlLog::WriteDump('Step-0000-7');

        $event = '7';
        $company = User::GetCompany($boss);
        $company_id = $company['id'];
        
        $createNew = $action == 'create';
        $strict_period = $action == 'auto';

        $eventTime = date('Y-m-d H:i:s');

        // {+ Start ------------------------- }
        if ($invoiceGoods == null and $action == 'auto') {
            // main automatic regime
            $invoiceGoods = InvoiceGood::findBy(
                [
                    'invoice_id'    => null, 
                    'company_id'    => $company_id, 
                    'status'        => ['OR'=>[null,'']]
                ], // , 'removed'
                ['customer_id' => 'DESC']
            );
        }

// dlLog::WriteDump('Step-1', 'Count =' . count($invoiceGoods), DataBase::$sql);

        if ($isrounded == null) {
            $isrounded = $company['isrounded'];
        }

        $onlyOneInvoice = $invoice !== null or $status1 == 'manual';
        if ($invoice !== null) self::readInvoiceitems($invoice);

        $rec_counter = 0;
        $item_count = 0;
        // $trace = "";
        $url_invoice = '';

dymp('STEP-2', $invoice);

        foreach ($invoiceGoods as $itemGood) {
dymp('Step-2-x ItemGood =' . $itemGood['id']);
            // if ($itemGood->getMark()) {
            try {

                $period_day = $itemGood['period']; // day
                $period_month = substr($period_day, 0, 7); // month
                $project_id = $itemGood['project_id']; // tasklist
                if ($project_id === null) {
                    // $trace .= "-1 ";
                    continue;
                }
                $tasklist = Tasklist::find($project_id);
dymp('Step-2-01', $tasklist);
                // #Bulat 2021-05-03
                if ($tasklist['grouppa']) { // $isMultyProject
                    $customer_id = $itemGood['customer_id'];
                    if(!$customer_id and $invoice) {
                        $customer_id = $invoice['customer_id'];
                        $itemGood['customer_id'] = $customer_id;
                    }
                } elseif($itemGood['customer_id']) {
                    $customer_id = $itemGood['customer_id'];
                } else {    
                    $customer_id = $tasklist['customer_id'];
                }
dymp('Step-2-02', $itemGood);

                if ($customer_id !== null) $customer = Client::find($customer_id);

                if ($customer_id === null or ($status1 == 'auto' and $customer['pilot'] == 1)) { // Manual mode
                    // $trace .= "-2 ";
dymp('Step-2-01-01 Manual mode continue |' . $customer_id .'|');
                    continue;
                } elseif($status1 == 'auto' and $customer['pilot'] == 2) { // completed tasks only
                    $task = Task::findOneBy([
                        'company_id'=>$company_id, 
                        'project_id' => $project_id, 
                        'tid' => $itemGood['tid'] 
                    ]);
                    if($task and !$task['completed']) {
                        dymp('Step-2-01-02 continue');
                        continue;
                    }
                }
            } catch (Exception $e) {
                $mssg = $e->getMessage();
// dlLog::WriteDump('Error: Step-X ' . $mssg );
                // Messager::log('(INV001) Error :' . $mssg );
                dymp('(INV001) Error :' . $mssg );
                // Notification::logEvent('INV001', 'Invoices', $mssg, $company_id);
                continue;
            }

dymp('Step-2-3', $invoice);
            if ($invoice == null) {
                $invoice = self::fetchInvoice(
                    $createNew,
                    $customer_id,
                    $company_id,
                    $period_month,
                    $status1
                );
dymp('Step-2-4 fetchInvoice', $invoice);
                // $trace .= "+1 ";
            }
dymp('Step-3', $invoice);

            if(!isset($invoice['rows'])) $invoice['rows'] = [];

            if ($invoice['customer_id'] !== $customer_id or 
                ($invoice['period'] !== $period_month and $strict_period)) {

                if ($onlyOneInvoice) {
dymp('Step-3.1 onlyOneInvoice');
                    // $trace .= "+2 ";
                    continue;
                }
                self::setInvoiceFixedHours($invoice, $isrounded);

dymp('Step-3.2 saveInvoice', $invoice);

                $invoice_id = self::saveInvoice($invoice);
dymp('Step-3.3 saveInvoice', $invoice_id);
                $url_invoice = route('qv.invoice.edit',['id' => $invoice_id]); //'/zinvoice/edit/'.$invoice_id;
                $rec_counter++;
                // $log_item = Transactions::logEvent($event, 'Invoice created / updated', $item_count, $company['id'], $invoice['customer_id'], $invoice, $rec_counter);
                // $em->persist($log_item);
                $item_count = 0;
// dlLog::WriteDump('Step-4 fetchInvoice');

                $invoice = self::fetchInvoice(
                    $createNew,
                    $customer_id,
                    $company_id,
                    $period_month,
                    'auto' //$status1
                );
                // $trace .= "+3 ";
            }

            if(!$itemGood['tag']) $itemGood['tag'] = '';
// add new invoice item            
            InvoiceGoodRepository::addNewItem($invoice, $itemGood, $customer, $isrounded, $keepHours);
            $item_count++;

            // $trace .= "+4 ";
        }
// dlLog::WriteDump('Step-5');
// die;

        if ($invoice !== null) {
            
            self::setInvoiceFixedHours($invoice,$isrounded);
// dymp('STEP-5.5', $invoice);
// die;
            $invoice_id = self::saveInvoice($invoice);
// dlLog::WriteDump('Step-6', $invoice, DataBase::$sql, 'invoice_id='.$invoice_id);

            $url_invoice = route('qv.invoice.edit', ['id' => $invoice['id']]); ///zinvoice/edit/' . $invoice->getId();
            $rec_counter++;
            // $log_item = Transactions::logEvent($event, 'Invoice created / updated', $item_count, $company['id'], $invoice['customer_id'], $invoice, $rec_counter);

// ItemsCache::deleteAll();
            $eventTime = date('Y-m-d H:i:s'); //$log_item['logtime']; //()->format('d-m-Y H:i:s');
            // $trace .= "+5 ";
        } else {
            // dd($trace, $invoiceGoods);
        }
        
        // dd($trace, $invoiceGoods);
        $note = "($rec_counter)";
        // $em->flush();
        $content['mssg' . $event] = $note;
        $content['time' . $event] = $eventTime;
        if(isset($content['invoice'])) {
            $content['invoice'] = $url_invoice;
        }
// dlLog::WriteDump('Step-7 rec_counter='.$rec_counter);

        $mssg = "$rec_counter invoice(s) have been created / updated";

        // Notification::logEvent('INV001', 'Invoices', $mssg, $company);

        return $content;
        // {+ End   ------------------------- }
    }

    static function fetchInvoice($createNew, 
    $customer_id, $company_id, $period, $status1 ): ?array
    {
        if ($createNew) {
// dlLog::WriteDump('(0) new invoice');            
            $invoice = self::createNewInvoice($customer_id, $company_id, $period, $status1);

// dlLog::WriteDump('new invoice', $invoice);            
        } else {
            $invoice = Invoice::findOneBy([
                'period'        => $period, 
                'customer_id'   => $customer_id, 
                'status'        => ['OR'=>['not submitted', 'not ready']],
                'status1'       => $status1 // So I found 'manual' and what?
            ]);
            // , null, null, null, true );
            if ($invoice == null) {
                $invoice = self::createNewInvoice($customer_id, $company_id, $period, $status1);
            } else {
                self::readInvoiceItems($invoice);
            }
        }
        return $invoice;
    }
    private static function createNewInvoice( $customer_id, $company_id, string $period, string $status1)
    {
        //
        $invoice = Invoice::GetDefault();

        $invoice['doc_date']    = date('Y-m-d H:i:s');
        $invoice['period']      = $period;
        $docNum = self::getNextDocNumber($company_id, $period); 
        $invoice['doc_number']  = $docNum; 
        $invoice['customer_id'] = $customer_id;
        $invoice['currency_code'] = 'EUR';
        $invoice['vatcoeff']    = 21;  // get it from user parms
        $invoice['status']      = 'not ready';
        $invoice['status0']     = 'open';
        $invoice['status1']     = $status1;
        $invoice['company_id']  = $company_id;

        Invoice::Commit($invoice);

        // dlLog::WriteDump("STOP-02 Commit invoice ", $invoice);
        // die;

        $invoice['rows']= [];

        return $invoice;
    }

    static function calcSubTotal(&$invoice, $row_index )
    {
        $pos = $invoice['rows'][$row_index]['level'];
        if ($pos !== '=') {
            $q = 0;
            $p = 0;
            $t = 0;
            foreach ($invoice['rows'] as $row) {
                $level = $row['level'];
                if($pos == $level) {
                    $q += floatval($row['quantity']);
                    $p += floatval($row['quantityplan']);
                    $t += floatval($row['total']);
                }
            }
            $q = round($q,3);
            $p = round($p,3);
            $t = round($t,2);

            $invoice['rows'][$pos]['quantity'] = $q;
            $invoice['rows'][$pos]['quantityplan'] = $p;
            $invoice['rows'][$pos]['total'] = $t;
            $price = $q ? round($t / $q, 2) : 0;
            $invoice['rows'][$pos]['price'] = $price;
            // $invoice['quantityplan'][$pos]    = $p;

            $invoice['subtotal'] = true;
            $invoice['subtotal_total'] = $t;
            $invoice['subtotal_price'] = $price;
            $invoice['subtotal_quantity'] = $q;
            $invoice['subtotal_quantityplan'] = $p;
        } else {

            $invoice['subtotal'] = false;
        }

        self::calcGlobTotals($invoice);
    }

    static function calcGlobTotals(&$invoice )
    {
            $q = 0;
            $t = 0;
            foreach ($invoice['rows'] as $row) {
                $level = $row['level'];
                if ($level == '+' or $row['score'] == '-') continue;
                $q += floatval($row['quantity']);
                $t += floatval($row['total']);
            }
            $invoice['grand_total']      = round($t,2);
            $invoice['grand_quantity']   = round($q,3);
    }

    static function saveInvoice(array &$invoice, bool $send_it = false)
    {
        self::calcInvoiceTotals($invoice);

        $updated    = date('Y-m-d H:i:s');
        $company    = Repository::GetCompany();
        $invoice['updated_at']  = $updated;
        // if(!$invoice['created_at']) $invoice['created_at']  = $updated;
        $invoice['tag']         = $invoice['tag'] ?? '';
        
        $invoice_id = Invoice::Commit($invoice);

        if($invoice_id) {
            foreach ($invoice['rows'] as $item) {
                // if($item['level'] == '+' or $item['score'] == '-') continue;
                if($item['score'] == '-') continue;

                if($item['tag'] == null) $item['tag'] = '';
                $item['company_id'] = $company['id'];
                $item['invoice_id'] = $invoice_id;
                $item['updated_at'] = $updated;
                // if(!$item['created_at']) $item['created_at']  = $updated;
                $id = InvoiceGood::Commit($item);
            }
        }

        InvoiceGoodRepository::RemoveOldItems($invoice_id, $updated);

        if ($send_it) {

            $acc_client = $company['accountparm1'];
            $acc_login  = $company['accountlogin'];
            $acc_key1   = $company['accountkey1'];
            $acc_key2   = $company['accountkey2'];
    
            $ASession = new SOAPAccounting($acc_login, $acc_key1, $acc_key2, $acc_client);
            self::SendAccBody($ASession, $invoice, true );
            $ASession->CloseSession();
        }

        return $invoice_id;
    }

    static function SendAccBody(SOAPAccounting $ASession, $invoice, $doflush)
    // ,$doflush, $em, Invoice  InvoiceGoodsRepository $repoGoods, )
    {
    try {

        $fields = self::prepareData($ASession, $invoice );
        // dd($fields);
        $response = $ASession->AddFactuur($fields);

        $NoFact = $response->AddFactuurResult->Factuurnummer;
        $response = $ASession->GetFacturen(null, null, $NoFact);

        if (isset($response->GetFacturenResult->Facturen->cFactuurList)) {

            $PdfURL = $response->GetFacturenResult->Facturen->cFactuurList->URLPDFBestand;
            $invoice['urlpdfbestand'] = $PdfURL;
            $Datum = $response->GetFacturenResult->Facturen->cFactuurList->Datum;
            $invoice['datum']   = $Datum;
            $invoice['submitted_at'] = date('Y-m-d H:i:s'); //new DateTime();
            $invoice['status']  = 'submitted';
            $invoice['status0'] = 'closed';
            $invoice['factuurnummer'] = $NoFact;

            Invoice::Commit($invoice);

            // $em->persist($invoice);
            // if ($doflush) $em->flush();
            $company    = Repository::GetCompany();
            if($company['donetasks']) {


                // $repoNotification = $em->getRepository(Notification::class);
                // $repoTrackMap = $em->getRepository(Trackingmap::class);
                // $company = $this->getUser()->getCompany();

                self::setTasksAsDone( $invoice, $company );
            }
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage(), $e->getCode());
    }
    }

    // EntityManagerInterface $em,
    static function setTasksAsDone($invoice, $company )
    {
        $developer = User::GetUser();
        $items = InvoiceGood::findBy(['invoice_id' => $invoice['id']]);

        if ($items and count($items) > 0) {

            $trackingName = 'Teamwork';
            $keys = Trackingmap::findCredentials('user', $developer, $trackingName, $company['id'] );
            $tracking  = Trackingapp::App($trackingName, $keys, $developer);
            // $trackRecord  = $keys['map'];
            // $company = $trackRecord->getCompany();

            $tids = [];
            foreach($items as $entry) {
                // dump($entry, $entry->getTid());
                // It is ONLY for latest tasks from Teamwork
                $tid = $entry->getTid();
                if(empty($tid) or array_search($tid, $tids) !== false) continue;
                $tids[] =  $tid;
                if($tid) {
                    $tracking->putTaskCompleteMark($tid);    
                    // $repoNotification->addEvent('TASK-fin', 'Task finished in Teamwork', 'Task finished (Teamwork):'.$entry->getTaskNl(),$company);
                } else {
                    // $repoNotification->addEvent('TASK-fin', 'Task finished', 'Task finished:'.$entry->getTaskNl(),$company);
                }
            }
            // dd('Okay');
        }
        return true;
    }

    static function prepareData(SOAPAccounting $ASession, $invoice )
    {
    $dataItems = InvoiceGood::findBy(['invoice' => $invoice],['position'=>'ASC']);
    $check0 = $invoice['quantity'];
    $check1 = 0;
    $check2 = 0;
    $items = [];
    // add Artikul to '+' level
    $len = count($dataItems);
    for($i = 0; $i < $len; ++$i) {
        $item = $dataItems[ $i ];
        if ($item === null) continue;
        $level = $item['level'];
        if (!($level == null or $level == '=' or $level == '+' )) continue;
        if ($level == '+' and ($i+1) < $len) {
            $next = $dataItems[$i+1];
            if($next) {
                $item['artikul'] = $next['artikul'];
            }
        }
        $items[] = &$item;
        $check1 += $item['quantity'];
    }

    $fields = $ASession->getFactuurFields();

    // Header
    $customer = Client::find($invoice['customer_id']);
    $fields['Relatiecode'] = $customer['code']; 
    // $invoice->getCustomer()->getCode(); //'0002'; // Client Very usefull (2)
    // $fields['Datum'] = $invoice->getDocDate(); // strtotime('2019-10-28');    // 
    // $fields['Datum'] = strtotime($invoice->getDocDate()->format('c'));    // 

    $fields['Datum'] = time(); //strtotime($invoice->getDocDate()->format('c'));    // 
    $fields['Factuursjabloon'] = 'Factuursjabloon';
    $fields['IncassoRekeningNummer'] = '0001';

    // Row items
    $invoiceRows = [];
    $empty_artikul = '';
    foreach ($items as $item) {
        if ($item['artikul'] == null) {
            $empty_artikul = 'Empty';
            continue;
        }

        $newRow = $ASession->getNewRow();

        $quanty = $item['quantity'];
        $quanty = $quanty ? $quanty : 0;
        $newRow['Aantal'] = $quanty; //$Items[1]->getQuantity(); // Amount

        $price = $item['price'];
        $price = $price ? $price : 0;
        $newRow['PrijsPerEenheid'] = $price; // $Items[1]->getPrice(); // Price


        $product = Product::find($item['artikul_id']);
        $newRow['Code'] = $product['code']; // $item->getArtikul()->getCode(); //'proga';
        $newRow['Omschrijving'] = $item['tasknl']; //->getTaskNl();
        // BI_EU_VERK_D Diensten naar binnen de EU 0% // Services inside EU 0%
        $newRow['BTWCode'] = 'HOOG_VERK_21'; // VAT code
        $newRow['TegenrekeningCode'] = '8000'; // Counter-account code

        $invoiceRows[] = $newRow;
        $check2 += $quanty;
    }

    // due to rounding errors; 
    if (! self::TheSameNums($check0,$check2)) 
    {
        $mssg = "Invoice: ID/No ". $invoice->getId() .'/'. $invoice->getDocNumber();
        $mssg = "<br>Incorrect check sums for invoice items : ($check0) ($check1) ($check2)";
        if($empty_artikul) {
            $mssg .= "<br>Reason: empty 'artikuls' in the invoice items"; 
        }
        throw new Exception( $mssg, 501 );
    }
    // dd($items, $invoiceRows, $check0, $check1, $check2 );

    $fields['Regels']['cFactuurRegel'] = $invoiceRows;

    return $fields;
    }

    static function TheSameNums($num1, $num2, $precision = 3) {
    $num1 = substr(number_format($num1, $precision), 0, -1);
    $num2 = substr(number_format($num2, $precision), 0, -1);
    return $num1 == $num2; 
    }

    static function setInvoiceFixedHours(array &$invoice, bool $isrounded = false) {

        if(empty($invoice['rows'])) {
            $invoice['rows'] = [];
        }

        $Items = $invoice['rows'];
        InvoiceGoodRepository::setFixedHours($Items);

        if($isrounded) {
            foreach ($Items as $item) {
                if (InvoiceGood::IsInitEntry($item))
                    InvoiceGood::roundHours($item);
            }
        }
        return;
    }

    static function readInvoiceitems(&$invoice): array
    {
        $invoice['rows'] = []; // new ArrayCollection();
        $items = InvoiceGood::findBy(['invoice_id' => $invoice['id'] ]);
        foreach ($items as $item) {
            $invoice['rows'][] = $item;
        }
        return $invoice['rows'];
    }

    static function getNextDocNumber($company_id, string $period) {
        $lastRec = Invoice::findOneBy(['company_id'=> $company_id],['id'=>'DESC']);
        $year = substr($period, 0, 4);
        if($lastRec) {
            $lastNumber = $lastRec['doc_number'];
            if(substr($lastNumber, 0, 4) == $year) {
                $no = (int) substr($lastRec['doc_number'], 4);
                $global = ++$no;
            } else {
                $global = 1;
            }
        } else {
            $global = 1;
        }
        return $year . $global;
    }

// ==================================================== 
    static function calcInvoiceTotals(&$invoice)
    {
        $items = $invoice['rows'];
        $total = 0;
        $quantity = 0;
        $status     = "not submitted";
        foreach ($items as $item) {
            if (InvoiceGood::IsInitEntry($item)) {
                $total      += (float)$item['total'];
                $quantity   += (float)$item['quantity'];
                if (!$item['artikul_id']) {
                    $status = "not ready";
                }
            }
        }
        $invoice['status']      = $status;
        $invoice['quantity'] = round($quantity,3); //
        $invoice['total']    = round($total,2);
        $invoice['vatsum']   = $total * ($invoice['vatcoeff'] / 100);
        $invoice['vatsum']   = round($invoice['vatsum'], 2);
        $invoice['totalvat'] = $total + $invoice['vatsum']; // 

        return $invoice;
    }

    static function findWithInvoices($company) {

        $company_id = $company['id'];
        $sql = "SELECT u.id as invoice_id, c.id as customer_id, c.name as customer_name FROM invoice AS u LEFT JOIN client AS c ON u.customer_id = c.id WHERE u.company_id = $company_id";
        // ...
        $data = DataBase::ExecuteQuery($sql, 'array');
        // $invoices = Invoice::findBy(['company_id'=>$company['id']]);
        $result[0] = ll('All customers');

        foreach($data as $customer) {
            $result[$customer['customer_id']] = $customer['customer_name'];
        }
        return $result;
    }

    static function getInvoiceDataSet($date1, $date2, $company)
    {
        $dataset = Invoice::CreateQueryBuilder('i')
            ->andWhere('i.doc_date > :val1')
            ->andWhere('i.doc_date <= :val2')
            ->andWhere('i.company_id = :company')
            ->setParameter('val1', $date1->format('Y-m-d H:i:s'))
            ->setParameter('val2', $date2->format('Y-m-d H:i:s'))
            ->setParameter('company', $company['id'])
            ->orderBy('i.id', 'ASC')
            // ->setMaxResults(300)
            ->getQuery()
            ->getResult();

        return $dataset;
    }
    function getItemsDataSet($date1, $date2, $company)
    {
        $dataset = InvoiceGood::createQueryBuilder('i')
            ->andWhere('i.updated_at > :val1')
            ->andWhere('i.updated_at <= :val2')
            ->andWhere('i.company_id = :company')
            ->setParameter('val1', $date1->format('Y-m-d H:i:s'))
            ->setParameter('val2', $date2->format('Y-m-d H:i:s'))
            ->setParameter('company', $company['id'])
            ->orderBy('i.id', 'ASC')
            // ->setMaxResults(300)
            ->getQuery()
            ->getResult();

        return $dataset;
    }

    static function readInvoiceData(DateTime $date1, DateTime $date2, $company)
    {

        $dataset = self::getInvoiceDataSet($date1, $date2, $company);

        $result = [];
        $count_submitted = 0;
        $count_ready = 0;
        $count_notready = 0;
        foreach ($dataset as $record) {
            $status = $record['status'];
            if ($status == 'submitted') {
                $count_submitted++;
            } elseif ($status == 'not submitted') {
                $count_ready++;
            } else {
                $count_notready++;
            }
        }

        // sort ASC ascending
        usort($result, function ($a, $b) {
            return $a['hours'] <=> $b['hours'];
        });

        $result = [
            'submitted' => $count_submitted,
            'ready' => $count_ready,
            'notready' => $count_notready
        ];
        return $result;
    }

}