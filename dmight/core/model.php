<?php

class dlModel
{
  static public $db_table;  
  protected $_table_name;
  protected $_table_key;

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
      
      return $gateway;  
  }
  public static function SetTable($db_table_name) {
    self::$db_table = $db_table_name;
  }
  public static function GetTable() {
    return self::$db_table ?? false;
  }

}

class dmModel extends dlModel {

    public $db_prefix;
    protected static $structures = [];

    static function repository() {
        $db_table_name = self::GetTable();
        if( $db_table_name ) {
            $repository     = new dmModel;
        } else {

            $className      = get_called_class();
            $db_table_name  = self::table_name($className);
            $repository     = self::Create($className);
        }
        $repository->_table_name = $repository->db_prefix . $db_table_name; 
        
        return $repository;
    }

    static function GetDefault($space = false) {
// https://dev.mysql.com/doc/refman/8.0/en/getting-information.html
        $table_name = self::repository()->_table_name;

        $sql = "DESCRIBE `{$table_name}`;";
        // Field   | Type        | Null | Key | Default | Extra 

        $data = DataBase::ExecuteQuery($sql, 'array');
        $result = [];
        if($data) {
            foreach ($data as $row) {
                $default = $row['Default'];
                if($space and $default === null) {
                    if(containExt($row['Type'],['CHAR', 'TEXT']) ) {
                        $default = '';
                    }
                }
                $result[$row['Field']] = $default;
            }
        }
        return $result;
    }

    static function CreateQueryBuilder($alias): QueryBuilder {
        $repository = self::repository();
        $builder = new QueryBuilder($alias, $repository->_table_name);
        return $builder;
    }

    function FormData ( $form ) {
        $dlf = new DataLinkForm();
        $field_names = $form->GetFieldNames();
        $field_value = [];        
        foreach($field_names as $field_name) {
            $value = $dlf->$field_name;
            $this->Set($field_name, $value);
            $field_value[$field_name] = $value;
        }
        return $field_value;
    }
// 
    static function Flush(dmForm $form, &$entry) {

        $form->Params2Form($entry);

        $fields = $form->fields;
        $field_value = [];
        foreach ($fields as $field_name => $options) {
            if(isset($entry[$field_name])) {
                $field_value[$field_name] = $options['value'];
            } elseif(isset($entry[$field_name.'_id'])) {
                $field_value[$field_name.'_id'] = $options['value'];
            } 
        }

// dump( $field_value, $entry['id'] );   
// MySQL DATABASE  
// https://www.w3schools.com/sql/trymysql.asp?filename=trysql_func_mysql_last_insert_id
        if($entry['id']) { // Update; record exists
            $result = self::make(
                'update', $entry['id'],
                $field_value
            );
        } else { // Insert - new record
            $result = self::make(
                'insert', 0,
                $field_value
            );
        }
        if($result) 
            return true; //self::GetLastID();
        else     
            return 0;
    }

    static function Commit(&$entry, $names = null, $id = 'id') {

        if($names) {
            $data = [];
            foreach ($names as $field_name) {
                if(array_key_exists($field_name, $entry ))
                    $data[$field_name] = $entry[$field_name]; 
            }
        } else {
            $data = $entry;
        }
        $last_rec_id = 0;
        if(isset($entry[$id]) and $entry[$id]) { // Update; record exists
            self::make(
                'update', $entry[$id],
                $data
            );
            $last_rec_id = $entry[$id];

        } else { // Insert - new record
            $last_rec_id = self::make(
                'insert', 0,
                $data
            );
            $data[$id]  = $last_rec_id;
            $entry[$id] = $last_rec_id;
        }
        // if($result) return self::GetLastID();
        return $last_rec_id; 
    }

    function Set($field, $value) {
        $this->$field = $value;
        return $this;
    }
    function Get($field) {
        return $this->$field;
    }

    function DbTableName() {
        if (method_exists($this, 'GetTableName')) {
            $className = $this->GetTableName();
        } else {
            $className = get_called_class();
        }
        return strtolower($this->db_prefix . $className);
    }
    function TableExists() {
        $tbl_name = $this->DbTableName();
        $db = APP::Config("DB_NAME");
        $sql = "SHOW TABLES FROM $db LIKE {$tbl_name};";

        $result = DataBase::ExecuteQuery($sql);
        dd('Table exists '.$tbl_name. '>'.$result."<");
        return $result;
    }

