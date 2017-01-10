<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * Current Login User class
 * Contains information of current login user.
 */
class LoginUser
{
    // User Id
    private $id = NULL;
    // User Login Name
    private $loginName = NULL;
    // Secret
    private $secret = NULL;
    // Time of Login
    private $timeOfLogin = NULL;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLoginName()
    {
        return $this->loginName;
    }

    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getTimeOfLogin()
    {
        return $this->timeOfLogin;
    }

    public function setTimeOfLogin($timeOfLogin)
    {
        $this->timeOfLogin = $timeOfLogin;
    }
}
