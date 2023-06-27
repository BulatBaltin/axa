<?
APP::addPlugin("dlmailer");

class MAILER{
    
    public static function sendEmail($lang,$emailto,$subject,$label,$vars=false,$data_vars=false,$sender_email = false,$sender_name = false,$reply_to_email="",$reply_to_name="",$attach=[]){

        // echo "<br>(1) sendEmail ", $emailto," ", $subject;

        if(!$sender_email){
            $sender_email=APP::Config("dlMailer_email_no_reply",APP::Config("support_email"));
        }
        if(!$sender_name){
            $sender_name=APP::Config("dlMailer_email_sender","Admin");
        }
       
        $dlMailer_def_vars = APP::Config("dlMailer_def_vars",false);
        if($dlMailer_def_vars){
            foreach($dlMailer_def_vars as $key => $val){
                if( in_array( $key , $vars )===false ) {
                    $vars[] = $key; 
                    $data_vars[] = $dlMailer_def_vars[$key]; 
                }
            }    
        }
        
        
        if($subject)
            $text=dl_mail_templates::getMailTemplate($label,$vars,$data_vars,false,$lang);
        else
            list($subject,$text)=dl_mail_templates::getMailTemplate($label,$vars,$data_vars,true,$lang);
            
        //$attach=array();
        if(APP::Config("dlMailer_attach_logo",false)){
            if(file_exists(getDocumentRoot(false).APP::Config("dlMailer_attach_logo","/img/mail_logo.jpg"))){
                $attach[]=getDocumentRoot(false).APP::Config("dlMailer_attach_logo","/img/mail_logo.jpg");
            }
        }

        //$text = dls_rassilka::AddStandartInfo($emailto,$text);
        // echo $text;
        // dlLog::Write($text);
        // return 0;
        // echo "<br>(2) sendEmail: MAILER::MailTo", $emailto, " ", $subject;

        return MAILER::MailTo($emailto,$subject,$text,$sender_email,$sender_name,$attach,$reply_to_email,$reply_to_name,$attach);
    }
    
    
    public static function sendEmailQueue($emailto,$subject,$label,$vars=false,$data_vars=false)
    {
        $sender_email=APP::Config("dlMailer_email_no_reply","admin@".UrlHelper::getHostUrl());
        $sender_name=APP::Config("dlMailer_email_sender","Admin");
        
        if($subject)
            $text=dl_mail_templates::getMailTemplate($label,$vars,$data_vars);
        else
            list($subject,$text)=dl_mail_templates::getMailTemplate($label,$vars,$data_vars,true);
        
        $dl_mailing_queue_gateway=new dl_mailing_queue();
        return $dl_mailing_queue_gateway->SendLetter($text,$vars,$data_vars,$subject,$emailto,NowDateTime());
    }
    
    
    public static function sendEmailQueueDirect($emailto,$subject,$text)
    {
        //$sender_email=APP::Config("dlMailer_email_no_reply","admin@".UrlHelper::getHostUrl());
        //$sender_name=APP::Config("dlMailer_email_sender","Admin");
        
        
        $dl_mailing_queue_gateway=new dl_mailing_queue();
        return $dl_mailing_queue_gateway->SendLetter($text,$vars,$data_vars,$subject,$emailto,NowDateTime());
    }
 
    public static function MailTo($emailto,$theme,$text,$sender_email,$sender_name,$attach,$reply_to_email="",$reply_to_name="")
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.office365.com";
        $mail->Port = 587;
        $mail->Username = "info@eendracht1.nl";
        $mail->Password = "Ad855ziRvVEYEt2";
        $mail->Priority   = 1;
        $mail->ContentType = 'text/html';
        $mail->Timeout       = 60;
        $mail->SMTPKeepAlive = true;


        //$mail->SetFrom($sender_email, $sender_name);
        $mail->SetFrom($mail->Username, $sender_name);
        $mail->ClearReplyTos();
        if($reply_to_email){
            $mail->AddReplyTo($reply_to_email, $reply_to_name);
        }
        $mail->Subject    = $theme;
        $mail->Body=$text;
        $mail->AddAddress($emailto, "");

