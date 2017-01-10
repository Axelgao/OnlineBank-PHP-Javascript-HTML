<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/UserHandler.php';
require_once 'model/User.php';
require_once 'model/LoginUser.php';
require_once 'model/CustomedException.php';

/**
 * Log In Controller
 * Provides log in function
 */
class LogInController
{
    // user handler object
    private $userHandler;

    function __construct()
    {
        $this->userHandler = new UserHandler();
    }

    /**
     * log in
     * @throws InputRequiredException
     */
    public function login()
    {
        try {
            // check input
            if (! isset($_POST["ID"])) {
                throw new InputRequiredException("Login name is required.");
            }
            if (! isset($_POST["password"])) {
                throw new InputRequiredException("Password is required.");
            }
            if (isset($_POST["rememberMe"])) {
                $rememberMe = $_POST["rememberMe"];
            }
            
            $loginName = $_POST["ID"];
            $userPassword = $_POST["password"];
            
            // check user login name and password
            $login = $this->userHandler->login($loginName, $userPassword);
            
            if ($login) {
                // login succeed, get loginUser object
                $_SESSION["loginUser"] = $login;
                
                // set cookie
                if (isset($rememberMe)) {
                    setcookie("loginName", $login->getLoginName(), time() + (86400 * 7), "/"); // 86400 = 1 day
                    setcookie("secret", $login->getSecret(), time() + (86400 * 7), "/"); // 86400 = 1 day
                }
                
                // forward to user home page
                header('Location: ' . "index.php?action=UserHome&method=findAccount");
                return;
            } else {
                $errorMessage = "Wrong login name or password.";
                require_once ('view/LogIn.php');
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            require_once ('view/LogIn.php');
            return;
        }
    }
}
?>
