<?
class OneCharField extends Text
{
    function __construct()
    {
        $this->AddValidator(new OneCharValidator());
        parent::__construct("",STRONG,10);
    }
}

abstract class DataField
{
    protected $_strong;
    protected $_def_value;
    protected $_tab_name;
    protected $_tab_object;
    protected $_field_name;
    protected $_field_name_rus;
    protected $_view_in_add_form=VIEW_IN_ADD;
    protected $_on_view_function=null;
    protected $_in_listing=YES;
    protected $_in_search=YES;
    protected $_validators;
    protected $_validation_errors;
    protected $_pk = false;
    protected $_x_edit=true;
    public $_x_edit_type='';
    public $_error=false;
    
    
    public function setID($pk){
        $this->_pk = $pk;
    }
    
    public function getID(){
        return $this->_pk;
    }



    function __construct($value,$strong)
    {
        $this->_def_value=$value;
        $this->_strong=$strong;
        if($strong)
            $this->AddValidator(new RequiredValidator()); 
    }

    public function XEdit($value="")
    {
        if($value===""){
            if($this->_x_edit===1){
                return true;
            }
            else{
                return $this->_x_edit&&$this->getTab()->isEditable();
            }
        }
        else{
            $this->_x_edit=$value;
        }
    }


    public function getValidationErrors()
    {
        return $this->_validation_errors;
    }

    public function AddValidator($validator)
    {
        $this->_validators[]=$validator;
    }

    public function Validate($value)
    {
        $result=true;
        if($this->_validators){
            foreach($this->_validators as $validator)
                {
                    if(!$validator->Validate($value))
                    {
                        $this->_validation_errors[]=$validator->getValidationError();
                        $result=false;     
                    }
                }
        }
        return $result;
    }

    public function ValidateOnAdd($value)
    {
        return $this->Validate($value);
    }

    public function ValidateOnEdit($value)
    {
        return $this->Validate($value);
    }

    function NotInSearch()
    {$this->_in_search=NO;}

    function IsInSearch()
    {return $this->_in_search;}

    function NotInListing()
    {$this->_in_listing=NO;}

    function IsInListing()
    {return $this->_in_listing;}

    function echofield($value)
    {}
    
    function IsStrong()
    {return $this->_strong;}



    function SetOnViewFunction($func_name)
    {
        $this->_on_view_function=$func_name;
    }


    function IsViewInAddForm()
    {
        return $this->_view_in_add_form;
    }
    function setViewInAddForm($value)
    {
        if($value==VIEW_IN_ADD)
        {$this->_strong=STRONG;}
        
        $this->_view_in_add_form=$value;
    }

    function getDefValue()
    {return $this->_def_value;}

     
    function setTabName($tab_name,$tab_obj=null)
    {
        $this->_tab_name=$tab_name;
        $this->_tab_object=$tab_obj;
    }

    function getTab()
    {
        return $this->_tab_object;
    }


    function setFieldName($field_name)
    {
        $this->_field_name=$field_name;
    }
    function setFieldNameRus($field_name)
    {
        $this->_field_name_rus=$field_name;
    }
    function getFieldNameRus()
    {
        return $this->_field_name_rus;
    }

    function getTabName()
    {
        return $this->_tab_name;
    }
    function getFieldName()
    {
        return $this->_field_name;
    }

    function GetGlobalFieldName()
    {
        return $this->getTabName()."_".$this->getFieldName();
    }


    function ReturnViewValue($value,$add_params=false)
    {
       return $value; 
    }
        
        
    function checkViewFunction($value,$add_params){
         if($this->_on_view_function)
        {
            if(is_array($this->_on_view_function))
            {
                $class=$this->_on_view_function[0];
                $func=$this->_on_view_function[1];
                $value=call_user_func("{$class}::{$func}",$value,$add_params);
                return $this->ReturnViewValue($value,$add_params);
            }
            else
            {
                $func_name=$this->_on_view_function;
                $value=$func_name($value);
                return $this->ReturnViewValue($value,$add_params);
            }
        }
        else
        {
            return null;
        }
    }    
            
    function OnView($value,$add_params=false)
    {
        $result = $this->checkViewFunction($value,$add_params);
        if($result!==null){
            return $result;
        }
       
        $max_symbols_in_field=APP::Constant("max_symbols_in_field");
        
        $add_params=(array)$add_params;
        $add_params['original_value']=HTML::Out($value);
        
        if(strlen($value)>$max_symbols_in_field)
        {
            $value1=HTML::Out(substr(strip_tags($value), 0,$max_symbols_in_field))."...";
            return $this->ReturnViewValue($value1,$add_params);
        }
        else
        {
            $value1=HTML::Out(strip_tags($value));
            return $this->ReturnViewValue($value1,$add_params);
        }
       
    }
            


    function OnViewInverse($value)
    {
        return $value;
    }
    function OnAdd($value)
    {
        return $value;
    }
    
    function OnAfterAdd($new_rec_id,$value)
    {
        
    }

    function OnEdit($db_table,$id,$value)
    {
        return $value;
    }

    function OnRemove($id)
    {

    }

    function HasRemoveHandler()
    {return false;}

    function HasEditHandler()
    {return false;}

    function HasAddHandler()
    {return false;}
}

abstract class DataFieldHandlers extends DataField
{
    function __construct($value,$strong)
    {parent::__construct($value,$strong);}

    function HasRemoveHandler()
    {return true;}

    function HasEditHandler()
    {return true;}

    function HasAddHandler()
    {return true;}

}

abstract class KeyValueField extends DataField
{
    protected $_key;
    protected $_field;
    
    
    function __constuct($value,$strong)
    {
        parent::_constuct($value,$strong);
    }
    
    abstract public function getData();
    
    abstract public function renderHTML($name,$params="",$first_rec=null);
    
    public function renderJSON($key_field, $value_field,$first_rec=false)
    {
        $result = $this->getData();
        
        $array = array();
        
        if($first_rec)
            $array[] = array( $key_field => $first_rec[0], $value_field => $first_rec[1] );
        
        while($rec = $result->NextElem())
        {    
            $array[] = array( $key_field => $rec[$this->_key], $value_field => $rec[$this->_field] );
        }                
        
        echo json_encode($array);
    }
    
    
     public function ReturnViewValue($value,$add_params=false)
    {
     
        
        if(isset($add_params['value']))
            $data_value=$add_params['value'];
        else
            $data_value=$value;
        $temp="";
        if($this->XEdit())    
            $temp.="
            <a  data-sourceCache='false'
                data-value='{$data_value}' 
                data-sourceError='Ошибка при загрузке списка. Возможно, у вас нет прав на эту опрерацию.' 
                data-source='/backend.php?page=ajax/xedit_renderkeyvaluejson&pk=".$add_params['id']."&table=".$this->getTabName()."&field=".$this->getFieldName()."' 
                data-name='".$this->getFieldName()."' 
                class='x-edit' 
                data-type='{$this->_x_edit_type}' 
                data-pk='".$add_params['id']."' 
                data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
            
        $temp.=$value;
        
        if($this->XEdit())
            $temp.="</a>";
            
        return $temp;
    }
    
}

abstract class ComboField extends KeyValueField 
{
    
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong);
        $this->_x_edit_type='select';
    }
    
    public function renderHTML($name,$params="",$first_rec=null,$sort_by="key", $class="") 
    {
        $result=$this->getData($sort_by);
        echo "<select id='id_".$name."' name='".$name."' class='". $class."' {$params}>";
        
        if($first_rec)
            {
                echo "<option value='".$first_rec[0]."' ";
                if($first_rec[0]==$this->getDefValue())
                    echo "selected";
                echo ">".$first_rec[1]."</option>";
            
            }
        
        while($rec=$result->NextElem())
        {   
            echo "<option value='".$rec[$this->_key]."'"; 
            if($this->getDefValue()==$rec[$this->_key])
                 echo " selected";
            echo ">".$rec[$this->_field]."</option>";
            
        }                
        echo "</select>";
        
    }
    
    
    
} 

class Pass extends DataFieldHandlers
{
    private $_length;

    function __construct($value,$strong,$length)
    {
        $this->_length=$length;
        parent::__construct($value,$strong);
        $this->_x_edit_type='password';
    }

    function echofield($value)
    {
        Pass::render($this->GetGlobalFieldName(),"");
    }

     public static function render($name,$value,$params="")
    {
        echo "<input type='password' name='".$name."' id='id_".$name."' value=\"{$value}\" {$params}>";
    }
    
    
    function OnView($value, $add_params = false)
    {
        return "Скрыт";    
    }
    
    public function ValidateOnEdit($value)
    {
        return true;
    }

    function OnEdit($db_table,$id,$value)
    {
        if($value=="")
            return "NOT_SET";
        else
            return md5($value);
    }
    
    function OnAdd($value)
    {
        return md5($value);
    }

    
    
}

class Num extends Text
{
    function __construct($value,$strong,$length)
    {
        $this->AddValidator(new NumValidator());
        parent::__construct($value,$strong,$length);
    }
}

class Email extends Text
{
    function __construct($value,$strong,$length)
    {
        $this->AddValidator(new EmailValidator());
        parent::__construct($value,$strong,$length);
        $this->_x_edit_type='email';
    }
    
    public function OnView($value,$add_params=false)
    {
        $add_params=(array)$add_params;
        $add_params['href']="mailto:".$value;
        return $this->ReturnViewValue($value,$add_params);
    }
}

class SortField extends Text
{
    function __construct()
    {
        $this->AddValidator(new NumValidator());
        parent::__construct(0,STRONG,10);
    }
    
    function OnView($value,$add_params = false)
    {
        //$this->ReturnViewValue($value,$add_params)
        return "<i class='icon-reorder sort_handle'></i>";
    } 
}

class Text extends DataField
{
    protected $_length;

    function __construct($value,$strong,$length=100)
    {
        $this->_length=$length;
        parent::__construct($value,$strong);
        $this->_x_edit_type='text';
    }
    
    function ReturnViewValue($value,$add_params=false)
    {
        $temp="";
        if($this->XEdit())
        {   
            if(!isset($add_params['href']))
                $href='#';
            else
                $href=$add_params['href'];
            $temp.="<a 
                        href='{$href}' 
                        data-name='".$this->getFieldName()."' 
                        class='x-edit x-edit-cont-".$this->getFieldName()."' 
                        data-type='{$this->_x_edit_type}' 
                        data-pk='".$add_params['id']."' 
                        data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
        }
            
        $temp.=$value;
        
        if($this->XEdit())
            $temp.="</a>";
            
        return $temp;
    }