        for($i=0;$i<count($attach);$i++){
            list($file,$ext) = explode(".",$attach[$i]);
            if(in_array($ext,["jpg","gif","png","jpeg"])){
                $mail->AddEmbeddedImage($attach[$i], 'mag_attach'.$i, "image{$i}.gif", 'base64', "image/jpeg");
            }
            elseif(in_array($ext,["html"])){
                $path = pathinfo($attach[$i]);
                $mail->AddAttachment($attach[$i],$path['basename'],'base64', "text/html");    
            }
            else{
                $path = pathinfo($attach[$i]);
                $mail->AddAttachment($attach[$i],$path['basename']);
            }
        }
        
        //< PRODUCTION MODE
        $result = $mail->Send();
        $echoLog = APP::Config("dlMailer_log",false);
        // PRODUCTION MODE >

        //< TEST MODE
        // $result = true;
        // echo "<br>MailTo: Result =", $result, ' echoLog =', $echoLog;
        // TEST MODE >

        if(!$result)
        {
            if($echoLog)
                dl_mailing_log::AddToLog($theme." (Error sending)",$text." Error info:".$mail->ErrorInfo,$emailto);
            
            $mail->ClearAddresses();
            $mail->ClearAttachments();   
            return false;
        } 
        else
        {
            if($echoLog)
                dl_mailing_log::AddToLog($theme,$text,$emailto);
                
            $mail->ClearAddresses();
            $mail->ClearAttachments();   
            return true;
        }
    }
}

class dl_mail_templates extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","label","discription","subject_nl","subject_de","text_nl","text_de"),"dl_mail_templates","id");
        $this->setTableRus(ll('Mailing list templates'),array("ID", ll("Label (do not change)"),ll("Description"),ll("Topic")." (nl)",ll("Topic")." (de)",ll("Text")." (nl)",ll("Text")." (de)"));
        $this->NOTDeletable();
        $this->NOTAddable();
        $this->SetAddText(ll("Add template"));
                    
        $label_field = new Text("",STRONG,30);
        $label_field->XEdit(false);
        $this->AddFieldType(new ID());
        $this->AddFieldType($label_field);
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,20));    
        $this->AddFieldType(new MultiText("",NOT_STRONG,100,20));    
    }
    
    public static function getMailTemplate($label,$vars=false,$data_vars=false,$with_subject=false, $lang = "nl")
    {
        $mail_templates_gateway=new dl_mail_templates();
        $main_text_templ=$mail_templates_gateway->getRecByField("label","main");
        $data_text_templ=$mail_templates_gateway->getRecByField("label",$label);
        $subject=$data_text_templ['subject_'.$lang];

        
        $decorator_templ = $main_text_templ['text_'.$lang ];
        if($vars&&$data_vars)
            $decorator_templ = str_replace($vars,$data_vars,$decorator_templ);

        $internal_part_templ = $data_text_templ['text_'.$lang ];
        if($vars&&$data_vars)
            $internal_part_templ = str_replace($vars,$data_vars,$internal_part_templ);

        $internal_part_templ = nl2br($internal_part_templ);

        $text_templ=str_replace(array("%%EMAIL_DATA%%"),array($internal_part_templ),$decorator_templ);

        
        if(!$with_subject)
        {
            return $text_templ; 
        }
        else
        {
            $subject = str_replace($vars,$data_vars,$subject);
            return array($subject,$text_templ);
        }
            
    }
}

abstract class Mailing extends dlModel
{
     function __construct($table_name,$table_rus)
    {
        parent::__construct(array("id","theme","text","email","datetime"),$table_name,"id");
        $this->setTableRus($table_rus,array("ID",ll("Topic"),ll("Text"),"Email",ll("Date/Time")));    
        $this->SetAddText(ll("Add email"));
        $this->NOTAddable();


        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,60));//theme
        $this->AddFieldType(new MultiText("",STRONG,60,10));//name
        $this->AddFieldType(new Text("",STRONG,40));//name_full
        $this->AddFieldType(new DateTimeField(NowDateTime(),STRONG));
    }
    
}

class dl_mailing_log extends Mailing
{
    function __construct()
    {
        parent::__construct("dl_mailing_log",ll('E-Mails log'));
    }
    
    
    public static function AddToLog($subject,$text,$email)
    {
        $dl_mailing_log_gateway=new dl_mailing_log();
        $dl_mailing_log_gateway->Add(array("NULL",$subject,$text,$email,NowDateTime()));
    }
}