    function ModifyTable() {
//SHOW TABLES FROM `db` LIKE 'tablename'; //zero rows = not exist        
        $tbl_name = $this->DbTableName();
        $struType = $this->structureSign();
        // dump($struType);
        $sql = 'DESCRIBE ' . $tbl_name .';';
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            // while($row = mysql_fetch_array($result)) {
            //     echo "{$row['Field']} - {$row['Type']}\n";
            // }
            $data = [];
            while($row = Database::fetch_array($result)) {
                $name = strtolower(trim($row['Field']));
                $type = strtolower(trim($row['Type']));
                $data[$name] = $name . ' ' . $type;
            };

            // new fields or updated
            $adds = [];
            $changes = [];
            foreach($struType as $name => $sign) {
                if(isset($data[$name]) and $data[$name] == $sign) continue;
                if(isset($data[$name]))
                    $changes[$name] = $sign;
                else
                    $adds[$name] = $sign;

            }
            // delete fields
            $drops = [];
            foreach($data as $name => $sign) {
                if(isset($struType[$name])) continue;
                $drops[$name] = $sign;
            }

            $sql = "";
            if($adds or $changes or $drops) {

                $sql = "ALTER TABLE " . $tbl_name . " ";

                // dump('adds',$adds);
                // dump('changes',$changes);
                // dump('drops',$drops);
                if($adds) {
                    $sql .= " ADD (";
                    $flds = '';
                    foreach ($adds as $name => $sign) {
                        $flds .= $sign . ',';
                    }
                    $flds = chop($flds,',');
                    $sql .= $flds ."),";
                }
                if($changes) {
                    $flds = '';
                    foreach ($changes as $name => $sign) {
                        $flds .= "CHANGE " . $name . ' ' . $sign .',';
                    }
                    // $flds = chop($flds,',');
                    $sql .= $flds;
                }
                if($drops) {
                    $flds = '';
                    foreach ($drops as $name => $sign) {
                        $flds .= "DROP " . $name . ',';
                    }
                    // $flds = chop($flds,',');
                    $sql .= $flds;
                }
                $sql = chop($sql,',') .';';

                if(method_exists($this, 'get_sql')) $this->get_sql($sql);
                // call sql statement
                $result = DataBase::ExecuteQuery($sql);
                if ($result) {
                    // $ret = Database::fetch_array($result);
                    // return true;
                    // dd($ret);
                    return $tbl_name . ' ' .$result; // $tbl_name . ' OK';
                }
                // $this->setError(Database::get_error());
                // return false;
                // return false; // $tbl_name . ' -';
            }
            // return false;
        }
        // $this->setError(Database::get_error());
        // return false;
        return $tbl_name . ' ' . false;

    }
    
    function CreateTable( $new ) {

        $tbl_name = $this->DbTableName();
        // if($new) {
        //     $exist = $this->TableExists();
        //     if($exist) return $tbl_name . ' EXISTS';
        // }

        Field::init( $this );

        // dd($tbl_name);

        // $sql = 'CREATE [TEMPORARY] TABLE [IF NOT EXISTS] tbl_name
        $if_not_exist = $new ? 'IF NOT EXISTS ' : '';
        $sql = 'CREATE TABLE ' . $if_not_exist . $tbl_name .' (';

        $structure = $this->structure();
        $flds = '';
        if($structure)
            ksort($structure, SORT_NUMERIC);
            foreach($structure as $column) {
                $flds .= $column .',';
            }

        if (Field::$postfix) {
            $flds .= chop(Field::$postfix,',');
        } else {
            $flds = chop($flds, ',');
        }
        $sql .= $flds . ');';

        if(method_exists($this, 'get_sql')) $this->get_sql($sql);
        // call sql statement
        $result = DataBase::ExecuteQuery($sql);
        if ($result) {
            // return Database::fetch_array($result);
            // return true;
            return $tbl_name . ' OK';
        }
        // $this->setError(Database::get_error());
        // return false;
        return $tbl_name . ' -';

    }
    protected function structureSign() {
        $sign = [];
        $structure = $this->structure();
        if($structure) {
            ksort($structure, SORT_NUMERIC);
            foreach($structure as $field) {
                $field = trim($field);
                $parts = explode(' ', $field, 3);
                // dump($field);
                // dump($parts);
                if(count($parts) > 1) {
                    $name = strtolower(trim($parts[0]));
                    $type = strtolower(trim($parts[1]));
                    // dump($name, '=', $type);
                    $sign[$name] = $name .' '.$type;
                    // dump($sign[$name] .'>' . $name .' '.$type);
                }
            }
        }
        return $sign;
    }  
    function Structure() {
        $structure = [
            Field::id(),
            Field::string('name'),
        ];
        return $structure;
    }  
    function SimulateData() {
        return 'empty for ' . $this->_table_name;
    }  
    function addstruct( $stru1, $stru0 = [] ) {

        $start = 20;
        // $stru0 = parent::Structure();
        $structure = $stru0;
        foreach($stru1 as $entry) {
            $structure[$start] = $entry; 
            $start++;
        }
        ksort($structure, SORT_NUMERIC);
        return $structure;
    }  
    static function Insert( &$content = [] )
    {
        return self::make( 'INSERT', 0, $content );
    }    
    static function Assign($id, &$content = [] )
    {
        if($id)
            return self::make( 'UPDATE', $id, $content );
        else
            return self::make( 'INSERT', 0, $content );
    }    
    static function Delete($invoice)
    {
        if(is_array($invoice)) {
            $id = $invoice['id'];
        } else {
            $id = $invoice;
        }
        return self::make_simple( 'DELETE', $id );
    }    

    // SELECT LAST_INSERT_ID();
    static function GetLastID() {
        return self::make_simple('LAST_ID', 0);
    }

    static function count( $where = [], $id = '*' ) {
        // $content = ['where' => '<table_name>.  ...']
        if($where) {
            $state = '';
            foreach ($where as $key => $value) {
                $state .= $key .' = ' . $value;
            }
            $content = ['where' => $state];
        } else $content = [];

        return self::make_simple( 'COUNT', $id, $content);
    }

    static function make( $action, $id, $content = [] )
    {
    try {

        // self::LastInsertId();
        $repository = self::repository();
        $table_name = $repository->_table_name;
        $keyId = $repository->_table_key ? $repository->_table_key : 'id';

        if(!isset(self::$structures[$table_name])) {
            self::$structures[$table_name] = self::GetDefault();
        }
        $stru_fields = self::$structures[$table_name];
        // dd($fields, $content);
        $action = strtoupper($action);
        $status = 0;
        $sql = "";
        switch ($action) {
            case 'UPDATE':
                $paires = "";
                foreach($content as $key => $value) {
                    // if(is_numeric($key) or $key == 'id' or !array_key_exists($key,$stru_fields)) continue;
                    if(is_numeric($key) or !array_key_exists($key,$stru_fields)) continue;
                    $value = sql_value($value);
                    $paires .= $key ." = $value,";

                }
                $paires = trim($paires, ',');
                $sql = 'UPDATE ' . $table_name . " SET " . $paires . " WHERE " . $table_name . "." . $keyId . " =" . $id;
                $status = 2; 
// dump($sql);
                break;
            case 'INSERT':

                $values = ' (';
                $fields = ' (';

                foreach($content as $key => $value) {
                    // if(is_numeric($key) or $key == 'id' or !array_key_exists($key,$stru_fields)) continue;
                    if(is_numeric($key) or !array_key_exists($key,$stru_fields)) continue;

                    $value = sql_value($value);
                    $values .= $value .',';
                    $fields .= $key.',';
                }
                $values = trim($values, ',') .') ';
                $fields = trim($fields, ',') .') ';
                $sql = "INSERT INTO " . $table_name . $fields . "VALUES" . $values.";";
                $status = 1; 
                break;
            default:
                break;
        } 
        if($sql) {
            // echo $sql;
            $res = DataBase::ExecuteQuery($sql);
// dlLog::WriteDump('res='.$res, Database::get_error());
            // dd($table_name, Database::get_error());
            // $this->setError(Database::get_error());
            if ($res) {
                if($status == 1) {
// dlLog::WriteDump('status='.$status);
                    $last_rec = self::GetLastID();
// dlLog::WriteDump('last_rec='.$last_rec);
                    return $last_rec;
                } else {
                    $last_rec = $content['id'];
                }
                // $this->OnUpdate($id, $this->getFields(), $params);
                return true;
            } else {
                $error = Database::get_error();
                $error = "Make: ExecuteQuery ". $sql .'<br>'.$error;
                $repository->setError($error);
                throw new Exception($error, 9003);
                // return false;
            }
        }
        else return false;
    } catch (Exception $e) {
        $mssg = "Make: ". $sql .'<br>'.$e->getMessage();
        throw new Exception($mssg, 9001);
    }
    return false;
    }

    static function make_simple( $action, $id, &$content = [] )
    {
    try {

// echo "<br>ID =", $id, '<br>';        // self::LastInsertId();
        $repository = self::repository();
        $table_name = $repository->_table_name;
        $keyId = $repository->_table_key ? $repository->_table_key : 'id';

        $action = strtoupper($action);
        $sql = "";
        switch ($action) {
            case 'DELETE':
                $sql = 'DELETE FROM ' . $table_name . " WHERE " . $table_name . "." . $keyId . " =" . $id;
                break;
                
            case 'COUNT':
                if(!$id) $id = '*';
                $where = (isset($content['where'])) ? " WHERE " . $content['where'] : ''; 
                $sql = "SELECT COUNT($id) FROM " . $table_name . $where;
                break;

            case 'LAST_ID':

                $sql_bak = DataBase::$sql;
                $sql = "SELECT LAST_INSERT_ID();";
                // $sql = "SELECT  AUTO_INCREMENT
                //  FROM    information_schema.TABLES
                //  WHERE   (TABLE_NAME = {$table_name})";
                // $sql = "SELECT IDENT_CURRENT('{$table_name}') AS Result";
                // $sql = "SELECT SCOPE_IDENTITY() AS Result;";

                // SCOPE_IDENTITY()
        
dlLog::WriteDump('(1)LAST FOR '.$table_name);
                $res = DataBase::ExecuteQuery($sql); //, 'array');
                $res = $res->fetch_array();
                DataBase::$sql = $sql_bak;
dlLog::WriteDump('(1.2)LAST FOR '.$table_name, $res, $sql_bak);
                // $ret = $res[0][0] ?? 0;
                $ret = $res['LAST_INSERT_ID()'] ?? 0;
dlLog::WriteDump('(2)LAST FOR '.$table_name, $ret, $res, $sql_bak);
                return $ret;

            default:
                break;
        } 
        if($sql) {
            // echo $sql;
            $res = DataBase::ExecuteQuery($sql);
dymp($action, $sql, $res);            
            if ($res) {
                return true;
            } else {
                $error = Database::get_error();
                $error = "Make: ExecuteQuery ". $sql .'<br>'.$error;
dymp('res='.$res, Database::get_error(), $sql);
                $repository->setError($error);
                throw new Exception($error, 9003);
            }
        }
        else return false;
    } catch (Exception $e) {
        $mssg = "Make: ". $sql .'<br>'.$e->getMessage();
        throw new Exception($mssg, 9002);
    }
    return false;
    }

    static function belongsTo( $id, $table ) // strange method
    {
        $obj = DataBase::repository( $table )->find( $id );
        return $obj['name'] ?? "";
    }
    static function table_name( $className ) { 
        if(method_exists($className, 'GetTableName')) {
            $db_table_name = $className::GetTableName();
        } else {
            $db_table_name = strtolower($className);
        }
        return $db_table_name;
    }
    static function GetDbTableName() {
        return self::repository()->_table_name;
    }

    function fetch($field, $id)
    {
        $entry = $this->find($id);
        if(is_array($field)) {
            $result = [];
            foreach($field as $fld) {
                $result[$fld] = $entry[$fld]; 
            }
            return $result;
        }
        return $entry[$field];
    }
    static function findUpdated($sort="DESC", $field = 'updated_at', $limit = 1 )
    {
        $table_name = self::repository()->_table_name;

        $sql = "SELECT * FROM {$table_name} ORDER BY {$field} {$sort} LIMIT {$limit};";


        $result = DataBase::ExecuteQuery($sql, 'array');
        if($result) {
            return $result[0];
        }
        return [];


        // // dump($sql);
        // $data = $repository->Query($sql);
        // $result = [];
        // if ($data->hasElems()) {
        //     while ($item = $data->NextElem()) {
        //         $result[] = $item;
        //     }
        //     return $result[0];
        // }
        // return $result;
    }

    static function find($id)
    {
        $table_name = self::repository()->_table_name;

        $sql = "SELECT * FROM `{$table_name}` WHERE `id` = " . $id . ";";
        // dump($sql);
        $result = DataBase::ExecuteQuery($sql, 'array');
        if($result) {
            return $result[0];
        }
        return [];
    }

    static function findOneBy(
        ?array $parms = null, 
        ?array $sort = null, 
        ?array $names = null,
        ?array $fields = null,
        ?bool $debug = false )
    {

        $result = self::findBy(
            $parms, 
            $sort, 
            $names,
            $fields,
            1,
            $debug
        );
        if($result) {
            return $result[0];
        }
        return null;
    }
    static function findAll($sort = null) {
        return self::findBy(null, $sort);
    }

    static function findBy(
        ?array  $parms = null, 
        ?array  $sort = null, 
        ?array  $names = null,
        ?array  $fields = null,
        ?int    $limit = null,
        ?bool   $debug = false
    )
    {
        
        $table_name = self::repository()->_table_name;

        $sql = " FROM {$table_name} ";
        $add_select = '';

        if($names) {
            $join_sql = '';
            foreach ($names as $name_id => $join_name) {
                $name_name = chop($name_id,'_id') . '_name';
                $add_select .= $join_name.'.name as '. $name_name.',';

                $join_sql .= 'LEFT JOIN '.$join_name.' ON '.$join_name.'.id = '.$table_name.'.'.$name_id.' '; 
            }
            $add_select = chop($add_select, ',');

            $sql = ','.$add_select.$sql.$join_sql;
        } 

        if($parms == null or count($parms) == 0) {
            // $sql = "SELECT * FROM {$table_name} *join* ";
            // $sql = " FROM {$table_name} {$join} ";

        } else {

            $where = self::CreateWhere($parms, $table_name);
            $sql .= $where;

        }

        $fld_list = '';
        if($fields) {
            foreach($fields as $field_name) {
                if(strpos($field_name, '.') === false)
                    $fld_list .= $table_name . '.' . $field_name.',';
                else
                    $fld_list .= $field_name.',';
            }
            $fld_list = chop($fld_list,',');
        } else {
            $fld_list = $table_name . '.*';
        }

        $sql = "SELECT {$fld_list}" . $sql; 

        if ($sort) {
            $sql .= " ORDER BY ";
            foreach($sort as $key => $dir) {
                if(strpos($key, '.') === false)
                    $sql .= "{$table_name}.{$key} ".$dir.",";
                else
                    $sql .= "{$key} ".$dir.",";
            }
            $sql = chop($sql,',');
        }
        if ($limit) {
            $sql .= " LIMIT ".$limit;
        }
        if($debug)
            echo $sql;

        $result = DataBase::ExecuteQuery($sql, 'array');
        return $result;
    }

    static private function setBracket(&$where, &$bracket, $state = true) {
        if($state == false ) {
            if($bracket) {
                $where = substr($where, 0, -4);
                $where .= ') AND ';
                $bracket = false;
            };
        } else {
            if(!$bracket) { 
                $where .= '('; 
                $bracket = true;
            }
        }
    }
    static function CreateWhere(?array $parms, string $table_name, $startWhere = true) {
        if(!$parms) return '';

        $where = $startWhere ? ' WHERE ' : '';
        $rtrim = true;
        $bracket = false;
        // $whereOR = '';
        foreach ($parms as $key => $value) {
            if(is_object($value)){
                $value = '='. $value->getId();
                $key = $key . '_id';
                self::setBracket($where, $bracket, false);
            } elseif(is_numeric($key) AND is_array($value)) {

                self::setBracket($where, $bracket, true);
                $bracket = true;
                $where .= self::CreateWhere($value, $table_name, false);
                $where .= ' OR ';
                $rtrim = true;
                continue;

            } elseif(is_array($value)) {
                self::setBracket($where, $bracket, false);
                if(isset($value['OR']) and is_array($value['OR'])) {
                    $vals = $value['OR'];
                    $where .= '(';
                    foreach ($vals as $val) {
                        $val = sql_value_eq($val);
                        if(strpos($key, '.') === false) 
                            $where .= "{$table_name}.{$key}".$val." OR ";
                        else
                            $where .= "{$key}".$val." OR ";
                    }
                    $rtrim = true;
                    $where = substr($where, 0, -4);
                    $where .= ') AND ';
                    continue;

                } else {
                    $value = '='. $value['id'];
                    $key = $key . '_id';
                }
            } else {
                self::setBracket($where, $bracket, false);
                $value = sql_value_eq($value);
            }
            $rtrim = true;
            if(strpos($key, '.') === false) 
                $where .= "{$table_name}.{$key}".$value." AND ";
            else
                $where .= "{$key}".$value." AND ";
        }
        if($bracket) {
            self::setBracket($where, $bracket, false);
        } 
        if ($rtrim) {
            $where = substr($where, 0, -5);
        }

        return $where;
    }
    public static function valLang($table, $fields,$lang,$id = 1){
        $table = strtolower($table);
        $gateway = dlModel::Create($table);
        $record = $gateway->getRecById($id);
        $result = [];
        foreach($fields as $field) {
            $result[$field] = isset($record[$field . '_' .$lang]) ? $record[$field . '_' .$lang] : $record[$field];
        }
        return $result;
    }
    static function findByLang(string $lang, array $parms = null, array $sort = null) {
        $data = self::findBy($parms, $sort);
        $result = [];
        $langLen = strlen($lang)+1;
        foreach ($data as $entry) {
            $record = [];
            foreach($entry as $field => $value) {
                if(strpos($field, '_'.$lang) !== false) {
                    $fieldRoot = substr($field, 0, -$langLen);
                    // dd($fieldRoot, $field, -$langLen);
                } else {
                    $fieldRoot = $field;
                }
                $record[$fieldRoot] = $value;
            }
            $result[] = $record;
        }
        // dd($result);
        return $result;
    }
}

