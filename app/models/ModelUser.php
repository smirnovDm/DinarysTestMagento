<?php

namespace models;
use core\Model;
use PDO;

class ModelUser extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PWD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ERRMODE_EXCEPTION => TRUE,
        ));
    }
    public function saveUser($email, $password, $username){
        $query = "INSERT INTO `users` (`id`, `email`, `password`, `username`) VALUES (NULL, '$email', '$password', '$username');";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }
    public function getUsers(){
        $query = "SELECT * FROM users;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }
    public function getUserById($id){
        $query = "SELECT * FROM `users` WHERE id = $id;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetch();
    }
}
