<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/Tranz.php';
require_once 'model/TranzHandler.php';

/**
 * Account handler class
 * Contains functions to handle accounts
 */
class AccountHandler
{
    // account transaction handler object
    private $tranzHandler;

    function __construct()
    {
        $this->tranzHandler = new TranzHandler();
    }

    /**
     * Add New Acccount
     *
     * @param Account $account            
     * @return new account id
     */
    public function addAccount($account)
    {
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // begin transaction
        $db->begin_transaction();
        
        try {
            $id = $this->newAccount($db, $account);
            $db->commit();
        } catch (Excepton $e) {
            $db->rollback();
            $db->close();
            throw $e;
        }
        $db->close();
        return $id;
    }

    /**
     * Add New Acccount
     *
     * @param Database Connection $db
     * @param Account $account            
     * @return new account id
     */
    public function newAccount($db, $account)
    {
        // check account number duplicated
        $tempAccount = $this->getAccountByAccountNumber($account->getAccountNumber());
        if (isset($tempAccount)) {
            throw new DuplicatedRecordException("Duplicated account number.");
        }
        
        // check new account number has same first three segments
        $accountList = $this->findAccount($account->getUserId());
        if (isset($accountList) && count($accountList) > 0) {
            $firstAccount = $accountList[0];
            $firstNumber = $firstAccount->getAccountNumber();
            $number = substr($firstNumber, 0, strlen($firstNumber) - 2);
            $inputNumber = substr($account->getAccountNumber(), 0, 
                strlen($account->getAccountNumber()) - 2);
            if ($number != $inputNumber) {
                throw new InvalidDataFormatException("Bad account number.");
            }
        }

        //Check open accounts number
        $accountList = $this->findOpenAccount($account->getUserId());
        if (isset($accountList) && count($accountList) >= 5) {
            throw new InvalidDataFormatException("Too many account number.");
        }
        
        // insert
        $query = <<<SQL
            INSERT INTO tbl_account
            ( account_number, user_id, balance, date_open, status, description )
            VALUES(?, ?, 0.0, CURDATE(), 1, ?)
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('sss', $accountNumber, $userId, $description);
            $accountNumber = $account->getAccountNumber();
            $userId = $account->getUserId();
            $description = $account->getDescription();
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                throw new Exception("Insert failed: (" . $no . ")" . $err);
            }
            
