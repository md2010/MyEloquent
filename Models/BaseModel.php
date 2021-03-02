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
        $this->setKeyValue();
        array_unshift($values, $this->keyValue);
        $this->attributes = array_combine($this->attributes,$values);
    }

    public function getByID($id)
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result; 
    }

    public function save() 
    {
        $id = 'id';
        $values = array_values($this->attributes);
        if (! $this->getByID($values[0])) {
            try {
                $questionMarks = $this->makePlaceholder($values);
                $statement = $this->connection->prepare("INSERT INTO $this->table VALUES (".$questionMarks. ")");
                $statement->execute($values);     
                echo "row inserted";
                echo "<br>";
            } catch (PDO $e) 
            {
                echo "Error" . $e->getMessage();
            }
        } else { //update -> delete func just deletes from DB, values are still here
            $this->delete($this->attributes[$id]);
            $this->save();
        } 
    }

    public function delete($id)
    {
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deletePermanently($id) //delete from DB and program
    {
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
        $this->attributes = array(); 
    }

    private function makePlaceholder($values)
    {
        $str = null;
        for($i = 0; $i < sizeof($values); $i++){
            $str .= '?';
            if ($i != sizeof($values) - 1)
                $str .= ', ';
        }
        str_replace("'",'',$str);
        return $str;
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
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    protected function fill(array $attributes = [])
    {
        array_unshift($attributes, 'id');
        $this->attributes = $attributes;
    }

}

