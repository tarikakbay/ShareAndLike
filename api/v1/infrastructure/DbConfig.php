<?php
require_once("../MainConfig.php");
require_once("../common/Response.php");

class DbConfig { 

    protected $connection;

    public function __construct()
    {
        if(!isset($this->connection))
        {
            $this->connection = new mysqli(MainConfig::$dbHost, MainConfig::$dbUserName, MainConfig::$dbPassword, MainConfig::$dbName);
            if(!$this->connection)
            {
                $response->ErrorMessage(-1,"Cannot connect to database server");  
                Ok($response); 
                exit;
            }
            $this->connection->set_charset("utf8");  
        }

        return $this->connection;
    }

}

?>