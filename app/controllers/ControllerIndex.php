<?php

use core\Controller;
use models\ModelIndex;

class ControllerIndex extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelIndex();
    }
    public function actionIndex(){

        if(!isset($_COOKIE['PHPSESSID']) && empty($_COOKIE['PHPSESSID']) || !isset($_COOKIE['user_id'])){
            header('Location:'.$_SERVER['REQUEST_URI'].'sign_in');
        }

        $user = $this->model->getUserById($_COOKIE['user_id']);
        $projects = $this->model->getProjects();
        $this->view->username = $user->username;
        $this->view->user_id = $user->id;
        $this->view->projects =  $projects;
        $this->view->render('main_index_view');
    }

    public function actionSignIn(){
        $this->view->render('sign_in_form');
    }
    public function actionSignUp(){
        $this->view->render('sign_up_form');
    }

}