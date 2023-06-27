<?php
  
class Paginator
{
   private $_items_num;
   private $_recs_per_page;
   private $_page_num;
   private $_table;               
   private $_fields;               
   private $_sort_by;               
   private $_search_cond;               
   private $_iterator;     
   private $_tag_data;
   private $_params = "";
   private $_partial=false;          
                         
   function __construct($table_name,$fields,$sort_by="`id` DESC",$search_cond="",$recs_per_page=false,$page_num=false)
    {
        if(!$page_num)
            $this->_page_num=(int)REQUEST::getParam("page_num",1);
        else
            $this->_page_num=$page_num;
            
        if(!$recs_per_page)
            $this->_recs_per_page=20;
        else
            $this->_recs_per_page=$recs_per_page;
            
        if($table_name)
        {
            $this->_table=$table_name;
            if(!class_exists($this->_table))
                throw new ErrorException("Bad table name param in Paginator");    
        }   
        
        $this->_fields=$fields;
        $this->_sort_by=$sort_by;
        $this->_search_cond=$search_cond;
    }
    
    
    
    
    public static function CreateForExternalUse($items_num,$recs_per_page,$page_num,$paginator_partial)
    {
        $paginator=new Paginator(false,false);
        if($paginator_partial)
            $paginator->Partial($paginator_partial);
        $paginator->setDataForExternalUse($items_num,$recs_per_page,$page_num);
        return $paginator;
    }
    
    public function Partial($partial_name=false)
    {
        if($partial_name===false)
            return $this->_partial;
        else
            $this->_partial=$partial_name;
            
    }
    
    public function setTagData($tag_data)
    {
        $this->_tag_data=$tag_data;
    }
    
    public function setParams($params)
    {
        $this->_params=$params;
    }
    
    
    public function setDataForExternalUse($items_num,$recs_per_page=false,$page_num=false)
    {
        $this->_items_num=$items_num;
        if(!$page_num)
            $this->_page_num=(int)REQUEST::getParam("page_num",1);
        else
            $this->_page_num=$page_num;
            
        if(!$recs_per_page)
            $this->_recs_per_page=20;
        else
            $this->_recs_per_page=$recs_per_page;
            
            
    }
    
    
    public function needPagination()
    {
        if($this->getResultRecNum()>$this->_recs_per_page)
            return true;
        else
            return false;
    }
    
    // public function Execute($return_array=false,$use_out_func=false)
    // {
    //     $this->_result_return_array=$return_array;
    //     $gateway=new $this->_table();
    //     list($items,$items_num)=$gateway->getAllRecsByPageFields($this->_fields,$this->_sort_by,$this->_page_num,$this->_recs_per_page);
    //     $this->_items_num=$items_num;
        
    //     if($return_array)
    //     {
    //         if(is_array($this->_fields))
    //         {
    //             $fields_to_get=$this->_fields;
    //         }
    //         elseif(in_array($fields,$this->getFields()))
    //         {
    //             $fields_to_get[]=$fields;
    //         }
    //         elseif($fields=="*")
    //         {
    //             $fields_to_get[]=$this->getFields();
    //         }
    //         else
    //         {
    //             throw new ErrorException("Bad param fields in Pagenator->Execute");    
    //             exit();
    //         }
            
    //         $result_array=array();
    //         while($item=DataBase::fetch_array($items))
    //         {
    //             $rec=array();
    //             foreach($fields_to_get as $field_to_get)
    //             {
    //                 if($use_out_func)
    //                     $rec[$field_to_get]=TextHelper::Out($item[$field_to_get]);
    //                 else
    //                     $rec[$field_to_get]=$item[$field_to_get];
    //             }
    //             $result_array[]=$rec;
    //         }
    //         $this->_iterator=new arrIterator($result_array);
    //         return array($result_array,$items_num);
    //     }
    //     else
    //     {
    //         $this->_iterator=new mysqlIterator($items);
    //         return array($items,$items_num);
    //     }
        
    // }
    
    public function NextElem()
    {
        return $this->_iterator->NextElem();
    }
    
    public function getResult()
    {
        return $this->_iterator->getList();
    }

    public function getResultRecNum()
    {
        return $this->_items_num;
    }
    
    public function isResultNotEmpty()
    {
        if($this->getResultRecNum()>0)
            return true;
        else
            return false;
    }
    
    public function echoPagination($url_template)
    {
            /*if($page_all_number===false&&$page_num===false)
            { */
                $page_all_number=$this->getAllPageNumber();
                
                if($page_all_number>1)
                    $this->PrintPagesList($page_all_number,$this->_page_num,$url_template);
            /*}
            else
            {
                if($page_all_number!=1)
                    Paginator::PrintPagesList($page_all_number,$page_num,$url_template);
            } */  
    }
    
    public function getAllPageNumber($recs_number=false,$recs_per_page=false)
    {
        if($recs_number===false)
            $recs_number=$this->_items_num;
            
        if($recs_per_page===false)
            $recs_per_page=$this->_recs_per_page;
       
        if((int)($recs_number/$recs_per_page)==$recs_number/$recs_per_page)
        {
            $page_number=(int)($recs_number/$recs_per_page);
        }
        else
        {
            $page_number=(int)($recs_number/$recs_per_page)+1;
        }
        return $page_number; 
        
    }
    
