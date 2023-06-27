<?
class dmForm {
    public $fields;
    public $options;
    public $action;
    public $method;
    public $upload;
    public $redirect;
    public $form_name;
    
    function __construct($form_name = '')
    {
        $this->form_name = $form_name ? $form_name : get_class_short($this);
    }

    function add($field_name, $options = []) {
        $this->fields[$field_name] = $options;
        return $this;
    }
    function __get($name)
    {
        if(isset($this->fields[$name])) {
if(isset($this->fields[$name]['value'])) return $this->fields[$name]['value'];
        }
        return null;
    }
    function __set($name, $value)
    {
        $this->fields[$name]['value'] = $value;
        return $this;
    }
    function setOptions( $options ) {
        $this->options = $options;
        // enctype="multipart/form-data"
        return $this;
    }
    function SetField($field_name, $options ) {
        $this->fields[$field_name] = $options;
        return $this;
    }
    function GetField($field_name) {
        return $this->fields[$field_name] ?? false;
    }
    function SetCollection($collections) {
        foreach ($collections as $name => $collection) {
            if(isset($this->fields[$name])) {
                // var_dump($collection['data']);
                // dump($collection['data']);
                // die;
                foreach ($collection['data'] as $entry) {
                    $form_type = $collection['form'];
                    $this->fields[$name]['value'][] = new $form_type($entry);
                }
            }
        }
    }

    function label($field_name) {
        $field = $this->GetField($field_name);
        return ($field and isset($field['label'])) ? $field['label'] : '';
    }
    function is_bool($field_name) {
        $field = $this->GetField($field_name);
        return ($field and isset($field['type']) and $field['type'] == 'checkbox');
    }

    function FillByName(&$target, $source, ?array $listNames = [])
    {
        if(!$listNames) {
            foreach ($source as $field_name => $any) {
                $listNames[] = $field_name;
            }
        }

        foreach ($listNames as $field_name) {
// echo $field_name, '<br>', isset($target[$field_name]),'<br>';            
            if(!isset($source[$field_name])) {
                $target[$field_name] = false;
                continue;
            } elseif($this->is_bool($field_name)) {
                $target[$field_name] = true;
                continue;
            }
            if(array_key_exists($field_name, $target))
                $target[$field_name] = $source[$field_name];
            elseif(array_key_exists($field_name .'_id', $target))
                $target[$field_name .'_id'] = $source[$field_name];

        }
    }

    function start($form_name = '', $url_route = ''){ //$route = '', $method = 'POST', $upload = false) {

        if($url_route ) {
            $route  = $url_route;
            $this->action = $route;

        } elseif($this->action) {
            $route  = $this->action;
            
        } else {
            $route  = $_SERVER["PHP_SELF"];
        }
        $method = $this->method ?? 'POST';
        $upload = $this->upload ?? false;
        if($form_name) $this->form_name = $form_name;
    
        if($upload) {
            $method = 'POST';
            $upload = ' enctype="multipart/form-data"';
        } else {
            $upload = '';
        }
        echo '<form name="'. $this->form_name .'" method="' . $method . '" action="' . htmlspecialchars($route) .'"'. $upload .'>';
    }
    function end() {
        echo '</form>';
    }
    function errors() {
        echo '';
    }
    function rest() {
        echo '';
    }

    function GetFormName() {
        return $this->form_name;
    }
    function GetFieldNames() {
        return array_keys($this->fields);
    }
    
    function Params2Form($entry) {
        $dlf = new DataLinkForm();

        foreach($this->fields as $field_name => $field) {
            if(isset($entry[$field_name])) {
                $this->fields[ $field_name ]['value'] = $dlf->$field_name;
            } elseif(isset($entry[$field_name.'_id'])) {
                // $field_name .= '_id';
                $this->fields[ $field_name ]['value'] = $dlf->$field_name;
            } 
        }
        return $this;
    }
    function SetData($entry) {
        if(!$entry) return $this;
        foreach($this->fields as $field_name => $field) {
            if(isset($entry[$field_name])) {
                $this->fields[ $field_name ]['value'] = $entry[$field_name];
            } elseif(isset($entry[$field_name.'_id'])) {
                $this->fields[ $field_name ]['value'] = $entry[$field_name.'_id'];
            }
        }
        return $this;
    }