    function echofield($value)
    {
        Text::render($this->GetGlobalFieldName(),$value,$this->_length,"","","",true);   
    }

    public static function render($name,$value,$size="",$params="",$class="",$placeholder="",$htmlspecialchars=false)
    {
        if(!$class)
            $class="good_text";
        
        if($htmlspecialchars)
            $value=TextHelper::Out($value);
        
        $placeholder_str="";
        if($placeholder)
            $placeholder_str="placeholder='{$placeholder}'";
        
        $size_str="";
        if($size)
            $size_str="size='{$size}'";
        
        echo "<input type='text' name='".$name."' id='id_".$name."' {$placeholder_str} {$size_str} value=\"{$value}\" class='{$class}' {$params}>";
    }
}

class MultiText extends DataField
{
    private $_cols;
    private $_rows;
    function __construct($value,$strong,$cols,$rows)
    {
        $this->_cols=$cols;
        $this->_rows=$rows;
        parent::__construct($value,$strong);
        $this->XEdit(false);
        $this->_x_edit_type='textarea';
    }

    function echofield($value)
    {
        MultiText::render($this->GetGlobalFieldName(),$value,$this->_rows,$this->_cols,"","",true);
    }

    public static function render($name,$value,$rows,$cols,$params="",$class="",$htmlspecialchars=false)
    {
        if(!$class)
            $class="good_text";
        
        if($htmlspecialchars)
            $value=TextHelper::Out($value,false,false);
            
        echo "<textarea name='".$name."' id='id_".$name."' rows='".$rows."' cols='".$cols."' class='{$class}' {$params}>".$value."</textarea>";
    }
    
    
    
     function ReturnViewValue($value,$add_params=false)
    {
        $temp="";
        if($this->XEdit())
        {   
            $temp.="<a 
                        data-name='".$this->getFieldName()."'
                        data-rows='{$this->_rows}' 
                        class='x-edit' 
                        data-type='{$this->_x_edit_type}' 
                        data-pk='".$add_params['id']."' 
                        data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
        }
            
        $temp.=$value;
        
        if($this->XEdit())
            $temp.="</a>";
            
        return $temp;
    }
    
    
    
    
}

class ID extends DataField
{
    function __construct()
    {
        parent::__construct("",STRONG);
    }
    
    public function OnView($value,$add_params=false)
    {
        $result = $this->checkViewFunction($value,$add_params);
        if($result!==null){
            return $result;
        }
        return $this->ReturnViewValue("<span class='id_field'>[ {$value} ]</span>",$add_params);
    }
}

class MapField extends DataField
{
    private $_width;
    private $_height;
    function __construct($value,$strong,$width=600,$height=500)
    {
        $this->_width=$width;
        $this->_height=$height;
        parent::__construct($value,$strong);
    }
    function echofield($value)
    {
        MapField::render($this->GetGlobalFieldName(),$value,$this->_width,$this->_height,true,"","");
    }

   public static function render($id,$value,$width,$height,$is_draggable,$name,$disc)
   {
       if($value)
        list($coords,$zoom)=explode(";",$value);
       else
        {
            $coords="55.73856806371529,37.521484374998664";
            $zoom="5";
        }
       echo " <script src=\"//api-maps.yandex.ru/2.0/?load=package.standard&mode=debug&lang=ru-RU\" type=\"text/javascript\"></script>";
       echo "
        <div id='YMapsID{$id}' style='width:{$width}px;height:{$height}px'></div>
        <input type='hidden' size='30' name='{$id}' id='id_{$id}' value='{$value}'>

        <script type='text/javascript'>
        
               var myMap{$id}=0;
                ymaps.ready(function () { 
                   
                   myMap{$id} = new ymaps.Map('YMapsID{$id}', {
                            // Центр карты
                            center: [{$coords}],
                            // Коэффициент масштабирования
                            zoom: {$zoom}
                            // Тип карты
                            //type: 'yandex#satellite'
                        }
                    );
                    
                    // Добавление стандартного набора кнопок
                    myMap{$id}.controls.add('mapTools')
                        // Добавление кнопки изменения масштаба 
                        .add('zoomControl')
                        // Добавление списка типов карты
                        .add('typeSelector');
                    
                    
                    
                    var myPlacemark{$id} = new ymaps.Placemark(
                            // Координаты метки
                            [{$coords}], {
                                iconContent: '{$name}',
                                // - контент балуна метки
                                balloonContent: '{$disc}'
                            }, {";
                                if($is_draggable)
                                    echo "draggable: true,";
                                echo "
                                hideIconOnBalloonOpen: false
                            }
                        );

                        
                    // Добавление метки на карту
                    myMap{$id}.geoObjects.add(myPlacemark{$id});
                    
                    myPlacemark{$id}.events.add('dragend',
                        function(e) {
                                        $('#id_{$id}').val(myPlacemark{$id}.geometry.getCoordinates()+';'+myMap{$id}.getZoom());
                                    }
                    );       
                   myMap{$id}.events.add('boundschange',
                        function(e) {
                                        $('#id_{$id}').val(myPlacemark{$id}.geometry.getCoordinates()+';'+myMap{$id}.getZoom());
                                    }
                    ); 
                });
                    
    function MapGoTo{$id}(name,flying_flag)
    {
        ymaps.geocode(name).then(function (res) {
        myMap{$id}.panTo(
                                // Координаты нового центра карты
                                res.geoObjects.get(0).geometry.getCoordinates(), 
                                {
                                    flying: flying_flag
                                }
                        );
            
        }); 
    }              
    </script>";
}

}

class MultiOption extends KeyValueField
{
    protected $_table;
    protected $_sort_fields_str;
    
    protected $_tags_view;
    protected $_many_to_many_embedded=true;
    protected $_many_to_many_external_table;
    
    public $additional_table_label = null;
    public $additional_table_label_value = null;
    
    
    public function additionalTableLabel($label = false, $label_value = false){
        if( $label && $label_value ) {
            $this->additional_table_label = $label; 
            $this->additional_table_label_value = $label_value;
        }
        else{
           return array( $this->additional_table_label, $this->additional_table_label_value ); 
        }
    }
    
    
    function setManyToManyExternalTable($many_to_many_external_table)
    {
        $this->_many_to_many_embedded=false;
        $this->_many_to_many_external_table=$many_to_many_external_table;    
    }
    
    function __construct($value,$strong,$table,$key,$field,$sort_fields_str=false,$tags_view=false,$many_to_many_external_table=false,
    $additional_table_label = null, $additional_table_label_value = null
    )
    {
        $this->_table=$table;
        $this->_key=$key;
        $this->_tags_view=$tags_view;
        
        $this->additional_table_label = $additional_table_label;
        $this->additional_table_label_value = $additional_table_label_value;
        
        if($many_to_many_external_table)
            $this->setManyToManyExternalTable($many_to_many_external_table);
        
        if(!$sort_fields_str)
            $this->_sort_fields_str=$key." ASC";
        
        $this->_field=$field;
        parent::__construct($value,$strong);
        
        if($this->_tags_view)
            $this->_x_edit_type='select2';
        else
            $this->_x_edit_type='checklist';
    }
    
    function getDefValue()
    {
        /*if(!$this->_many_to_many_embedded)
        {
            
        }
        else*/
            return $this->_def_value;
    }
    
   function echofield($value)
    {
        MultiOption::render($this->GetGlobalFieldName(),$this->_table,$this->_key,$this->_field,$value,false,$this->_tags_view,$this->_many_to_many_external_table,$this->additional_table_label,$this->additional_table_label_value);
    }
    
    function getData()
    {   // echo 2;    
        if(!$this->_sort_fields_str)
            $this->_sort_fields_str=$this->_key." ASC";

        return DataBase::ExecuteQuery("SELECT ".$this->_key.",".$this->_field." FROM ".$this->_table." ORDER BY ".$this->_sort_fields_str,'iterator');
    }
    
    
    public function ReturnViewValue($value,$add_params=false)
    {
        
        
        if($this->_tags_view)
        {
            if($add_params['value'])
                $data_value=$add_params['value'];
            else
                $data_value=$value;
                
            $item_id=$add_params['id'];
            $temp="";
            if($this->XEdit())    
                $temp.="
                <a  
                    data-value='{$data_value}' 
                    id='".$item_id."_".$this->getFieldName()."_".$this->getTabName()."'
                    data-name='".$this->getFieldName()."' 
                    data-type='{$this->_x_edit_type}' 
                    data-pk='".$item_id."' 
                    data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
                
            $temp.=$value;
            
            if($this->XEdit())
                {
                    $temp.="</a>";
                    $temp.="<script language='Javascript'>
                        \$(function(){
            
                            \$.post('/backend.php?page=ajax/xedit_renderkeyvaluejson&pk=".$item_id."&table=".$this->getTabName()."&field=".$this->getFieldName()."&param1=id',
                                {},
                                function(data1,success){
                                 
                                    \$('#".$item_id."_".$this->getFieldName()."_".$this->getTabName()."').editable({
                                        source: data1,
                                        select2: {
                                           multiple: true
                                        }
                                    });
                                    
                                  /*  \$('.class_".$this->getFieldName()."_".$this->getTabName()."').editable({
                                        source: data1,
                                        select2: {
                                           multiple: true
                                        }
                                    });*/
                                },
                                'json'
                                );  
         
                        });
                    </script>";
                
                }
                
            return $temp;
        }
        else
        {
             return parent::ReturnViewValue($value,$add_params);
        }
    }
                
    
    function OnAfterAdd($new_rec_id,$value)
    {
        if(!$this->_many_to_many_embedded)
        {
            //тут нужно синхронизировать все с таблицей данных
            $slave_ids=explode(";",$value);
            $m2m_table=$this->_many_to_many_external_table;
            
            $table_gateway=new $m2m_table();
            
            
            list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
           
                
            if(count($slave_ids)&&$value)
                foreach($slave_ids as $slave_id){
                    if(!$additional_table_label){
                        $table_gateway->Add(array("NULL",$new_rec_id,$slave_id));   
                   }
                   else{
                        $table_gateway->Add(array("NULL",$new_rec_id,$slave_id, $additional_table_label_value));
                   }
                }
                
                
                
      /*      function AddRecAdditionalTable($additional_table_master_key, $additional_table_slave_key){
       
       //далее нужно создать экземпляр таблицы вспомагательной
       if(class_exists($this->additional_table_name)){
           
           $additional_table_gateway = new $this->additional_table_name();
           list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
           if(!$additional_table_label){
                $additional_table_gateway->Add(array("NULL", $additional_table_master_key, $additional_table_slave_key));   
           }
           else{
                $additional_table_gateway->Add(array("NULL", $additional_table_master_key, $additional_table_slave_key, $additional_table_label_value));
           }
       
       }
            
   }*/
                
                
                  
        }      
    }
    
