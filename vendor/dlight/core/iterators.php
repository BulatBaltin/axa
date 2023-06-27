<?php
  
abstract class dbIterator
{
    protected $_list;
    function __construct($list)
    {
       $this->_list=$list;
    }
        
    abstract protected function NextElem($htmlspecialchars,$nl2br);
    abstract protected function hasElems();
    abstract protected function CountElems();
    abstract protected function getArray();
    abstract protected function SeekBegin();
    
    public function getList()
    {
        return $this->_list;
    }
    
    
    public function each($callback,$data=false)
    {
        if($this->hasElems())
        {
            $this->SeekBegin();
            while($elem=$this->NextElem())
            {
               $callback($elem,$data); 
            }   
        }
    }
}

class arrIterator extends dbIterator
{
    private $_i;    
    function __construct($list)
    {
        if(is_array($list))
        {
            parent::__construct($list);
            $this->_i=0;
        }
        else
             throw new ErrorException("Wrong param for ArrayIterator");
    }
    
    function getArray(){
        return $this->_list;
    }
    
    public function hasElems()
    {
        if(count($this->_list))
            return true;
        else
            return false;
        
    }
    
    public function CountElems()
    {
        return count($this->_list);
    }
    
        
    public function NextElem($htmlspecialchars=false,$nl2br=false)
    {
        if($this->_i<count($this->_list))
        {
            $return_elem=$this->_list[$this->_i];
            $this->_i++;
            
            if($htmlspecialchars)
                return TextHelper::Out($return_elem,$nl2br,false);
            else
                return $return_elem;
        }
        else 
            return false;
    }
    public function SeekBegin()
    {
        $this->_i=0;
    }
}

class mysqlIterator extends dbIterator
{    

    function __construct($list)
    {
        parent::__construct($list);       
    }
    
    public function hasElems()
    {
        if(DataBase::num_rows($this->_list))
            return true;
        else
            return false;
        
    }
    
    function getArray(){
        if($this->_list && DataBase::num_rows($this->_list))
            DataBase::data_seek($this->_list, 0);
            
        $result = array();
        while($res = DataBase::fetch_array($this->_list))
            $result[] = $res;
        
        return $result; 
    }
    
    
    public function CountElems()
    {
        return DataBase::num_rows($this->_list);
    }
        
    public function NextElem($htmlspecialchars=false,$nl2br=false)
    {
         $res = DataBase::fetch_array($this->_list);
         $result_arr=array();
         if($htmlspecialchars&&$res)
         {
            foreach($res as $key=>$value)
                 $result_arr[$key]=TextHelper::Out($value,$nl2br,false);
                 
            return $result_arr;
         }
        else
            return $res;  
            
         
    }
    
    public function SeekBegin()
    {
        if($this->_list&&DataBase::num_rows($this->_list))
            DataBase::data_seek($this->_list,0);
    }
}
?>