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
        return dmModel::Create($table_name);    
    }

    //[== Standart ==] 
    public static function Connect($server = "DB_SERVER")
    {

        if (APP::Config($server)) {

            $host = APP::Config($server); 
            $hostname = $host['hostname'];
            $username = $host['username'];
            $password = $host['password'];
            $database = $host['database'];
            $charset  = $host['charset'];
            // $port = null,
            // $socket = null

            DataBase::$_mysqli = new mysqli($hostname, $username, $password, $database);

            if (DataBase::$_mysqli->connect_error) {
                //die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                return false;
            } else {
                DataBase::ExecuteQuery("set names " . $charset );
                return true;
            }
        }
    }

    public static function ExecuteQuery(
        string $sql, 
        ?string $return = 'mysqlresult', 
        $params = null, 
        $debug = false)
    {
        // $start_time = microtime(true);
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $value  = sql_value($value);
                $sql    = str_replace(':'.$key, $value, $sql);
            }
        }

        self::$sql = $sql;
        $result = DataBase::db()->query($sql, MYSQLI_STORE_RESULT);
        // $duration = microtime(true) - $start_time;
        // STAT::addQueriesNum();
        // STAT::addToQueriesLog($sql, $duration);

        if ($return == 'mysqlresult')
            return $result;

        if ($return == 'array') {
            // if($debug) var_dump($return);
            $result_array = [];
            if(is_object($result)) {
                while ($rec = $result->fetch_array(MYSQLI_ASSOC)) {
                    $result_array[] = $rec;
                }
                return $result_array;
            } elseif($result == true) {
                return true;
            } else {
                throw new Exception('Error: ExecuteQuery Line 73. Sql=' .$sql );
            }
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
        $str = is_string($str) ? $str : '';
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

function sql_value($value) { 
    if(is_string($value))   return "'".DataBase::real_escape_string($value)."'";
    if(is_numeric($value))  return $value;
    if($value === null)     return 'NULL';
    if(is_bool($value))     return $value ? 'TRUE' : 'FALSE';
    if($value instanceof DateTime) return $value->format('Y-m-d H:i:s')."'";

    // // $value = esc_single_double_quote($value);
    // $value = DataBase::real_escape_string($value);
    // $value = $value."'";
    return $value;
}
function sql_value_eq($value) { 
    if(is_string($value))   return " ='".DataBase::real_escape_string($value)."'";
    if(is_numeric($value))  return ' =' .$value;
    if($value === null)     return ' IS NULL';
    if(is_bool($value))     return ' =' .$value ? 'TRUE' : 'FALSE';
    if($value instanceof DateTime) return " ='" . $value->format('Y-m-d H:i:s')."'";

    // $value = esc_single_double_quote($value);
    $value = DataBase::real_escape_string($value);
    $value = " ='".$value."'";
    return $value;
}


// class DbManager {
//     function FormData ( $form, $entry) {
//         $dlf = new DataLinkForm();
//         $field_names = $form->GetFieldNames();
//         $field_value = [];        
//         foreach($field_names as $field_name) {
//             $value = $dlf->$field_name;
//             $entry->Set($field_name, $value);
//             $field_value[$field_name] = $value;
//         }
//         return $field_value;
//     }
// }