    function CreateView () {
        return $this->fields;
    }
    function isCheckbox($field) {
        return $field['type'] == 'checkbox';
    }
    function isButton($field) {
        return $field['type'] == 'submit' or $field['type'] == 'button';
    }
    function isDate($field) {
        return $field['type'] == 'date';
    }
    function isDateTime($field) {
        return $field['type'] == 'datetime';
    }
    function isComboArray($field) {
        return $field['type'] == 'combo';
    }
    function isFile($field) {
        return $field['type'] == 'file';
    }
    function isTableCombo($field) {
        return $field['type'] == 'combotable';
    }
    function isPassword($field) {
        return $field['type'] == 'password';
    }
    function isTextarea($field) {
        return $field['type'] == 'textarea';
    }
    function isInput($field) {
        return $field['type'] == 'text';
    }

    private function printID($id) {
        return $id ? 'id="'.$id.'"' : '';
    }
    private function printName($name) {
        return $name ? 'name="'.$name.'"' : '';
    }
    private function printValue($value) {
        return $value ? 'value="'.$value.'"' : '';
    }
    private function GetAttrs($field_name, $field, $attrs) {
        
        if(isset($attrs['id']))
            $id = $attrs['id'];
        else
            $id = isset($field['id']) ? $field['id'] : $this->form_name . '_' . $field_name . '_id';

        if(isset($attrs['name']))
            $name = $attrs['name'];
        else 
            $name = isset($field['name']) ? $field['name'] : $field_name;

        if(isset($attrs['value']))
            $val = $attrs['value'];
        else 
            $val = isset($field['value']) ? $field['value'] : '';

        $params = isset($field['hidden']) ? 'hidden ' : '';
        if(is_array( $attrs ))
            foreach ($attrs as $param => $value) {
                $param = strtolower($param);
                if($param == 'id' or $param == 'name' or $param == 'value') continue;
                $params .= $param .'="' . $value . '"';
            }

        return [$id, $name, $val, $params];
    }

    function row( $field_name, $attrs = null, $cargo = null, $isLabel = true, $isGroup = true) {
        $this->widget($field_name, $attrs, $cargo, $isLabel, $isGroup);
    }
    static function widgetCast($field, $cargo = null)
    {
        $form = new dmForm;
        $form->fields[$field['name']] = $field;
        $isLabel = isset($field['label']);
        $form->widget($field['name'], null, $cargo, $isLabel);
    }
    function widgetAll() {
        foreach ($this->fields as $key => $field) {
            $this->widget($key);
        }
    }
    function rowAll() {
        foreach ($this->fields as $key => $field) {
            $this->row($key);
        }
    }
    function widget($field_name, $attrs = null, $cargo = null, $isLabel = false, $isGroup = false) {
        $field = $this->getField($field_name);
        if($field === false) {
            $class = get_class($this);
            echo <<< EOF
            <div class="form-group">Not found field '{$field_name}' Form: {$class}</div>
            EOF;
            return;
        }

        if(!$isLabel or !isset($field['label'])) $isLabel = false;
        if(!isset($field['type'])) $field['type'] = 'text';
        $field['type'] = strtolower($field['type']);

        if($this->isInput($field)) {
            $this->InputView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup);
            return; 
        }
        if($this->isComboArray($field)) {
            $this->ComboArrayView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup);
            return; 
        }
        if($this->isFile($field)) {
            $this->FileView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup);
            return; 
        }
        if($this->isDateTime($field)) {
            $this->DateTimeView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup);
            return; 
        }
        if($this->isDate($field)) {
            $this->DateView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
            return; 
        }
        if($this->isCheckbox($field)) {
            $this->CheckboxView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
            return; 
        }
        if($this->isPassword($field)) {
            $this->PasswordView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
            return; 
        }
        if($this->isTextarea($field)) {
            $this->TextareaView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
            return; 
        }
        if($this->isButton($field)) {
            $this->ButtonView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
            return; 
        }
       $this->InputView($field_name, $field, $attrs, $cargo,$isLabel, $isGroup);
    }