class Field {
    static $postfix;
    static $prefix;
    static $db_model;
    static $db_prefix;

    static function Init($db_model) {
        self::$postfix = '';
        self::$prefix = '';
        self::$db_model = $db_model;
        self::$db_prefix = $db_model->db_prefix;
    }
    static function String($name, $len = 256, $type = 'VARCHAR') {
        return " {$name} {$type}({$len})";
    }
    static function Text($name, $type = 'TEXT') {
        return " {$name} {$type}";
    }
    static function Id($keys = null) {
        if($keys) {
            self::$postfix .= " PRIMARY KEY({$keys}),";
            return ' id INT AUTO_INCREMENT';
        }
        return ' id INT AUTO_INCREMENT PRIMARY KEY';
    }
    static function Reference($db_table) {
        $key = $db_table . '_id';
        // $db_name = self::$db_prefix . $db_table;
        // self::$postfix .= " FOREIGN KEY({$key}) REFERENCES {$db_name}(id),";
        return " {$key} INT";
    }
    static function DateTime($name, $type = 'DATETIME') {
        // $type = DATE,TIME,YEAR
        return " {$name} {$type}";
    }
    static function Decimal($name, $len = 12, $precision = 2) {
        return " {$name} DECIMAL({$len},{$precision})";
    }
    static function Number($name, $len = 12, $precision = 2, $type = "DECIMAL") {
        // $type = REAL,FLOAT,DOUBLE,DECIMAL
        return " {$name} {$type}({$len},{$precision})";
    }
    static function Integer($name, $type = "INT") {
        // $type = INT,TINYINT,SMALLINT,MEDIUMINT,BIGINT
        return " {$name} {$type}";
    }
    static function Int($name, $type = "INT") {
        // $type = INT,TINYINT,SMALLINT,MEDIUMINT,BIGINT
        return " {$name} {$type}";
    }
    static function Boolean($name, $type = "TINYINT") {
        // $type = INT,TINYINT,SMALLINT,MEDIUMINT,BIGINT
        return " {$name} {$type}";
    }
    static function Bool($name, $type = "TINYINT") {
        // $type = INT,TINYINT,SMALLINT,MEDIUMINT,BIGINT
        return " {$name} {$type}";
    }
    static function Special($name, $type) {
        // all other types
        return " {$name} {$type}";
    }
    static function Table($name, $type) {
        // all other types
        return " {$name} {$type}";
    }

