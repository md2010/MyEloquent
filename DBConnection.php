<?php 

class DBConnection 
{
    public $conn;
    protected $servername = "localhost";
    protected $dbname = "db";
    protected $user = "root";
    protected $password = "1234";

    public function __construct() 
    {   
        try {
            $this->conn =  new PDO("mysql:host=$this->servername;dbname=$this->dbname", 
                        $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDO $e)
        {
            echo $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

}

?>