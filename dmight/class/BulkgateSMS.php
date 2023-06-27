<?php

class BulkgateSMS {
    private $phone;
    private $sender;
    private $message;
    static $namespace = '/dlight/vendor/'; //DMIGHT . "namespace/";

    function __construct($namespace = "") 
    {

        if($namespace) self::$namespace = $namespace;
        $app_id = "25416";
        $app_token = "bWZhYtHZahlsOYo2KuEPlbyBmpjgHbsmc5qDQeEzXLZkdNh5dJ";
        
        spl_autoload_register('load_namespace');
        $connection = new BulkGate\Message\Connection($app_id, $app_token);
        $this->sender = new BulkGate\Sms\Sender($connection);
    }
    function SendMessage($text = "TEST", $phone = "+380501415243") {
        if(!$phone) $phone = $this->phone;
        $this->message = new BulkGate\Sms\Message( $phone, $text );
        $this->sender->send($this->message);
        return $this;
    }
    function GetMessageID() {
        return $this->message->getId();
    }
    function GetMessageStatus() {
        return $this->message->getStatus();
    }
    function GetMessagePrice() {
        return $this->message->getPrice();
    }
    function GetProviderData() {
        $data['id']     = $this->GetMessageID();
        $data['status'] = $this->GetMessageStatus();
        $data['price']  = $this->GetMessagePrice();
        return $data;
    }
    function SendBulkSMS( array $messages = [] ) {
        $list = [];
        foreach($messages as $message) {
            $list[] = new BulkGate\Sms\Message( $message['phone'], $message['text'] );
        }
        $this->message = new BulkGate\Sms\BulkMessage($list);
        $this->message->send();
        return $this;
    }
}

function load_namespace($class_name)
{
	$folder =  BulkgateSMS::$namespace . $class_name;
    return find_namespace($folder);
}

function find_namespace($class_name)
{
    $class = chop($class_name,'/');
	$file = str_replace('\\', '/', $class .'.php');

    if (file_exists($file) == true) {
        require_once($file);
        return true;
    } 
    return false;
}

?>