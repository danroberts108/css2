<?php

class Login {
    //Fields for login model in database
    protected $userid = 0;
    protected $password = "";

    //Constructor for login model
    public function __construct($userid, $password) {
        $this->userid = $userid;
        $this->password = $password;
    }

    //Returns the userid
    public function getUserid(): int {
        return $this->userid;
    }

    //Returns the password hash
    public function getPasswordhash(): string {
        return $this->password;
    }

    //Sets the userid
    public function setUserid($userid) {
        $this->userid = $userid;
    }

    //Sets the password hash
    public function setPasswordhash($passwordhash) {
        $this->password = $passwordhash;
    }
}