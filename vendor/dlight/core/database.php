<?
class DataBase
{
    public static $_mysqli;
	public static $link = null;
	public static $resource_id = null;
	public static $sql = null;
	public static $pfx = '';
	public static $debug = true;

    public static function repository( $table_name )
    {
        return dlModel::Create($table_name);    
    }

    //[== Standart ==] 
    public static function Connect()
    {

        if (APP::Config("DB_SERVER")) {
            DataBase::$_mysqli = new mysqli(APP::Config("DB_SERVER"), APP::Config("DB_USER_NAME"), APP::Config("DB_USER_LOGIN"), APP::Config("DB_NAME"));

            if (DataBase::$_mysqli->connect_error) {
                //die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                return false;
            } else {
                DataBase::ExecuteQuery("set names " . APP::Config("DB_CHARSET"));
                return true;
            }
        }
    }

    public static function ExecuteQuery($sql, $return = 'mysqlresult')
    {
        $start_time = microtime(true);
        self::$sql = $sql;
        $result = DataBase::db()->query($sql, MYSQLI_STORE_RESULT);
        $duration = microtime(true) - $start_time;
        STAT::addQueriesNum();
        STAT::addToQueriesLog($sql, $duration);

        if ($return == 'mysqlresult')
            return $result;

        if ($return == 'array') {
            $result_array = array();
            while ($rec = $result->fetch_array())
                $result_array[] = $rec;

            return $result_array;
        }

        if ($return == 'iterator')
            return new mysqlIterator($result);

        return $result;
    }
    public static function db()
    {
        return DataBase::$_mysqli;
    }

    function getTableStructure($atable)
    {
        $sql = "SHOW COLUMNS FROM " . $atable . " FROM " . APP::Config("DB_NAME");
        return DataBase::ExecuteQuery($sql);
    }

    function getTables()
    {
        $sql = "SHOW TABLES FROM " . APP::Config("DB_NAME");
        return DataBase::ExecuteQuery($sql);
    }

    public static function num_rows($result)
    {
        return $result->num_rows;
    }

    public static function insert_id()
    {
        return DataBase::db()->insert_id;
    }

    public static function affected_rows($result)
    {
        if (is_object($result)) {
            return $result->affected_rows;
        }
        return 0;
    }

    public static function fetch_array($result)
    {
        return $result->fetch_array();
    }

    public static function data_seek($result, $offset)
    {
        return $result->data_seek($offset);
    }

    public static function real_escape_string($str)
    {
        return DataBase::db()->real_escape_string($str);
    }

    public static function get_error()
    {
        return DataBase::db()->error . "(" . DataBase::db()->errno . ")";
    }

    public static function parseBefore($str)
    {
        return DataBase::real_escape_string($str);
    }

    public static function parseBeforeStripTags($str)
    {
        return DataBase::real_escape_string(strip_tags($str));
    }

}

//это для админки - предустановленные фильтры - гибкий фильтр
class Filter
{
    public $_slug;
    public $_filter;
    public $_name;
    function __construct($slug, $name, $filter)
    {
        $this->_slug = $slug;
        $this->_filter = $filter;
        $this->_name = $name;
    }

    function getSlug()
    {
        return $this->_slug;
    }

    function getFilter()
    {
        return $this->_filter;
    }

    function getName()
    {
        return $this->_name;
    }
}

// для админки (поиск)
class SearchField
{
    public $_s_field;
    public $_s_string;
    public $_s_sign;

    function __construct($field, $string, $sign)
    {
        $this->_s_field = $field;
        $this->_s_string = $string;
        $this->_s_sign = $sign;
    }


    public static function PrintSearchFieldInForm($table_gateway, $s_field, $s_string, $s_field_sign, $counter)
    {
        echo "
                <div class='search_field'>
                    " . ll('Search') . ":
                        <input type='text' name='s_string{$counter}'  size='30' value='{$s_string}'>&nbsp;&nbsp;&nbsp;
                    " . ll('Field') . ":
                        <select name='s_field{$counter}'>";

        $rus_fields = $table_gateway->getFieldsRus();
        $fields = $table_gateway->getFields();
        $fields_types = $table_gateway->getFieldsTypes();

        if (!$s_field) {
            $s_field = "name";
        }
        for ($i = 0; $i < count($rus_fields); $i++) {
            if ($rus_fields[$i] != "" && $fields_types[$i]->IsInListing() && $fields_types[$i]->IsInSearch()) {
                echo "<option value='" . $fields[$i] . "'";
                if ($fields[$i] == $s_field)
                    echo "selected";
                echo ">" . $rus_fields[$i] . "</option>";
            }
        }

        echo "</select>&nbsp;&nbsp;&nbsp;
                    " . ll('Comparison') . ":
                    <select name='s_field_sign{$counter}'>
                        <option value='0'";
        if ($s_field_sign == 0) echo "selected";
        echo ">" . ll('Exact match') . "</option>
                        <option value='1'";
        if ($s_field_sign === "" || $s_field_sign == 1) echo "selected";
        echo ">" . ll('Not Exact match') . "</option>
                        <option value='2'";
        if ($s_field_sign == 2) echo "selected";
        echo ">" . ll('Not equal') . "</option>
                    </select>
                
                </div>";
    }
}

