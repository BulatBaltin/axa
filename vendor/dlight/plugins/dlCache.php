<?php
  class dl_cache extends dlModel {
    
    function __construct(){
        parent::__construct();
        $this->setTableName("dl_cache","Кеш");
        $this->SetAddText("Добавить элемент");
        
        $this->AddFields(array(            
            array(new Text(uniqid(),STRONG,100),"hash","UID"),
            array(new Text("",NOT_STRONG,100),"value","Данные")
        ));        
    }
    
    public function AddData($key,$value){
        $hash = $this->getHash($key);
        $this->Add(array("NULL",$hash,json_encode($value)));
    } 
    
    public function getHash($key){
        if(is_array($key)){
            $new_key = implode("|",$key);
        }
        else{
            $new_key = $key;
        }
        return md5($new_key);
    }
    
    public function getVal($key){   
        $hash = $this->getHash($key); 
        $rec = $this->getRecFieldsByField("hash",$hash);
        if($rec){
            return json_decode($rec['value']);
        }
        else{
            return null;
        }
    }
     
  }
?>
