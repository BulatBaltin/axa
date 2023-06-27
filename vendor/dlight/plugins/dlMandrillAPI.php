<?php
  APP::addPlugin("dlmandrillapi");
  require_once getDocumentRoot()."dlight/vendor/mandrill/Mandrill.php";
  
  class dlMandrill{
      public $_api_key = "409QQXMMtEbroM-JR59rhQ";
      public $_mandrill_obj = null;
      
      function __construct(){
        $this->_mandrill_obj = new Mandrill($this->_api_key);        
      }
      
      public function SendTestEmailsMandrill(){
          
          $sender_email = APP::Config("dlMailer_email_no_reply");
          $sender_name = APP::Config("PROJECT_NAME");
          $subject = "Тема";
          $html = "<p>Привет1, *|FIO|*</p><p>Мы с радостью <strong>предлагаем вам</strong></p><a href='https://www.youtube.com/'>YouTube</a>";
          $to = [
            ["email"=>"dmitriy.baltin@gmail.com","name"=>"Dima Baltin"],
            ["email"=>"lightloft@diansoftware.com","name"=>"Light Loft"]
          ];
          
          
          $merge_vars = array(
            array(
                'rcpt' => 'dmitriy.baltin@gmail.com',
                'vars' => array(
                    array(
                        'name' => 'FIO',
                        'content' => 'Dmitriy Baltin'
                    )
                )
            ),
            array(
                'rcpt' => 'lightloft@diansoftware.com',
                'vars' => array(
                    array(
                        'name' => 'FIO',
                        'content' => 'Light'
                    )
                )
            )
        );
          
          if(count($to)){
            $this->SendEmailsMandrill($sender_email,$sender_name,$subject,$html,$to, $merge_vars);
          }
      }
      
      
      public function SendEmailsMandrill($sender_email, $sender_name, $subject, $html, $to, $merge_vars = []){
         try {
    $message = array(
        'html' => $html,
        'text' => null,
        'subject' => $subject,
        'from_email' => $sender_email,
        'from_name' => $sender_name,
        'to' => $to,
        /*'to' => array(
            array(
                'email' => 'recipient.email@example.com',
                'name' => 'Recipient Name',
                'type' => 'to'
            )
        ),*/
        //'headers' => array('Reply-To' => 'message.reply@example.com'),
        'important' => true,
        'track_opens' => true,
        'track_clicks' => true,
        'merge_vars' => $merge_vars,
        /*'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),*/
        
        /*'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => 'message.bcc_address@example.com',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array('password-resets'),
        'subaccount' => 'customer-123',
        'google_analytics_domains' => array('example.com'),
        'google_analytics_campaign' => 'message.from_email@example.com',
        'metadata' => array('website' => 'www.example.com'),
        'recipient_metadata' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'values' => array('user_id' => 123456)
            )
        ),
        'attachments' => array(
            array(
                'type' => 'text/plain',
                'name' => 'myfile.txt',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        ),
        'images' => array(
            array(
                'type' => 'image/png',
                'name' => 'IMAGECID',
                'content' => 'ZXhhbXBsZSBmaWxl'
            )
        )   */
    );
    $async = false;
    $ip_pool = '';
    $send_at = '';
    $result = $this->_mandrill_obj->messages->send($message, $async, $ip_pool, $send_at);
    //print_r($result);
    /*
    Array
    (
        [0] => Array
            (
                [email] => recipient.email@example.com
                [status] => sent
                [reject_reason] => hard-bounce
                [_id] => abc123abc123abc123abc123abc123
            )
    
    )
    */
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}   
          
          
          
      }
      
      
       /*
      public function SendEmailsMandrill($sender_email, $sender_name, $subject, ){
          
          $args = array(
            'key' => dlMandrillApi::$_api_key,
            'message' => array(
                "html" => '<p><strong>Какой-то</strong> текст</p>',
                "text" => null,
                "from_email" => "from@mail.ru",
                "from_name" => "Имя отправителя",
                "subject" => "Тема письма",
                "to" => array(array("email" => "to@mail.ru")),
                "track_opens" => true,
                "track_clicks" => true
            )
          );

 

            $curl = curl_init('https://mandrillapp.com/api/1.0/messages/send.json' );

            curl_setopt($curl, CURLOPT_POST, true);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($curl, CURLOPT_HEADER, false);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));

            $response = curl_exec($curl);

          
      }*/
      
      
  }
?>