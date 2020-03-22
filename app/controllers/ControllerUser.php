<?php

use core\Controller;
use models\ModelUser;

class ControllerUser extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelUser();
    }
    public function actionSaveUser()
    {
        $input = filter_input_array(INPUT_POST);
        $password = password_hash($input['pass'], PASSWORD_DEFAULT);
        $users = $this->model->getUsers();

        foreach ($users as $value) {
            if ($input['email'] == $value->email) {
                $msg = 'Email already exists! Please try again!';
            } else if ($input['username'] == $value->username) {
                $msg = 'Username already exists! Please try again!';
            } else {

            }
        }
        $this->model->saveUser($input['email'], $password, $input['username']);
    echo $msg;
    }

    public function actionAuthentication(){
        $input = filter_input_array(INPUT_POST);
        $users = $this->model->getUsers();
        $flag = false;
        foreach ($users as $value){
            if($input['email'] == $value->email && password_verify($input['pass'], $value->password)){
                setcookie('user_id', $value->id);
                $flag = true;
                break;
            }
        }
        $msg = 'Wrong email or password! Please try again!';
        if(!$flag){
            echo $msg;
        }
    }

}