    function OnEdit($db_table,$id,$value)
    {
        if(!$this->_many_to_many_embedded)
        {
            //тут нужно синхронизировать все с таблицей данных
            $slave_ids=explode(";",$value);
            
            $m2m_table=$this->_many_to_many_external_table;
            $table_gateway=new $m2m_table();
            
             list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
            
            if(!$additional_table_label){
                $table_gateway->RemoveByMasterId($id);
            }
            else{
                $table_gateway->RemoveWhereExt("`{$table_gateway->_master_field_name}`='{$id}' AND `{$additional_table_label}` = '{$additional_table_label_value}'");
            }
            if(count($slave_ids)&&$value)
                foreach($slave_ids as $slave_id)
                {
                    if(!$additional_table_label){
                        $table_gateway->Add(array("NULL",$id,$slave_id));
                    }
                    else{
                        $table_gateway->Add(array("NULL",$id,$slave_id,$additional_table_label_value));
                    }
                }
        }
        
        return $value;
    } 
    
    function OnRemove($id)
    {
        if(!$this->_many_to_many_embedded)
        {
            $m2m_table=$this->_many_to_many_external_table;
            $table_gateway=new $m2m_table();
            if(!$additional_table_label){
                $table_gateway->RemoveByMasterId($id);
            }
            else{
                $table_gateway->RemoveWhereExt("`{$table_gateway->_master_field_name}`='{$id}' AND `{$additional_table_label}` = '{$additional_table_label_value}'");
            }
        }
    }   
        
    
    public function renderHTML($name,$params="",$first_rec=null)
    {
          
        $result=$this->getData();
        $def_value=$this->getDefValue();
          
        if(!$this->_tags_view)
        {              
            $selected_keys_arr=explode(";",$def_value);
            HiddenField::render($name,$def_value);
            
            while($rec=$result->NextElem())
            {    
                echo "<div>";
                echo "<input type='checkbox' data-item_id='{$rec[$this->_key]}' class='class_{$name}' ";
                if(in_array($rec[$this->_key],$selected_keys_arr))
                    echo "checked";
                echo "> ".TextHelper::Out($rec[$this->_field]);
                echo "</div>";
            }       
                     
            echo "
            <script type='text/javascript'>
               $(document).ready(function(){    
                  $('.class_{$name}').change(function(){
                        var ids=new Array();
                        $('.class_{$name}').each(function(){
                            if($(this).prop('checked'))
                                ids.push($(this).data('item_id'));
                        }); 
                        $('#id_{$name}').val(ids.join(';'));
                  });
               });
            </script>";
        }
        else
        {
            $selected_keys_arr=explode(";",$def_value);
            echo "<select multiple id='id_temp_".$name."'   {$params} style='width:200px;'>";
                
            while($rec=$result->NextElem()){   
                
                    echo "<option value='".$rec[$this->_key]."'";
                    if(in_array($rec[$this->_key],$selected_keys_arr)){ 
                         echo " selected";
                    }
                    echo ">".$rec[$this->_field]."</option>";
            }                
            
            
            echo "</select>";
            
            HiddenField::render($name,$def_value);
            
             echo "
            <script type='text/javascript'>
               \$(document).ready(function(){    
                  \$('#id_temp_".$name."').select2({width:'500px'});
                  
                  \$('#id_temp_".$name."').change(function(event){
                  
                                                  
                  
                         var val=( ( event.val instanceof Array ) ? event.val.join ( ';' ) : event.val );
                         \$('#id_".$name."').val(val);
                  
                  })
                  
               });
            </script>";
            
        }
        
        
        
        
    }
    

    public static function render($name,$table,$key,$field,$selected_keys="",$sort_fields=false,$tags_view=false,$m2m=false, $additional_table_label = null ,$additional_table_label_value = null){
        
         $mo=new MultiOption($selected_keys,STRONG,$table,$key,$field,$sort_fields,$tags_view,$m2m, $additional_table_label,$additional_table_label_value);
         $mo->renderHTML($name);
         
    }


    function OnView($value,$add_params = false)
    {    
         $selected_keys_arr=explode(";",$value);
         $selected_keys_sql=implode(", ",$selected_keys_arr);
         $result=DataBase::ExecuteQuery("SELECT ".$this->_field." FROM `".$this->_table."` WHERE `".$this->_key."` IN ({$selected_keys_sql})");
         
         $res=array();
         while($item=DataBase::fetch_array($result))
            $res[]=TextHelper::Out($item[$this->_field]);
         
         $add_params=(array)$add_params;
         $add_params['value']=$selected_keys_sql;
         return $this->ReturnViewValue(implode("<br>",$res),$add_params);
    }



}






class MultiOptionLP extends MultiOption 
{    
     function __construct($value,$strong,$table,$key,$field,$sort_fields_str=false,$tags_view=false,$many_to_many_external_table=false)
    {
        
        parent::__construct($value,$strong,$table,$key,$field,$sort_fields_str,$tags_view,$many_to_many_external_table);
        
    }
    
    function echofield($value)
    {
        MultiOptionLP::render($this->GetGlobalFieldName(),$this->_table,$this->_key,$this->_field,$value,false,$this->_tags_view,$this->_many_to_many_external_table);
    }
    
    /*public static function render($name,$table,$key,$field,$selected_keys="",$sort_fields=false,$tags_view=false,$m2m=false)
    {
         $mo=new MultiOptionLP($selected_keys,STRONG,$table,$key,$field,$sort_fields,$tags_view,$m2m);
         $mo->renderHTML($name);
    } */
    
    public static function render($name,$table,$key,$field,$selected_keys="",$sort_fields=false,$tags_view=false,$m2m=false, $additional_table_label = null ,$additional_table_label_value = null){
        
         $mo=new MultiOptionLP($selected_keys,STRONG,$table,$key,$field,$sort_fields,$tags_view,$m2m);
         $mo->renderHTML($name);
         
    }
    
    public function renderHTML($name,$params="",$first_rec=null)
    {

        $result=$this->getData();
        $def_value=$this->getDefValue();
        
        if(!$this->_tags_view)
        {              
            $selected_keys_arr=explode(";",$def_value);
            HiddenField::render($name,$def_value);
            
            while($rec=$result->NextElem())
            {    
                echo "<div>";
                echo "<input type='checkbox' data-item_id='{$rec[$this->_key]}' class='class_{$name}' ";
                if(in_array($rec[$this->_key],$selected_keys_arr))
                    echo "checked";
                echo "> ".TextHelper::Out($rec[$this->_field]);
                echo "</div>";
            }       
                     
            echo "
            <script type='text/javascript'>
               $(document).ready(function(){    
                  $('.class_{$name}').change(function(){
                        var ids=new Array();
                        $('.class_{$name}').each(function(){
                            if($(this).prop('checked'))
                                ids.push($(this).data('item_id'));
                        }); 
                        $('#id_{$name}').val(ids.join(';'));
                  });
               });
            </script>";
        }
        else
        {
            $selected_keys_arr=explode(";",$def_value);
            echo "<select multiple id='id_temp_".$name."'   {$params} style='width:200px;'>";
                
            $selected_data = [];
            while($rec=$result->NextElem()){   
                if(in_array($rec[$this->_key],$selected_keys_arr)){
                    $selected_data[] = ["key"=>$rec[$this->_key],"val"=>$rec[$this->_field]];
                }
            }                
            
            foreach($selected_keys_arr as $selected_key){
                foreach($selected_data as $data){
                    if($data["key"]==$selected_key){
                        echo "<option value='".$data["key"]."'"; 
                         echo " selected";
                         echo ">".$data["val"]."</option>";            
                    }
                }
            }
            
            
            
            
            $result->SeekBegin();
            while($rec=$result->NextElem()){
                if(!in_array($rec[$this->_key],$selected_keys_arr)){   
                    echo "<option value='".$rec[$this->_key]."'";    
                    echo ">".$rec[$this->_field]."</option>";
                }
            }
            
            echo "</select>";
            
            HiddenField::render($name,$def_value);
            
             echo "
            <script type='text/javascript'>
               \$(document).ready(function(){    
                  \$('#id_temp_".$name."').select2({width:'1000px'});
                  
                  \$('#id_temp_".$name."').change(function(event){
                  
                  
                  
                        var vals_arr = new Array();
                          /*
                          
                          
                         \$(this).children(':selected').each(function(){
                             vals_arr.push(\$(this).val());
                          });*/
                          
                          
                         \$('.select2-choices li div').each(function(){
                             vals_arr.push(\$(this).text());
                          });
                          
                          \$('#id_".$name."').val(vals_arr.join ( ';' ));
                          console.log(vals_arr);
                  
                         //var val=( ( event.val instanceof Array ) ? event.val.join ( ';' ) : event.val );
                         //\$('#id_".$name."').val(val);
                  
                  })
                  
               });
            </script>";
            
        }
        
    }
}

class YesNoComboArray extends ComboArray
{
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong,array(ll("NO"),ll("YES")));
    }
}

class OnOffComboArray extends ComboArray
{
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong,array("Откл.","Вкл."));
    }
}


class ComboArray extends ComboField
{
    private $_array;
    function __construct($value,$strong,$array)
    {
        $this->_key="key";
        $this->_field="value";
        $this->_array=$array;
        parent::__construct($value,$strong);
    }
    function echofield($value)
    {
        ComboArray::render($this->GetGlobalFieldName(),$value,$this->_array);
    }

