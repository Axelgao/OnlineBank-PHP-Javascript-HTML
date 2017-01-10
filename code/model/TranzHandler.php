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
 * Transaction Handler Class
 * Contains functions to handle transaction information
 */
class TranzHandler
{
    /**
     * Add New Tranz
     *
     * @param $db - database connection
     * @param $tranz - account transaction object             
     * @return new tranz id
     */
    public function addTranz($db, $tranz)
    {
        // insert
        $query = <<<SQL
            INSERT INTO tbl_transaction
            ( account_id, transaction_type, amount, balance, transaction_time, description )
            VALUES(?, ?, ?, ?, NOW(), ?)
SQL;
        
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('isdds', $accountId, $transactionType, $amount, $balance, $description);
            $accountId = $tranz->getAccountId();
            $transactionType = $tranz->getTransactionType();
            $amount = $tranz->getAmount();
            $balance = $tranz->getBalance();
            $description = $tranz->getDescription();
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                throw new Exception("Tranz insert failed: (" . $no . ")" . $err);
            }
            
            // get new id
            $id = $db->insert_id;
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            throw new Exception("Tranz prepare failed: (" . $no . ")" . $err);
        }
        return $id;
    }

    /**
     * Find Transaction By Acccount Id
     *
     * @param $accountId - account id           
     * @param $userId - user id           
     * @param $fromDate - search data start          
     * @param $toDate - search data end          
     * @return tranz list
     */
    public function findTranz($accountId, $userId, $fromDate, $toDate)
    {
        $tranzArray = array();
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        $query = <<<SQL
            SELECT a.id, a.account_id, b.account_number, a.transaction_type, a.amount, a.balance, 
            a.transaction_time, a.description
            FROM tbl_transaction a INNER JOIN tbl_account b ON a.account_id=b.id
            WHERE a.account_id=?
SQL;
        if (isset($fromDate)) {
            // date condition input 
            $s = (new DateTime($toDate))->modify('+1 day');
            $tmpDate = $s->format("Y-m-d");
            $query = $query . " AND a.transaction_time>=? ";
            $query = $query . " AND a.transaction_time<=? ";
        }
        $query = $query . " ORDER BY a.id";
        $stmt = $db->prepare($query);
        
        if ($stmt) {
            if (isset($fromDate)) {
                $stmt->bind_param('iss', $accountId, $fromDate, $tmpDate);
            } else {
                $stmt->bind_param('i', $accountId);
            }
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $newAccountId, $accountNumber, $transactionType, 
                $amount, $balance, $transactionTime, $description);
            while ($stmt->fetch()) {
                $tranz = new Tranz();
                $tranz->setId($id);
                $tranz->setAccountId($newAccountId);
                $tranz->setAccountNumber($accountNumber);
                $tranz->setTransactionType($transactionType);
                $tranz->setAmount($amount);
                $tranz->setBalance($balance);
                $tranz->setTransactionTime($transactionTime);
                $tranz->setDescription($description);
                $tranzArray[$id] = $tranz;
            }
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->close();
            throw new Exception("Tranz prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $tranzArray;
    }

    /**
     * Find Transaction By Conditions
     *
     * @param $accountId - account id           
     * @param $userId - user id           
     * @param $fromDate - search data start          
     * @param $toDate - search data end          
     * @param $type - transaction type          
     * @param $order - order type, asc or desc          
     * @return tranz list
     */
    public function filter($accountId, $userId, $fromDate, $toDate, $type, $order)
    {
        $tranzArray = array();
        
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // $this->accountHandler->getAndCheckAccount($accountId, $userId);
        
        $query = <<<SQL
            SELECT a.id, a.account_id, b.account_number, a.transaction_type, a.amount, a.balance, 
            a.transaction_time, a.description
            FROM tbl_transaction a INNER JOIN tbl_account b ON a.account_id=b.id
            WHERE a.account_id=?
SQL;
        if (isset($fromDate)) {
            $query = $query . " AND a.transaction_time>=? ";
            $query = $query . " AND a.transaction_time<=? ";
        }
        
        switch ($type) {
            case "D":
                $query = $query . " AND a.transaction_type='D' ";
                break;
            case "W":
                $query = $query . " AND a.transaction_type='W' ";
                break;
            case "F":
                $query = $query . " AND a.transaction_type='F' ";
                break;
            case "T":
                $query = $query . " AND a.transaction_type='T' ";
                break;
            case "P":
                $query = $query . " AND a.transaction_type='P' ";
                break;
        }
        
        switch ($order) {
            case "asc":
                $query = $query . " ORDER BY a.id";
                break;
            case "desc":
                $query = $query . " ORDER BY a.id DESC";
                break;
        }
        
        $stmt = $db->prepare($query);
        
        if ($stmt) {
            if (isset($fromDate)) {
                $stmt->bind_param('iss', $accountId, $fromDate, $toDate);
            } else {
                $stmt->bind_param('i', $accountId);
            }
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $newAccountId, $accountNumber, $transactionType, 
                $amount, $balance, $transactionTime, $description);
            while ($stmt->fetch()) {
                $tranz = new Tranz();
                $tranz->setId($id);
                $tranz->setAccountId($newAccountId);
                $tranz->setAccountNumber($accountNumber);
                $tranz->setTransactionType($transactionType);
                $tranz->setAmount($amount);
                $tranz->setBalance($balance);
                $tranz->setTransactionTime($transactionTime);
                $tranz->setDescription($description);
                $tranzArray[$id] = $tranz;
            }
            $stmt->close();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->close();
            throw new Exception("Tranz prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        
        return $tranzArray;
    }
}