//< Views
    function GetAndDrop(&$field, $name, &$value, $default) {
        if(isset($field[$name])) {
            $value = $field[$name];
            unset($field[$name]);    
        } else 
            $value = $default;
    }
    
    function InputView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {

        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);
        $value_value    = $this->printValue($value);
        
        $class = $field['class'] ?? '';
        $placeholder = $this->inject($field, 'placeholder');
        $input_type  = $field['type'] ?? 'text';
        $input_class = 'form-control';

        if($isGroup) {
            $div_class  = $field['div_class'] ?? ''; 
            $div_style  = $field['div_style'] ?? '';

echo <<< EOF
<div class="form-group $div_class" style="$div_style">
EOF;        
        }

        if($isLabel) {
            $label = $field['label'];
            $label_style     = $field['label_style'] ?? ''; 
            $label_class     = $field['label_class'] ?? ''; //required'; 
    
echo <<< DATA
<label for="{$id}" class="{$label_class}" style="$label_style">$label</label>
DATA;
        }

        if($field['type'] == 'number') {
            if( !isset($attrs['step']) and isset($field['step'])) {
                $step = $field['step'];
                $params .= " step='$step'";
            }
        }

echo <<< DATA
<input type="$input_type" maxlength="255" class="{$input_class} {$class}" {$id_id} {$name_name} {$value_value} {$placeholder} {$params} {$cargo}>
DATA;
        if($isGroup) 
echo <<< EOF
</div>
EOF;        
    } 

    function TextareaView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {

        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);
        // $value_value    = $this->printValue($value);
        
        $class = $field['class'] ?? '';
        $rows_rows = isset($field['rows']) ? 'rows="'. $field['rows']. '"' : '';
        $cols_cols = isset($field['cols']) ? 'cols="'. $field['cols']. '"' : '';

        $placeholder = $this->inject($field, 'placeholder');
        $input_class = 'form-control';

        if($isGroup) {
            $div_class  = $field['div_class'] ?? ''; 
            $div_style  = $field['div_style'] ?? '';

echo <<< EOF
<div class="form-group $div_class" style="$div_style">
EOF;        
        }

        if($isLabel) {
            $label = $field['label'];
            $label_style     = $field['label_style'] ?? ''; 
            $label_class     = $field['label_class'] ?? ''; //required'; 
    
echo <<< DATA
<label for="{$id}" class="{$label_class}" style="$label_style">$label</label>
DATA;
        }

echo <<< DATA
<textarea $cols_cols $rows_rows class="{$input_class} {$class}" {$id_id} {$name_name}  {$placeholder} {$params} {$cargo}>$value</textarea>
DATA;
        if($isGroup) 
echo <<< EOF
</div>
EOF;        
    } 

    private function inject($field, $root) {
        return isset($field[$root]) ? $root.'="'.$field[$root].'"' : '';
    }
    // 
    function ComboArrayView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {

        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);

        if($isGroup) {
            $div_class  = $field['div_class'] ?? ''; 
            $div_style  = $field['div_style'] ?? '';

echo <<< EOF
<div class="form-group $div_class" style="$div_style">
EOF;        
        }

        if($isLabel) {
            $label_style     = $field['label_style'] ?? ''; 
            $label_class     = $field['label_class'] ?? ''; //'required'; 
            $label = $field['label']; 
    
echo <<< EOF
<label for="$id" class="$label_class" style="$label_style">$label</label>
EOF;        
        }

        $data = [];
        if(isset($field['source'])) {

            // $data_gateway = dmModel::Create($field['source']);
            if(is_array($field['source'])) {
                $dataset = $field['source'];
                foreach ($dataset as $key => $entry) {
                    $data[$key] = $entry;
                }
            } else {
                if(isset($field['dataset'])) { // it should be function
                    // function call
                    $dataset = ($field['dataset'])($field['source'] ?? '');
                } else {
                    $dataset = ($field['source'])::findBy($field['where'] ?? null,$field['sort'] ?? null);
                }
                if($dataset) {
                    if(isset($field['first_rec'])) {
                        $first = $field['first_rec'];
                        $data[$first[0]] = $first[1];
                        // $data[$first[0]] = $first[1];
                    }
                    if(isset($field['presentation'])) {
                        foreach ($dataset as $key => $entry) {
                            $data[$entry['id']] = ($field['presentation'])($entry);
                        }
                    } else {
                        foreach ($dataset as $key => $entry) {
                            $data[$entry['id']] = $entry['name'];
                        }
                    }
                }
            }
        }
        $class      = $field['class'] ?? '';
        $multiple   = isset($field['multiple']) ? ' multiple="true"' : '';

        // ComboArray::render($field_name, $value, $data, $params, $first_rec, $class); 