    public function getData() 
    {
        $array=array();
        foreach($this->_array as $key=>$value)
        {
            $array[]=array($this->_key=>$key,$this->_field=>$value);
        }
        return new arrIterator($array);
    }

public static function render($name,$selected,$ar,$params="",$first_rec=null, $class="")
{
    
    $ctarr=new ComboArray($selected,STRONG,$ar);
    $ctarr->renderHTML($name,$params, $first_rec, 'key', $class);
    
    /*echo "<select id='id_".$name."' name='".$name."' class='good_text' {$params}>";
    
    if($first_rec)
        {
            echo "<option value='".$first_rec[0]."' ";
            if($first_rec[0]==$selected)
                echo "selected";
            echo ">".$first_rec[1]."</option>";
        
        }
    
    while (list ($key, $val) = each ($ar) )
    {
        if($key==$selected)
        {
            echo "<option value='".$key."' selected>".$val."</option>";
        }
        else
        {
            echo "<option value='".$key."'>".$val."</option>";
        }
    }
    echo "</select>";*/
}

public static function printComboYesNo($name,$selected)
{
    $yesnoarray=array(0=>"Нет",1=>"Да");
    ComboArray::render($name,$selected,$yesnoarray);
}


public static function printComboOnOff($name,$selected,$params="")
{
    $onoffarray=array(0=>"Выкл.",1=>"Вкл.");
    ComboArray::render($name,$selected,$onoffarray,$params);
}



function OnViewInverse($value)
{    
    if(in_array($value,$this->_array))
    {
        return array_search($value,$this->_array);
    }
    else
    {
        return false;
    }
            
}

function OnView($value,$add_params =false)
{    
    if($this->_on_view_function)
    {
        $func_name=$this->_on_view_function;
        $add_params=(array)$add_params;
        $add_params['value']=$value;
        $value=$func_name($value, $add_params);
        return $this->ReturnViewValue($value,$add_params);
    }
    else
    {
            return $this->ReturnViewValue($this->_array[$value],$add_params);
    }
}


}

class ComboTableSQL extends ComboField
{
    private $_select;
    private $_from;
    private $_where;
    private $_last_part;
    /*private $_key;
    private $_field;*/
    private $_params;
    private $_first_rec;
    function __construct($value,$strong,$select,$from,$where,$last_part,$key,$field,$params="",$first_rec=false)
    {
        $this->_select=$select;
        $this->_from=$from;
        $this->_where=$where;
        $this->_last_part=$last_part;
        
        $this->_params=$params;
        $this->_first_rec=$first_rec;
        
        $this->_key=$key;
        $this->_field=$field;
        parent::__construct($value,$strong);
    }
    function echofield($value)
    {
        ComboTableSQL::render($this->GetGlobalFieldName(),$this->_select,$this->_from,$this->_where,$this->_last_part,$this->_key,$this->_field,$value,$this->_params,$this->_first_rec);
    }
    
    public function getData() 
    {
        return DataBase::ExecuteQuery("SELECT {$this->_select} FROM {$this->_from} WHERE {$this->_where} {$this->_last_part}",'iterator');
    }

    public static function render($name,$select,$from,$where,$last_part,$key,$field,$selected_key,$params="",$first_rec=null)
    {
        
        $ctsql=new ComboTableSQL($selected_key,STRONG,$select,$from,$where,$last_part,$key,$field);
        $ctsql->renderHTML($name,$params,$first_rec);
        
  
    }



    function OnViewInverse($value)
    {    
         $result=DataBase::ExecuteQuery("SELECT ".$this->_select." FROM `".$this->_from."` WHERE `".$this->_field."`='{$value}'");
         $rec=DataBase::fetch_array($result);
         return $rec[$this->_key];
    }

    function OnView($value,  $add_params = false)
    {    
         
         $result=DataBase::ExecuteQuery("SELECT ".$this->_select." FROM `".$this->_from."` WHERE `".$this->_key."`='{$value}'");
         $rec=DataBase::fetch_array($result);
         return $rec[$this->_field];
    }
}

class ComboTable extends ComboField
{
    public $_table;
    protected  $_params="";
    protected  $_first_rec=null;
    protected  $_sort_str="";
    /*private $_key;
    private $_field;*/
    
    function __construct( $value, $strong, $table, $key, $field, $params="", $first_rec=null , $sort_str = "")
    {
        $this->_sort_str = $sort_str;
        $this->_table=$table;
        $this->_key=$key;
        $this->_field=$field;
        
        $this->_params=$params;
        $this->_first_rec=$first_rec;
        
        parent::__construct($value,$strong);
    }
    
    function echofield($value,$select_name=false)
    {
        if(!$select_name){
            $select_name = $this->GetGlobalFieldName();
        } 
        if(!$this->_sort_str){
            $sort_by = "field";
        }
        else{
            $sort_by = $this->_sort_str;
        }
        ComboTable::render($select_name,$this->_table,$this->_key,$this->_field,$value,$this->_params,$this->_first_rec,$sort_by);   
    }


   
    
    public function getData($sort_by="key") 
    {   
        if($sort_by=="key")  {
            $sort_by_str = $this->_key." ASC";
        }
        elseif($sort_by=="field"){
            $sort_by_str = $this->_field." ASC";
        }
        else{
            $sort_by_str = $sort_by;
        }
        return DataBase::ExecuteQuery("SELECT ".$this->_key.",".$this->_field." FROM ".$this->_table." ORDER BY ".$sort_by_str,'iterator');
    }

    

    public static function render($name,$table,$key,$field,$selected_key,$params="",$first_rec=null,$sort_by="key")
    {
        $ct=new ComboTable($selected_key,STRONG,$table,$key,$field);
        $ct->renderHTML($name,$params,$first_rec,$sort_by);
    }
    
   

    function OnViewInverse($value)
    {    
         $result=DataBase::ExecuteQuery("SELECT ".$this->_key." FROM `".$this->_table."` WHERE `".$this->_field."`='{$value}'");
         $rec=DataBase::fetch_array($result);
         return $rec[$this->_key];
    }

    function OnView($value,$add_params = false)
    {   
        $result=DataBase::ExecuteQuery("SELECT ".$this->_field." FROM `".$this->_table."` WHERE `".$this->_key."`='{$value}'");
         $rec=DataBase::fetch_array($result);

        if($this->_on_view_function)
        {
            $func_name=$this->_on_view_function;
            $add_params=(array)$add_params;
            $add_params['value']=$value;
            $value=$func_name($rec[$this->_field], $add_params);
            return $this->ReturnViewValue($value,$add_params);
        }
        else
        { 
        
        
         return $this->ReturnViewValue($rec[$this->_field],$add_params);

        }
    }



}

class FileField extends DataFieldHandlers
{
    private $_directory;
    private $_directory_to_add_to_th_field;
    function __construct($strong,$directory,$directory_to_add_to_th_field="")
    {
    $this->_directory=$directory; //формат: ../files/
    $this->_directory_to_add_to_th_field=$directory_to_add_to_th_field;//формат: images/123/

    parent::__construct("",$strong);
    }
    function echofield($value)
    {
        FileField::render($this->GetGlobalFieldName());
    }

    public static function render($name, $params="")
    {
        echo "<input type='file' class='good_text' name='".$name."' id='id_".$name."' {$params}/>";
    }


    function OnView($value,  $add_params = false)
    {
        if($this->_on_view_function)
        {
            $func_name=$this->_on_view_function;
            $value=$func_name($value);
            return $value;
        }
        else
        {
        return "<a href='/{$this->_directory}{$value}'>{$value}</a>";
        }
    }

    function OnAdd($value)
    {
         if($_FILES[$this->GetGlobalFieldName()]['name'])
                {
                      $ar=FILE_SYSTEM::getFileNameAndExtension($_FILES[$this->GetGlobalFieldName()]['name']);
                      $ext=$ar[1];
                      //print_r($ar);
                      $new_name=tempvalue();
                      move_uploaded_file($_FILES[$this->GetGlobalFieldName()]['tmp_name'], getDocumentRoot().$this->_directory.$new_name.".".$ext);
                      return $this->_directory_to_add_to_th_field.$new_name.".".$ext;     
                     
                }
                else
                    return "NOT_SET";
                
        
         
    }
    function OnEdit($db_table,$id,$value)
    {
        $rec=$db_table->getRecFieldsById($id,array($this->getFieldName()));
        
        if($_FILES[$this->GetGlobalFieldName()]['name'])
                {
                 /*    if($_FILES[$this->GetGlobalFieldName()]['size']>$this->_size*1024)
                    {
                    $this->_error="Слишком большой размер файла. Максимальный размер: {$this->_size} KB";
                   
                    return "NOT_SET";
                    }*/
                      $ar=explode("[.]",$_FILES[$this->GetGlobalFieldName()]['name']);
                      $ext=$ar[count($ar)-1];
                      $new_name=tempvalue();
                      if(file_exists(getDocumentRoot().$this->_directory.$rec[$this->getFieldName()])&&$rec[$this->getFieldName()]!="")
                      {
                        unlink(getDocumentRoot().$this->_directory.$rec[$this->getFieldName()]);
                      }
                      move_uploaded_file($_FILES[$this->GetGlobalFieldName()]['tmp_name'], getDocumentRoot().$this->_directory.$new_name.".".$ext);
                      return $this->_directory_to_add_to_th_field.$new_name.".".$ext;
                }
                else
                {return "NOT_SET";}

    }

    function OnRemove($id)
    {
        $rec=$this->getTab()->getRecById($id);
        if(file_exists(getDocumentRoot().$this->_directory.$rec[$this->getFieldName()])&&$rec[$this->getFieldName()]!="")
            unlink(getDocumentRoot().$this->_directory.$rec[$this->getFieldName()]);
    }



}

class ItemParamsField extends DataFieldHandlers{
    
    public $additional_table_name; 
    public $additional_table_external_key;
    public $additional_table_param_name; 
    public $sort_by_first_param = false;
    //public $additional_table_param_value;
    public $header_texts = array("Название", "Значение"); 
    
    function __construct( $value, $strong,  $header_texts=false, $additional_table_name=false, $additional_table_external_key=false, $additional_table_param_name=false, $sort_by_first_param = false)/*, $additional_table_param_value=false*/
    {
        $this->sort_by_first_param = $sort_by_first_param;    
        $this->additional_table_name = $additional_table_name;
        $this->additional_table_external_key = $additional_table_external_key;
        $this->additional_table_param_name = $additional_table_param_name;
        //$this->additional_table_param_value = $additional_table_param_value;
        if($header_texts){
            $this->header_texts = $header_texts;
        }
    }
    
    function echofield($value){
        include_dlight_partial("ItemParamsField",array(
            "field"=>$this,
            "value"=>$value)
            );
    }
    
     function OnView($value,  $add_params = false){ 
        if($this->_on_view_function){
            return parent::OnView($value);
        }
        else{
            if(!is_object($this->additional_table_param_name)){    
                return str_replace(array(";",":"),array("<br>"," : "), $value);
            }
            else{
                if($value){
                    $field = $this->additional_table_param_name;
                    $data = $field->getData();
                    $spr = array();
                    while($row = $data->NextElem()){
                        $spr[$row[0]] = $row[1];
                    }
                    
                    $params = explode(";" , $value);
               
                    for($i=0;$i<count($params);$i++){
                        $param_data = explode(":" , $params[$i]);
                        $params[$i] = $spr[$param_data[0]]." : ".$param_data[1];    
                    }
                    return implode("<br>",$params);
                }
                else{
                    return "";
                }
            }
        }
    }
    
    
    
