<?php
  abstract class dbObserver
{
    protected $_actionOnEdit=false;    
    protected $_actionOnAdd=false;    
    protected $_actionOnRemove=false;    
    
    
    protected $_EditParams=false;    
    protected $_AddParams=false;    
    protected $_RemoveParams=false;    
    
    
    
    
    function actionOnAdd($AddParams=false)
    {
        $this->_actionOnAdd=true;    
        $this->_AddParams=$AddParams;    
    }
    
    function actionOnEdit($EditParams=false)
    {
        $this->_actionOnEdit=true;    
        $this->_EditParams=$EditParams;    
    }
    
    function actionOnRemove($RemoveParams=false)
    {
        $this->_actionOnRemove=true;    
        $this->_RemoveParams=$RemoveParams;    
    }
    
    function OnEdit($id,$rec_data)
    {
        if($this->_actionOnEdit)
        {
            $this->OnEditHandler($id,$rec_data);
        }
    }
    
    function OnAdd($rec_data)
    {
        if($this->_actionOnAdd)
        {
            $this->OnAddHandler($rec_data);
        }
    }
    
    function OnRemove($id)
    {
        if($this->_actionOnRemove)
        {
            $this->OnRemoveHandler($id);
        }
    }
    
    abstract protected function OnEditHandler($id,$rec_data);
    abstract protected function OnAddHandler($rec_data);
    abstract protected function OnRemoveHandler($id);
}


class EmailObserver extends dbObserver
{
    private $_dest_email;       
    private $_DBTable;
    private $_inSendQue=false;        
    
    
    function __construct($DBTable,$dest_email=false)
    {
        if($dest_email)
            $this->_dest_email=$dest_email;
        else
            $this->_dest_email=APP::Config("dlMailer_app_email");
            
        $this->_DBTable=$DBTable;
    }
    
    function inSendQue()
    {
        $this->_inSendQue=true;    
    }
    
    private function SendEmail($subject,$label,$vars,$data_vars)
    {
        if($this->_inSendQue)
            MAILER::sendEmailQueue($this->_dest_email,$subject,$label,$vars,$data_vars);
        else
            MAILER::sendEmail($this->_dest_email,$subject,$label,$vars,$data_vars);
    }
    
    private function parseParamsAndSendEmail($ActionParams,$rec_data)
    {
        $table_fields=$this->_DBTable->getFields();
        $subject=$ActionParams['subject'];
        $label=$ActionParams['label'];
        $dest_email=$ActionParams['dest_email'];
        if($dest_email&&DataHelper::checkEmail($dest_email))
           $this->_dest_email=$dest_email;
        elseif($dest_email)
        {
            $index_email=array_search($dest_email,$table_fields);
            if($index_email!==false)
              $this->_dest_email=$rec_data[$index_email];
        }
           
        $vars=$ActionParams['vars'];   
        $data_vars_field_names=$ActionParams['data_vars'];
        $data_vars=array();
        
        foreach($data_vars_field_names as $data_vars_field_name)
        {
            $index=array_search($data_vars_field_name,$table_fields);
            if($index!==false)
              $data_vars[]=$rec_data[$index];
            else
              $data_vars[]="BAD_PARAM";
        
        }
        
        $this->SendEmail($subject,$label,$vars,$data_vars);
        
    }
     
    function OnEditHandler($id,$rec_data)
    {
        $this->parseParamsAndSendEmail($this->_EditParams,$rec_data);
    }
    
    function OnAddHandler($rec_data)
    {
        $this->parseParamsAndSendEmail($this->_AddParams,$rec_data);
        
    }
    
    function OnRemoveHandler($id)
    {
        $rec_data=$this->_DBTable->getRecById($id);
        $this->parseParamsAndSendEmail($this->_RemoveParams,$rec_data);
    }
}


?>