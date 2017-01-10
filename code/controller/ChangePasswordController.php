<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

require_once 'model/UserHandler.php';
require_once 'model/User.php';
require_once 'model/CustomedException.php';

/**
 * Change Password Controller
 * Provide change password function for current user
 */
class ChangePasswordController
{
    // user handler object
    private $userHandler;

    function __construct()
    {
        $this->userHandler = new UserHandler();
    }

    /**
     * Change password
     * 
     * @throws InputRequiredException
     * @throws Exception
     */
    public function changePassword()
    {
        // current user id
        $loginUser = $_SESSION["loginUser"];
        $loginName = $loginUser->getLoginName();
        
        if (isset($_POST["submit"])) {
            try {
                $password = $_POST["password"];
                $newPassword = $_POST["newPassword"];
                $repeatNewPassword = $_POST["repeatNewPassword"];
                
                // check input
                if (! isset($password) || strlen($password) == 0) {
                    throw new InputRequiredException("Old password is required.");
                }
                
                if (! isset($newPassword) || strlen($newPassword) == 0) {
                    throw new InputRequiredException("New password is required.");
                }
                
                if ($newPassword != $repeatNewPassword) {
                    throw new Exception("New password and repeat new password should be identical.");
                }
                
                if ($password == $newPassword) {
                    throw new Exception("Old password and new password should be different.");
                }
                
                // write to database
                $ret = $this->userHandler->changePassword($loginName, $password, $newPassword);
                if ($ret) {
                    require_once ('view/ChangePassResult.php');
                } else {
                    require_once ('view/ChangePass.php');
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/ChangePass.php');
                return;
            }
        } else {
            require_once ('view/ChangePass.php');
        }
    }
}
?>
