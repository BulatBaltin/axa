<?php
  class dlModel extends dlPlugin
  {
      /**
      * @return  dlModel
      */

    // ====================================== new methods

    //[== Standart ==] 
    public static function Create($model_name=false)
    {
        if($model_name){
            $gateway =  new $model_name();
        }
        else
        {
            $class_name = get_called_class();
            $gateway = new $class_name();
        }
        
        $gateway->ReturnIterator();
        return $gateway;  
    }
    
    function updateAssoc($id, $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        return $this->UpdateExt($id, $fields, $values);
    }

  }
  
  
  class dlModelCached 
  {
    public static $_cache = [];
     
    public static function getRecById($model_name, $id)
    {

         if(!isset(dlModelCached::$_cache[$id])){
            dlModelCached::$_cache[$id] = dlModel::Create($model_name)->getRecById($id); 
        }
        return dlModelCached::$_cache[$id];
    }
  }
  
  
  //типичные таблицы
abstract class Spr extends dlModel
{
    public static $_cache = [];

    function __construct($table_name,$rus_name)
    {
        parent::__construct(array("id","name_de","name_nl","sort"),$table_name,"id");
        $this->setTableRus($rus_name,array("ID","Name (de)","Name (nl)","Sort"));

        $this->SetAddText("Add");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new SortField());
    }

    public function get_val($id){
        if(!isset(self::$_cache[get_called_class()][$id])){
            $recs = dlModel::Create(get_called_class())->getAllRecs("id","DESC");
            while($rec = $recs->NextElem()){
                self::$_cache[get_called_class()][$rec["id"]] = $rec; 
            }
            //self::$_cache[$id] = self::val($id); 
        }
        return isset(self::$_cache[get_called_class()][$id])?self::$_cache[get_called_class()][$id]:null;
    }

}

abstract class SprMLang extends dlModel
{
    function __construct($table_name,$rus_name)
    {
        parent::__construct(array("id","name_rus","name_en"),$table_name,"id");
        $this->setTableRus($rus_name,array("ID","Название (рус.)","Название (англ.)"));

        $this->SetAddText("Добавить элемент");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new Text("",STRONG,60));
    }
}


abstract class M2MTable extends dlModel
{
    public $_master_field_name;
    public $_slave_field_name;
    function __construct($table_name,$fields_names,$id,$master_field_name,$slave_field_name)
    {
        parent::__construct($fields_names,$table_name,$id);
        
        $this->_master_field_name=$master_field_name;
        $this->_slave_field_name=$slave_field_name;
    }
    
    function RemoveByMasterId($master_id)
    {
        $this->RemoveWhere($this->_master_field_name,"=",$master_id);
    }
}