echo <<< SELECT
<select $id_id $name_name class="form-control $class" $multiple $params $cargo>  
SELECT;
        foreach ($data as $key => $text) {
            $selected = ($value == $key) ? 'selected' : ''; 
echo <<< OPTIONS
<option value="$key" $selected>$text</option>  
OPTIONS;
        }
echo <<< SELECT
</select>  
SELECT;

        if($isGroup) {
echo <<< EOF
</div>
EOF;        
        }
    }

    function FileView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {

        // $cargo = self::GetCargo($params);
        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);
        $value_value    = $this->printValue($value);

        $file_type = $field['file_type'] ?? 'jpg, .jpeg, .png';
        $data = $field['empty_data'] ?? 'empty.png';
        $value = $field['value'] ?? 'default.png';

        echo <<< EOF
        <div class="custom-file">
        <input type="file"accept="{$file_type}" data="$data" class="custom-file-input"  $id_id $name_name $value_value $params $cargo>
        <label for="{$id}" class="custom-file-label"></label>
        </div>
        EOF;        
    }
// 
function DateTimeView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {

    [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

    $id_id          = $this->printID($id);
    $name_name      = $this->printName($name);
    $value = $value ?? date('Y-m-d H:i'); 
    $value_value    = $this->printValue($value);

    $min_value  = $field['min_value'] ?? ''; 
    $max_value  = $field['max_value'] ?? ''; 
    $class      = $field['class'] ?? ''; 

    if($isGroup) {
        $div_style = $field['div_style'] ?? ''; 
        $div_class = $field['div_class'] ?? ''; 
echo <<< DATA
<div class="form-group $div_class" style="$div_style">
DATA;   
    } 

    if($isLabel) {

        $label_style = $field['label_style'] ?? ''; 
        $label_class = $field['label_class'] ?? ''; 
        $label = $field['label']; 

echo <<< DATA
<label for="$id" class="$label_class" style="$label_style">$label</label>
DATA;   
    }

echo <<< DATA
<input type="datetime-local" class="form-control $class" $id_id $name_name $value_value $min_value $max_value $params $cargo>
DATA;    

    if($isGroup)
echo <<< DATA
</div>    
DATA;    

    } // END METHOD 

    function DateView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {
        // $cargo = self::GetCargo($params);
        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);
        $value          = $value ?? date('Y-m-d'); 
        $value_value    = $this->printValue($value);

        $min_value  = $field['min_value'] ?? ''; 
        $max_value  = $field['max_value'] ?? ''; 
        $class      = $field['class'] ?? ''; 

        if($isGroup) {
            $div_style = $field['div_style'] ?? ''; 
            $div_class = $field['div_class'] ?? ''; 
echo <<< DATA
<div class="form-group $div_class" style="$div_style">
DATA;   
        } 

        if($isLabel) {

            $label_style = $field['label_style'] ?? ''; 
            $label_class = $field['label_class'] ?? ''; 
            $label = $field['label']; // ?? "Date / time"; 

echo <<< DATA
<label for="$id" class="$label_class" style="$label_style">$label</label>
DATA;    
        }

echo <<< DATA
<input type="date" class="form-control $class" $value_value $id_id $name_name $min_value $max_value $params $cargo>
DATA;    

        if($isGroup)
echo <<< DATA
</div>    
DATA;    

    }

    function CheckboxView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {
        // $cargo = self::GetCargo($params);
        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

        $id_id          = $this->printID($id);
        $name_name      = $this->printName($name);
        $value_value    = $this->printValue($value);

        $label = $field['label'] ?? ''; //'checkbox';    
        $class = $field['class'] ?? '';    
        $placeholder    = $this->inject($field, 'placeholder');
        $input_type     = $field['type'] ?? 'text';    
        $input_class    = 'custom-checkbox'; //'form-check-input';

        if($isGroup) {
            $div_style = $field['div_style'] ?? ''; 
            $div_class = $field['div_class'] ?? ''; 
echo <<< DATA
<div class="form-group $div_class" style="$div_style">
DATA;   
        } 
        // $label_class = 'form-check-label';
        $checked = $value ? 'checked' : '';

echo <<< DATA
<input type="$input_type" $checked $id_id $name_name maxlength="255" class="$input_class $class" $value_value" $placeholder $params $cargo><label for="$id">$label</label>
DATA;

        if($isGroup)
echo <<< DATA
</div>    
DATA;    
    }

    function ButtonView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {
        // $cargo = self::GetCargo($params);
        $button_type     = $field['type'];    
        [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);
        $name_name      = $this->printName($name);
        $id_id          = $this->printID($id);
        $input_class    = 'btn '; //'form-check-input';
        $class          = $field['class'] ?? '';    
        $label          = $field['label'] ?? 'Action'; //'checkbox';    
        $icon           = $field['icon'] ?? ''; //'checkbox';    

echo <<< DATA
<button  type="$button_type" $name_name $id_id class="$input_class $class"{$params}{$cargo}>{$label}{$icon}</button>
DATA;   
    } 