abstract class DBTable
{
    protected $_table_name;
    protected $_table_rus_name;
    protected $_table_key;
    protected $_isAddable;
    protected $_AddText;
    protected $_isEdited;
    protected $_isDeleted;
    protected $_error;
    protected $_filters;
    protected $_filter;
    protected $_observers = array();
    protected $_external_keys = array();
    protected $_returnIterator;
    protected $_fields_names;
    protected $_fields_rus_names;
    protected $_viewFields;
    protected $_fieldsTypes;
    // <Bulat+2021-02-26
    // protected $_recs_per_page = 20;
    protected $_recs_per_page = 50;
    // />
    protected $_enable_change_recs_per_page = true;
    protected $_sortable = false;

    protected $_last_insert_id;
    protected $_table_db;
    protected $_permissions;
    protected $_permissions_for_edit;
    protected $_listing_fields = null;

    public function getParamValueIndex($params, $field_name)
    {
        $index = array_search($field_name, $this->_fields_names);
        return [$params[$index], $index];
    }

    public function OnAdminListingViewEvent()
    {
    }

    public function getMaxIdRec()
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "` ORDER BY `id` DESC LIMIT 0, 1";
        $result = DataBase::ExecuteQuery($sql);
        //echo $sql;
        if ($result)
            return Database::fetch_array($result);
        else {
            $this->setError(Database::get_error());
            return false;
        }

