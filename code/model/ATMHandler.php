<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/AccountHandler.php';
require_once 'model/TranzHandler.php';
require_once 'model/Account.php';
require_once 'model/ATM.php';
require_once 'model/CustomedException.php';
require_once 'model/Tranz.php';

/**
 * ATM handler class
 * Contains functions to handle ATM
 */
class ATMHandler
{

    public function calculate($accountNumber, $inputAmount, $type)
    {
        $tempAccount = $this->getAccountByAccountNumber($accountNumber);
        
        // check account owner
        $account = $tempAccount->getAndCheckAccount($tempAccount->accountId, $tempAccount->userId);
        
        // operation
        if ($inputAmount <= 0) {
            throw new InvalidRecordException("Bad Input Amount.");
        } elseif ($type == 'W' && $account->balance < $inputAmount) {
            throw new InvalidRecordException("Not Enough Balance.");
        }
        
        if ($type == 'D') {
            $atmTranz = $this->deposit($account->getAccountNumber(), $account->getUserId(), $inputAmount, "My deposit tranz");
        }
        
        if ($type == 'W') {
            $atmTranz = $this->withdraw($account->getAccountNumber(), $account->getUserId(), $inputAmount, "My withdraw tranz");
        }
        
        return $atmTranz;
    }

    public function display($accountNumber, $inputAmount, $type)
    {
        $tempAccount = $this->getAccountByAccountNumber($accountNumber);
        
        // check account owner
        $account = $tempAccount->getAndCheckAccount($tempAccount->accountId, $tempAccount->userId);
        
        $atmResult = new ATM();
        
        // ATM operation result
        if (($inputAmount <= 0) || ($type == 'W' && $account->balance < $inputAmount)) {
            $atmResult->setOperationResult("Operation fails!");
        } elseif (($type == 'D') || ($type == 'W' && $account->balance >= $inputAmount)) {
            $atmResult->setOperationResult("Operation succeeds!");
        }
        
        $atmResult->setInput($inputAmount);
        
        $atmResult->setOperationType($type);
        
        return $atmResult;
    }
}