function PasswordView($field_name, $field, $attrs, $cargo, $isLabel, $isGroup) {
    // $cargo = self::GetCargo($params);
    [$id, $name, $value, $params] = $this->GetAttrs($field_name, $field, $attrs);

    $id_id          = $this->printID($id);
    $name_name      = $this->printName($name);
    $value_value    = $this->printValue($value);

    $class          = $field['class'] ?? '';    
    $input_type     = $field['type'] ?? 'text';    
    $placeholder    = $field['placeholder'] ?? '&#9679;&#9679;&#9679;&#9679;&#9679;';    
    $input_class    = 'form-control';

    if($isGroup) {
        $div_style = $field['div_style'] ?? ''; 
        $div_class = $field['div_class'] ?? ''; 
echo <<< DATA
<div class="form-group $div_class" style="$div_style">
DATA;   
    } 

    if($isLabel) {
        $label_style     = $field['label_style'] ?? ''; 
        $label_class     = $field['label_class'] ?? 'required'; 
        $label = $field['label']; // ?? 'Field';    

echo <<< DATA
<label for="$id" class="$label_class" style="$label_style">$label</label>
DATA;
    }

echo <<< DATA
<div class='pass-box form-group' style='display:flex;'>
<input type="$input_type" $id_id $name_name maxlength="255" class="$input_class $class" $value_value placeholder="$placeholder" $params $cargo>
<i class="far fa-eye" data-id="$id" id="tog-pass-$id" style="margin:auto;margin-left: -30px;cursor: pointer;"></i>
</div>
DATA;

    if($isGroup)
echo <<< DATA
</div>    
DATA;    

    }

}
// end form CLASS

function form_row(dmForm $form, $field_name, $attrs = null, $cargo = null, $isLabel = true, $isGroup = true) {
    $form->row( $field_name, $attrs, $cargo, $isLabel, $isGroup);
}
function form_widget(dmForm $form, $field_name, $attrs = null, $cargo = null, $isLabel = false, $isGroup = false) {
    $form->widget( $field_name, $attrs, $cargo, $isLabel, $isGroup);
}