    static function Edit($name, $title, $attr) {
        // all other types
        // return Self;
    }
    static function View($name, $title, $attr) {
        // all other types
        // return " {$name} {$type}";
    }
    
}

class Repository {

    static function GetCompany() {
        $boss       = User::GetUser();
        $company    = User::GetCompany($boss);
        return $company;
    }
}

class AdminDB {
    function CreateTables( $tables ) {
        foreach($tables as $db_table) {
            /** @var dmModel */
            $db = new $db_table;
            $db->CreateTable($db_table, true);
        }
    }
}

class QueryBuilder{

    private $where;
    private $andWhere;
    private $orWhere;
    private $params;
    private $order;
    private $alias;
    private $table_name;
    private $limit;
    private $offset;
    private $leftJoin;
    public $sql;

    function SetAlias( $alias )
    {
        $this->alias = $alias;
    }
    function SetTableName( $name )
    {
        $this->table_name = $name;
    }
    function __construct($alias, $table_name)
    {
        $this->alias = $alias;
        $this->table_name = $table_name;

        $this->andWhere = [];
        $this->orWhere = [];
        $this->leftJoin = [];
        $this->params = [];
        $this->order = [];
    }
    function SetParameters ($params) {
        foreach ($params as $param => $value) {
            $this->params[$param] = $value;
        }
        return $this;
    }

