<?php


namespace models;
use core\Model;
use PDO;

class ModelProject extends Model
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

    public function saveProject($name, $description, $user_id){
        $query = "INSERT INTO `projects` (`id`, `name`, `description`, `user_id`) VALUES (NULL, '$name', '$description', '$user_id');";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
        return true;
    }
    public function getProjects(){
    $query = "SELECT * FROM projects;";
    $result = $this->db->query($query);
    if(!$result){
        return false;
    }
    return $result->fetchAll();
    }

    public function getProjectByUserId($user_id){
        $query = "SELECT * FROM `projects` WHERE user_id = $user_id order by id DESC limit 1;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }

    public function deleteProjectById($id){
        $query = "DELETE FROM `projects` WHERE `projects`.`id` = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
        return true;
    }

    public function getProjectById($id){
        $query = "SELECT * FROM `projects` WHERE id = $id;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }

    public function projectUpdate($name, $description, $id){
        $query = "UPDATE `projects` SET `name` = '$name', `description` = '$description' WHERE `projects`.`id` = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
        return true;
    }

}
