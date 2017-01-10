<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/AccountHandler.php';
require_once 'model/Account.php';

/**
 * User Home Controller
 * Provides user home functions
 */
class UserHomeController
{
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->accountHandler = new AccountHandler();
    }

    /**
     * find all account of current user
     */
    public function findAccount()
    {
        // get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        // search accounts from database
        $accountList = $this->accountHandler->findAccount($userId);
        
        require_once ('view/UserHome.php');
    }
}
?>
