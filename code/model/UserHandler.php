<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once ("User.php");
require_once ("CustomedException.php");
require_once ("Account.php");
require_once ("AccountHandler.php");

/**
 * User handler class
 * Contains functions to handle users
 */
class UserHandler
{

    /**
     * New User Join
     *
     * @param User $user            
     * @return new account id
     */
    public function join($user)
    {
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // check user login name duplicated
        $tempUser = $this->getUserByLoginName($db, $user->getLoginName());
        if (isset($tempUser)) {
            throw new DuplicatedRecordException("Duplicated user login name.");
        }
        
        // create salt
        $salt = rand(0, 999999);
        $saltText = sprintf("%06d", $salt);
        $user->setSalt($saltText);
        $password = $this->hashPassword($user->getPassword(), $saltText);
        $user->setPassword($password);
        
        // begin transaction
        $db->begin_transaction();
        
        // insert
        $query = <<<SQL
            INSERT INTO tbl_user
            (login_name, first_name, last_name, password, salt, address, phone_number, date_of_birth )
            VALUES(?, ?, ?, ?, ?, ?, ?, ?)
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ssssssss', $loginName, $firstName, $lastName, 
                $password, $saltText, $address, $phoneNumber, $dateOfBirth);
            
            $loginName = $user->getLoginName();
            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $address = $user->getAddress();
            $phoneNumber = $user->getPhoneNumber();
            $dateOfBirth = $user->getDateOfBirth();
            
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                $db->rollback();
                $db->close();
                throw new Exception("Insert failed: (" . $no . ")" . $err);
            }
            
            // get new id
            $id = $db->insert_id;
            $stmt->close();
            
            // add basic account
            $account = new Account();
            
            // new account number
            $rand1 = rand(0, 9999);
            $rand1Text = sprintf("%04d", $rand1);
            $rand2 = rand(0, 9999999);
            $rand2Text = sprintf("%07d", $rand2);
            $accountNumber = "12-" . $rand1Text . "-" . $rand2Text . "-00";
            $account->setAccountNumber($accountNumber);
            // should check up duplicate account number. but if we were so lucky, go to buy lottery
            
            $account->setDescription("Basic account");
            $account->setUserId($id);
            
            $handler = new AccountHandler();
            $accountId = $handler->newAccount($db, $account);
            
            $db->commit();
        } else {
            $no = $db->errno;
            $err = $db->error;
            $db->rollback();
            $db->close();
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        $db->close();
        return $id;
    }

    /**
     * Login with User Login Name and Password
     *
     * @param $loginName - login name 
     * @param $password - password
     * @return CurrentUser or false
     */
    public function login($loginName, $password)
    {
        $currentUser = FALSE;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // find uesr information by login name
        $user = $this->getUserByLoginNameAndPassword($db, $loginName, $password);
        if (isset($user)) {
            $currentUser = new LoginUser();
            $currentUser->setId($user->getId());
            $currentUser->setLoginName($user->getLoginName());
            $currentUser->setTimeOfLogin(date("Y-m-d h:i:sa"));
            
            // calculate cookie secret
            $key = $this->calculateSecret($user->getId(), $user->getSalt());
            $currentUser->setSecret($key);
        }
        
        $db->close();
        return $currentUser;
    }

    /**
     * Check user id and secret
     *
     * @param $loginName - login name 
     * @param $secret - secret string
     * @return CurrentUser or false
     */
    public function findLoginUserBySecret($loginName, $secret)
    {
        $currentUser = FALSE;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // find uesr information by login name
        $user = $this->getUserByLoginName($db, $loginName);
        if (isset($user)) {
            // calculate cookie secret
            $key = $this->calculateSecret($user->getId(), $user->getSalt());
            if ($key == $secret) {
                $currentUser = new LoginUser();
                $currentUser->setId($user->getId());
                $currentUser->setLoginName($user->getLoginName());
                $currentUser->setTimeOfLogin(date("Y-m-d h:i:sa"));
                $currentUser->setSecret($key);
            }
        }
        
        $db->close();
        return $currentUser;
    }

    /**
     * Change Password
     *
     * @param $currentUserId - current user id
     * @param $password - old password
     * @param $newPassword - new password
     * @return true / false
     */
    public function changePassword($loginName, $password, $newPassword)
    {
        $rows = 0;
        
        // connection database
        $db = Db::connect();
        if ($db->connect_errno) {
            die("Connection failed: (" . $db->connect_error . ")" . $db->connect_error);
        }
        
        // find uesr information by login name
        $user = $this->getUserByLoginNameAndPassword($db, $loginName, $password);
        if (! isset($user)) {
            throw new Exception("Wrong login name or password.");
        }
        
        // begin transaction
        $db->begin_transaction();
        
        // calculate new password hash
        $salt = $user->getSalt();
        $hassPassword = $this->hashPassword($newPassword, $salt);
        
        // update
        $query = "UPDATE tbl_user set password=? where login_name=?";
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ss', $hassPassword, $loginName);
            if ($stmt->execute() == FALSE) {
                $no = $db->errno;
                $err = $db->error;
                $db->rollback();
                $db->close();
                throw new Exception("Insert failed: (" . $no . ")" . $err);
            }
            
            // get new id
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
        
        if ($rows == 1)
            return True;
        else
            return False;
    }

    /**
     * Login with User Login Name and Password
     *
     * @param $db - database connection
     * @param $loginName - login name 
     * @param $password - password
     * @return CurrentUser or NULL
     */
    private function getUserByLoginNameAndPassword($db, $loginName, $password)
    {
        $user = NULL;
        
        // find user information by login name
        $tempUser = $this->getUserByLoginName($db, $loginName);
        if (! isset($tempUser)) {
            throw new Exception("Wrong login name or password.");
        }
        
        // calculate hash of password
        $salt = $tempUser->getSalt();
        $hashPassword = $this->hashPassword($password, $salt);
        
        $query = <<<SQL
            SELECT id, login_name, first_name, last_name, password, salt, 
            address, phone_number, date_of_birth
            FROM tbl_user
            WHERE login_name=? AND password=?
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ss', $loginName, $hashPassword);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $newLoginName, $firstName, $lastName, $newPassword, 
                $salt, $address, $phoneNumber, $dateOfBirth);
            if ($stmt->fetch()) {
                $user = new User();
                $user->setId($id);
                $user->setLoginName($newLoginName);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setPassword($newPassword);
                $user->setSalt($salt);
                $user->setAddress($address);
                $user->setPhoneNumber($phoneNumber);
                $user->setDateOfBirth($dateOfBirth);
            }
            $stmt->close();
        } else {
            $no = $stmt->errno;
            $err = $stmt->error;
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        return $user;
    }

    /**
     * Get User By Login Name
     *
     * @param $db - database connection
     * @param $loginName - login name            
     * @return User
     */
    private function getUserByLoginName($db, $loginName)
    {
        $user = NULL;
        
        $query = <<<SQL
            SELECT id, login_name, first_name, last_name, password, salt, 
            address, phone_number, date_of_birth
            FROM tbl_user
            WHERE login_name=?
SQL;
        $stmt = $db->prepare($query);
        if ($stmt) {
            $stmt->bind_param('s', $loginName);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $newLoginName, $firstName, $lastName, $password, 
                $salt, $address, $phoneNumber, $dateOfBirth);
            if ($stmt->fetch()) {
                $user = new User();
                $user->setId($id);
                $user->setLoginName($newLoginName);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setPassword($password);
                $user->setSalt($salt);
                $user->setAddress($address);
                $user->setPhoneNumber($phoneNumber);
                $user->setDateOfBirth($dateOfBirth);
            }
            $stmt->close();
        } else {
            $no = $stmt->errno;
            $err = $stmt->error;
            throw new Exception("Prepare failed: (" . $no . ")" . $err);
        }
        
        return $user;
    }

    /**
     * calculate secret for cookie
     * @param $userId - user id
     * @param $salt - salt
     * @return string
     */
    private function calculateSecret($userId, $salt)
    {
        $key = $salt . "-" . $userId;
        $key = md5($key);
        return $key;
    }

    /**
     * calculate password hash
     * @param $password - password
     * @param $salt - salt
     * @return string
     */
    private function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }
}