            // success, get new id
            $id = $db->insert_id;
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        return $id;
    }

    /**
     * Update Acccount Information
     *
     * @param Account $account            
     * @return rows updated
     */
    public function updateAccount($account)
    {
        $rows = 0;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // check account owner
        $tempAccount = $this->getAndCheckAccount($account->getId(), $account->getUserId());
        if($account->getStatus()=="0" && $tempAccount->getBalance()>0){
            $account->setStatus("1");
            $account->setAccountNumber($tempAccount->getAccountNumber());
            throw new Exception("The account cannot be closed as it still has balance.");
        }
        
        // begin transaction
        $db->begin_transaction();
        
        // update
        $query = "UPDATE tbl_account SET status=?, description=? WHERE id=?";
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ssi', $status, $description, $id);
            $status = $account->getStatus();
            $description = $account->getDescription();
            $id = $account->getId();
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                $db->rollback();
                throw new Exception("Update failed: (" . $no . ")" . $err);
            }
            
            // get rows
            $rows = $stmt->affected_rows;
            $stmt->close();
            $db->commit();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        $db->close();
        return $rows;
    }

    /**
     * Deposit
     *
     * @param $accountId - account id
     * @param $userId - user id
     * @param $amount - amount
     * @param $description - description
     * @return new transaction object 
     */
    public function deposit($accountId, $userId, $amount, $description)
    {
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // begin transaction
        $db->begin_transaction();
        
        try {
            // update balance, create transaction record
            $tranz = $this->updateBalance($db, $accountId, $userId, $amount, "D", $description);
        } catch (Exception $e) {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw $e;
        }
        
        $db->commit();
        $db->close();
        return $tranz;
    }

    /**
     * Withdraw
     *
     * @param $accountId - account id
     * @param $userId - user id
     * @param $amount - amount
     * @param $description - description
     * @return new transaction object 
     */
    public function withdraw($accountId, $userId, $amount, $description)
    {
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // begin transaction
        $db->begin_transaction();
        
        try {
            // update balance, create transaction record
            $tranz = $this->updateBalance($db, $accountId, $userId, $amount, "W", $description);
        } catch (Exception $e) {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw $e;
        }
        
        $db->commit();
        $db->close();
        return $tranz;
    }

    /**
     * Payment
     *
     * @param $accountId - account id
     * @param $userId - user id
     * @param $amount - amount
     * @param $description - description
     * @return new transaction object 
     */
    public function payment($accountId, $userId, $amount, $description)
    {
        $tranz = 0;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // begin transaction
        $db->begin_transaction();
        
        try {
            // update balance, create transaction record
            $tranz = $this->updateBalance($db, $accountId, $userId, $amount, "P", $description);
        } catch (Exception $e) {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw $e;
        }
        
        $db->commit();
        $db->close();
        return $tranz;
    }

    /**
     * Transfer
     *
     * @param $accountIdFrom - account id from
     * @param $accountIdTo - account id to
     * @param $userId - user id
     * @param $amount - amount
     * @param $description - description
     * @return new transaction object 
     */
    public function transfer($accountIdFrom, $accountIdTo, $userId, $amount, $description)
    {
        $tranz = 0;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // check account owner
        $tempAccount = $this->getAndCheckAccount($accountIdFrom, $userId);
        $tempAccount = $this->getAndCheckAccount($accountIdTo, $userId);
        
        // begin transaction
        $db->begin_transaction();
        
        try {
            // update balance, create transaction record
            $tranz = $this->updateBalance($db, $accountIdFrom, $userId, $amount, "F", $description);
            $tranz = $this->updateBalance($db, $accountIdTo, $userId, $amount, "T", $description);
        } catch (Exception $e) {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw $e;
        }
        
        $db->commit();
        
        $db->close();
        return $tranz;
    }

    /**
     * Update Acccount InformationM
     *
     * @param $db - database connection
     * @param $accountIdaccount id
     * @param $userId - user id
     * @param $amount - amount
     * @param $type - type
     * @param $description - description
     * @return rows updated
     */
    private function updateBalance($db, $accountId, $userId, $amount, $type, $description)
    {
        // check account owner
        $tempAccount = $this->getAndCheckAccount($accountId, $userId);
        
        // update
        if ($type == "D" || $type == 'T') {
            $query = "UPDATE tbl_account SET balance=balance+? WHERE id=?";
        } else {
            $query = "UPDATE tbl_account SET balance=balance-? WHERE id=? and balance>=?";
        }
        $stmt = $db->prepare($query);
        if ($stmt) {
            if ($type == "D" || $type == 'T') {
                $stmt->bind_param('di', $amount, $accountId);
            } else {
                $stmt->bind_param('did', $amount, $accountId, $amount);
            }
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                $db->rollback();
                throw new Exception("Update failed: (" . $no . ")" . $err);
            }
            
            // get rows
            $rows = $stmt->affected_rows;
            if ($rows != 1)
                throw new Exception("Update failed: balance not enough.");
            
            $stmt->close();
            
            $tempAcount = $this->getAccount($accountId);
            
            // write transaction
            $tranz = new Tranz();
            $tranz->setAccountId($accountId);
            $tranz->setAccountNumber($tempAccount->getAccountNumber());
            $tranz->setTransactionType($type);
            $tranz->setAmount($amount);
            $tranz->setBalance($tempAcount->getBalance());
            $tranz->setTransactionTime(date("y-m-d", time()));
            $tranz->setDescription($description);
            
            $this->tranzHandler->addTranz($db, $tranz);
            
            // get new id
            $tranzId = $db->insert_id;
            $tranz->setId($tranzId);
        } else {
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        return $tranz;
    }

    /**
     * Get Acccount By Account Id
     *
     * @param int $accountId            
     * @return account
     */
    public function getAccount($accountId)
    {
        $account = NULL;
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        $query = <<<SQL
        SELECT id, account_number, user_id, balance, date_open, status, description
        FROM tbl_account
        WHERE id=?
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('i', $accountId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $accountNumber, $userId, $balance, $dateOpen, $status, $description);
            if ($stmt->fetch()) {
                $account = new Account();
                $account->setId($id);
                $account->setAccountNumber($accountNumber);
                $account->setUserId($userId);
                $account->setBalance($balance);
                $account->setDateOpen($dateOpen);
                $account->setStatus($status);
                $account->setDescription($description);
            }
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $account;
    }

    /**
     * Get and Check Acccount By Account Id and User Id
     *
     * @param int $accountId
     * @param int $userId            
     * @throws InvalidRecordException
     * @return account
     */
    public function getAndCheckAccount($accountId, $userId)
    {
        $account = $this->getAccount($accountId);
        if (! isset($account)) {
            throw new InvalidRecordException("No such account number.");
        }
        if ($account->getUserId() != $userId) {
            throw new InvalidRecordException("You have no such account number.");
        }
        if ($account->getStatus() != "1") {
            throw new InvalidRecordException("Account number has closed.");
        }
        
        return $account;
    }

    /**
     * Get Acccount By Account Number
     *
     * @param string $accountNumber            
     * @return account
     */
    public function getAccountByAccountNumber($accountNumber)
    {
        $account = NULL;
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        $query = <<<SQL
        SELECT id, account_number, user_id, balance, date_open, status, description
        FROM tbl_account
        WHERE account_number=?
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('s', $accountNumber);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $accountNum, $userId, $balance, $dateOpen, $status, $description);
            if ($stmt->fetch()) {
                $account = new Account();
                $account->setId($id);
                $account->setAccountNumber($accountNum);
                $account->setUserId($userId);
                $account->setBalance($balance);
                $account->setDateOpen($dateOpen);
                $account->setStatus($status);
                $account->setDescription($description);
            }
            $stmt->close();
        } else {
            $no = $stmt->errno;
            $err = $stmt->error;
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $account;
    }

    /**
     * Find Acccounts By User Id
     *
     * @param int $userId            
     * @return account list
     */
    public function findAccount($userId)
    {
        $accountArray = array();
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        $query = <<<SQL
        SELECT id, account_number, user_id, balance, date_open, status, description
        FROM tbl_account WHERE user_id=? ORDER BY account_number
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $accountNumber, $tempUserId, $balance, $dateOpen, $status, $description);
            $idx = 0;
            while ($stmt->fetch()) {
                $account = new Account();
                $account->setId($id);
                $account->setAccountNumber($accountNumber);
                $account->setUserId($tempUserId);
                $account->setBalance($balance);
                $account->setDateOpen($dateOpen);
                $account->setStatus($status);
                $account->setDescription($description);
                $accountArray[$idx] = $account;
                $idx++;
            }
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $accountArray;
    }

    /**
     * Find Open Acccounts By User Id
     *
     * @param int $userId            
     * @return account list
     */
    public function findOpenAccount($userId)
    {
        $accountArray = array();
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        $query = <<<SQL
        SELECT id, account_number, user_id, balance, date_open, status, description
        FROM tbl_account 
        WHERE user_id=?
        AND status='1'
        ORDER BY account_number
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $accountNumber, $tempUserId, $balance, $dateOpen, $status, $description);
            $idx = 0;
            while ($stmt->fetch()) {
                $account = new Account();
                $account->setId($id);
                $account->setAccountNumber($accountNumber);
                $account->setUserId($tempUserId);
                $account->setBalance($balance);
                $account->setDateOpen($dateOpen);
                $account->setStatus($status);
                $account->setDescription($description);
                $accountArray[$idx] = $account;
                $idx++;
            }
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $accountArray;
    }
}