    function OnAfterAdd($new_rec_id,$value){
       if(!$this->additional_table_name||!$value)
        return;
        
       //далее нужно создать экземпляр таблицы вспомагательной
       if(class_exists($this->additional_table_name)){
           
           $additional_table_gateway = new $this->additional_table_name();
           $params = explode(";" , $value);
           
           foreach($params as $param){
                $param_data = explode(":" , $param);
                $additional_table_gateway->Add(array("NULL", $new_rec_id, $param_data[0], $param_data[1]));    
           }
            
       }
         
   }
   
   public function formatDataFromPost(){
            $delim=":";
            $separator=";";
            
         $field_id = $this->GetGlobalFieldName();
         $param_names = $_POST["param_name_".$field_id];
         $param_values = $_POST["param_value_".$field_id];
         $result = array();
         for($i=0;$i<count($param_names);$i++){
            if($param_names[$i]!=""&&$param_values[$i]!=""){
                $result[] = $param_names[$i].":".$param_values[$i];
            }      
         }
         if(count($result)){
             return implode(";",$result);
         }
         else{
            return "";
         }
   }
   
   function OnEdit($db_table,$id,$value){
   
        $value = $this->formatDataFromPost();
           
        if(!$this->additional_table_name)
        return $value;
       
       //далее нужно создать экземпляр таблицы вспомагательной
       if(class_exists($this->additional_table_name)){
           $additional_table_gateway = new $this->additional_table_name();
           //удаляем 
           $additional_table_gateway->RemoveWhere($this->additional_table_external_key,"=",$id);
           
           if($value){
              $params = explode(";" , $value);
               
               foreach($params as $param){
                    $param_data = explode(":" , $param);
                    $additional_table_gateway->Add(array("NULL", $id, $param_data[0], $param_data[1]));    
               } 
           }
       }
       
       return $value; 
    }
    
    function OnAdd($value)
    {
         //$this->GetGlobalFieldName()
         return $this->formatDataFromPost();
                
                    
    //        return "NOT_SET"; 
    }
    
    function OnRemove($id){
        if(!$this->additional_table_name)
            return;
           
           //далее нужно создать экземпляр таблицы вспомагательной
           if(class_exists($this->additional_table_name)){
               $additional_table_gateway = new $this->additional_table_name();
               //удаляем 
               $additional_table_gateway->RemoveWhere($this->additional_table_external_key,"=",$id);
           }
    }
   
    
    
}




class OneToMany2ModelsSelection extends DataFieldHandlers{
    
    public $model1_table_name;
    public $model1_table_key;
    public $model1_table_field;
    public $model2_table_name;
    public $model2_table_key;
    public $model2_table_field; 
    public $model2_external_key_for_model1;
    
    
    function __construct( $value, $strong, 
        $model1_table_name, $model1_table_key, $model1_table_field, 
        $model2_table_name, $model2_table_key, $model2_table_field, 
        $model2_external_key_for_model1){
        
        $this->model1_table_name = $model1_table_name;
        $this->model1_table_key = $model1_table_key;
        $this->model1_table_field = $model1_table_field;
        
        $this->model2_table_name = $model2_table_name;
        $this->model2_table_key = $model2_table_key;
        $this->model2_table_field = $model2_table_field;
        
        $this->model2_external_key_for_model1 = $model2_external_key_for_model1;
        
        parent::__construct($value,$strong);
        
    }
    

    
    function echofield($value){
        include_dlight_partial("OneToMany2ModelsSelection",array(
            "field"=>$this,
            "value"=>$value)
            );
    }
    

   
   
  
   
   function OnView($value,  $add_params = false){   
    
        if($this->_on_view_function){
            return parent::OnView($value);
        }
        else{
            $parents = $this->getElementParents($value,true);
            $res = array();
            
            $res[]=$parents[0][$this->model1_table_field];
            $res[]=$parents[1][$this->model2_table_field]." (".$parents[1][$this->model2_table_key].")";
            
            return implode(" > ",$res);
        }
    }
   
   
    
      
    function getChildren($parent_elem_value, $elem_data = false, $current_elem = false){
        
      
        
        $model2_table_gateway = new $this->model2_table_name();   
        $model2_table_gateway->ReturnIterator();
        
        
                    
        //list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
        /*   if(!$additional_table_label){*/
                $children = $model2_table_gateway->getWhereExt( $this->model2_external_key_for_model1 . "=" . $parent_elem_value,  
                    array( $this->model2_table_key, $this->model2_table_field ) );   
           /*}
           else{
                $children = $tree_table_gateway->getWhereExt( $this->tree_table_parent_elem_field . "=" . $parent_elem_value. " AND `{$additional_table_label}` = '{$additional_table_label_value}'" , 
                    array($this->tree_table_key, $this->tree_table_field ));
           }*/
                    
                    
          
        if($elem_data){
            $children_data_ar = $children->getArray();
            if($current_elem!==false){
                foreach($children_data_ar as $key=>$child){
                    if($children_data_ar[$key][$this->model2_table_key] == $current_elem){
                        $children_data_ar[$key]['selected']=true;
                    }
                    else{
                        $children_data_ar[$key]['selected']=false;
                    }
                }    
            }
            
            return $children_data_ar; 
        }
        else{
            $result = array();
            while($child = $children->NextElem()){
                $result[] = $child[$this->model2_table_key];     
            }      
            return $result;
        }            
    }
    
    
    function getElementParents($elem_value, $elem_data = false){
                                             
        $model1_table_gateway = new $this->model1_table_name();
        $model2_table_gateway = new $this->model2_table_name();                                                           
        $elem_parents = [];
        
        $model2_item = $model2_table_gateway->getRecById($elem_value);
        if($elem_data)
            $elem_parents[] = $model2_item;
        else
            $elem_parents[] = $model2_item[$this->model2_table_key];
         
        
        $model1_item = $model1_table_gateway->getRecById($model2_item[$this->model2_external_key_for_model1]);
        if($elem_data)
            $elem_parents[] = $model1_item;
        else
            $elem_parents[] = $model1_item[$this->model1_table_key];
                                                         
                                                
        return array_reverse($elem_parents);
   
    }
    
}







class TreeElemField extends DataFieldHandlers
{
    public $tree_table_name;
    public $tree_table_key;
    public $tree_table_field;
    public $additional_table_name;
    public $additional_table_master_key;
    public $additional_table_slave_key;
    public $tree_table_parent_elem_field;
    
    public $additional_table_label = null;
    public $additional_table_label_value = null;
    
    
    function __construct( $value, $strong, $tree_table_name, $tree_table_key, $tree_table_field, $tree_table_parent_elem_field,
    $additional_table_name = false, $additional_table_master_key = false, $additional_table_slave_key = false ){
        
        $this->tree_table_name = $tree_table_name;
        $this->tree_table_key = $tree_table_key;
        $this->tree_table_field = $tree_table_field;
        $this->tree_table_parent_elem_field = $tree_table_parent_elem_field;
        $this->additional_table_name = $additional_table_name;
        $this->additional_table_master_key = $additional_table_master_key;
        $this->additional_table_slave_key = $additional_table_slave_key;
        parent::__construct($value,$strong);
        
    }
    
    public function additionalTableLabel($label = false, $label_value = false){
        if( $label && $label_value ) {
            $this->additional_table_label = $label; 
            $this->additional_table_label_value = $label_value;
        }
        else{
           return array( $this->additional_table_label, $this->additional_table_label_value ); 
        }
    }
    
    function echofield($value){
        include_dlight_partial("TreeField",array(
            "field"=>$this,
            "value"=>$value)
            );
    }
    
   function OnAfterAdd($new_rec_id,$value){
       
       if(!$this->additional_table_name){
            return;   
       } 
        
       //тут нужно получить родителей для $value
       $parents = $this -> getElementParents($value);
           
       foreach($parents as $parent){
            $this->AddRecAdditionalTable($new_rec_id, $parent);
       }     
   }
   
   function AddRecAdditionalTable($additional_table_master_key, $additional_table_slave_key){
       
       //далее нужно создать экземпляр таблицы вспомагательной
       if(class_exists($this->additional_table_name)){
           
           $additional_table_gateway = new $this->additional_table_name();
           list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
           if(!$additional_table_label){
                $additional_table_gateway->Add(array("NULL", $additional_table_master_key, $additional_table_slave_key));   
           }
           else{
                $additional_table_gateway->Add(array("NULL", $additional_table_master_key, $additional_table_slave_key, $additional_table_label_value));
           }
       
       }
            
   }
   
   
   function RemoveRecAdditionalTable($additional_table_master_key, $id){
       
       //далее нужно создать экземпляр таблицы вспомагательной
       if(class_exists($this->additional_table_name)){
           $additional_table_gateway = new $this->additional_table_name();
       
           
           list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
           if(!$additional_table_label){
                $additional_table_gateway->RemoveWhere($additional_table_master_key,"=",$id);   
           }
           else{
                $additional_table_gateway->RemoveWhereExt("`{$additional_table_master_key}`='{$id}' AND `{$additional_table_label}` = '{$additional_table_label_value}'");
           }
       
       }
            
   }
   
   function OnView($value,  $add_params = false)
    {   
    
        if($this->_on_view_function){
            return parent::OnView($value);
        }
        else{
            $parents = $this->getElementParents($value,true);
            
            $res = array();
            foreach($parents as $parent){
                $res[]=$parent[$this->tree_table_field]." (".$parent[$this->tree_table_key].")"; 
            }
            return implode(" > ",$res);
        }
    }
   
    function OnEdit($db_table,$id,$value){   
        if(!$this->additional_table_name)
        return $value;
        
       //тут нужно получить родителей для $value
       $parents = $this-> getElementParents($value);
       
       //удаляем 
       $this->RemoveRecAdditionalTable($this->additional_table_master_key,$id);
           
       foreach($parents as $parent){
            $this->AddRecAdditionalTable( $id, $parent );    
       } 
       
       return $value; 
    }
    
