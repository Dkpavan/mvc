<?php
Ccc::loadFile("Model/Core/Adapter.php");
class Table
{

    private $data = [];
    private $tableName;
    private $primaryKey;
    protected $adapter;

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->adapter = new Adapter();
        }
        return $this->adapter;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData($key = null)
    {
        if ($key == null) {
            return $this->data;
        }
        if (!array_key_exists($key, $this->data)) {
            return null;
        }
        return $this->data[$key];
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function __get($key)
    {
        if (!array_key_exists($key, $this->data)) {
            return null;
        }
        return $this->data[$key];
    }

    public function __unset($key)
    {
        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }
        return $this;
    }
    public function resetData()
    {
        $this->data = [];
        return $this;
    }

    public function setTableName($name)
    {
        $this->tableName = $name;
        return $this;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setPrimaryKey($key)
    {
        $this->primaryKey = $key;
        return $this;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function save()
    { 
        if (!$this->getId()) {
            $value = null;
            foreach ($this->data as $data) {
                $value .= "'" . $this->getAdapter()->quote($data) . "',";
            }
            $value = substr($value, 0, -1);
            $column = "`" .implode("`,`", array_keys($this->data)) . "`";
            $query = "INSERT into `{$this->getTableName()}`({$column}) VALUES({$value})";
            $insertId = $this->getAdapter()->insert($query);
            if (!$insertId) {
                throw new Exception("Sorry There is some Issue to insert data", 1);
            }
            $this->data[$this->getPrimaryKey()] = $insertId;
            
        } else {
            
            $columnValue = [];
            foreach ($this->data as $key => $value) {
                $columnValue[] = "`{$key}` = '{$this->getAdapter()->quote($value)}'";
            }
            $value = "". implode(', ', $columnValue).""; 
            $where =  "`{$this->getPrimaryKey()}`= ".$this->getId()."";
            $query = "UPDATE `{$this->getTableName()}` SET {$value}  WHERE {$where}";
            $result = $this->getAdapter()->update($query);
            if (!$result) {
                throw new Exception("Unable to update data", 1);
            }  
        }
        $this->load($this->getId());
        return $this;

    }

    public function setId($id)
    {
        $this->data[$this->getPrimaryKey()] = $id;
        return $this;
    }
    public function getId()
    {
        if(!array_key_exists($this->getPrimaryKey(),$this->data)){
            return null;
        }
        return $this->data[$this->getPrimaryKey()];
    }
    public function load($primaryKey, $column = null)
    {
        if ($column == null) {
            $column = $this->getPrimaryKey();
        }
        $query = "SELECT * from `{$this->getTableName()}` Where `{$column}` =  {$primaryKey} ";
        return $this->fetchRow($query);
    }

    public function fetchRow($query)
    {
        $row = $this->getAdapter()->fetchRow($query);
        if (!$row) {
            $this->resetData();
            return $this;
        }
        $this->data = $row;
        return $this;
    }

    public function fetchAll($query = null)
    {
        if(!$query){
            $query = "SELECT * from `{$this->getTableName()}`";
        }

        $rows = $this->getAdapter()->fetchAll($query);
        if (!$rows) {
            return null;
        }
        foreach($rows as $key =>$row){
            $object = new $this;
            $object->setData($row);
            $rows[$key] = $object; 
        }
        return $rows;
    }

    public function delete($query = null)
    {
        if ($query == null) {
            $id = $_GET['id'];
            $query = "DELETE  from `{$this->getTableName()}` Where `{$this->getPrimaryKey()}` =  {$id} ";
            return $this->getAdapter()->delete($query);
        }
        return $this->getAdapter()->delete($query);
    }

}
