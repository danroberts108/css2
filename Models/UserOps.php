<?php

require_once('Models/Database.php');

class UserOps {
    protected $_dbHandle, $dbInstance;

    //Constructor
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Checks if a users credentials are valid and if they are logs them in
    public function loginUser($username, $password) {

        $query = "SELECT userid, fname FROM users WHERE username=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $username);

        $statement->execute();
        $result = $statement->fetch();
        $userid = $result['userid'];
        $fname = $result['fname'];

        $query = "SELECT password FROM login WHERE userid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);

        $statement->execute();
        $result = $statement->fetch();

        $passwordmatch = password_verify($password, $result['password']);

        if ($passwordmatch) {
            session_start();

            $_SESSION['login'] = $username;
            $_SESSION['uid'] = $userid;
            $_SESSION['fname'] = $fname;

            header("Location: index.php");
        }else{
            $_SESSION['message'] = "Login failed. Please re-enter your details and try again.";
        }

    }

    //Registers a user in the database
    public function registerUser($username, $email, $photo, $password, $lat, $lon, $fname, $lname) {

        $duplicate = $this->checkDuplicate($username);
        if ($duplicate) {
            return false;
        }

        $query = "INSERT INTO users (username, email, photo, lat, lon, fname, lname) VALUES (?,?,?,?,?,?,?)";
        $statement = $this->_dbHandle->prepare($query);

        $pwHash = password_hash($password, PASSWORD_DEFAULT);

        $statement->bindParam(1, $username);
        $statement->bindParam(2, $email);
        $statement->bindParam(3, $photo);
        $statement->bindParam(4, $lat);
        $statement->bindParam(5, $lon);
        $statement->bindParam(6, $fname);
        $statement->bindParam(7, $lname);
        $statement->execute();

        $query = "SELECT userid FROM users WHERE username=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $username);
        $statement->execute();

        $useridstring = $statement->fetch();
        $userid = $useridstring['userid'];

        $query = "INSERT INTO login (userid, password) VALUES (?,?)";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);
        $statement->bindParam(2, $pwHash);

        $statement->execute();

        session_start();

        $_SESSION["login"] = $username;
        $_SESSION["uid"] = $userid;
        $_SESSION['fname'] = $fname;

        header('Location: index.php');

        return true;
    }

    //Checks if a username has two entries
    public function checkDuplicate($username): bool {
        $query = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($query);
        $statement->bindParam(1, $username);
        $statement->execute();
        $return = $statement->fetch();
        if ($return !== false) {
            $return = true;
        }
        return $return;
    }
}