        //    SELECT * FROM permlog ORDER BY id DESC LIMIT 0, 1

    }
    public function lastInsertId($val = false)
    {
        if ($val === false) {
            return $this->_last_insert_id;
        } else {
            $this->_last_insert_id = $val;
        }
    }

    public function addExternalKeys($arr_links)
    {
        $this->_external_keys = $arr_links;
    }
    public function addExternalKey($model_name, $external_key)
    {
        $this->_external_keys[] = array($model_name, $external_key);
    }


    public function ListingFields($listing_fields = false)
    {

        if ($listing_fields === false) {
            return $this->_listing_fields;
        } else {
            $this->_listing_fields = $listing_fields;
        }
    }

    public function getNextAutoIncrement()
    {
        return $this->QueryScalar("SELECT AUTO_INCREMENT 
                    FROM information_schema.tables
                    WHERE table_name =  '" . $this->_table_name . "'
                    AND table_schema =  '" . APP::Config("DB_NAME") . "'");
    }

    public function getFieldType($field_name)
    {
        $index = array_search($field_name, $this->_fields_names);
        if ($index === false)
            return false;
        else
            return $this->_fieldsTypes[$index];
    }

    public function getFieldName($field_name)
    {
        $index = array_search($field_name, $this->_fields_names);
        if ($index === false)
            return false;
        else
            return $this->_fields_rus_names[$index];
    }

    // Bulat+
    function getDefCond()
    {
        return "";
    }

    function getDefSort()
    {
        $sortable = $this->Sortable();
        if ($sortable) {
            return array($sortable, "ASC");
        } else
            return array("id", "DESC");
    }

    function RecsPerPage($value = false)
    {
        if ($value === false)
            return $this->_recs_per_page;
        else
            $this->_recs_per_page = $value;
    }

    function ChangeRecsPerPage($value = "")
    {
        if ($value === "")
            return $this->_enable_change_recs_per_page;
        else
            $this->_enable_change_recs_per_page = $value;
    }

    function Sortable()
    {
        /*   foreach($this->_fieldsTypes as $fieldType)
    {
     if(get_class($fieldType)=="SortField")
        return true;   
    }
    return false;*/

        for ($i = 0; $i < count($this->_fieldsTypes); $i++) {
            if (get_class($this->_fieldsTypes[$i]) == "SortField")
                return $this->_fields_names[$i];
        }
        return false;
    }

    function AddObserver($observer)
    {
        $this->_observers[] = $observer;
    }

    public static function ReturnResultIterator($result, $htmlspecialchars = false, $nl2br = false, $strip_tags = false, $exeption_keys = false)
    {
        if ($htmlspecialchars) {
            $iterator = new mysqlIterator($result);
            $array = array();
            while ($item = $iterator->NextElem()) {
                $array[] = TextHelper::Out($item, $nl2br, $strip_tags, $exeption_keys);
            }
            return new arrIterator($array);
        } else
            return new mysqlIterator($result);
    }

    public static function ReturnResultScalar($result, $htmlspecialchars = false, $nl2br = false, $strip_tags = false, $exeption_keys = false)
    {
        $iterator = new mysqlIterator($result);
        if ($iterator->hasElems()) {
            if ($htmlspecialchars) {
                $elem = $iterator->NextElem();
                return TextHelper::Out($elem, $nl2br, $strip_tags, $exeption_keys);
            } else
                return $iterator->NextElem();
        } else
            return null;
    }

    protected function ReturnResult($result, $htmlspecialchars = false, $nl2br = false, $strip_tags = false, $exeption_keys = false)
    {
        if ($this->_returnIterator)
            return DBTable::ReturnResultIterator($result, $htmlspecialchars, $nl2br, $strip_tags, $exeption_keys);
        else
            return $result;
    }

    public function ReturnIterator()
    {
        $this->_returnIterator = true;
    }

    public function setTableName($table_name, $table_name_rus)
    {
        $this->_table_rus_name = $table_name_rus;
        $this->_table_name = $table_name;
    }


    function __construct($fields_names = null, $table_name = false, $table_key = false)
    {
        $this->_returnIterator = false;
        if ($fields_names)
            $this->_fields_names = $fields_names;
        if ($table_name && !$this->_table_name)
            $this->_table_name = $table_name;
        if ($table_key)
            $this->_table_key = $table_key;
        else
            $this->_table_key = "id";

        $this->_permissions = array("edit" => 1, "delete" => 1, "add" => 1, "view" => 1);



        if ($fields_names) {
            for ($i = 0; $i < count($fields_names); $i++) {
                $this->_viewFields[] = 1;
                $this->_permissions_for_edit[$fields_names[$i]] = 1;
            }
        }

        $this->_fieldsTypes = array();

        if ($fields_names)
            $this->_fields_rus_names = $fields_names;
        if ($table_name)
            $this->_table_rus_name = $table_name;

        $this->_isAddable = true;
        $this->_isEdited = true;
        $this->_isDeleted = true;
        $this->_AddText = ll('Add entry'); //"Добавить запись в таблицу";

        $this->_filter = "";
    }


    function SetFilter($filter)
    {
        $this->_filter = $filter;
    }

    function GetFilter()
    {
        return $this->_filter;
    }

    function AddToFilters($filter)
    {
        $this->_filters[] = $filter;
    }

    function ApplyFilter($slug)
    {
        foreach ($this->_filters as $filter) {
            if ($filter->getSlug() == $slug) {
                $this->SetFilter($filter->getFilter());
                $this->_table_rus_name = $filter->getName();
                return true;
            }
        }

        return false;
    }



    function SetPermissionsForEdit($permissions)
    {
        $this->_permissions_for_edit = $permissions;
    }


    function getPermissionsForEdit()
    {
        return $this->_permissions_for_edit;
    }

    function SetPermissions($permissions)
    {
        $this->_permissions = $permissions;
    }

    function GetPermission($label)
    {
        return $this->_permissions[$label];
    }

    // function SetDataBaseForTable()
    // {
    //     DataBaseSingleton::SetDBName($this->_table_db);
    // }

    function OnView($table_gateway, $sort_by, $sort_dir, $page_num, $recs_per_page, $s_field = false, $s_string = false, $s_field_sign = false)
    {
        return false;
    }

    function OnAddForm()
    {
        return false;
    }


    function getError()
    {
        return $this->_error;
    }

    function setError($text)
    {
        $this->_error = $text;
    }


    function getViewFields()
    {
        return $this->_viewFields;
    }


    function setViewFields($viewFields)
    {
        $this->_viewFields = $viewFields;
    }


    function AddFields($fields)
    {
        if (is_array($fields)) {

            if (get_class($fields[0][0]) != "ID") {
                array_unshift($fields, array(new ID(), "id", "ID"));
            }

            foreach ($fields as $field) {
                $field_type = $field[0];
                $field_name = $field[1];
                $field_name_rus = $field[2];

                $this->_fields_names[] = $field_name;
                $this->_fields_rus_names[] = $field_name_rus;

                $field_type->setTabName($this->getName(), $this);
                $field_type->setFieldName($field_name);
                $field_type->setFieldNameRus($field_name_rus);
                $this->_fieldsTypes[] = $field_type;
            }
        }
    }

    function AddFieldType($field_type)
    {
        if ($field_type) {
            $field_type->setTabName($this->getName(), $this);
            $field_type->setFieldName($this->_fields_names[count($this->_fieldsTypes)]);
            $field_type->setFieldNameRus($this->_fields_rus_names[count($this->_fieldsTypes)]);
            $this->_fieldsTypes[] = $field_type;
        }
    }

    function getFieldsTypes($fields_names = false)
    {
        if (!$fields_names) {
            return $this->_fieldsTypes;
        } else {
            if (!is_array($fields_names)) {
                $fields_names = array($fields_names);
            }
            $result = array();
            foreach ($fields_names as $fields_name) {
                $result[] = $this->getFieldType($fields_name);
            }
            return $result;
        }
    }







    function GetAddText()
    {
        return $this->_AddText;
    }


    function SetAddText($text)
    {
        $this->_AddText = $text;
    }


    function isDeletable()
    {
        return $this->_isDeleted;
    }


    function isEditable()
    {
        return $this->_isEdited;
    }


    function isAddable()
    {
        return $this->_isAddable;
    }


    function NOTEditable()
    {
        $this->_isEdited = false;
    }


    function NOTDeletable()
    {
        $this->_isDeleted = false;
    }


    function NOTAddable()
    {
        $this->_isAddable = false;
    }



    function setTableRus($table_rus_name, $fields_rus_names)
    {
        $this->_fields_rus_names = $fields_rus_names;
        $this->_table_rus_name = $table_rus_name;
    }

    function getFieldsRus()
    {
        return $this->_fields_rus_names;
    }


    function getNameRus()
    {
        return $this->_table_rus_name;
    }




    function getFields()
    {
        return $this->_fields_names;
    }

    function getName()
    {
        return $this->_table_name;
    }

    function getKey()
    {
        return $this->_table_key;
    }


    function getRecsNumber()
    {
        $sql = "SELECT count( `" . $this->getKey() . "` ) FROM `" . $this->_table_name . "`";
        $rec = Database::fetch_array(DataBase::ExecuteQuery($sql));
        return $rec[0];
    }


    function getPageNumber($recs_per_page)
    {
        $recs_number = $this->getRecsNumber();
        if ((int) ($recs_number / $recs_per_page) == $recs_number / $recs_per_page) {
            $page_number = (int) ($recs_number / $recs_per_page);
        } else {
            $page_number = (int) ($recs_number / $recs_per_page) + 1;
        }
        return $page_number;
    }






    function LockTableRead()
    {
        $sql = "LOCK TABLES `" . $this->_table_name . "` READ";
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function LockTableWrite()
    {
        $sql = "LOCK TABLES `" . $this->_table_name . "` WRITE";
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function UnLockTables()
    {
        $sql = "UNLOCK TABLES";
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function Trancate()
    {
        $sql = "TRUNCATE TABLE `" . $this->_table_name . "`";
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }





    function GetRandRec()
    {
        $range_result = DataBase::ExecuteQuery(" SELECT MAX(`{$this->_table_key}`) AS max_id , MIN(`{$this->_table_key}`) AS min_id FROM `" . $this->_table_name . "` ");
        $range_row = Database::fetch_array($range_result);
        if ($range_row['min_id'] && $range_row['max_id']) {
            $random = mt_rand($range_row['min_id'], $range_row['max_id']);
            $result = DataBase::ExecuteQuery("SELECT * FROM `{$this->_table_name}` WHERE `id` >= {$random} LIMIT 0,1");
            if (Database::num_rows($result) > 0) {
                return Database::fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function getAllRecFieldsSort($fields, $sort_by, $sort_direction)
    {
        if (count($fields) > 0) {

            /*$fields_names="";
    for($i=0;$i<count($fields)-1;$i++)
    {
        $fields_names.=" `".$fields[$i]."`,";
    }
    $fields_names.=" `".$fields[count($fields)-1]."`";*/

            $fields_names = implode(", ", $fields);
            $sql = "SELECT " . $fields_names . " FROM `" . $this->_table_name . "` ORDER BY `" . $sort_by . "` " . $sort_direction;
            //echo $sql;
            $result = DataBase::ExecuteQuery($sql);
            if ($result)
                return $this->ReturnResult($result);
            else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            $this->setError('Неверные параметры');
            return false;
        }
    }


    function getrecsWhere($field, $value)
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `{$field}`='{$value}'";
        //echo $sql;
        $result = DataBase::ExecuteQuery($sql);
        if ($result)
            return $this->ReturnResult($result);
        else
            return "Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка: " . Database::get_error();
    }

    function getAllRecsByPageFields($fields, $sort_by, $page_num, $recs_per_page, $search_cond = "")
    {

        if (is_array($fields))
            $fields_name = implode(",", $fields);
        elseif (in_array($fields, $this->getFields()))
            $fields_name = $fields;
        else
            $fields_name = "*";


        $sql = "SELECT SQL_CALC_FOUND_ROWS {$fields_name} FROM `" . $this->_table_name . "`";

        if ($this->_filter)
            $sql .= " WHERE {$this->_filter} ";

        if ($search_cond)
            $sql .= " WHERE {$search_cond} ";

        if ($sort_by)
            $sql .= "ORDER BY " . $sort_by;


        $sql .= " LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;


        $sql_count = "SELECT FOUND_ROWS() as 'num'";


        //echo $sql;

        $result = DataBase::ExecuteQuery($sql);
        $result_count = DataBase::ExecuteQuery($sql_count);

        if ($result) {
            $row = Database::fetch_array($result_count);
            return array(0 => $this->ReturnResult($result), 1 => $row['num']);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }




    public function ExecuteQueryExt($sql, $return_array = false)
    {
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            $data = $this->ReturnResult($result);
            if ($return_array) {
                return $data->getArray();
            }
            return $data;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }





    function Add($params)
    {
        foreach ($this->_observers as $observer) {
            $observer->OnAdd($params);
        }

        for ($i = 0; $i < count($this->_fieldsTypes); $i++) {
            $params[$i] = $this->_fieldsTypes[$i]->OnAdd($params[$i]);

            if ($this->_fieldsTypes[$i]->_error != false) {
                $this->setError($this->_fieldsTypes[$i]->_error);
                return false;
            }
        }


        $values = array();
        $fields = array();
        //Database::real_escape_string
        for ($i = 0; $i < count($params); $i++) {
            if ($params[$i] != "NULL") {
                $values[] = "'" . Database::real_escape_string($params[$i]) . "'";
            } else {
                $values[] = Database::real_escape_string($params[$i]);
            }
            $fields[] = "`" . $this->_fields_names[$i] . "`";
        }
        $values_str = implode(",", $values);
        $fields_str = implode(",", $fields);

        $sql = "INSERT INTO `" . $this->_table_name . "` (" . $fields_str . ") VALUES (" . $values_str . ");";

        // echo $sql;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            $new_rec_id = Database::insert_id();
            $this->lastInsertId($new_rec_id);
            for ($i = 0; $i < count($this->_fieldsTypes); $i++)
                $this->_fieldsTypes[$i]->OnAfterAdd($new_rec_id, $params[$i]);

            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }



    function AddDirect($params)
    {




        $values = "";
        $fields = "";
        for ($i = 0; $i < count($params); $i++) {
            $value = stringBeforeDBInput($params[$i]);
            if ($i != count($params) - 1) {
                $values .= "'" . $value . "',";
                $fields .= "`" . $this->_fields_names[$i] . "`,";
            } else {
                $values .= "'" . $value . "'";
                $fields .= "`" . $this->_fields_names[$i] . "`";
            }
        }
        $sql = "INSERT INTO `" . $this->_table_name . "` (" . $fields . ") VALUES (" . $values . ");";

        //echo $sql;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            $new_rec_id = Database::insert_id();
            $this->lastInsertId($new_rec_id);
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    function getAllByIds($ids)
    {
        if (count($ids) > 0) {
            $cond = "";

            $first = true;
            /*for($i=0;$i<count($ids);$i++)
    foreach($ids as $key=>$value)
    {
        if($first)
        {$cond.="`".$this->_table_key."`=".$ids[$i];   $first=false;}
        else
        {$cond.=" OR `".$this->_table_key."`=".$ids[$i];}
    } */

            foreach ($ids as $key => $value) {
                if ($first) {
                    $cond .= "`" . $this->_table_key . "`=" . $value;
                    $first = false;
                } else {
                    $cond .= " OR `" . $this->_table_key . "`=" . $value;
                }
            }

            $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE " . $cond;
            //echo $sql;
            $result = DataBase::ExecuteQuery($sql);
            if ($result) {
                return $this->ReturnResult($result);
            } else {
                return "Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка:" . Database::get_error();
            }
        } else {
            return null;
        }
    }


    function RemoveWhere($field, $sign, $value)
    {
        $value = DataBase::real_escape_string($value);
        $sql = "DELETE FROM `" . $this->_table_name . "` WHERE `{$field}` {$sign} {$value}";
        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }

        // echo $sql;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    function RemoveWhereExt($where)
    {
        $sql = "DELETE FROM `" . $this->_table_name . "` WHERE {$where}";
        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }






    public static function GetData($fields = false, $filter = false, $page_num = false, $recs_per_page = false, $sort_cond = false, $all_num_rows = false)
    {
        $class_name = get_called_class();
        $gateway = new $class_name();
        $tb_name = $gateway->getName();
        $model_filter = $gateway->GetFilter();


        if (is_array($fields))
            $fields_name = implode(", ", $fields);
        elseif (in_array($fields, $gateway->getFields()))
            $fields_name = $fields;
        else
            $fields_name = "*";


        $sql = "SELECT ";

        if ($all_num_rows)
            $sql .= "SQL_CALC_FOUND_ROWS ";

        $sql .= "{$fields_name} FROM `" . $tb_name . "`";

        if ($model_filter || $filter) {
            if ($model_filter && $filter)
                $sql .= " WHERE {$model_filter} AND {$filter}";
            elseif ($model_filter)
                $sql .= " WHERE {$model_filter} ";
            elseif ($filter)
                $sql .= " WHERE {$filter} ";
        }

        /*if(isset($search_cond))
        $sql.=" WHERE {$search_cond} ";*/

        if ($sort_cond)
            $sql .= "ORDER BY " . $sort_cond;

        if ($page_num && $recs_per_page)
            $sql .= " LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;

        if ($all_num_rows)
            $sql_count = "SELECT FOUND_ROWS() as 'num'";

        //echo $sql;

        $result = DataBase::ExecuteQuery($sql);
        if ($all_num_rows)
            $result_count = DataBase::ExecuteQuery($sql_count);

        if ($result) {
            if ($all_num_rows) {
                $count = DBTable::ReturnResultScalar($result_count);
                return array(DBTable::ReturnResultIterator($result), $count['num']);
            } else
                return DBTable::ReturnResultIterator($result);
        } else {
            dlError::addError(Database::get_error(), "MySQLError");
            return false;
        }
    }

    function getRecsWhereFieldIN($field, $values, $fields, $sort_by = false, $sort_dir = false, $num = false)
    {
        if (count($values) > 0) {
            for ($i = 0; $i < count($values); $i++)
                $values[$i] = "'" . Database::real_escape_string($values[$i]) . "'";

            $cond = implode(", ", $values);


            if (!$fields) {
                $fields_to_get = "*";
            } else {
                /*$fields_to_get="";
    $first=true; 
   for($i=0;$i<count($fields);$i++)
    {
        if($first)
        {$fields_to_get.="{$fields[$i]}";   $first=false;}
        else
        {$fields_to_get.=", ".$fields[$i];}
    } */

                $fields_to_get = implode(", ", $fields);
            }



            $cond2 = "";
            if ($sort_by) {
                $cond2 = " ORDER BY `{$sort_by}` {$sort_dir}";
            }

            if ($num) {
                $cond2 .= " LIMIT 0,{$num}";
            }



            $sql = "SELECT {$fields_to_get} FROM `" . $this->_table_name . "` WHERE `{$field}` IN (" . $cond . ") {$cond2}";
            //echo $sql;
            $result = DataBase::ExecuteQuery($sql);
            if ($result) {
                return $this->ReturnResult($result);
            } else {
                return "Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка:" . Database::get_error();
            }
        } else {
            return null;
        }
    }



    public static function UpdateData($id, $fields, $values)
    {
        $class_name = get_called_class();
        $gateway = new $class_name();
        return $gateway->UpdateExt($id, $fields, $values);
    }


    public function OnUpdate($id, $fields = false, $params = false)
    {
    }

    function ChangeField($id, $field, $value)
    {
        $sql = "UPDATE `" . $this->_table_name . "` SET `" . $field . "`= `" . $field . "`+" . $value . " WHERE `" . $this->getKey() . "`=" . $id;
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            $this->OnUpdate($id, [$field], [$value]);
            return true;
        } else {
            return false;
        }
    }

    function UpdateFields($id, $fields, $values)
    {
        if (count($fields) == count($values) && count($values) > 0) {
            $paires_arr = array();
            for ($i = 0; $i < count($fields); $i++) {
                $value = stringBeforeDBInput($values[$i]);
                if ($value != "NOT_SET")
                    $paires_arr[] = "`" . $fields[$i] . "`='" . $value . "'";
            }
            $paires = implode(", ", $paires_arr);
            $sql = "UPDATE `" . $this->_table_name . "` SET " . $paires . " WHERE `" . $this->_table_name . "`.`" . $this->_table_key . "` =" . $id;
            //echo $sql;
            $res = DataBase::ExecuteQuery($sql);

            if ($res) {
                $this->OnUpdate($id, $fields, $values);
                if (Database::affected_rows($res))
                    return true;
                else
                    return 0;
            } else
                return false;
        } else {
            $this->setError("неправильные параметры функции");
            return false;
        }
    }



    function UpdateFieldsByCond($cond, $fields, $values)
    {
        if (count($fields) == count($values) && count($values) > 0) {
            $paires = "";
            for ($i = 0; $i < count($fields); $i++) {
                $value1 = stringBeforeDBInput($values[$i]);
                if ($paires == "") {
                    $paires .= "`" . $fields[$i] . "`='" . $value1 . "'";
                } else {
                    $paires .= ", `" . $fields[$i] . "`='" . $value1 . "'";
                }
            }

            $sql = "UPDATE `" . $this->_table_name . "` SET " . $paires . " WHERE " . $cond;
            //echo $sql;
            $res = DataBase::ExecuteQuery($sql);
            if ($res) {
                return true;
            } else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            $this->setError("неправильные параметры функции");
            return false;
        }
    }

    function UpdateFieldsByField($field, $value, $fields, $values)
    {
        if (count($fields) == count($values) && count($values) > 0) {
            $paires = "";
            for ($i = 0; $i < count($fields); $i++) {
                $value1 = stringBeforeDBInput($values[$i]);
                if ($paires == "") {
                    $paires .= "`" . $fields[$i] . "`='" . $value1 . "'";
                } else {
                    $paires .= ", `" . $fields[$i] . "`='" . $value1 . "'";
                }
            }

            $sql = "UPDATE `" . $this->_table_name . "` SET " . $paires . " WHERE `" . $field . "` ='" . $value . "'";
            //echo $sql;
            $res = DataBase::ExecuteQuery($sql);
            if ($res) {
                return true;
            } else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            $this->setError("неправильные параметры функции");
            return false;
        }
    }

    function UpdateExt($id, $fields, $params)
    {
        $params2 = array();

        for ($i = 0; $i < count($fields); $i++) {
            $FieldType = $this->getFieldType($fields[$i]);
            //$index=array_search($fields[$i],$this->_fields_names);
            //if($index!==false)
            //{
            /*if($this->_fieldsTypes[$index]->HasEditHandler())
            { */
            $params2[] = $FieldType->OnEdit($this, $id, $params[$i]);

            if ($FieldType->_error != false) {
                $this->setError($FieldType->_error);
                return false;
            }
            /*  }
            else
                $params2[]=$params[$i];*/
            //}

        }


        $paires_arr = array();
        for ($i = 0; $i < count($params2); $i++) {
            if ($params2[$i] !== "NOT_SET") {
                $value = Database::real_escape_string($params2[$i]);
                $paires_arr[] = "`" . $fields[$i] . "`='" . $value . "'";
            }
        }

        if (count($paires_arr)) {
            $paires = implode(", ", $paires_arr);
            $sql = "UPDATE 
            `" . $this->_table_name . "` 
            SET 
                " . $paires . " 
            WHERE 
                `" . $this->_table_name . "`.`" . $this->_table_key . "` =" . $id;
            // echo $sql;
            $res = DataBase::ExecuteQuery($sql);
            if ($res) {
                $this->OnUpdate($id, $fields, $params);
                return true;
            } else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            return true;
        }
    }

    function Update($id, $params)
    {

        for ($i = 0; $i < count($this->_fieldsTypes); $i++) {
            /*if($this->_fieldsTypes[$i]->HasEditHandler())
        {  */
            $params[$i] = $this->_fieldsTypes[$i]->OnEdit($this, $id, $params[$i]);

            if ($this->_fieldsTypes[$i]->_error != false) {
                $this->setError($this->_fieldsTypes[$i]->_error);
                return false;
            }
            //}

        }


        $paires = "";
        for ($i = 0; $i < count($params); $i++) {
            if (($this->_fields_names[$i] != $this->getKey()) && ($params[$i] !== "NOT_SET")) {

                $value = Database::real_escape_string($params[$i]);
                //$value=$params[$i];
                if ($paires == "") {
                    $paires .= "`" . $this->_fields_names[$i] . "`='" . $value . "'";
                } else {
                    $paires .= ", `" . $this->_fields_names[$i] . "`='" . $value . "'";
                }
            }
        }

        $sql = "UPDATE `" . $this->_table_name . "` SET " . $paires . " WHERE `" . $this->_table_name . "`.`" . $this->_table_key . "` =" . $id;
        //echo $sql;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            $this->OnUpdate($id, $this->getFields(), $params);
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }




    function getRecByField($field, $value)
    {
        $value = Database::real_escape_string($value);
        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `" . $field . "` = '" . $value . "'";

        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            if (Database::num_rows($result) > 0) {
                return Database::fetch_array($result);
            } else {
                return false;
            }
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    function getRecById($id)
    {
        $id = Database::real_escape_string($id);
        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `" . $this->_table_key . "` = " . $id;
        $result = DataBase::ExecuteQuery($sql);
        if ($result)
            return Database::fetch_array($result);
        else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    function getRecFieldsById($id, $fields)
    {
        if (!count($fields) || !is_array($fields)) {
            $this->setError('Неверные параметры');
            return false;
        }
        $fields_names = implode(", ", $fields);
        $id = Database::real_escape_string($id);
        $sql = "SELECT " . $fields_names . " FROM `" . $this->_table_name . "` WHERE `" . $this->_table_key . "` = " . $id;
        //echo $sql;
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return Database::fetch_array($result);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    function getLastRecsFields($last_num, $fields)
    {
        if (count($fields) > 0) {
            $fields_names = "";
            for ($i = 0; $i < count($fields) - 1; $i++) {
                $fields_names .= " `" . $fields[$i] . "`,";
            }
            $fields_names .= " `" . $fields[count($fields) - 1] . "`";


            $sql = "SELECT " . $fields_names . " FROM `" . $this->_table_name . "` ORDER BY `" . $this->_table_key . "` DESC LIMIT 0, " . $last_num;
            //echo $sql;
            $result = DataBase::ExecuteQuery($sql);
            if ($result) {
                return $this->ReturnResult($result);
            } else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            $this->setError('Неверные параметры');
            return false;
        }
    }


    public function QueryScalar($sql)
    {
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            $res = $this->ReturnResult($result);
            if ($this->_returnIterator) {
                if ($res->CountElems()) {
                    $row = $res->NextElem();
                    return $row[0];
                } else
                    return null;
            } else {
                if (Database::num_rows($res)) {
                    $row = Database::fetch_array($res);
                    return $row[0];
                } else
                    return null;
            }
            return $res;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    public function QueryByPage($sql, $page_num, $recs_per_page)
    {

        $sql .= " LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;
        $sql_count = "SELECT FOUND_ROWS() as 'num'";

        $result = DataBase::ExecuteQuery($sql);
        $result_count = DataBase::ExecuteQuery($sql_count);

        if ($result) {
            $row = Database::fetch_array($result_count);
            return array(0 => $this->ReturnResult($result), 1 => $row['num']);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    public function QueryRow($sql)
    {
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            $res = $this->ReturnResult($result);
            if ($this->_returnIterator) {
                if ($res->CountElems())
                    return $res->NextElem();
                else
                    return null;
            } else {
                if (Database::num_rows($res))
                    return Database::fetch_array($res);
                else
                    return null;
            }
            return $res;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }
    public function Query($sql)
    {
        $result = DataBase::ExecuteQuery($sql);
        //echo $sql;
        if ($result) {
            return $this->ReturnResult($result);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    function getRecFieldsByField($field_id, $field_value_id, $fields = [])
    {
        if (!empty($fields)) {
            $fields_names = implode(", ", $fields);
        } else
            $fields_names = "*";

        $field_value_id = Database::real_escape_string($field_value_id);


        $sql = "SELECT " . $fields_names . " FROM `" . $this->_table_name . "` WHERE `" . $field_id . "` = '" . $field_value_id . "'";
        //echo $sql;
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            if (Database::num_rows($result)) {
                return Database::fetch_array($result);
            } else {
                return null;
            }
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }



    function getAllRecFields($fields)
    {
        if (count($fields) > 0) {
            $fields_names = "";
            for ($i = 0; $i < count($fields) - 1; $i++) {
                $fields_names .= " `" . $fields[$i] . "`,";
            }
            $fields_names .= " `" . $fields[count($fields) - 1] . "`";


            $sql = "SELECT " . $fields_names . " FROM `" . $this->_table_name . "`";

            if ($this->_filter) {
                $sql .= " WHERE {$this->_filter}";
            }
            //echo $sql;
            $result = DataBase::ExecuteQuery($sql);
            if ($result) {
                return $this->ReturnResult($result);
            } else {
                $this->setError(Database::get_error());
                return false;
            }
        } else {
            $this->setError('Неверные параметры');
            return false;
        }
    }


    function getWhere($field, $value, $sort_by = "id", $sort_direction = "DESC")
    {

        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `{$field}`='{$value}'";

        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }

        $sql .= " ORDER BY `" . $sort_by . "` " . $sort_direction;

        //echo $sql;
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return $this->ReturnResult($result);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    function getWhereExt($cond, $fields = [], $sort_by = "id", $sort_direction = "DESC")
    {

        if (!empty($fields))
            $fields_names = implode(", ", $fields);
        else
            $fields_names = "*";

        $sql = "SELECT {$fields_names} FROM `" . $this->_table_name . "` WHERE {$cond}";

        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }

        $sql .= " ORDER BY `" . $sort_by . "` " . $sort_direction;


        //echo $sql;
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            return $this->ReturnResult($result);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }




    function getAllRecs($sort_by, $sort_direction)
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "`";

        if ($this->_filter) {
            $sql .= " WHERE {$this->_filter}";
        }

        if ($sort_by) {
            $sql .= " ORDER BY `" . $sort_by . "` " . $sort_direction;
        }

        //echo $sql;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return $this->ReturnResult($res);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }

    function getAllRecsByPage($sort_by, $sort_direction, $page_num, $recs_per_page)
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "`";

        if ($this->_filter) {
            $sql .= " WHERE {$this->_filter} ";
        }

        if ($sort_by) {
            $sql .= "ORDER BY `" . $sort_by . "` " . $sort_direction . " ";
        }


        $sql .= "LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;


        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return $this->ReturnResult($res);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }





    function Remove($id)
    {
        foreach ($this->_observers as $observer) {
            $observer->OnRemove($id);
        }
        foreach ($this->_fieldsTypes as $fieldType) {
            $fieldType->OnRemove($id);
        }
        foreach ($this->_external_keys as $external_key_obj) {
            $model_name = $external_key_obj[0];
            $external_key = $external_key_obj[1];
            if (class_exists($model_name)) {
                dlModel::Create($model_name)->RemoveWhere($external_key, "=", $id);
            }
        }

        $sql = "DELETE FROM `" . $this->_table_name . "` WHERE `" . $this->_table_name . "`.`" . $this->_table_key . "` = " . $id;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    function RemoveAll()
    {
        $sql = "DELETE FROM `{$this->_table_name}`";

        if ($this->_filter) {
            $sql .= " WHERE {$this->_filter}";
        }

        $result = DataBase::ExecuteQuery($sql);

        if ($result) {
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }



    function RemoveExt($s_field, $s_string, $s_field_sign)
    {




        if ($s_field) {



            $s_string1 = trim(stringBeforeDBInput($s_string));
            $engFieldsNames = $this->getFields();
            $fieldTypes = $this->getFieldsTypes();

            if (in_array($s_field, $engFieldsNames)) {

                $index = array_search($s_field, $engFieldsNames);
                $fieldType = $fieldTypes[$index];
                $s_string1 = $fieldType->OnViewInverse($s_string1);

                if ($s_field_sign == 0) {
                    $ar = explode("~", $s_string1);
                    if (count($ar) == 2) {
                        $sign = "BETWEEN '{$ar[0]}' AND '{$ar[1]}'";
                    } else {
                        $sign = "='{$s_string1}'";
                    }
                } else if ($s_field_sign == 1) {
                    $sign = "LIKE '%{$s_string1}%'";
                } else {
                    $sign = "<>'{$s_string1}'";
                }


                $sql = "DELETE FROM `{$this->_table_name}` WHERE `{$s_field}` {$sign}";

                if ($this->_filter) {
                    $sql .= " AND {$this->_filter}";
                }

                //echo $sql;

                $result = DataBase::ExecuteQuery($sql);

                if ($result) {
                    return array(true, Database::affected_rows($result));
                } else {
                    $this->setError(Database::get_error());
                    return array(false, 0);
                }
            }
        }

        return false;
    }


    function RemoveDirect($id)
    {
        $sql = "DELETE FROM `" . $this->_table_name . "` WHERE `" . $this->_table_name . "`.`" . $this->_table_key . "` = " . $id;
        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return true;
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }



    function getSearchCond($searchFields, $sep_logic = "AND")
    {
        if (count($searchFields) > 0) {
            $engFieldsNames = $this->getFields();
            $fieldTypes = $this->getFieldsTypes();

            $where_cond = "";

            for ($i = 0; $i < count($searchFields); $i++) {
                $s_field = $searchFields[$i]->_s_field;
                $s_string = $searchFields[$i]->_s_string;
                $s_field_sign = $searchFields[$i]->_s_sign;


                $s_string1 = trim(stringBeforeDBInput($s_string));


                //if(in_array($s_field,$engFieldsNames))
                //{
                $index = array_search($s_field, $engFieldsNames);
                $fieldType = $fieldTypes[$index];
                $s_string1 = $fieldType->OnViewInverse($s_string1);

                if ($s_field_sign == 0) {
                    $ar = explode("~", $s_string1);
                    if (count($ar) == 2) {
                        $sign = "BETWEEN '{$ar[0]}' AND '{$ar[1]}'";
                    } else {
                        $sign = "='{$s_string1}'";
                    }
                } else if ($s_field_sign == 1) {
                    $sign = "LIKE '%{$s_string1}%'";
                } else {
                    $sign = "<>'{$s_string1}'";
                }

                if ($where_cond != "") {
                    $where_cond .= " {$sep_logic} ";
                }

                $where_cond .= "{$s_field} {$sign}";
                //}
            }

            if ($where_cond != "") $where_cond = " WHERE " . $where_cond;
        } else {
            $where_cond = "";
        }

        return $where_cond;
    }




    function getAllRecsByPageExt($sort_by, $sort_direction, $page_num, $recs_per_page, $searchFields, $sep_logic = "AND") //,$s_field,$s_string,$s_field_sign=0
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `" . $this->_table_name . "`";

        $where_cond = $this->getSearchCond($searchFields, $sep_logic);

        if ($this->_filter) {
            if ($where_cond) {
                // $where_cond = "({$where_cond}) AND {$this->_filter}";
                $where_cond = "{$where_cond} AND {$this->_filter}";
                // if($where_cond) echo $where_cond; die;
            } else {
                $where_cond = " WHERE {$this->_filter}";
            }
        }

        $sql .= $where_cond;

        if ($sort_by && $sort_direction) {
            $sql .= " ORDER BY `" . $sort_by . "` " . $sort_direction . " ";
        } else if ($sort_by) {
            $sql .= " ORDER BY " . $sort_by;
        }



        $sql .= " LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;


        $sql_count = "SELECT FOUND_ROWS() as 'num'";


        //echo $sql;


        $result = DataBase::ExecuteQuery($sql);
        $result_count = DataBase::ExecuteQuery($sql_count);

        if ($result) {
            $row = Database::fetch_array($result_count);
            return array(0 => $this->ReturnResult($result), 1 => $row['num']);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }





    function getAllRecsByPageSearch($s_field, $s_string, $sort_by, $sort_direction, $page_num, $recs_per_page)
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `" . $s_field . "` LIKE '%" . $s_string . "%'";

        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }


        if ($sort_by) {
            $sql .= " ORDER BY `" . $sort_by . "` " . $sort_direction;
        }

        $sql .= " LIMIT " . ($page_num - 1) * $recs_per_page . " , " . $recs_per_page;

        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return $this->ReturnResult($res);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }


    function getBETWEEN($field, $start, $end)
    {
        $sql = "SELECT * FROM `" . $this->_table_name . "` WHERE `" . $field . "` BETWEEN '" . $start . "' AND '" . $end . "'";

        if ($this->_filter) {
            $sql .= " AND {$this->_filter}";
        }

        $res = DataBase::ExecuteQuery($sql);
        if ($res) {
            return $this->ReturnResult($res);
        } else {
            $this->setError(Database::get_error());
            return false;
        }
    }
}
