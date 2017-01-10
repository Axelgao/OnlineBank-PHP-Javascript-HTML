

<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
require_once 'model/UserHandler.php';
require_once 'model/User.php';

/**
 * New User Join Controller
 * Provides user join function
 */
class JoinController
{
    // user handler object
    private $userHandler;

    function __construct()
    {
        $this->userHandler = new UserHandler();
    }

    /**
     * New user join
     * @throws InputRequiredException
     * @throws DataTooLongException
     * @throws Exception
     * @throws InvalidDataFormatException
     */
    public function join()
    {
        $user = new User();
        
        if (isset($_POST["submit"])) {
            try {
                $loginName = $_POST["loginName"];
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $address = $_POST["address"];
                $phoneNumber = $_POST["phoneNumber"];
                $dateOfBirth = $_POST["DateOfBirth"];
                $password = $_POST["password"];
                $rePassword = $_POST["rePassword"];
                
                $user->setLoginName($loginName);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setAddress($address);
                $user->setPhoneNumber($phoneNumber);
                $user->setDateOfBirth($dateOfBirth);
                $user->setPassword($password);
                
                // check input
                if (! isset($loginName) || strlen($loginName) == 0) {
                    throw new InputRequiredException("Login name is required.");
                }
                if (strlen($loginName) > 20) {
                    throw new DataTooLongException("Login name should be less than 20.");
                }
                if (! isset($firstName) || strlen($firstName) == 0) {
                    throw new InputRequiredException("First name is required.");
                }
                if (strlen($firstName) > 20) {
                    throw new DataTooLongException("First name should be less than 20.");
                }
                if (! isset($lastName) || strlen($lastName) == 0) {
                    throw new InputRequiredException("Last name is required.");
                }
                if (strlen($lastName) > 20) {
                    throw new DataTooLongException("Last name should be less than 20.");
                }
                if (! isset($address) || strlen($address) == 0) {
                    throw new InputRequiredException("Address is required.");
                }
                if (strlen($address) > 255) {
                    throw new DataTooLongException("Address should be less than 255.");
                }
                if (! isset($phoneNumber) || strlen($phoneNumber) == 0) {
                    throw new InputRequiredException("Phone Number is required.");
                }
                if (strlen($phoneNumber) > 100) {
                    throw new DataTooLongException("Phone number should be less than 100.");
                }
                if (! isset($dateOfBirth) || strlen($dateOfBirth) == 0) {
                    throw new InputRequiredException("Date of birth is required.");
                }
                if (! isset($password) || strlen($password) == 0) {
                    throw new InputRequiredException("Password is required.");
                }
                if (strlen($password) > 30) {
                    throw new DataTooLongException("Password should be less than 30.");
                }
                if (! isset($rePassword) || strlen($rePassword) == 0) {
                    throw new InputRequiredException("Repeat password is required.");
                }
                
                if ($password != $rePassword) {
                    throw new Exception("password and repeat password should be same");
                }
                
                if (! strtotime($dateOfBirth)) {
                    throw new InvalidDataFormatException("Date of birth has a bad format.");
                }
                
                //create new user and basic account in database
                $ret = $this->userHandler->join($user);
                if ($ret) {
                    require_once ('view/JoinResult.php');
                } else {
                    require_once ('view/Join.php');
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                require_once ('view/Join.php');
                return;
            }
        } else {
            require_once ('view/Join.php');
        }
    }
}
?>
