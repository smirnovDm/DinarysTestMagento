<?php

namespace models;
use core\Model;
use PDO;

class ModelTask extends Model
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

    public function getTasks(){
        $query = "SELECT * FROM `tasks`;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }
    public function getProjectById($id){
        $query = "SELECT * FROM `projects` WHERE id = $id;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }
    public function setDone($done, $id){
        $query = "UPDATE `tasks` SET `done` = '$done' WHERE `tasks`.`id` = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }
    public function deleteTasksById($id){
        $query = "DELETE FROM `tasks` where project_id = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }
    public function addTask($name, $priority, $done, $deadline, $project_id, $user_id){
        $query = "INSERT INTO `tasks` (`id`, `name`, `priority`, `done`, `deadline`, `project_id`, `user_id`) VALUES (NULL, '$name', '$priority', '$done', '$deadline', '$project_id', '$user_id');";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }
    public function deleteTaskById($id){
        $query = "DELETE FROM `tasks` WHERE `tasks`.`id` = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }
    public function getTaskById($id){
        $query  = "SELECT * FROM `tasks` where id = $id;";
        $result = $this->db->query($query);
        if(!$result){
            return false;
        }
        return $result->fetchAll();
    }
    public function updateTask($priority, $deadline, $name, $id){
        $query = "UPDATE `tasks` SET `priority` = '$priority', `deadline` = '$deadline', `name` = '$name' WHERE `tasks`.`id` = $id;";
        $result = $this->db->prepare($query);
        if(!$result->execute()){
            return $result->errorInfo();
        }
    }

}