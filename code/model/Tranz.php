<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * Transaction Class
 * Contains account transaction information
 */
class Tranz
{
    // id
    protected $id = 0;
    // account id
    protected $accountId = 0;
    // account number
    protected $accountNumber = 0;
    // transaction type
    protected $transactionType = NULL;
    // transaction amount
    protected $amount = 0.0;
    // balance after transaction
    protected $balance = 0.0;
    // transaction time
    protected $transactionTime = NULL;
    // description
    protected $description = NULL;

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
    
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }
    
    public function getTransactionType()
    {
        return $this->transactionType;
    }
    
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getBalance()
    {
        return $this->balance;
    }
    
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getTransactionTime()
    {
        return $this->transactionTime;
    }
    
    public function setTransactionTime($transactionTime)
    {
        $this->transactionTime = $transactionTime;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
