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
 * Payment Controller
 * Provides payment functions
 */
class PaymentController
{
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->accountHandler = new AccountHandler();
    }

    /**
     * Payment
     * @throws InputRequiredException
     * @throws InvalidDataFormatException
     * @throws DataTooLongException
     */
    public function pay()
    {
        // get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        // find all accounts of current user for showing
        $accountList = $this->accountHandler->findOpenAccount($userId);
        
        if (isset($_POST["submit"])) {
            try {
                // pay parameters
                $accountId = $_POST["accountId"];
                $amount = $_POST["amount"];
                $outerAccount = $_POST["outerAccount"];
                $description = $_POST["description"];
                
                // check input data
                if (! isset($accountId) || strlen($accountId) == 0) {
                    throw new InputRequiredException("Account id is required.");
                }
                if (! is_numeric($accountId)) {
                    throw new InvalidDataFormatException("Account id has a bad format.");
                }
                
                if (! isset($amount) || strlen($amount) == 0) {
                    throw new InputRequiredException("Amount is required.");
                }
                if (! is_numeric($amount)) {
                    throw new InvalidDataFormatException("Amount has a bad format.");
                }
                
                if (! isset($outerAccount) || strlen($outerAccount) == 0) {
                    throw new InputRequiredException("Receiver account is required.");
                }
                
                if (strlen($description) + strlen($outerAccount) + 2 > 200) {
                    throw new DataTooLongException("Description and receiver account should be less than 200.");
                }
                
                //record pay information in database, return transaction information
                $tranz = $this->accountHandler->payment($accountId, $userId, $amount, 
                    $outerAccount . ": " . $description);
                
                // get updated account by id
                $account = $this->accountHandler->getAccount($accountId);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/Payment.php');
                return;
            }
            
            require_once ('view/PaymentResult.php');
        } else {
            require_once ('view/Payment.php');
        }
    }
}

