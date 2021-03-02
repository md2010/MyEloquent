<?php

include_once 'Traits/HasAttributes.php';
include_once 'Database/DBConnection.php';

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
        $instance = DBConnection::getInstance();
        $this->connection = $instance->getConnection();
        $this->setTable();
        $this->fill($attributes);
    }

    public function create(array $values = []) 
    {   
        try {
            $this->setKeyValue();
            array_unshift($values, $this->keyValue);
            $statement = $this->connection->prepare("INSERT INTO $this->table VALUES (?,?,?,?)");
            $statement->execute($values);     
            echo "row inserted";
            echo "<br>";
        } catch (PDO $e) 
        {
            echo "Error" . $e->getMessage();
        } 
    }

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
        $this->keyValue = $this->connection->lastInsertId() + 1;
    }

    public function getKeyValue()
    {   
        return $this->keyValue;
    }

    public function __get($name) 
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
       /*if ($this->checkAttribute($key)) {
            try {
                $sql = "SELECT $key FROM $this->table WHERE id = $this->keyValue";
                $q = $this->connection->prepare($sql);
                $q->setFetchMode(PDO::FETCH_CLASS, $this->table);
                $q->execute();
            } catch (PDO $e)
            {
                echo $e;
            }
       } */
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        /*if ($this->checkAttribute($key)) {
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
        } */
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    protected function fill(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

}

