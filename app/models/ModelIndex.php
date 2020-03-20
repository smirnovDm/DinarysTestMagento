<?php
namespace models;
use core\Model;
use PDO;

class ModelIndex extends Model
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
    public function getUserById($id){
        $query = "SELECT * FROM `users` WHERE id = $id;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetch();
    }
    public function getProjects(){
        $query = "SELECT * FROM projects;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }
}