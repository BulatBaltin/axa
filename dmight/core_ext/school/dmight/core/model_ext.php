<?php

class AdminDB {
function CreateTables( $tables ) {

    foreach($tables as $db_table) {
        /** @var dmModel */
        $db = new $db_table;
        $db->CreateTable($db_table, true);
    }

    }
}
class dmModel extends dlModel {

    public $db_prefix;

    function DbTableName() {
        $className = get_called_class();
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
    static function Append( $content = [] )
    {
        return self::make( 'INSERT', 0, $content );
    }    
    static function Assign($id, $content = [] )
    {
        if($id)
            return self::make( 'UPDATE', $id, $content );
        else
            return self::make( 'INSERT', 0, $content );
    }    
    static function make( $action, $id, $content = [] )
    {
    try {
        $repository = self::repository();
        $action = strtoupper($action);
        $sql = "";
        switch ($action) {
            case 'UPDATE':
                $paires = "";
                foreach($content as $key => $value) {
                    $value = Database::real_escape_string($value);
                    $paires .= $key . ' = '."'$value',";
                }
                $paires = trim($paires, ',');
                $sql = 'UPDATE ' . $repository->_table_name . " SET " . $paires . " WHERE " . $repository->_table_name . "." . $repository->_table_key . " =" . $id;
                // dump($sql);
                break;
            case 'INSERT':

                $values = ' (';
                $fields = ' (';

                foreach($content as $key => $value) {
                    $fields .= $key . ",";
                    $values .= "'". Database::real_escape_string($value)."',";
                }
                $values = trim($values, ',') .') ';
                $fields = trim($fields, ',') .') ';
                $sql = "INSERT INTO " . $repository->_table_name . $fields . "VALUES" . $values.";";
                // dump($sql);
                break;
            case 'DELETE':
                $sql = 'DELETE FROM ' . $repository->_table_name . " WHERE " . $repository->_table_name . "." . $repository->_table_key . " =" . $id;
                // dd($sql);
                break;
            
            default:
                # code...
                break;
        } 
        if($sql) {

            // echo $sql;
            $res = DataBase::ExecuteQuery($sql);

            // dd($repository->_table_name, Database::get_error());
            // $this->setError(Database::get_error());
            if ($res) {
                // $this->OnUpdate($id, $this->getFields(), $params);
                return true;
            } else {
                $repository->setError(Database::get_error());
                return false;
            }
        }
        else return false;
    } catch (Exception $e) {
        dd($e->getMessage());
    }
    }

    static function belongsTo( $id, $table )
    {
        $obj = DataBase::repository( $table )->find( $id );
        return $obj['name'] ?? "";
    }
    static function table_name( $name ) { 
        // return strtolower($name) . 's';
        return strtolower($name);
    }
    static function repository() {

        $className = get_called_class();
        $db_table_name = self::table_name($className);
        $repository = self::Create($className); //DataBase::Repository($db_table_name);
        $repository->_table_name = $repository->db_prefix . $db_table_name; //DataBase::Repository($db_table_name)

        return $repository;
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
    static function find($id)
    {
        $repository = self::repository();
        $table_name = $repository->_table_name;

        $sql = "SELECT * FROM `{$table_name}` WHERE `id` = " . $id . ";";
        // dump($sql);
        $data = $repository->Query($sql);

        $result = [];
        if ($data->hasElems()) {
            while ($item = $data->NextElem()) {
                $result[] = $item;
            }
            return $result[0];
        }
        return $result;
    }
    static function findUpdated($sort="DESC", $field = 'updated_at', $limit = 1 )
    {
        $repository = self::repository();
        $table_name = $repository->_table_name;

        $sql = "SELECT * FROM {$table_name} ORDER BY {$field} {$sort} LIMIT {$limit};";

        // dump($sql);
        $data = $repository->Query($sql);

        $result = [];
        if ($data->hasElems()) {
            while ($item = $data->NextElem()) {
                $result[] = $item;
            }
            return $result[0];
        }
        return $result;
    }

    static function findAll($sort = null) {
        $repository = self::repository();
        return $repository->findBy(null, $sort);
    }

    static function findBy(?array $parms = null, ?array $sort = null)
    {
        
        $repository = self::repository();
        $table_name = $repository->_table_name;

        if($parms == null or count($parms) == 0) {
            $sql = "SELECT * FROM `{$table_name}`";

        } else {

            $sql = "SELECT * FROM `{$table_name}` WHERE ";
            foreach ($parms as $key => $value) {
                $sql .= "`{$key}` = '" . $value . "' AND ";
            }
            $sql = substr($sql, 0, -5);
        }

        if ($sort) {
            $sql .= " ORDER BY ";
            foreach($sort as $key => $dir) {
                $sql .= "`".$key."` ".$dir.",";
            }
            $sql = chop($sql,',');

        }
        // dump( $sql );
        $data = $repository->Query($sql);

        $result = [];
        if ($data->hasElems()) {
            while ($item = $data->NextElem()) {
                $result[] = $item;
            }
        }
        return $result;
    }

    static function findOneBy(array $parms)
    {
        $repository = self::repository();
        $table_name = $repository->_table_name;
        
        $sql = "SELECT * FROM `{$table_name}` WHERE ";
        foreach ($parms as $key => $value) {
            $sql .= "`{$key}` = '" . $value . "' AND ";
        }
        $sql = substr($sql, 0, -5);
        // echo $sql;

        $data = $repository->Query($sql);

        $result = [];
        if ($data->hasElems()) {
            while ($item = $data->NextElem()) {
                $result[] = $item;
            }
            return $result[0];
        }
        return null;
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
    function updateAssoc($id, $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        return $this->UpdateExt($id, $fields, $values);
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