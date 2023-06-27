<?
// namespace BulkGate\Sms;
// namespace BulkGate\Message;

// $app_id = "25416";
// $app_token = "bWZhYtHZahlsOYo2KuEPlbyBmpjgHbsmc5qDQeEzXLZkdNh5dJ";
// $text = "TEST test : " . (new \DateTime())->format('c');

// $connection = new BulkGate\Message\Connection($app_id, $app_token);
// $sender = new BulkGate\Sms\Sender($connection);
// $message = new BulkGate\Sms\Message( '+380501415243', $text );
// $sender->send($message);

// $text = 'Just a test';
$sms_provider = new BulkgateSMS(DMIGHT . "namespace/");
$sms_provider->SendMessage( $text );

$data = $sms_provider->GetProviderData();

$result = "OK";