    private $_param = 2;
    
    
    private function PrintPagesList($page_all_number,$page_num,$url_template)
    {
        //if($page_num>1)
        //    $this->Echo1Link($page_num,"<<",$url_template);
            
            
        if($page_all_number>9)
        {
            if($page_num<=$this->_param-1||$page_num>=$page_all_number-($this->_param-1))
            {
                $this->Print1Page(1,$this->_param,$page_num,$url_template);
                $this->Echo1Link(0,"...","#");
                $this->Print1Page($page_all_number-$this->_param,$page_all_number,$page_num,$url_template);
            }
            else
            {
                $this->Print1Page(1,$this->_param-1,$page_num,$url_template);
                if($page_num>$this->_param+1&&$page_num<$page_all_number-($this->_param+1))
                {
                    $this->Echo1Link(0,"...","#");
                    $this->Print1Page($page_num-1,$page_num+1,$page_num,$url_template);
                    $this->Echo1Link(0,"...","#");
                }
                else
                {
                    if($page_num<=5)
                    {
                        $this->Print1Page($this->_param,$page_num+1,$page_num,$url_template);
                        $this->Echo1Link(0,"...","#");
                    }
                }
                
                if($page_num>=$page_all_number-($this->_param+1))
                {
                    $this->Echo1Link(0,"...","#");
                    $this->Print1Page($page_num-1,$page_all_number-$this->_param,$page_num,$url_template);
                }
                $this->Print1Page($page_all_number-($this->_param-1),$page_all_number,$page_num,$url_template);
            }
        }
        else
        {
            $this->Print1Page(1,$page_all_number,$page_num,$url_template);
        }
        
        //if($page_num+1<=$page_all_number)
        //    $this->Echo1Link($page_num,">>",$url_template);
        
    }
    
    private function PrintPagesListw($page_all_number,$page_num,$url_template)
    {
        //if($page_num>1)
        //    $this->Echo1Link($page_num,"<<",$url_template);
            
            
        if($page_all_number>10)
        {
            if($page_num<=3||$page_num>=$page_all_number-3)
            {
                $this->Print1Page(1,4,$page_num,$url_template);
                $this->Echo1Link(0,"...","#");
                $this->Print1Page($page_all_number-4,$page_all_number,$page_num,$url_template);
            }
            else
            {
                $this->Print1Page(1,3,$page_num,$url_template);
                if($page_num>5&&$page_num<$page_all_number-5)
                {
                    $this->Echo1Link(0,"...","#");
                    $this->Print1Page($page_num-1,$page_num+1,$page_num,$url_template);
                    $this->Echo1Link(0,"...","#");
                }
                else
                {
                    if($page_num<=5)
                    {
                        $this->Print1Page(4,$page_num+1,$page_num,$url_template);
                        $this->Echo1Link(0,"...","#");
                    }
                }
                
                if($page_num>=$page_all_number-5)
                {
                    $this->Echo1Link(0,"...","#");
                    $this->Print1Page($page_num-1,$page_all_number-4,$page_num,$url_template);
                }
                $this->Print1Page($page_all_number-3,$page_all_number,$page_num,$url_template);
            }
        }
        else
        {
            $this->Print1Page(1,$page_all_number,$page_num,$url_template);
        }
        
        //if($page_num+1<=$page_all_number)
        //    $this->Echo1Link($page_num,">>",$url_template);
        
    }  
    
   
    
    
  
    
    private function Print1Page($beg,$end,$page_num,$url_template)
    {
        for($i=$beg;$i<=$end;$i++)
        {        
            $this->Echo1Link($page_num,$i,$url_template);
        }   
    }


    private function Echo1Link($page_num,$link_text,$url_template)
    {
        if($this->Partial())
        {
            $page=$link_text;
            if($page=="<<")
               $page=$page_num-1;
            else if($page==">>")
                $page=$page_num+1;
                
            include_partial($this->Partial(),array("active_page"=>$page_num,"page"=>$link_text,"url"=>$this->getUrl($page,$url_template),"tag_data"=>$this->getUrl($page,$this->_tag_data),"params"=>$this->_params));        
        }
        else
        {
            if($link_text==$page_num)
                echo "<span>".$i."</span>";
            else
            {
                $href=$this->getUrl($page_num,$url_template);
                echo "<a href='{$href}' ".$this->_tag_data.">".$link_text."</a> ";
            }
        }
         
    }

    private function getUrl($page_num,$url_template){
        $url_template = str_replace("%param_value%",$page_num,$url_template);
        $href = str_replace("%param%","&page_num=".$page_num,$url_template);
        if($page_num==1&&$url_template){
            $arr = explode("?",$href);
            if(isset($arr[1])){
                $href = $arr[0].UrlHelper::urlParamReplace($arr[1],array("page_num"=>null),"?");
            }
            $href = UrlHelper::removeLastSlash($href);
        }
        return $href;     
    }
}
?>