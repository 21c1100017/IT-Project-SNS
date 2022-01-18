<?php
# /database.php

class database {

    private $db_name = "it_project_sns";
    private $db_user = "21c1100017";
    private $db_host = "localhost";
    private $db_password = "21c1100017";
    private $db_handler;
    private $db_statement;
    private $sql;
    private $bind_array = [];

    public function connect(){

        try{

            $this->db_handler = new PDO(
                "mysql:host=".$this->db_host.";dbname=".$this->db_name,
                $this->db_user,
                $this->db_password,
                [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
                ]
            );

            date_default_timezone_set("Asia/Tokyo");

        }catch(\PDOException $e){

            echo $e->getMessage();
            exit;

        }
    }

    public function setSQL($sql){
        $this->sql = $sql;
    }

    public function setBindArray($array){
        $this->bind_array = $array;
    }

    public function execute(){

        try{

            if(empty($db_handler)){
                $this->connect();
            }

            $this->db_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_statement = $this->db_handler->prepare($this->sql);

            foreach($bind_array as $key => $value){
                $this->db_statement->bindParam($key, $value);
            }

            $this->db_statement->execute();

        }catch(Exception $e){

            echo $e->getMessage();

        }
    }

    public function fetch(){
        return $this->db_statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll(){
        return $this->db_statement->fetchAll(PDO::FETCH_ASSOC);
    }
}