class dl_mailing_queue extends Mailing
{
    function __construct()
    {
        parent::__construct("dl_mailing_queue","Письма для рассылки");
    }
    
    
    function Add($params){
        list($text,$text_index) = $this->getParamValueIndex($params,"text");
        list($email,$email_index) = $this->getParamValueIndex($params,"email");
        $params[$text_index] = dls_rassilka::AddStandartInfo($email,$text);
        return parent::Add($params);
    }

    
    function AddLetter($subj,$text,$email){
        return $this->Add(array("NULL",$subj,$text,$email,NowDateTime()));
    }


    function SendLetter($text_temlate,$search,$replace_with,$theme,$email,$datetime){
        $text=str_replace($search,$replace_with,$text_temlate);
        return $this->Add(array("NULL",$theme,$text,$email,$datetime));
    }



    function getLetters($num)
    {
        $limits="";
        if($num)
            $limits="LIMIT 0,{$num}";
        
        
         $sql="
        SELECT
            `id`
        FROM 
            `".$this->_table_name."`
        ORDER BY 
            `id` ASC 
        {$limits}";

        //echo $sql;
        $result=DataBase::ExecuteQuery($sql);

        if($result)
            return $result;
        else
        {
            $this->setError("Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка:".Database::get_error());
            return false;
        }
    }


}




class MultiThreading
{
    /**
     * Имя сервера
     *
     * @var string
     * @access private
     */
    private $server;
    
    /**
     * Максимальное количество потоков
     *
     * @var int
     * @access private
     */
    private $maxthreads;
    
    /**
     * Имя скрипта, который выполняет нужную нам задачу
     *
     * @var string
     * @access private
     */
    private $scriptname;
    
    /**
     * Параметры, которые мы будем передавать скрипту
     *
     * @var array
     * @access private
     */
    private $params = array();
    
    /**
     * Массив, в котором хранятся потоки
     *
     * @var array
     * @access private
     */
    private $threads = array();
    
    /**
     * Массив, в котором хранятся результаты
     *
     * @var array
     * @access private
     */
    private $results = array();
    
    /**
     * Конструктор класса. В нем мы указываем максимальное количество потоков и имя сервера. Оба аргумента необязательны.
     *
     * @param int $maxthreads максимальное количество потоков, по умолчанию 10
     * @param string $server имя сервера, по умолчанию имя сервера, на котором запущено приложение
     * @access public
     */
    public function __construct($maxthreads = 10, $server = '')
    {
        if ($server)
            $this->server = $server;
        else
            $this->server = $_SERVER['SERVER_NAME'];
        
        $this->maxthreads = $maxthreads;
    }
    
    /**
     * Указываем имя скрипта, который выполняет нужную нам задачу
     *
     * @param string $scriptname имя скрипта, включая путь к нему
     * @access public
     */
    public function setScriptName($scriptname)
    {
        if (!$fp = fopen(UrlHelper::Protocol().'://'.$this->server.'/'.$scriptname, 'r'))
            throw new Exception('Cant open script file');
        
        fclose($fp);
        
        $this->scriptname = $scriptname;
    }
    
    /**
     * Задаем параметры, которые мы будем передавать скрипту
     *
     * @param array $params массив параметров
     * @access public
     */
    public function setParams($params = array())
    {
        $this->params = $params;
    }
    