    function OnRemove($id){
        if(!$this->additional_table_name)
            return;
            
           $this->RemoveRecAdditionalTable($this->additional_table_master_key,$id);
    }
    
    
    function getChildren($parent_elem_value, $elem_data = false, $current_elem = false)
    {
        if(!class_exists($this->tree_table_name)) {
            return false;
        }
        
        $tree_table_gateway = new $this->tree_table_name();
        $tree_table_gateway->ReturnIterator();
        
        
                    
        //list($additional_table_label, $additional_table_label_value) = $this->additionalTableLabel();
        /*   if(!$additional_table_label){*/
                $children = $tree_table_gateway->getWhereExt( $this->tree_table_parent_elem_field . "=" . $parent_elem_value, 
                    array($this->tree_table_key, $this->tree_table_field ));   
              
           /*}
           else{
                $children = $tree_table_gateway->getWhereExt( $this->tree_table_parent_elem_field . "=" . $parent_elem_value. " AND `{$additional_table_label}` = '{$additional_table_label_value}'" , 
                    array($this->tree_table_key, $this->tree_table_field ));
           }*/
                    
                    
        
        if($elem_data){
            $children_data_ar = $children->getArray();
            if($current_elem!==false){
                foreach($children_data_ar as $key=>$child){
                    if($children_data_ar[$key][$this->tree_table_key] == $current_elem){
                        $children_data_ar[$key]['selected']=true;
                    }
                    else{
                        $children_data_ar[$key]['selected']=false;
                    }
                }    
            }
            
            return $children_data_ar; 
        }
        else{
            $result = array();
            while($child = $children->NextElem()){
                $result[] = $child[$this->tree_table_key];     
            }      
            return $result;
        }            
    }
    
    
    function getElementParents($elem_value, $elem_data = false){
        if(class_exists($this->tree_table_name)) {
            $tree_table_gateway = new $this->tree_table_name();
            $elem_id = $elem_value;
            $elem_parents = array();
            while($elem_id) {
                $elem = $tree_table_gateway->getRecFieldsById($elem_id, 
                    array($this->tree_table_key, $this->tree_table_field, $this->tree_table_parent_elem_field));
                if($elem){
                    if($elem_data)
                        $elem_parents[] = $elem;
                    else
                        $elem_parents[] = $elem[$this->tree_table_key];
                        
                    $elem_id = $elem[$this->tree_table_parent_elem_field];      
                }
                else{
                    $elem_id = false;
                }   
            }
            return array_reverse($elem_parents);
        }
        else
            return false;
    }
    
}

class MultiPhotoField extends PhotoField 
{
    
    private $_pic_preview_name; 
    private $_editable;
    
    function __construct($strong,$directory,$pic_sizes,$pic_names,
                        $pic_preview_name,$editable=true,
                        $viewasimg=false,$multidirs=false,$watermark=false,
                        $pic_scale_algoritm=false){
        $this->_editable = $editable;
        $this->_pic_preview_name = $pic_preview_name;
        parent::__construct($strong,$directory,$pic_sizes,$pic_names,30000,$viewasimg,$multidirs,$watermark,$pic_scale_algoritm);        
    }  
    
    function echofield($value)
    {
        include_dlight_partial("MultiPhotoField",array("value"=>$value,"field_id"=>$this->GetGlobalFieldName(),"directory"=>$this->_directory,"model_name"=>$this->getTabName(),"field_name"=>$this->getFieldName(),"pic_preview_name"=>$this->_pic_preview_name,"editable"=>$this->_editable,"item_id"=>$this->getID()));
    }
    
    function OnAdd($value)
    {
        if(!$value || $value == "NOT_SET"){
            return $value;
        }
             
         $images = explode(";", $value);
         for($i=0; $i<count($images); $i++){
            $images[$i] = str_replace("NEW_FILE|","",$images[$i]);    
         } 
         
         $pic_names = $this->getPicNames();   
         //папка для новых картинок
         $dest_dir = $this->_directory;
         $dir = "";
         if($this->_multidirs){
            $dir=$this->getPhotoDir($this->_directory,$this->GetGlobalFieldName());
            $dest_dir = $dest_dir . $dir;    
         }
          
         //переносим картинки
         $result = array();
         for($i=0; $i<count($images); $i++) {
             
            $ar = FILE_SYSTEM::getFileNameAndExtension($images[$i]);
            for($j=0; $j<count($pic_names); $j++) {
                $image_path = $ar[0] . $pic_names[$j] . "." . $ar[1];  
                if(file_exists(getDocumentRoot(false) . $image_path)) {
                    $file_name = basename($image_path);
                    rename(getDocumentRoot(false) . $image_path, getDocumentRoot() . $dest_dir . "/" . $file_name);
                }   
            }
            
            $result[]= $dir."/".basename($images[$i]);
         } 
        return implode(";", $result);          
           
    }
    
    function OnEdit($db_table,$id,$value)
    {
        //not implemented
        if(!$value || $value == "NOT_SET"){
            return $value;
        }
        
        
        $pic_names = $this->getPicNames();   
         
         if(strpos($value,"NEW_FILE|")!==false){
             
             //папка для новых картинок
             $dest_dir = $this->_directory;
             $dir = "";
             if($this->_multidirs){
                $dir=$this->getPhotoDir($this->_directory,$this->GetGlobalFieldName());
                $dest_dir = $dest_dir . $dir;    
             }
         }
         
         //старое значение поля
         $rec = $this->getTab()->getRecById($id);
         //старые картинки
         $old_images = explode(";", $rec[$this->getFieldName()]);
         
        
        $images = explode(";", $value);
        $result = array();
        for($i=0; $i<count($images); $i++){
            
            if(strpos($images[$i],"NEW_FILE|")!==false){
                //это новая картинка
                $image = str_replace("NEW_FILE|","",$images[$i]);
                $ar = FILE_SYSTEM::getFileNameAndExtension($image);
                for($j=0; $j<count($pic_names); $j++) {
                    $image_path = $ar[0] . $pic_names[$j] . "." . $ar[1];  
                    if(file_exists(getDocumentRoot(false) . $image_path)) {
                        $file_name = basename($image_path);
                        rename(getDocumentRoot(false) . $image_path, getDocumentRoot() . $dest_dir . "/" . $file_name);
                    }   
                }
                $result[]= $dir."/".basename($image);      
            }
            else{
                $result[] = $images[$i];
                //удаляем $images[$i] из массива $old_images
                $key = array_search($images[$i], $old_images);
                if ($key !== false && $key !== null){
                    unset($old_images[$key]);
                }    
            }
                
        }
        
        //удаляем старые фото, которых нет в новых фото
        if(count($old_images))
            $this->RemoveImages($old_images);
        
        return implode(";", $result);
        
    }
    
    function OnRemove($id)
    {  
        $rec = $this->getTab()->getRecById($id);
        if($rec[$this->getFieldName()] && $rec[$this->getFieldName()]!="NOT_SET"){
            $images = explode(";",$rec[$this->getFieldName()]);
            $this->RemoveImages($images);    
        }   
    }
    
    function RemoveImages($images){
        $pic_names = $this->getPicNames();
        foreach($images as $image) {
            if($image){
                $ar = FILE_SYSTEM::getFileNameAndExtension($image);
                for($j=0; $j<count($pic_names); $j++) {
                    $image_path = $this->_directory . $ar[0] . $pic_names[$j] . "." . $ar[1];
                    //echo getDocumentRoot() . $image_path . "!!!" . $images[$i];  
                    if(file_exists(getDocumentRoot() . $image_path)) {
                        unlink(getDocumentRoot() . $image_path);
                    }   
                }
            }
         }
    }
    
    function OnView($value,  $add_params = false)
    {   //not implemented
    
        if($this->_on_view_function){
            return parent::OnView($value);
        }
        else{
            
            $images = explode(";", $value);
            $image = $images[0];
            
            if($image!="" && $image!="NOT_SET")
                {
                    //echo getDocumentRoot()."{$this->_directory}{$file}{$this->_pic_preview_name}.{$ext}";
                    //echo $image;
                    list($file,$ext) = FILE_SYSTEM::getFileNameAndExtension($image);
                    if(file_exists(getDocumentRoot()."{$this->_directory}{$file}{$this->_pic_preview_name}.{$ext}"))
                    {
                        if($this->_viewasimg){
                            return "<a target='_blank' class='zoom' href='/{$this->_directory}{$image}'><img src='/{$this->_directory}{$file}{$this->_pic_preview_name}.{$ext}'></a>";
                        }
                        else{
                            return "<a target='_blank' class='zoom' href='/{$this->_directory}{$image}'>{$this->_directory}{$image}</a>";
                        }
                    }   
                    else{
                        return "";
                    }
                }       
            else
                return "";
            
        }
        
    }

}

class PhotoField extends DataFieldHandlers
{
    protected $_size;
    protected $_directory;
    protected $_pic_names;
    protected $_pic_sizes;
    protected $_pic_scale_algoritm;
    protected $_viewasimg;
    protected $_multidirs;

