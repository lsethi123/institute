<?php
class dbSchema
{
    public $result, $last_id;
    private $stmt, $dbh;
    
    function __construct()
    {
        
    }
    
    private function connectToDB()
    {
        try
        {
            //CHECK EXISTING CONNECTION IS THERE
            if(isset($this->dbh) && !empty($this->dbh))
            {
                //CONNECTION EXISTS USE THAT
            }
            else
            {
                //CONNECTION NOT EXISTS CREATE NEW
                $this->dbh = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                //echo 'New connection ==> ()';
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function queryPrepared($sql, $vars, $close_con = true, $get_last_id = false, $table = '')
    {
        try
        {
            $this->connectToDB();
            
            $this->dbh->beginTransaction();
            $this->stmt = $this->dbh->prepare($sql) or die("QUERY FAILED !!! " . $sql);
            $this->stmt->execute($vars);
            
            if($get_last_id)
            {
                $this->last_id = $this->dbh->lastInsertId($table);
            }
            
            $this->result = $this->stmt->rowCount();
            $this->dbh->commit();
            
            if($close_con)
            {
                $this->dbh = null;
            }
            
            return (($this->result) > 0);
        }
        catch (PDOException $e)
        {
            $this->dbh->rollBack();
            if($close_con)
            {
                $this->dbh = null;
            }
            echo $e->getMessage();
        }
    }
    
    /**
     *GET DATA 
     * @param  String  $sql SQL Statement
     * @param  ASSOC_ARRAY  $vars Array of array (':col', $value, PDO::PARAM_INT)
     * @param  BOOLEAN $close_con whether to close connection
     */
    public function queryBind($sql, $vars, $close_con = true, $get_last_id = false, $table = '')
    {
        try
        {
            $this->connectToDB();
            
            $this->dbh->beginTransaction();
            $this->stmt = $this->dbh->prepare($sql) or die("QUERY FAILED !!! " . $sql);
            foreach($vars as $key => $value)
            {
                $this->stmt->bindParam($value[0], $value[1], $value[2]);
            }            
            $this->stmt->execute();
            
            if($get_last_id)
            {
                $this->last_id = $this->dbh->lastInsertId($table);
            }
            
            $this->result = $this->stmt->rowCount();
            $this->dbh->commit();
            
            if($close_con)
            {
                $this->dbh = null;
            }
            
            return (($this->result) > 0);
        }
        catch (PDOException $e)
        {
            $this->dbh->rollBack();
            if($close_con)
            {
                $this->dbh = null;
            }
            echo $e->getMessage();
        }
    }
    
    public function fetchQuery($sql, $close_con = true)
    {
        try
        {
            $this->connectToDB();
            
            $this->stmt = $this->dbh->prepare($sql) or die("QUERY FAILED !!! " . $sql);
            $this->stmt->execute();
            $this->result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            if($close_con)
            {
                $this->dbh = null;
            }
            return $this->result;
        }
        catch (PDOException $e)
        {
            if($close_con)
            {
                $this->dbh = null;
            }
            echo $e->getMessage();
        }
    }
    
    public function fetchQueryPrepared($sql, $vars, $close_con = true)
    {
        try
        {
            $this->connectToDB();
            
            $this->stmt = $this->dbh->prepare($sql) or die("QUERY FAILED !!! " . $sql);
            $this->stmt->execute($vars);
            $this->result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            if($close_con)
            {
                $this->dbh = null;
            }
            return $this->result;
        }
        catch (PDOException $e)
        {
            if($close_con)
            {
                $this->dbh = null;
            }
            echo $e->getMessage();
        }
    }
    
    public function fetchQueryBind($sql, $vars, $close_con = true)
    {
        try
        {
            $this->connectToDB();
            
            $this->stmt = $this->dbh->prepare($sql) or die("QUERY FAILED !!! " . $sql);            
            foreach($vars as $key => $value)
            {
                $this->stmt->bindParam($value[0], $value[1], $value[2]);
            }
            $this->stmt->execute();
            $this->result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            if($close_con)
            {
                $this->dbh = null;
            }
            return $this->result;
        }
        catch (PDOException $e)
        {
            if($close_con)
            {
                $this->dbh = null;
            }
            echo $e->getMessage();
        }
    }
    
    public function closeCon()
    {
        if(isset($this->dbh))
        {
            $this->dbh = null;
        }
    }
}
$db = new dbSchema();
?>