    /**
     * Выполняем задачу, комментарии в коде
     *
     * @access public
     */
    public function execute()
    {
        // Запускаем механизм, и он работает, пока не выполнятся все потоки
        do {
            // Если не превысили лимит потоков
            if (count($this->threads) < $this->maxthreads) {
                // Если удается получить следующий набор параметров
                if ($item = current($this->params)) {
                
                    // Формируем запрос методом GET
                    
                    $query_string = '';
                
                    foreach ($item as $key=>$value)
                        $query_string .= '&'.urlencode($key).'='.urlencode($value);
                    
                    $query = "GET ".UrlHelper::Protocol()."://".$this->server."/".$this->scriptname."?".$query_string." HTTP/1.0\r\n";
                    
                    // Открыватем соединение
                    
                    if (!$fsock = fsockopen($this->server, 80))
                        throw new Exception('Cant open socket connection');
                
                    fputs($fsock, $query);
                    fputs($fsock, "Host: {$this->server}\r\n");
                    fputs($fsock, "\r\n");
                
                    stream_set_blocking($fsock, 0);
                    stream_set_timeout($fsock, 3600);
                    
                    // Записываем поток
                
                    $this->threads[] = $fsock;
                    
                    // Переходим к следующему элементу
                
                    next($this->params);
                }
            }
            
            // Перебираем потоки
            foreach ($this->threads as $key=>$value) {
                // Если поток отработал, закрываем и удаляем
                if (feof($value)) {
                    fclose($value);
                    unset($this->threads[$key]);
                } else {
                    // Иначе считываем результаты
                    $this->results[] = fgets($value);
                }
            }
            
            // Можно поставить задержку, чтобы не повесить сервер
            sleep(1);
            
        // ... пока не выполнятся все потоки    
        } while (count($this->threads) > 0);
    
        return $this->results;
    }
}




class dl_stat_mailing_open extends dlModel {
    function __construct() {
        parent::__construct();
        $this->setTableName("dl_stat_mailing_open","Статистика открытий имейлов");
        $this->SetAddText("Добавить открытие");
        $this->AddFields(array(            
            array(new ComboTable(0,NOT_STRONG,"dls_rassilka","id","email_subject","",array(0,"* Не указано *")),"rassilka_id","Рассылка"),
            array(new DateTimeField(NowDateTime(),STRONG),"datetime","Дата/Время"),
            array(new Text("",STRONG,100),"email","Email")
            ));
    }

    
    public function OpenedBefore($rassilka_id, $email){
        $result = $this->getWhereExt("`email`='{$email}' AND `rassilka_id`='{$rassilka_id}'");
        return $result->hasElems();
    }
    
    public function CheckLetterOpened($rassilka_id, $email){
        if($email=="%%RECIEVER_EMAIL%%"){
            return null;
        }
        if(!$this->OpenedBefore($rassilka_id, $email)){
            $this->Add(["NULL",$rassilka_id,NowDateTime(),$email]);
        }
    }
    
    public static function get_mail_img_url($rassilka_id, $email){
        $email = urlencode($email);
        return  UrlHelper::Protocol()."://".APP::Config("DOMAIN")."/statopen.php?id={$rassilka_id}&email={$email}";
    }
    
    
    public function getCountRassilka($rassilka_id){
       return $this->QueryScalar("SELECT COUNT(`id`) as 'count' FROM ".$this->_table_name." WHERE `rassilka_id`='{$rassilka_id}'");
    }
    
    
}

class dl_stat_mailing_clicks extends dlModel {
    function __construct() {
        parent::__construct();
        $this->setTableName("dl_stat_mailing_clicks","Статистика кликов в имейле");
        $this->SetAddText("Добавить открытие");
        $this->AddFields(array(            
            array(new ComboTable(0,NOT_STRONG,"dls_rassilka","id","email_subject","",array(0,"* Не указано *")),"rassilka_id","Рассылка"),
            array(new DateTimeField(NowDateTime(),STRONG),"datetime","Дата/Время"),
            array(new Text("",STRONG,100),"email","Email"),
            array(new Text("",STRONG,100),"dest_url","Url")
            ));
    }
    
    public function CheckClick($rassilka_id, $email, $dest_url){
        if($email=="%%RECIEVER_EMAIL%%"){
            return null;
        } 
        $this->Add(["NULL", $rassilka_id, NowDateTime(), $email, $dest_url]);
    }
    
    public function getCountRassilka($rassilka_id){
       return $this->QueryScalar("SELECT COUNT(`id`) as 'count' FROM ".$this->_table_name." WHERE `rassilka_id`='{$rassilka_id}'");
    }
    
    public static function get_mail_website_url($rassilka_id, $email, $dest_url){
        $email = urlencode($email);
        $dest_url = urlencode($dest_url);
        return  UrlHelper::Protocol()."://".APP::Config("DOMAIN")."/statclicks.php?action=goto&id={$rassilka_id}&email={$email}&url=".$dest_url;
    }
    
    
}


?>