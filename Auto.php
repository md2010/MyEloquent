<?php

include 'BaseModel.php';

class Auto extends BaseModel 
{
    public $attributes = ['name', 'model', 'year'];

    public function __construct()
    {
        parent::__construct($this->attributes);
    }

    public function create(array $values = []) 
    {
        //array_combine($this->attributes, $values);
        try {
            $sql = "INSERT INTO auto (name, model, year) VALUES (?,?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute($values);  
            $this->setKeyValue();      
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

}

?>