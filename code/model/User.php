<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * User class
 * Contains information of user.
 */
class User
{
    // User Id
    private $id = NULL;
    // Login Name
    private $loginName = NULL;
    // First Name
    private $firstName = NULL;
    // Last Name
    private $lastName = NULL;
    // Password
    private $password = NULL;
    // Salt
    private $salt = NULL;
    // Address
    private $address = NULL;
    // Phone Number
    private $phoneNumber = NULL;
    // Date of Birth
    private $dateOfBirth = NULL;
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    
    public function getLoginName(){
        return $this->loginName;
    }
    public function setLoginName($loginName){
        $this->loginName = $loginName;
    }
    
    public function getFirstName(){
        return $this->firstName;
    }
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }
    
    public function getLastName(){
        return $this->lastName;
    }
    public function setLastName($lastName){
        $this->lastName = $lastName;
    }
    
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function getSalt(){
        return $this->salt;
    }
    public function setSalt($salt){
        $this->salt = $salt;
    }

    public function getAddress(){
        return $this->address;
    }
    public function setAddress($address){
        $this->address = $address;
    }
    
    public function getPhoneNumber(){
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber){
        $this->phoneNumber = $phoneNumber;
    }
    
    public function getDateOfBirth(){
        return $this->dateOfBirth;
    }
    public function setDateOfBirth($dateOfBirth){
        $this->dateOfBirth = $dateOfBirth;
    }
}
