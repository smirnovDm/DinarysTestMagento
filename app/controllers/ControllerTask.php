<?php

use core\Controller;
use models\ModelTask;


class ControllerTask extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelTask();
    }

    public function actionGetTasks(){

        $project_id = filter_input(INPUT_POST, 'project_id');
        $tasks = $this->model->getTasks();
        $project = $this->model->getProjectById($project_id);

        $str = "";

        foreach ($tasks as $value){

            if($project_id == $value->project_id){
                $str .= "<li class='task'><span>";

                if($value->user_id == $_COOKIE['user_id']){
                    if($value->done == 0){
                        $str .=	"<input type='checkbox' class='done_flag' name='todo-tasks' data-done='$value->done' id='$value->id' />";
                    } else {
                        $str .=	"<input type='checkbox' class='done_flag' name='todo-tasks' data-done='$value->done' checked id='$value->id'/>";
                    }

                    } else {
                    if($value->done == 0){
                        $str .=	"<input type='checkbox' class='done_flag' name='todo-tasks'  disabled id='$value->id' />";
                    } else {
                        $str .=	"<input type='checkbox' class='done_flag' name='todo-tasks' disabled checked id='$value->id' />";
                    }
                }
                $str .=	"

                        <div>
                            <label for='$value->id'><span>$value->name</span><span class='line-through'></span></label><br>";
                if($value->priority == 0){
                    $str .= "<span style='margin-left: 40px; background-color: blue; border-radius: 5px; padding: 3px; color: #fff'>Low</span>";
                } else if($value->priority == 1){
                    $str .= "<span style='margin-left: 40px; background-color: green; border-radius: 5px; padding: 3px; color: #fff'>Medium</span>";
                } else if($value->priority == 2){
                    $str .= "<span style='margin-left: 40px; background-color: red; border-radius: 5px; padding: 3px; color: #fff'>High</span>";
                }
                $str .= "
                            deadline:
                            <span>$value->deadline</span>
                        </div>

                 </span>";
    

                if($value->user_id == $_COOKIE['user_id']){
                    $str .= "<span style='padding-top: 20px;'>
                            <span class='edit_task' data-task='$value->id'><i class='fas fa-edit'></i></span>
                            <span class='delete_task' data-task='$value->id'><i class='fas fa-trash'></i></span>
                             <span>";
                }
                $str .= "</li>";
            }


        }
    echo $str;

    }

    public function actionSetDone(){
        $data_done = filter_input_array(INPUT_POST);
        $this->model->setDone($data_done['done'], $data_done['id']);
    }

    public function actionDeleteTasks(){

        $project_id = filter_input(INPUT_POST, 'project_id');
        $this->model->deleteTasksById($project_id);
    }
    public function actionAddTask(){
        $task_input = filter_input_array(INPUT_POST);
        $done = 0;
        $deadline = $task_input['deadline_date'].' '. $task_input['deadline_time'];
        $this->model->addTask($task_input['task_name'], $task_input['task_priority'], $done, $deadline, $task_input['project_id'], $_COOKIE['user_id']);
    }
    public function actionDeleteTask(){
        $task_id = filter_input(INPUT_POST, 'task_id');
        $this->model->deleteTaskById($task_id);
    }
    public function actionGetTask(){
        $task_id = filter_input(INPUT_POST, 'task_id');
        $task =  $this->model->getTaskById($task_id);
        $date_arr = explode(' ', $task[0]->deadline);
        $task_to_edit = [];
        $task_to_edit['name'] = $task[0]->name;
        $task_to_edit['priority'] = $task[0]->priority;
        $task_to_edit['time'] = $date_arr[1];
        $task_to_edit['date'] = $date_arr[0];
        $json = json_encode($task_to_edit);
        echo $json;
    }
    public function actionUpdateTask(){
        $task_corrections = filter_input_array(INPUT_POST);
        $deadline = $task_corrections['task_date'].' '.$task_corrections['task_time'];
        $this->model->updateTask($task_corrections['task_priority'], $deadline, $task_corrections['task_name'], $task_corrections['task_id']);
    }
}