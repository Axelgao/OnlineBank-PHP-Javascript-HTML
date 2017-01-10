<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * Account class
 * Contains information of account.
 */
class Account
{
    // Account Id
    private $id = NULL;
    // Account Number
    private $accountNumber = NULL;
    // User Id
    private $userId = NULL;
    // Account Balance
    private $balance = 0.0;
    // Account Open Date
    private $dateOpen = NULL;
    // Account Status
    private $status = NULL;
    // Account Description
    private $description = NULL;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    
    public function getAccountNumber(){
        return $this->accountNumber;
    }
    public function setAccountNumber($accountNumber){
        $this->accountNumber = $accountNumber;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    
    public function getBalance(){
        return $this->balance;
    }
    public function setBalance($balance){
        $this->balance = $balance;
    }
    
    public function getDateOpen(){
        return $this->dateOpen;
    }
    public function setDateOpen($dateOpen){
        $this->dateOpen = $dateOpen;
    }
    
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }
}
