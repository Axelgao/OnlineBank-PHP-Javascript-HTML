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
 * Account Controller
 * Contains page control functions about account creation and update.
 *
 */
class AccountController
{
    // account handler object
    private $accountHandler;

    function __construct()
    {
        $this->accountHandler = new AccountHandler();
    }

    /**
     * add an account
     * @throws InputRequiredException
     * @throws InvalidDataFormatException
     * @throws DataTooLongException
     */
    public function addAccount()
    {
        //get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        $account = new Account();
        
        if (isset($_POST["submit"])) {
            // add new account
            try {
                $accountNumber = $_POST["accountNumber"];
                $description = $_POST["description"];
                $account->setAccountNumber($accountNumber);
                $account->setDescription($description);
                
                // check input
                if (! isset($accountNumber) || strlen($accountNumber) == 0) {
                    throw new InputRequiredException("Account number is required.");
                }
                $pattern = "/(\d{2})-(\d{4})-(\d{7})-(\d{2})/";
                if (! preg_match($pattern, $accountNumber)) {
                    throw new InvalidDataFormatException("Account number format is 12-3456-7890123-45.");
                }
                
                if (strlen($description) > 200) {
                    throw new DataTooLongException("Description should be less than 200.");
                }
                
                $account->setUserId($userId);
                
                // add to database
                $id = $this->accountHandler->addAccount($account);
                // get new created account by id for showing
                $account = $this->accountHandler->getAccount($id);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/AddAccount.php');
                return;
            }
            
            require_once ('view/AddAccountResult.php');
        } else {
            require_once ('view/AddAccount.php');
        }
    }

    /**
     * update account information
     * @throws InputRequiredException
     * @throws InvalidDataFormatException
     * @throws DataTooLongException
     * @throws InvalidRecordException
     */
    public function updateAccount()
    {
        //get current user id
        $loginUser = $_SESSION["loginUser"];
        $userId = $loginUser->getId();
        
        $account = new Account();
        
        if (isset($_POST["submit"])) {
            try {
                // update account
                $id = $_POST["id"];
                $status = $_POST["status"];
                $description = $_POST["description"];
                $account->setId($id);
                $account->setStatus($status);
                $account->setDescription($description);
                
                // check input
                if (! isset($id) || strlen($id) == 0) {
                    throw new InputRequiredException("Account id is required.");
                }
                if (! is_numeric($id)) {
                    throw new InvalidDataFormatException("Account id has a bad format.");
                }
                
                if (! isset($status) || strlen($status) == 0) {
                    throw new InputRequiredException("Status is required.");
                }
                if (! $status == "0" && ! $status == "1") {
                    throw new InvalidDataFormatException("Status has a bad format.");
                }
                
                if (strlen($description) > 200) {
                    throw new DataTooLongException("Description should be less than 200.");
                }
                
                // update to database
                $account->setUserId($userId);
                $no = $this->accountHandler->updateAccount($account);
                
                //something wrong
                if ($no <= 0) {
                    throw new InvalidRecordException("No account updated.");
                }
                
                // get updated account
                $account = $this->accountHandler->getAccount($id);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/UpdateAccount.php');
                return;
            }
            
            require_once ('view/UpdateAccountResult.php');
        } else {
            // get account by account id & current user id
            try {
                $account = $this->accountHandler->getAndCheckAccount($_GET["id"], $userId);
            } catch (InvalidRecordException $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/UpdateAccount.php');
                return;
            }
            
            require_once ('view/UpdateAccount.php');
        }
    }
}

