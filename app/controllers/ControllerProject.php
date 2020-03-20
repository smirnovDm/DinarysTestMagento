<?php


use core\Controller;
use models\ModelProject;

class ControllerProject extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelProject();
    }

    public function actionSaveProject(){
        $project = filter_input_array(INPUT_POST);
        $this->model->saveProject($project['name'], $project['description'], $project['user_id']);
    }

    public function actionShowProjects(){
        $projects = $this->model->getProjects();
        $str = "";
        foreach ($projects as $value){
            $str .= "<li class='project_item' id='$value->id'><span>$value->name</span>";
            if($_COOKIE['user_id'] == $value->user_id){
                $str .= "<span>
                            <span class='edit_project' data-project='$value->id'><i class='fas fa-edit'></i></span>
                            <span class='delete_project' data-project='$value->id'><i class='fas fa-trash'></i></span>
                        <span>";
            }
            $str .= "</li>";
        }
        echo $str;
    }
    public function actionDeleteProject(){
        $id = filter_input(INPUT_POST, 'project_id');
        $this->model->deleteProjectById($id);
    }

    public function actionGetProject(){
        $id = filter_input(INPUT_POST, 'project_id');
        $project = $this->model->getProjectById($id);
        $project = json_encode($project);
        echo $project;
    }
    public function actionUpdateProject()
    {
        $project_props = filter_input_array(INPUT_POST);
        $this->model->projectUpdate($project_props['name'], $project_props['description'], $project_props['project_id']);

    }


}