    protected $_maxsize;
    protected $_watermark;
function __construct($strong,$directory,$pic_sizes,$pic_names,$maxsize,$viewasimg=false,$multidirs=false,$watermark=false,$pic_scale_algoritm=false)
{
$this->_viewasimg=$viewasimg;
$this->_directory=$directory; //формат: ../files/
$this->_pic_sizes=$pic_sizes;
$this->_pic_scale_algoritm=$pic_scale_algoritm;
$this->_pic_names=$pic_names;
$this->_maxsize=$maxsize;
$this->_multidirs=$multidirs;
$this->_watermark=$watermark;

parent::__construct("",$strong);
}

public function getPicNames(){
    return $this->_pic_names;
} 

public function setDirectory($dir){
    $this->_directory = $dir;
}

function echofield($value)
{
    
     if($value){
     $img = get_img($this->_tab_name,$this->_field_name,$value);
     echo "<img src='".$img."' style='width:200px; height:auto; display:block; margin-bottom:10px;'>";
     }
    FileField::render($this->GetGlobalFieldName());
}


public function getDirName()
{
    return $this->_directory;
}



function OnView($value, $add_params = false)
{
    if($this->_on_view_function)
    {
        return parent::OnView($value);
    }
    else
    {
    
    $ar=explode(";",$value);
    if($ar[0]!=""&&$ar[0]!="NOT_SET")
        {
            $ar1=FILE_SYSTEM::getFileNameAndExtension($ar[0]);
            if(file_exists(getDocumentRoot()."{$this->_directory}{$ar1[0]}{$this->_pic_names[count($this->_pic_names)-1]}.{$ar1[1]}"))
            {
                if($this->_viewasimg)
                {return "<a target='_blank' class='zoom' href='/{$this->_directory}{$ar1[0]}{$this->_pic_names[0]}.{$ar1[1]}'><img src='/{$this->_directory}{$ar1[0]}{$this->_pic_names[count($this->_pic_names)-1]}.{$ar1[1]}'></a>";}
                else
                {return "<a target='_blank' class='zoom' href='/{$this->_directory}{$ar1[0]}{$this->_pic_names[count($this->_pic_names)-1]}.{$ar1[1]}'>{$ar1[0]}{$this->_pic_names[count($this->_pic_names)-1]}.{$ar1[1]}</a>";
                }
            }   
            else
                {return "/{$this->_directory}{$ar1[0]}{$this->_pic_names[count($this->_pic_names)-1]}.{$ar1[1]}";}

        }       
    else
        {return "";}
        
    }
}


function getNewFileName($uploaded_file_name,$ext = ""){
    
    $table_gateway = $this->getTab();
    $table_name = $this->getTabName();
    $field_name = $this->getFieldName();
    $item_id = $this->getID();
    
    if($table_name == "dls_products" && $field_name == "images" && $item_id){
    
            
        $product = $table_gateway->getRecFieldsById($item_id,["name"]);
        /*$name = TextHelper::translite($product["name"])."-".$item_id;
        $counter = 0; 
        do{
            $counter++;
            $file_name = getDocumentRoot().$this->getDirName().$name."-".$counter.".".$ext;
            //echo $file_name;
        }while(file_exists($file_name));
        
            
        return $name."-".$counter;*/
        
        return TextHelper::translite($product["name_uk"])."-".RandNum(6);
    }
    else{
        return tempvalue();    
    }
}

private function RemoveImagesFiles($list)
{
    if(is_array($list)){
      foreach($list as $image){
        if(file_exists(getDocumentRoot()."/".$this->_directory.$image)&&$image!=""&&$image!="NOT_SET")
            unlink(getDocumentRoot()."/".$this->_directory.$image);
      }
    }
}


public function checkAndCreateImages($src_image_file){
    list($file_name, $ext)=FILE_SYSTEM::getFileNameAndExtension($src_image_file);
    $ext=stripslashes(strtolower($ext));
     if(!in_array($ext,array("jpg","gif","png"))){
        return false;
     }
     
     for($i=0;$i<count($this->_pic_sizes);$i++){
         
        $dest_file_name=$file_name.$this->_pic_names[$i].".".$ext;
         
        if(!$this->_pic_scale_algoritm||$this->_pic_scale_algoritm[$i]==IMG_ALG_SCALE){
            $this->ScaleImageExt($dest_file_name,getDocumentRoot().$this->_directory."/".$src_image_file,$this->_pic_sizes[$i][0],$this->_pic_sizes[$i][1],getDocumentRoot().$this->_directory."/",$ext);
        }
        elseif($this->_pic_scale_algoritm[$i]==IMG_ALG_ADAPTIVE){
            $this->ScaleImageAdaptive($dest_file_name,getDocumentRoot().$this->_directory."/".$src_image_file,$this->_pic_sizes[$i][0],$this->_pic_sizes[$i][1],getDocumentRoot().$this->_directory."/",$ext,false);  
        }
     }
}


function executeAddEditImageFile($uploaded_file_name, $uploaded_file_temp_path, $remove_old_files = false, $dest_dir = false)
{
    list($file_name, $ext)=FILE_SYSTEM::getFileNameAndExtension($uploaded_file_name);
    $ext=stripslashes(strtolower($ext));
    
      if(in_array($ext,array("jpg","gif","png")))      
      {
          
          if($remove_old_files)
            $this->RemoveImagesFiles($remove_old_files);
      
          $new_name=$this->getNewFileName($file_name, $ext);
          $field_value="";
          for($i=0;$i<count($this->_pic_sizes);$i++)
          {
            $newtempname=$new_name.$this->_pic_names[$i].".".$ext;
            
            if($dest_dir){
                $newtempname=$dest_dir."/".$newtempname;
            }
            else if($this->_multidirs){
                $dir=$this->getPhotoDir($this->_directory,$this->GetGlobalFieldName());
                $newtempname=$dir."/".$newtempname;    
            }
            
            $field_value.=$newtempname;
              
            if(!$i&&$this->_watermark)
                $watermark=true;
            else
                $watermark=false;
              
            /*if(!$this->_pic_scale_algoritm||$this->_pic_scale_algoritm[$i]==IMG_ALG_NEW_SCALE)
              $this->ScaleImageNew($newtempname,$_FILES[$this->GetGlobalFieldName()]['tmp_name'],$this->_pic_sizes[$i][0],$this->_pic_sizes[$i][1],getDocumentRoot()."/".$this->_directory,$ext,$watermark);*/
            if(!$this->_pic_scale_algoritm||$this->_pic_scale_algoritm[$i]==IMG_ALG_SCALE){
                  $this->ScaleImageExt($newtempname,$uploaded_file_temp_path,$this->_pic_sizes[$i][0],$this->_pic_sizes[$i][1],getDocumentRoot()."/".$this->_directory,$ext/*,$watermark*/);
              }
            elseif($this->_pic_scale_algoritm[$i]==IMG_ALG_ADAPTIVE)
              $this->ScaleImageAdaptive($newtempname,$uploaded_file_temp_path,$this->_pic_sizes[$i][0],$this->_pic_sizes[$i][1],getDocumentRoot()."/".$this->_directory,$ext,$watermark);  
              
            if($i!=count($this->_pic_sizes)-1)
                $field_value.=";";
          
          }
          
          return $field_value;     
    }
    else
    {
     $this->_error="Неверное расширение файла! Допустимые расширения: jpg, gif или png";
     return "NOT_SET";
    }    
}



function OnAdd($value)
{
     if($_FILES[$this->GetGlobalFieldName()]['name'])
            {   
                if($_FILES[$this->GetGlobalFieldName()]['size']>$this->_maxsize*1024)
                {
                    $this->_error="Слишком большой размер файла. Максимальный размер: {$this->_maxsize} KB";
                    return "NOT_SET";
                }
                
                return $this->executeAddEditImageFile($_FILES[$this->GetGlobalFieldName()]['name'], $_FILES[$this->GetGlobalFieldName()]['tmp_name']);
                 
            }
            else
                return "NOT_SET";
    
     
}
function OnEdit($db_table,$id,$value)
{
    if($_FILES[$this->GetGlobalFieldName()]['name'])
            {           
                $rec=$db_table->getRecFieldsById($id,array($this->getFieldName()));
                $old_pics=explode(";",$rec[$this->getFieldName()]);
                           
                if($_FILES[$this->GetGlobalFieldName()]['size']>$this->_maxsize*1024)
                {
                    $this->_error="Слишком большой размер файла. Максимальный размер: {$this->_maxsize} KB";
                    return "NOT_SET";
                }
                                
                return $this->executeAddEditImageFile($_FILES[$this->GetGlobalFieldName()]['name'], $_FILES[$this->GetGlobalFieldName()]['tmp_name'], $old_pics);                    
            }
            else
            {return "NOT_SET";}

}

function OnRemove($id)
{
    $rec=$this->getTab()->getRecById($id);
    $old_pics=explode(";",$rec[$this->getFieldName()]);
    $this->RemoveImagesFiles($old_pics);
}


protected function getFilesNumInDir($dir)
{
if ($handle = opendir($dir)) {
    $num=0;
    while (false !== ($entry = readdir($handle)))
        if ($entry != "." && $entry != "..")
            $num++;
            
            
    closedir($handle);
    return $num;
}
return false;
}

protected function getPhotoDir($root_path,$label)
{
    $photos_folder_gateway=new dlphotos_folder();
    $folder_obj=$photos_folder_gateway->getRecFieldsByField("label",trim($label),array("cur_folder","max_files"));
    if($folder_obj)
    {
        $cur_folder_name=$folder_obj['cur_folder'];
        $max_files=$folder_obj['max_files'];
        
        
        if(!$cur_folder_name)
        {
            //Директории еще нет, создаем ее:
            $cur_folder_name=1;
            mkdir(getDocumentRoot()."/".$root_path.$cur_folder_name,0777);
            $photos_folder_gateway->UpdateFieldsByField("label",$label,array("cur_folder"),array($cur_folder_name));
        }
        else
        {
            if(file_exists(getDocumentRoot()."/".$root_path.$cur_folder_name))
            {
            //проверить сколько файлов в папке
             $num=$this->getFilesNumInDir(getDocumentRoot()."/".$root_path.$cur_folder_name);
             if($num>$max_files)
             {
                 while(file_exists(getDocumentRoot()."/".$root_path.$cur_folder_name))
                    $cur_folder_name++;
                    
                 mkdir(getDocumentRoot()."/".$root_path.$cur_folder_name,0777);
                 $photos_folder_gateway->UpdateFieldsByField("label",$label,array("cur_folder"),array($cur_folder_name));
             }
            }
            else
                mkdir(getDocumentRoot()."/".$root_path.$cur_folder_name,0777);
        }
        
        
        return $cur_folder_name;
        
        
    }
    else
       return "";
}


function ScaleImageAdaptive($filename,$temp_path,$w_param,$h_param,$path_result,$ext)
{
    $dest_file=$path_result.$filename;
    try
    {
         $thumb = PhpThumbFactory::create($temp_path);
    }
    catch (Exception $e)
    {
         return false;
    }
    $thumb->adaptiveResize($w_param, $h_param);
    $thumb->save($dest_file);
    return true;
}



function ScaleImageExt($filename,$temp_path,$w_param,$h_param,$path_result,$ext)
{
$q = 100; // Качество jpeg изображения

$file = $filename; // Записываем содержимое массива
                                               // $_FILES в $file
switch($ext)
{
case "jpg":
$src = imagecreatefromjpeg($temp_path); // Создаем временный
break;
case "png":
$src = imagecreatefrompng($temp_path); // Создаем временный
break;
case "gif":
$src = imagecreatefromgif($temp_path); // Создаем временный
break;
}


                                                           
$w_src = imagesx($src); // Определяем его линейный размер по горизонтали (ширина)
$h_src = imagesy($src); // Определяем его линейный размер по вертикали (высота)


    
$w = $w_param;
$dir = $path_result; // Папка, куда будет записан
                                                 // уже преобразованный файл
$path = $dir.$file; // Полный путь к файлу (включая и его имя)

if (($w_src > $w_param)||($h_src > $h_param))  // Проверяем не равна ли уже
                         //исходная ширина необходимой нам
  {
   if ((float)$w_src/(float)$h_src>(float)$w_param/(float)$h_param)
     {
      /*$ratio = $w_src/$w; 
      $w_dest = $w; 
      $h_dest = round($h_src/$ratio); */
      
      $w=$w_param;
      $ratio = $w_src/$w; 
      $w_dest = $w; 
       $h_dest= round($h_src/$ratio); 
      
     }
   elseif ((float)$w_src/(float)$h_src<(float)$w_param/(float)$h_param) 
     {
         
         $w=$h_param;
      $ratio = $h_src/$w; 
      $h_dest = $w; 
      $w_dest = round($w_src/$ratio); 
         
      
     }
   else // Если изображение квадратное
     {
      $w_dest = $w; // Подставляем максимальные значения
      $h_dest = $h_param;
     }
   $dest = imagecreatetruecolor($w_dest,$h_dest); // Создаем пустое изображение
   imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
   // Преобразуем исходное изображение в конечное (с новыми размерами).
   // Функция использует ресемплинг, поэтому изображение будет лучшего
   // качества, чем если использовать вместо imagecopyresampled функцию
   // imagecopyresized
   
   
   switch($ext)
    {
    case "jpg":
       $res = imagejpeg($dest,$path,$q); // Копируем файл в папку
    break;
    case "png":
       $res = imagepng($dest,$path,9); // Копируем файл в папку
    break;
    case "gif":
       $res = imagegif($dest,$path,$q); // Копируем файл в папку
    break;
    }
    
    
     if (!$res)
     {
      imagedestroy($dest); // Освобождаем память
      imagedestroy($src);
      return false;
     }
     
    imagedestroy($dest);
    imagedestroy($src);
   
    
   return true;
    
   
  }
else
  {
       //move_uploaded_file($temp_path, $path);
       copy($temp_path, $path);
       //echo "123";
      /*switch($ext)
{
case "jpg":
 $dest = imagecreatefromjpeg($temp_path);   
break;
case "png":
 $dest = imagecreatefrompng($temp_path);   
break;
case "gif":
 $dest = imagecreatefromgif($temp_path);   
break;
}       */

      
      
      
  
   
   // Если исходная ширина равна нужной нам на выходе, то просто
   // создаем временный файл без преобразований
  }
 
   
     
   
   
   
   
  
}




}

