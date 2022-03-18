<?php

class UserData {
    //Variables for user data structure
    protected $_userid, $_username, $_email, $_photo, $_lat, $_lon, $_fname, $_lname;

    //Constructor for the user data structure
    public function __construct($dbRow) {
        $this->_userid = $dbRow['userid'];
        $this->_username = $dbRow['username'];
        $this->_email = $dbRow['email'];
        $this->_photo = $dbRow['photo'];
        $this->_lat = $dbRow['lat'];
        $this->_lon = $dbRow['lon'];
        $this->_fname = $dbRow['fname'];
        $this->_lname = $dbRow['lname'];
    }

    //Returns the userid
    public function getUserid(): int {
        return $this->_userid;
    }

    //Returns the username
    public function getUsername(): string {
        return $this->_username;
    }

    //Returns the email
    public function getEmail(): string {
        return $this->_email;
    }

    //Returns the photo name
    public function getPhoto(): string {
        return $this->_photo;
    }

    //Returns the latitude
    public function getLat(): float {
        return $this->_lat;
    }

    //Returns the longitude
    public function getLon(): float {
        return $this->_lon;
    }

    //Returns the first name
    public function getFname(): string {
        return $this->_fname;
    }

    //Returns the last name
    public function getLname(): string {
        return $this->_lname;
    }

    //Sets the user id
    public function setUserid($userid) {
        $this->_userid = $userid;
    }

    //Sets the username
    public function setUsername($username) {
        $this->_username = $username;
    }

    //Sets the email
    public function setEmail($email) {
        $this->_email = $email;
    }

    //Sets the photo name
    public function setPhoto($photo) {
        $this->_photo = $photo;
    }

    //Sets the latitude
    public function setLat($lat) {
        $this->_lat = $lat;
    }

    //Sets the longitude
    public function setLon($lon) {
        $this->_lon = $lon;
    }

    //Sets the first name
    public function setFname($fname) {
        $this->_fname = $fname;
    }

    //Sets the last name
    public function setLname($lname) {
        $this->_lname = $lname;
    }
}


