<?php

use core\Controller;


class ControllerLogOut extends Controller
{
    public function actionGoodBye(){

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
}