//это модель photos_folder 
class dlphotos_folder extends DBTable
{
    function __construct()
    {
        parent::__construct(array("id","label","cur_folder"),"dlphotos_folder","id");
        $this->setTableRus("Управление папками изображений",array("ID","Метка","Текущая папка"));

        $this->SetAddText("Добавить");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,30));
        $this->AddFieldType(new Text("",STRONG,30));
    }
}

class HiddenField extends DataField
{
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong);
    }

    function echofield($value)
    {
        HiddenField::render($this->GetGlobalFieldName(),$value,20);
    }
    
    public static function render($name,$value,$params="")
    {
        echo "<input type='hidden' name='".$name."' id='id_".$name."' value='".$value."' {$params}>";
    }

}

class DateField extends DataFieldHandlers
{
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong);
    }
    
    function echofield($value)
    {
        DateField::render($this->GetGlobalFieldName(),$value);
    }
    
    public static function render($name,$value,$params="")
    {
        if(strpos($value,"/")===false){
            $value=FormatDateForView($value);
        }
        
        HTML::RenderJSFile(
        array(  
            "/dlight/vendor/unicorn/js/bootstrap-datepicker.js"  
        )
        );

        HTML::RenderCSSFile(
                array(
                "/dlight/vendor/unicorn/css/datepicker.css"
                )        
        ); 
        
        
        Text::render($name,$value,10,$params,"");
        echo "
        <script>
         \$(document).ready(function() {
            \$('#id_{$name}').datepicker({format:'dd/mm/yyyy'});
         });
        </script>";
        
        
        //EchoCalendar($name,10,$value,$params);
    }
    
    function HasRemoveHandler()
    {return false;}
    
    
    
     function ReturnViewValue($value,$add_params=false)
    {
        $temp="";
        if($this->XEdit())
        {   
            $temp.="<a 
                        href='#'
                        data-value='{$add_params['value']}' 
                        data-name='".$this->getFieldName()."'
                        data-format='DD/MM/YYYY' 
                        data-viewformat='DD/MM/YYYY' 
                        data-template='D / MMM / YYYY' 
                        class='x-edit' 
                        data-type='combodate' 
                        data-pk='".$add_params['id']."' 
                        data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
        }
            
        $temp.=$value;
        
        if($this->XEdit())
            $temp.="</a>";
            
        return $temp;
    }
    
    

    function OnView($value,$add_params = false)
    {        
        $add_params=(array)$add_params;
        $add_params['value']=$value;
        return $this->ReturnViewValue(FormatDateForView($value),$add_params);
    }

    function OnViewInverse($value)
    {        
        return FormatDateForDB($value);
        
    }
    
    function OnAdd($value)
    {
        return FormatDateForDB($value);
    }
    
    function OnEdit($db_table,$id,$value)
    {
        if($value!="NOT_SET")
        {
            return FormatDateForDB($value);
        }
        else 
        return $value;
    }
}
      
class RedactorField extends DataFieldHandlers
{
    function __construct($value,$strong)
    {
    parent::__construct($value,$strong);
    }

    function echofield($value)
    {
        RedactorField::render($this->GetGlobalFieldName(),$value);
    }
    
    
    public static function render($name,$value)
    {

    // $script_lang=Local::getLang("ru");
    echo "<script type=\"text/javascript\" src=\"/dlight/vendor/ckeditor/ckeditor.js\"></script>";
    echo "<textarea id='id_{$name}' name='{$name}'>{$value}</textarea>";
    echo "<script type=\"text/javascript\">
           CKEDITOR.replace( 'id_{$name}',
           {
            toolbar :
            [
                ['Source','Bold', 'Italic','Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'Image','-',
                'JustifyBlock','JustifyLeft','JustifyCenter','JustifyRight','FontSize',  'Styles', 'Format', 'Font', 'FontSize' , 'TextColor', 'BGColor','Undo','Redo','-','Paste','-','Youtube']
            ],
            enterMode : CKEDITOR.ENTER_P,
            language: 'nl'
            
    });       
        </script>";
    
    // include_partial("redactor-upload-images",array("uid"=>$name));

    }



    

     
     
     

    function HasRemoveHandler()
    {return false;}

    function OnAdd($value)
    {   
        if(strpos($value,"\""))
     {return str_replace("\"","'",$value);}
     
     return $value;

    }
    function OnEdit($db_table,$id,$value)
    {   
    if(strpos($value,"\""))
     {return str_replace("\"","'",$value);}
     
     return $value;
    }


}



class dlForm{
    
    public static function isPost(){                              
        if((count($_POST)||count($_FILES))&&dlForm::checkCSRFToken()){
            return true;
        }
        else{
            return false;
        }
    }
    
    public static function checkCSRFToken(){
        
        if(!isset($_POST[dlForm::getCSRFFieldName()])){
            return false;
        }
        $csrf_value = $_POST[dlForm::getCSRFFieldName()];
        if(!isset($_SESSION[dlForm::getCSRFSessionName()])){
            $_SESSION[dlForm::getCSRFSessionName()] = array($csrf_value);
            return true;
        }
        else{
            if(in_array($csrf_value,$_SESSION[dlForm::getCSRFSessionName()])){
                return false;
            }
            else{
                $_SESSION[dlForm::getCSRFSessionName()][]=$csrf_value;
                return true;
            }
        }
        
        
    }
    public static function renderCSRFToken(){
        HiddenField::render(dlForm::getCSRFFieldName(),uniqid());
    }
    public static function getCSRFFieldName(){
        return "_csrftoken";
    }
    public static function getCSRFSessionName(){
        return "session_csrftoken";
    }
}






class DateTimeField extends DataFieldHandlers
{
    function __construct($value,$strong)
    {
        parent::__construct($value,$strong);
    }
    function echofield($value)
    {
        list($date,$time)=explode(" ",$value);
        DateTimeField::render("id_".$this->GetGlobalFieldName(),$this->GetGlobalFieldName(),$date,$time);
    }

    public static function render($id,$name,$valuedate,$valuetime)
    {
        echo "
        <script language='Javascript'>
              \$(document).ready(function() {
                
                \$('#id_temp_{$name}, #temp2_{$id}').change(function(){
                    \$('#{$id}').val(\$('#id_temp_{$name}').val()+' '+\$('#temp2_{$id}').val());
                });
              });
        </script>";
        DateField::render("temp_".$name,$valuedate,"style='width:90px !important;'");
        echo "&nbsp;&nbsp;
        ".ll('Time').": <input type='text' name='temp2_".$name."' id='temp2_".$id."' value='".$valuetime."' style='width:90px !important;'>";
        echo "<input type='hidden' name='".$name."' id='".$id."' value='".$valuedate." ".$valuetime."'>";
    }
    
    
    
     
     function ReturnViewValue($value,$add_params=false)
    {
        $temp="";
        if($this->XEdit())
        {   
            $temp.="<a 
                        href='#'
                        data-value='{$add_params['value']}' 
                        data-name='".$this->getFieldName()."'
                        data-template='D MMM YYYY HH:mm' 
                        data-format='YYYY-MM-DD HH:mm' 
                        data-viewformat='DD/MM/YYYY HH:mm:ss'
                        class='x-edit' 
                        data-type='combodate' 
                        data-pk='".$add_params['id']."' 
                        data-url='/backend.php?page=ajax/xedit&table=".$this->getTabName()."'>";
        }
            
        $temp.=$value;
        
        if($this->XEdit())
            $temp.="</a>";
            
        return $temp;
    }
    
    

    function OnView($value,$add_params = false)
    {        
        $add_params=(array)$add_params;
        $add_params['value']=$value;
        return $this->ReturnViewValue(FormatDateTimeForViewWithSec($value),$add_params);
    }
    



    
    function OnViewInverse($value)
    {        
        return FormatDateTimeForDBWithSec($value);
    }


  

    function HasRemoveHandler()
    {return false;}

    function OnAdd($value)
    {   
    if(strstr($value,"/"))
    {
        return FormatDateTimeForDB($value);
    }
    else
    {return $value;}
    }
    function OnEdit($db_table,$id,$value)
    {
            
        if(strstr($value,"/"))
        {
            return FormatDateTimeForDB($value);
        }
        else
        {return $value;}

    }

}

?>