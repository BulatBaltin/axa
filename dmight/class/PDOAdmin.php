<?php
// https://www.youtube.com/watch?v=BaEm2Qv14oU
class PDOAdmin {

    public $dbo;
    public $stmt;

    // function Connect () {

    function Connect () {

        try {
            $username   = 'root';
            $password   = '';
            $host       = 'localhost';
            $dbname     = 'fantasy';
    
            $this->dbo = new PDO("mysqli:host={$host};dbname={$dbname}", $username, $password);
            return $this;

        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage(); //throw $th;
            die;
        }

    }

    function Prepare ($sql, $params) { 
        $this->stmt = $this->Connect()->dbo->prepare($sql);
        if(!$this->stmt->execute($params)) {
            $this->stmt = null;
            header("location: ../index.php?error='db statement failed'");
            exit();
        }
        return $this->stmt;
    }

    function fetchArray () { 
        if($this->stmt->rowCount() == 0)
        {
            // $this->stmt = null;
            // header("location: ../index.php?error='db statement failed'");
            return [];
        }
        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


}