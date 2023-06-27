<?
class Notification extends dmModel {
    static function GetTableName() {
        return 'notification';
    }

    static function logEvent( $code, $name, $description, $company_id, $customer_id = null)
    {
        $log_item = Transactions::GetDefault();
        
        $log_item['customer_id'] = $customer_id;
        $log_item['logtime'] = date('Y-m-d H:i:s'); //new DateTime());
        $log_item['code'] = $code;
        $log_item['name'] = $name;
        $log_item['description'] = $description;
        $log_item['company_id'] = $company_id; //->format('Y-m-d H:i:s'));

        Transactions::Commit($log_item);
        return $log_item;
    }

}