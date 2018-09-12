<?php
include_once 'DbConfig.php';
 
class Db extends DbConfig
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getData($query)
    {        
        //echo "Db.php Query:".$query;
        
        $result = $this->connection->query($query);

        if ($result == false) {
            return false;
        } 
        
        $rows = array();
        
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        return $rows;
    }

        
    public function getDataSingleRow($query)
    {     
        $result = $this->connection->query($query);
        
        if ($result == false) {
            return false;
        } 
        
        return $result->fetch_assoc();
    }

    public function getRowCount($query)
    {     
        $result = $this->connection->query($query);
        
        return $result->num_rows;
    }
        
    public function execute($query) 
    {
        $result = $this->connection->query($query);

        if ($result == false) {
            echo 'Error: cannot execute the command Query:' . $query. "<br/>"; //!!!Düzeltilmeli
            return false;
        } else {
            return true;
        }        
    }

    public function executePK($query) 
    {
        try
        { 
            $result = $this->connection->query($query);
            $value = $this->connection->insert_id;

            if ($result == false) { 
                echo 'Error: cannot execute the command Query:' . $query. "<br/>"; //!!!Düzeltilmel; //!!!Düzeltilmeli
            }

            if($value>0)
            {
                return $value ;
            }
            else
            {
                return 0;
            }    
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
    
    public function delete($id, $table) 
    { 
        $query = "DELETE FROM $table WHERE Id = $id";
        
        $result = $this->connection->query($query);
    
        if ($result == false) {
            echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
            return false;
        } else {
            return true;
        }
    }
 
    public function escape_string($value)
    {
        return $this->connection->real_escape_string($value);
    }
}
?>