<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

require_once 'model/AccountHandler.php';
require_once 'model/Account.php';
require_once 'model/CustomedException.php';

/**
 * Atm Stimulator Class
 * Provide Atm stimulation functions
 */
class ATMController
{
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->accountHandler = new AccountHandler();
    }

    /**
     * atm functions: deposit and withdraw
     */
    public function atm()
    {
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        // find account list of current user for showing
        $accountList = $this->accountHandler->findOpenAccount($userId);
        
        if (isset($_POST["submit"])) {
            try {
                // pay
                $accountId = $_POST["accountId"];
                $amount = $_POST["amount"];
                $type = $_POST["type"];
                $description = $_POST["description"];
                
                // check input data
                if ($type == 'D') {
                    //deposit to database
                    $tranz = $this->accountHandler->deposit($accountId, $userId, $amount, $description);
                } elseif ($type == 'W') {
                    //withdraw to database
                    $tranz = $this->accountHandler->withdraw($accountId, $userId, $amount, $description);
                }
                
                // get account by id
                $account = $this->accountHandler->getAccount($accountId);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/ATM.php');
                return;
            }
            
            require_once ('view/ATMResult.php');
        } else {
            require_once ('view/ATM.php');
        }
    }
}

