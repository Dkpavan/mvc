<?php

class Adapter
{

    private $serverName;
    private $userName;
    private $password;
    private $databaseName;
    private $error;
    private $statement;
    public $connect;

    public function __construct()
    {
        $this->serverName = "localhost";
        $this->userName = "root";
        $this->password = "";
        $this->databaseName = "project";
    }

    public function setConnect($connect)
    {
        $this->connect = $connect;
        return $this;
    }

    public function getConnect()
    {
        return $this->connect;
    }

    public function connect()
    {
        $connect = new mysqli("$this->serverName","$this->userName","$this->password","$this->databaseName");
        if($connect->connect_errno){
            throw new Exception($connect->connect_error, 1);   
        }

        $this->setConnect($connect);
        return $this;
    }

    public function prepareSql($query)
    {
        if(!$this->getConnect()){
            $this->connect();
        }
        $result = $this->getConnect()->query($query);
        return $result;
    }
    
    public function insert($query)
    {
        $result = $this->prepareSql($query);
        if ( !$result) {
            return false;
        } 
        $lasId = $this->getConnect()->insert_id;
        return $lasId;
    }

    public function update($query)
    {
        $result = $this->prepareSql($query);
        
        if (!$result) {
            return false;
        } 
        return true;       
    }

    public function delete($query)
    {
        $result = $this->prepareSql($query);
        
        if ( !$result) {
            return false;
        } 
        return true;    
    }

    public function fetchRow($query)
    {
        $result = $this->prepareSql($query);
        
        if ( !$result) {
            return false;
        } 
        return $result->fetch_assoc();   
    }

    public function fetchAll($query)
    {
        $result = $this->prepareSql($query);
        
        if ( !$result) {
            return false;
        }   
        return $result->fetch_all(MYSQLI_ASSOC); 
    }
    
    public function quote($string)
    {
        if(!$this->getConnect()){
            $this->connect();
        }
        $string = mysqli_real_escape_string($this->getConnect(),$string);
        return $string;
    }
}

$p = new Adapter();
