<?php

include 'HasAttributes.php';
include 'DBConnection.php';

abstract class BaseModel
{
    use HasAttributes;

    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $keyValue;
    public $exists = false;
    
    public function __construct (array $attributes = [])
    {   
        $db = new DBConnection();
        $this->connection = $db->getConnection();
        $this->setTable();
        $this->fill($attributes);
    }

    abstract public function create(array $values = []);

    public function setTable()
    {
        $this->table = get_class($this);
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getKeyType()
    {
        return $this->keyType;
    }

    public function setKeyType($type)
    {
        $this->keyType = $type;

        return $this;
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function setKeyName($key)
    {
        $this->primaryKey = $key;
        return $this;
    }

    protected function setKeyValue()
    {
        $this->keyValue = $this->connection->lastInsertId();
    }

    public function getKeyValue()
    {   
        return $this->keyValue;
    }

    public function __get($key) 
    {
       if ($this->checkAttribute($key)) {
            try {
                $sql = "SELECT $key FROM $this->table WHERE id = $this->keyValue";
                $q = $this->connection->prepare($sql);
                $q->execute();
                echo $key .": ". $q->fetchColumn();
            } catch (PDO $e)
            {
                echo $e;
            }
       } 
    }

    public function __set($key, $value)
    {
        if ($this->checkAttribute($key)) {
            try {
                $sql = "UPDATE $this->table SET $key = $value WHERE id = $this->keyValue";
                $q = $this->connection->prepare($sql);
                $q->execute();
                echo $key ." is set to " .$value;
                echo "<br>";
            } catch (PDO $e)
            {
                echo $e;
            }
        }
    }

    protected function fill(array $attributes = [])
    {
        foreach($attributes as $key => $value){
            $this->setAttributes($key, $value);
        }
    }

}

?>