    function SetParameter ($param, $value) {
        $this->params[$param] = $value;
        return $this;
    }
    function where ($where) {
        $this->where = $where;
        return $this;
    }
    function andWhere ($statement) {
        $this->andWhere[] = $statement;
        return $this;
    }
    function orWhere ($statement) {
        $this->orWhere[] = $statement;
        return $this;
    }
    function leftJoin ($table, $alias, $on) {
        $this->leftJoin[] = ['table'=>$table, 'alias'=>$alias, 'on' => $on];
        return $this;
    }
    function orderBy ($param, $value) {
        $this->order[$param] = $value;
        return $this;
    }
    function setMaxResults($max) {
        $this->limit = $max;
        return $this;
    }
    function setFirstResult($offset) {
        $this->offset = $offset;
        return $this;
    }
    function GetQuery() {
        $sql = 'SELECT * FROM ' . $this->table_name . ' AS ' . $this->alias . ' ';

        // $joins = '';
        if($this->leftJoin ) {

            foreach ($this->leftJoin as $entity) {
                $sql .= ' LEFT JOIN '. $entity['table'] . " AS ". $entity['alias'] . ' ON '. $entity['on'];
            }
        }

        $where = '';
        if($this->andWhere ) {
            foreach ($this->andWhere as $key => $value) {
                $where .= $value . " AND ";
            }
            $where = substr($where, 0, -5);
        }
        if($this->orWhere ) {
            foreach ($this->orWhere as $key => $value) {
                $where .= $value . " OR ";
            }
            $where = substr($where, 0, -4);
        }
        if($where) {
            $where = " WHERE " . $where;
            $sql .= $where;
        }
        if($this->where) {
            if(!$where) $sql .= " WHERE ";
            $sql .= $this->where;
        }

        if($this->order ) {
            $order = " ORDER BY ";
            foreach($this->order as $key => $dir) {
                $order .= "{$key} ". $dir. ",";
            }
            $order = chop($order,',');
        }
        if($order) {
            $sql .= $order;
        }
        if($this->offset) {
            $offset = $this->offset . ', ';
        } else {
            $offset = '';
        }

        if($this->limit) {
            $sql .= " LIMIT {$offset}{$this->limit}";
        }
        $this->sql = $sql;
        return $this;
    }
    function GetResult() { 
        $dataset = DataBase::ExecuteQuery($this->sql, 'array', $this->params);
        return $dataset;
    }

    function delete( $where = '') {
        if($where) $where = " WHERE " . $this->table_name . "." . $where;
        $this->sql = 'DELETE FROM ' . $this->table_name . $where;
        // dd($this->sql);
        return $this;
    }

}
    