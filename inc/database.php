<?php

/**
 * Description of database
 *
 * @author Dataro
 */
class Database {

    /**
     * Connection holder
     * @var PDOConnection Connection Object 
     */
    private $_con;

    private $_rs;
    
    private $_id;
    
    public function __construct() {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        try{
            $con_string = "mysql:host=localhost;dbname=studentportal";
            $this->_con = new PDO($con_string, "root", "", $options);
        } catch (PDOException $e) {
            msgBox("error", $e->getMessage());
            exit();
        }
    }
    
    public function __destruct() {
        try{
            $this->close();
        } catch (PDOException $e) {
            msgBox("error", $e->getMessage());
        }
            
    }
   
    public function query($stmt, $args = NULL)
    {
        try{
            $this->_rs = $this->_con->prepare($stmt);
            if($args===NULL)
            {
                $this->_rs->execute();
            }
            else
            {
                $this->_rs->execute($args);
            }
            $this->_id = $this->_rs->rowCount();
        }  catch (PDOException $e){
            throw $e;
        }
    }
    
    public function runQuery($stmt, $args = NULL)
    {
        try{
            $this->_rs = $this->_con->prepare($stmt);
            if($args == NULL)
            {
                $this->_rs->execute();
            }
            else
            {
                $this->_rs->execute($args);
            }
            $this->_id = $this->_con->lastInsertId();
        } catch (Exception $ex) {

        }
    }
    
    
    
    public function fetchObject()
    {
        return $this->_rs->fetch(PDO::FETCH_OBJ);
    }
    
    public function rowCount()
    {
        return $this->_id;
    }
    
     public function insertId()
    {
        return $this->_id;
    }
     
     
    public function close()
    {
        try{
            $this->_con = NULL;
            $this->_rs = NULL;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    
}
