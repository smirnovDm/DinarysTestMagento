<div class="wrapper">
    <div class="container-projects">
        <div class="header_projects"><h2 class="panel-title">Projects<span class="add_project"> <i class="far fa-plus-square"></i></h2></span></div>
        <div class="main_list_projects">
<!--            --><?php //if(!empty($this->projects)): ?>
            <ul class="projects_list">
                            <p></p>
                <?php foreach ($this->projects as $value): ?>
                <li class="project_item" id='<?=$value->id?>'>
                    <span><?= $value->name ?></span>
                    <?php if ($this->user_id == $value->user_id): ?>
                    <span>
								<span class="edit_project" data-project="<?=$value->id?>"><i class='fas fa-edit'></i></span>
								<span class="delete_project" data-project="<?=$value->id?>"><i class='fas fa-trash'></i></span>
                    </span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
<!--            --><?php //else: ?>

<!--            --><?php //endif; ?>
        </div>
        <div class="footer_projects">
            <span>
                <button class="create_project-btn">Create project</button>
            </span>
            <span>
                <button class="open_project-btn">Open</button>
            </span>

        </div>
    </div>
    <div id="todo" class="panel">
        <h2 class="panel-title">Tasks <span class="top_task_add"><i class="far fa-plus-square"></i></h2></span>

        <div class="panel-content">
            <ul class="tasks">

            </ul>
        </div>
        <div class="panel-footer">
            <span>
                <button class="create_task-btn">Add task</button>
            </span>
        </div>
    </div>
    <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <header class="w3-container w3-teal">
            <span onclick="document.getElementById('id01').style.display='none'"
                  class="w3-button w3-display-topright">&times;</span>
                    <h2>Creating project</h2>
                </header>

                    <label>Project name</label>
                    <input class="w3-input" type="text" name="project_name" maxlength="60" autocomplete="off">

                    <label>Project description</label>
                    <textarea class="w3-input" rows="10" name="description"></textarea>

                <footer class="w3-container w3-teal" style="height: 50px;">
                    <span class="save_project">
                        <button class="w3-btn w3-padding-large w3-black" style="margin-top: 2px;">Save</button>
                    </span>
                </footer>
            </div>
        </div>
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-teal">
            <span onclick="document.getElementById('id02').style.display='none'"
                  class="w3-button w3-display-topright" name="close_win">&times;</span>
                <h2>Updating project</h2>
            </header>

            <label>Project name</label>
            <input class="w3-input" type="text" name="project_name_update" maxlength="60" autocomplete="off">

            <label>Project description</label>
            <textarea class="w3-input" rows="10" name="description_update"></textarea>


            <footer class="w3-container w3-teal" style="height: 50px;">
                    <span class="edit_project_btn">
                        <button class="w3-btn w3-padding-large w3-black" style="margin-top: 2px;">Save</button>
                    </span>
            </footer>
        </div>
    </div>
    <div id="id03" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-teal">
        <span onclick="document.getElementById('id03').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
                <h2>Add task</h2>
            </header>
            <div class="w3-container">


                    <label>Task title</label>
                    <input class="w3-input" type="text" name="task_name" maxlength="70" autocomplete="off">

                    <label>Task priority</label>
                <select class="w3-select" name="task_priority">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="0">Low</option>
                    <option value="1">Medium</option>
                    <option value="2">High</option>
                </select>

                <h2>Deadline</h2>

                <label>Choose time</label>
                <input class="w3-input" type="time" name="deadline_time" style="width: 20%;">

                <label>Choose date</label>
                <input class="w3-input" type="date" name="deadline_date" style="width: 20%;">


            </div>
            <footer class="w3-container w3-teal" style="height: 50px">
                <span class="add_task-btn">
                        <button class="w3-btn w3-padding-large w3-black" style="margin-top: 2px;">Save</button>
                </span>
            </footer>
        </div>
    </div>
    <div id="id04" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-teal">
        <span onclick="document.getElementById('id04').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
                <h2>Edit task</h2>
            </header>
            <div class="w3-container">


                <label>Task title</label>
                <input class="w3-input" type="text" name="task_name_edit" maxlength="70" autocomplete="off">

                <label>Task priority</label>
                <select class="w3-select" name="task_priority_edit">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="0">Low</option>
                    <option value="1">Medium</option>
                    <option value="2">High</option>
                </select>

                <h2>Deadline</h2>

                <label>Choose time</label>
                <input class="w3-input" type="time" name="deadline_time_edit" style="width: 20%;">

                <label>Choose date</label>
                <input class="w3-input" type="date" name="deadline_date_edit" style="width: 20%;">

            </div>
            <footer class="w3-container w3-teal" style="height: 50px">
                <span class="edit_task-btn">
                        <button class="w3-btn w3-padding-large w3-black" style="margin-top: 2px;">Save</button>
                </span>
            </footer>
        </div>
    </div>
    </div>
<h3 class="log_out" style="padding-left: 800px">Log out(<?php echo $this->username ?>)</h3>
