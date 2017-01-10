<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/TranzHandler.php';
require_once 'model/Tranz.php';
require_once 'model/AccountHandler.php';
require_once 'model/Account.php';
require_once 'model/CustomedException.php';

/**
 * Account Transaction Controller
 * Provides account transactions search functions
 */
class TranzController
{
    // transaction handler object
    private $tranzHandler;
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->tranzHandler = new TranzHandler();
        $this->accountHandler = new AccountHandler();
    }

    /**
     * Search Account Transaction By Conditions
     * @throws InputRequiredException
     * @throws InvalidDataFormatException
     */
    public function findTranz()
    {
        // get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        $fromDate = NULL;
        $toDate = NULL;
        $newDate = NULL;
        
        try {
            // search parameters
            $accountId = $_REQUEST["accountId"];
            if (! isset($accountId) || strlen($accountId) == 0) {
                throw new InputRequiredException("Account id is required.");
            }
            if (! is_numeric($accountId)) {
                throw new InvalidDataFormatException("Account id has a bad format.");
            }
            
            // check and get account
            $account = $this->accountHandler->getAndCheckAccount($accountId, $userId);
            // search from database for error showing
            $tranzList = $this->tranzHandler->findTranz($accountId, $userId, NULL, NULL);
            
            if (isset($_POST["submit"])) {
                $fromDate = $_POST["fromDate"];
                $toDate = $_POST["toDate"];
                
                // check input
                if (! isset($fromDate) || strlen($fromDate) == 0) {
                    throw new InputRequiredException("From date is required.");
                }
                if (! strtotime($fromDate)) {
                    throw new InvalidDataFormatException("From date has a bad format.");
                }
                
                if (! isset($toDate) || strlen($toDate) == 0) {
                    throw new InputRequiredException("To date is required.");
                }
                if (! strtotime($toDate)) {
                    throw new InvalidDataFormatException("To date has a bad format.");
                }
                // toDate plus 1 day
                $newDate = $toDate; // date('Y-m-d', strtotime($toDate . '+1 day'));
                
                // search from database
                $tranzList = $this->tranzHandler->findTranz($accountId, $userId, $fromDate, $newDate);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
        
        require_once ('view/TranzList.php');
    }
}

