(function ($) {

    "use strict";
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    function deleteAllCookies() {
        var cookies = document.cookie.split(";");

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
    /*==================================================================
    [ Validate ] SIGN_IN */
    var input = $('.validate-input .input100');


    $(".login1000-form-btn").click(function () {
        var flag = true;

        var email = $("input[name='email_sign_in']").val();
        var pass = $("input[name='pass_sign_in']").val();

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                flag=false;
            }
        }
         if(flag){
             $.ajax({
                 type: "POST",
                 url: '/authentication',
                 data: {email: email, pass: pass},
                 success: function (data) {
                     console.log(data);
                     if(data == 'Wrong email or password! Please try again!'){
                         $(".wrong_authentication").css('display', 'block').html(data);
                     } else {
                         window.location.replace("/");
                     }
                 }
             });
         }
    });


    $('.input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
            $(".wrong_authentication").css('display', 'none');
        });
    });
    /*===============================================================*/

    /*================================================================
    [VALIDATE] SIGN_UP*/
    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }

        }

    }
    function showValidate(input) {
        var thisAlert = $(input).parent();
        console.log(thisAlert);
        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }


    $(".input100").each(function(){
        $(this).focus(function(){
            hideValidate(this);
            $(".password-match-warning").css('display', 'none');
            $(".username_warning").css('display', 'none');
            $(".email_warning").css('display', 'none');
        });
    });

    $(".login100-form-btn").click(function () {
        var flag = true;

        var email = $("input[name='email']").val();
        var username = $("input[name='username']").val();
        var pass = $("input[name='pass']").val();


        for(var i=0; i<input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                flag = false;
            }
        }
        if($("input[name='pass']").val() !== $("input[name='pass_confirm']").val()){
            $(".password-match-warning").css('display', 'block');
            flag = false;
        }
        if(flag){

            $.ajax({
               type: "POST",
               url: '/create_user',
               data: {email: email, username: username, pass: pass},
                success: function (data) {
                   if(data == 'Username already exists! Please try again!'){
                        $(".username_warning").css('display', 'block').html(data);

                   } else if(data == 'Email already exists! Please try again!'){
                        $(".email_warning").css('display', 'block').html(data);
                   }
                   else {
                       window.location.replace("/");
                   }
                }
            });
        }

    });
    /*=======================================================================================*/

    /*INDEX_MAIN_VIEW*/
    $(".log_out").click(function () {
        deleteAllCookies();
        window.location.replace("/logout");
    });

    /*PROJECT FUNCTIONAL*/
    $(".add_project").click(function () {
        $("#id01").css('display', 'block');
        $("input[name='project_name']").val('');
        $("textarea[name='description']").val('');
    });


    $(".create_project-btn").click(function () {
            $("#id01").css('display', 'block');
            $("input[name='project_name']").val('');
            $("textarea[name='description']").val('');

    });

    var project_id ;
   $(document).on('click', '.project_item', function () {
       project_id = $(this).attr('id');
       $(".open_project-btn").css('display', 'block');
       $(".create_task-btn").css('display', 'none');
       $(".top_task_add").css('display', 'none');
       $(".tasks").text("Please click 'OPEN' button when choose project!");
       $(".project_item").each(function () {
           if($(this).hasClass('open')){
               $(this).removeClass('open')
           }
       });
           $(this).addClass('open');

   });


    $(".save_project").click(function () {
       var user_id = getCookie('user_id');
       var name = $("input[name='project_name']").val();
       var description = $("textarea[name='description']").val();

       if(!name || !description){
            alert('Please, fill the creating form!');
       } else {
           $.ajax({
               type: "POST",
               url: '/save_project',
               data: {name: name, description: description, user_id: user_id},
               success: function (data) {
                   $("#id01").css('display', 'none');
                   $.ajax({
                       type: "GET",
                       url: '/show_all_projects',
                       success: function (data) {
                           $(".projects_list").html(data);
                       }
                   });
               }
           });
       }
    });


    $(document).on('click', '.delete_project', function () {

        var id = $(this).attr("data-project");
        $.ajax({
            type: "POST",
            url: "/delete_tasks",
            data: {project_id: id},
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "/delete_project",
                    data: {project_id: id},
                    success: function (data) {
                        $.ajax({
                            type: "GET",
                            url: '/show_all_projects',
                            success: function (data) {
                                console.log(data);
                                $(".open_project-btn").css('display', 'none');
                                $(".projects_list").html(data);
                            }
                        });
                    }
                });
            }
        });
    });

    $("span[name='close_win']").click(function () {
        $(".open_project-btn").css('display', 'none');
    });

    var pr_id;

    $(document).on('click', '.edit_project', function() {

    pr_id = $(this).attr("data-project");
    $("#id02").css('display', 'block');
    $(".create_project-btn").text('Create projet').removeClass('open_project-btn').addClass('create_project-btn');
    $.ajax({
        type: "POST",
        url: '/get_project',
        data: {project_id: pr_id},
        success: function (data) {
            var project = JSON.parse(data, true);
            for(let i=0; i<project.length; i++){
                pr_id = project[i].id;
                var name = project[i].name;
                var description = project[i].description;
                $("input[name='project_name_update']").val(name);
                $("textarea[name='description_update']").val(description);
             }
          }
        });
    });

  $(document).on('click', '.edit_project_btn', function () {
      let prname = $("input[name='project_name_update']").val();
      let prdescription = $("textarea[name='description_update']").val();
      if(!prname || !prdescription) {
          alert('Please, fill the updating form!');
      } else {
          $.ajax({
              type: "POST",
              url: "/update_project",
              data: {name: prname, description: prdescription, project_id: pr_id},
              success: function () {
                  $(".open_project-btn").css('display', 'none');
                  $("#id02").css('display', 'none');
                  $.ajax({
                      type: "GET",
                      url: '/show_all_projects',
                      success: function (data) {
                          $(".projects_list").html(data);
                      }
                  })
              }
          })
      }
  });

   $(".open_project-btn").click(function () {
       $(".top_task_add").css('display', 'inline-block');
       $(".create_task-btn").css('display','block');
       $.ajax({
           type: "POST",
           url: "/get_tasks",
           data: {project_id: project_id},
           success: function (data) {
               if(!data){
                   $(".tasks").text('There are no tasks in that project. Please add one!');
               } else {
                   $(".tasks").html(data);
               }
           }
       })
   });

    /*END OF PROJECT FUNCTIONAL*/

    /*TASKS FUNCTIONAL*/

    $(document).on('click', '.create_task-btn', function () {
        $("#id03").css('display', 'block');
    });

    $(document).on('change', '.done_flag', function () {
        var id = $(this).attr('id');
        var done = $(this).attr('data-done');
        if(done == 1){
            done = 0;
            $.ajax({
                type: "POST",
                url: "/set_done",
                data: {id: id, done: done},
                success: function (data) {
                    $.ajax({
                        type: "POST",
                        url: "/get_tasks",
                        data: {project_id: project_id},
                        success: function (data) {
                            console.log(data);
                            $(".tasks").html(data);
                        }
                    });
                }
            });
        } else {
            done = 1;
            $.ajax({
                type: "POST",
                url: "/set_done",
                data: {id: id, done: done},
                success: function (data) {
                    $.ajax({
                        type: "POST",
                        url: "/get_tasks",
                        data: {project_id: project_id},
                        success: function (data) {
                            console.log(data);
                            $(".tasks").html(data);
                        }
                    });
                }
            });
        }

    });

    $(document).on('click', '.add_task-btn', function () {

       let task_name = $("input[name='task_name']").val();
       let task_priority = $("select[name='task_priority']").val();
       let deadline_time = $("input[name='deadline_time']").val();
       let deadline_date = $("input[name='deadline_date']").val();

       if(!task_name || task_priority == null || !deadline_time || !deadline_date){
           alert('Please, fill empty fields to add your task!');
       } else {
           $.ajax({
               type: "POST",
               url: "/add_task",
               data: {task_name: task_name, task_priority: task_priority, deadline_time: deadline_time, deadline_date: deadline_date, project_id: project_id},
               success: function (data) {
                   $("#id03").css('display', 'none');
                   $("input[name='task_name']").val('');
                   $("select[name='task_priority']").val(null);
                   $("input[name='deadline_time']").val('');
                   $("input[name='deadline_date']").val('');
                   $.ajax({
                       type: "POST",
                       url: "/get_tasks",
                       data: {project_id: project_id},
                       success: function (data) {
                           console.log(data);
                           $(".tasks").html(data);
                       }
                   });
               }
           })
       }
    });

    $(document).on('click', '.delete_task', function () {
        let id = $(this).attr('data-task');
        $.ajax({
            type: "POST",
            url: "/delete_task",
            data: {task_id: id},
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "/get_tasks",
                    data: {project_id: project_id},
                    success: function (data) {
                        console.log(data);
                        $(".tasks").html(data);
                    }
                });
            }
        })
    });

    var task_id;
    $(document).on('click', '.edit_task', function () {
       task_id = $(this).attr('data-task');
       $("#id04").css('display', 'block');
       $.ajax({
           type: "POST",
           url: "/get_task",
           data: {task_id: task_id},
           success: function (data) {
               console.log(data);
           let task = JSON.parse(data, true);
           let task_name = task.name;
           let task_priority = task.priority;
           let task_time = task.time;
           let task_date = task.date;
           $("input[name='task_name_edit']").val(task_name);
           $("select[name='task_priority_edit']").val(task_priority);
           $("input[name='deadline_time_edit']").val(task_time);
           $("input[name='deadline_date_edit']").val(task_date);
           }
       })
    });

    $(document).on('click', '.edit_task-btn', function () {
        let ch_tname = $("input[name='task_name_edit']").val();
        let ch_tpriority = $("select[name='task_priority_edit']").val();
        let ch_ttime = $("input[name='deadline_time_edit']").val();
        let ch_tdate = $("input[name='deadline_date_edit']").val();
        if(!ch_tname || ch_tpriority == null || !ch_ttime || !ch_tdate) {
            alert('Please, fill empty fields to add your task!');
        } else {
            $.ajax({
                type: "POST",
                url: "/update_task",
                data: {task_name: ch_tname, task_priority: ch_tpriority, task_time: ch_ttime, task_date: ch_tdate, task_id: task_id},
                success: function (data) {
                    $("#id04").css('display', 'none');
                    $.ajax({
                        type: "POST",
                        url: "/get_tasks",
                        data: {project_id: project_id},
                        success: function (data) {
                            $(".tasks").html(data);
                        }
                    });
                }
            });
        }
    });

    $(".top_task_add").click(function () {
        $("#id03").css('display', 'block');
    });

})(jQuery);
