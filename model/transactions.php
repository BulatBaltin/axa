<?php

Class Transactions extends dmModel {
    static function GetTableName() {
        return 'transactions';
    }

    static function getImportLayout( $company ) {
        
        $ImportItems = [
            [
                'name' => 'Users / Co-workers',
                'time' => self::getImpProp("1", 'time', $company['id']),
                'status' => self::getImpProp("1", 'status', $company['id']),
                'note' => self::getImpProp("1", 'note', $company['id']),
                'path' => 'user.indexing', 'id' => "1"
            ],
            [
                'name' => 'Clients',
                'time' => self::getImpProp("2", 'time', $company['id']),
                'status' => self::getImpProp("2", 'status', $company['id']),
                'note' => self::getImpProp("2", 'note', $company['id']),
                'path' => 'client.index', 'id' => "2"
            ],
            [
                'name' => 'Projects',
                'time' => self::getImpProp("3", 'time', $company['id']),
                'status' => self::getImpProp("3", 'status', $company['id']),
                'note' => self::getImpProp("3", 'note', $company['id']),
                'path' => 'project.index', 'id' => "3"
            ],
            [
                'name' => 'Products',
                'time' => self::getImpProp("4", 'time', $company['id']),
                'status' => self::getImpProp("4", 'status', $company['id']),
                'note' => self::getImpProp("4", 'note', $company['id']),
                'path' => 'products.index', 'id' => "4"
            ],
            [
                'name' => 'Import Hours',
                'time' => self::getImpProp("5", 'time', $company['id']),
                'status' => self::getImpProp("5", 'status', $company['id']),
                'note' => self::getImpProp("5", 'note', $company['id']),
                'path' => 'zhours.index', 'id' => "5"
            ],
            [
                'name' => 'Tasks',
                'time' => self::getImpProp("6", 'time', $company['id']),
                'status' => self::getImpProp("6", 'status', $company['id']),
                'note' => self::getImpProp("6", 'note', $company['id']),
                'path' => 'tasks.index', 'id' => "6"
            ],
            [
                'name' => 'Auto-create invoices',
                'time' => self::getImpProp("7", 'time', $company['id']),
                'status' => self::getImpProp("7", 'status', $company['id']),
                'note' => self::getImpProp("7", 'note', $company['id']),
                'path' => 'zinvoice.index', 'id' => "7"
            ]
        ];
        return $ImportItems;
    } 

    static private function getImpProp($code, $what, $company_id)
    {
        $result = self::findOneBy(
            ['code' => $code, 'company_id' => $company_id],
            ['eventtime' => 'DESC']
        );

        if (!$result) return "";

        $note = $result['event'];
        if ($what === 'status') {
            $status = (strpos($note, '[') !== false) ? 'warn' : 'ok';
            return $status;
        }
        if ($what === 'note') {
            return $note ? $note : "";
        }
        if ($what === 'time') {
            $note = (new dateTime($result['logtime']))->format('d/m/Y H:i:s');
            return $note;
        }
    }
    static function logEvent( $code, $name, $number, $company_id, $customer_id = null, $document = null, $doc_count = 0)
    {
        $log_item = Transactions::GetDefault();
        $log_item['logtime']    = date('Y-m-d H:i:s'); //(new DateTime());
        $log_item['code']       = $code;
        $log_item['name']       = $name;
        $log_item['event']      = $number;
        $log_item['description'] = $number;
        $log_item['customer_id']   = $customer_id;
        $log_item['eventtime']  = $log_item['logtime']; //->format('Y-m-d H:i:s'));
        $log_item['company_id'] = $company_id; //->format('Y-m-d H:i:s'));

        if ($document !== null) {
            $log_item['obj_id'] = $document['id'];
            if ($code === '6') { // Create invoice
                $pattern = "%d tasks have been added to invoice %s for customer %s";
                $comment = sprintf($pattern, $number, $document['doc_number'], $document['customer_id']);
                $log_item['description']    = $comment;
                $log_item['obj_type']       = 'invoice';
                $log_item['event']          = "($doc_count)";
            } elseif ($code === '7') {
                $log_item['obj_type'] = 'itemplan';
            }
        }

        Transactions::Commit($log_item);
        return $log_item;
    }


}