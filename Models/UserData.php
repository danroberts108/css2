<?php

/**
 *
 */
class UserData implements JsonSerializable
{
    //Variables for user data structure
    /**
     * @var mixed UserID
     */
    /**
     * @var mixed Username
     */
    /**
     * @var mixed Email
     */
    /**
     * @var mixed Photo name
     */
    /**
     * @var mixed Latitude
     */
    /**
     * @var mixed Longitude
     */
    /**
     * @var mixed First name
     */
    /**
     * @var mixed Last name
     */
    protected $_userid, $_username, $_email, $_photo, $_lat, $_lon, $_fname, $_lname;

    //Constructor for the user data structure

    /**
     * @param $dbRow
     */
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

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            '_userid' => $this->_userid,
            '_username' => $this->_username,
            '_email' => $this->_email,
            '_photo' => $this->_photo,
            '_lat' => $this->_lat,
            '_lon' => $this->_lon,
            '_fname' => $this->_fname,
            '_lname' => $this->_lname
        ];
    }

    //Returns the userid

    /**
     * @return int
     */
    public function getUserid(): int {
        return $this->_userid;
    }

    //Returns the username

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->_username;
    }

    //Returns the email

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->_email;
    }

    //Returns the photo name

    /**
     * @return string
     */
    public function getPhoto(): string {
        return $this->_photo;
    }

    //Returns the latitude

    /**
     * @return float
     */
    public function getLat(): float {
        return $this->_lat;
    }

    //Returns the longitude

    /**
     * @return float
     */
    public function getLon(): float {
        return $this->_lon;
    }

    //Returns the first name

    /**
     * @return string
     */
    public function getFname(): string {
        return $this->_fname;
    }

    //Returns the last name

    /**
     * @return string
     */
    public function getLname(): string {
        return $this->_lname;
    }

    //Sets the user id

    /**
     * @param $userid
     * @return void
     */
    public function setUserid($userid) {
        $this->_userid = $userid;
    }

    //Sets the username

    /**
     * @param $username
     * @return void
     */
    public function setUsername($username) {
        $this->_username = $username;
    }

    //Sets the email

    /**
     * @param $email
     * @return void
     */
    public function setEmail($email) {
        $this->_email = $email;
    }

    //Sets the photo name

    /**
     * @param $photo
     * @return void
     */
    public function setPhoto($photo) {
        $this->_photo = $photo;
    }

    //Sets the latitude

    /**
     * @param $lat
     * @return void
     */
    public function setLat($lat) {
        $this->_lat = $lat;
    }

    //Sets the longitude

    /**
     * @param $lon
     * @return void
     */
    public function setLon($lon) {
        $this->_lon = $lon;
    }

    //Sets the first name

    /**
     * @param $fname
     * @return void
     */
    public function setFname($fname) {
        $this->_fname = $fname;
    }

    //Sets the last name

    /**
     * @param $lname
     * @return void
     */
    public function setLname($lname) {
        $this->_lname = $lname;
    }


}


