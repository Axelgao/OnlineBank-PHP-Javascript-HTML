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
 * Transfer Controller
 * Provides transfer function
 */
class TransferController
{
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->accountHandler = new AccountHandler();
    }

    /**
     * Transfer
     * 
     * @throws InputRequiredException
     * @throws InvalidDataFormatException
     * @throws Exception
     * @throws DataTooLongException
     */
    public function transfer()
    {
        // get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        // find all accounts of current user for showing
        $accountList = $this->accountHandler->findOpenAccount($userId);
        
        if (isset($_POST["submit"])) {
            try {
                // transfer parameters
                $accountIdFrom = $_POST["accountIdFrom"];
                $accountIdTo = $_POST["accountIdTo"];
                $amount = $_POST["amount"];
                $description = $_POST["description"];
                
                // check input
                if (! isset($accountIdFrom) || strlen($accountIdFrom) == 0) {
                    throw new InputRequiredException("From account id is required.");
                }
                if (! is_numeric($accountIdFrom)) {
                    throw new InvalidDataFormatException("From account id has a bad format.");
                }
                
                if (! isset($accountIdTo) || strlen($accountIdTo) == 0) {
                    throw new InputRequiredException("To account id is required.");
                }
                if (! is_numeric($accountIdTo)) {
                    throw new InvalidDataFormatException("To account id has a bad format.");
                }
                
                if ($accountIdFrom == $accountIdTo) {
                    throw new Exception("Please select different accounts.");
                }
                
                if (! isset($amount) || strlen($amount) == 0) {
                    throw new InputRequiredException("Amount is required.");
                }
                if (! is_numeric($amount)) {
                    throw new InvalidDataFormatException("Amount has a bad format.");
                }
                
                if (strlen($description) > 200) {
                    throw new DataTooLongException("Description should be less than 200.");
                }
                
                // transfer amount and record into database
                $tranz = $this->accountHandler->transfer($accountIdFrom, $accountIdTo, 
                    $userId, $amount, $description);
                
                // get accounts by id
                $accountFrom = $this->accountHandler->getAccount($accountIdFrom);
                $accountTo = $this->accountHandler->getAccount($accountIdTo);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/Transfer.php');
                return;
            }
            
            require_once ('view/TransferResult.php');
        } else {
            require_once ('view/Transfer.php');
        }
    }
}

