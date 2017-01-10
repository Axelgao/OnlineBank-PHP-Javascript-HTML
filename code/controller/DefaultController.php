<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * Default Controller
 * provide default functions: index, error and logout
 */
class DefaultController
{

    /**
     * index
     */
    public function index()
    {
        require_once ('view/LogIn.php');
    }

    /**
     * error
     */
    public function error()
    {
        require_once ('view/Error.php');
    }

    /**
     * log out
     */
    public function logout()
    {
        if (isset($_SESSION["loginUser"])) {
            // remove session content
            $_SESSION["loginUser"] = NULL;
            // remove cookie content
            setcookie("loginName", NULL, time() - 3600, "/");
            setcookie("secret", NULL, time() - 3600, "/");
            unset($_COOKIE['loginName']);
            unset($_COOKIE['secret']);
        }
        
        // forward to index page
        header("Location: index.php");
        return;
    }
}
?>