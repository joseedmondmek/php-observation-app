<?php

class Connection
{
 
    protected $db =null;
 
 
    public function Open()
    {
        try {
        $dsn      = "mysql:dbname=observations_db; host=localhost";
        $user     = "root";
        $password = "mysql";
 
        $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
        );
 
 
 
            $this->db = new PDO($dsn, $user, $password, $options);
 
            return $this->db;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
 
    public function Close()
    {
        $this->db = null;
        return true;
    }
}

?>