<?php

require_once ('Models/Database.php');
require_once ('Models/UserData.php');
require_once('Models/UserFriendshipData.php');
require_once('Models/Location.php');

/**
 *
 */
class UserDataSet {
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO|null
     */
    protected $_dbHandle, $_dbInstance;

    //Object constructor

    /**
     *
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Fetches all users in database

    /**
     * @return array
     */
    public function fetchAllUsers() {
        //Query to select all records in the users table
        $sqlQuery = 'SELECT * FROM users';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        //Creates an array and stores the returned rows in it.
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    //Fetches all users that are friends with the given userid

    /**
     * @param $userid
     * @return array
     */
    public function fetchFriends($userid) {
        //Query to select user data and friendship id from the users table and friends table that is friends with the given user
        $query = "SELECT DISTINCT users.userid, users.username, users.email, users.photo, users.lat, users.lon, users.fname, users.lname, friends.friendshipid FROM (users INNER JOIN friends ON (users.userid = friends.friend1 OR users.userid=friends.friend2)) WHERE (friends.friend1=? OR friends.friend2=?) AND status='2' AND userid!=?";
        $statement = $this->_dbHandle->prepare($query);

        //sets the parameters in the query
        $statement->bindParam(1, $userid);
        $statement->bindParam(2, $userid);
        $statement->bindParam(3, $userid);

        //Executes the query
        $statement->execute();

        //Creates an array and stores the returned rows in it
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new UserFriendshipData($row);
        }

        return $dataset;
    }

    //Fetches all users that are not friends with the given user

    /**
     * @param $userid
     * @return array
     */
    public function fetchNonFriends($userid) {
        //Query to get the user data from the users table of all the users that are not friends with or blocked by the given user
        $query = "SELECT users.userid, users.username, users.email, users.photo, users.lat, users.lon, users.fname, users.lname FROM users WHERE users.userid NOT IN (SELECT DISTINCT users.userid FROM (users INNER JOIN friends ON (users.userid = friends.friend1 OR users.userid=friends.friend2)) WHERE (friends.friend1=? OR friends.friend2=?) AND (status='2' OR status='1' OR status='3') AND userid!=?)";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);
        $statement->bindParam(2, $userid);
        $statement->bindParam(3, $userid);

        $statement->execute();

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new UserData($row);
        }

        return $dataset;
    }

    //Fetches all requests for the given user

    /**
     * @param $userid
     * @return array
     */
    public function fetchRequests($userid) {
        //Query to get all friend requests for the given user
        $query = "SELECT DISTINCT users.userid, users.username, users.email, users.photo, users.lat, users.lon, users.fname, users.lname, friends.friendshipid FROM (users INNER JOIN friends ON users.userid = friends.friend1) WHERE (friends.friend1=? OR friends.friend2=?) AND status='1' AND users.userid!=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);
        $statement->bindParam(2, $userid);
        $statement->bindParam(3, $userid);

        $statement->execute();

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new UserFriendshipData($row);
        }

        return $dataset;
    }

    /**
     * @param $userid
     * @return array
     */
    public function fetchSentRequests($userid) {
        $query = "SELECT DISTINCT users.userid, users.username, users.email, users.photo, users.lat, users.lon, users.fname, users.lname, friends.friendshipid FROM (users INNER JOIN friends ON users.userid = friends.friend2) WHERE (friends.friend1=? OR friends.friend2=?) AND status='1' AND users.userid!=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);
        $statement->bindParam(2, $userid);
        $statement->bindParam(3, $userid);

        $statement->execute();

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new UserFriendshipData($row);
        }

        return $dataset;
    }

    //Fetches the user data for the given user

    /**
     * @param $userid
     * @return array
     */
    public function fetchUser($userid) {
        $query = "SELECT * FROM users WHERE userid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $userid);

        $statement->execute();

        $row = $statement->fetch();

        $dataset = [];

        $dataset[] = new UserData($row);

        return $dataset;
    }

    //Creates a request from the requester to the requestee

    /**
     * @param $requester
     * @param $requestee
     * @return void
     */
    public function requestFriend($requester, $requestee) {
        $query = "INSERT INTO friends (friend1, friend2, status) VALUES (?,?,'1')";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $requester);
        $statement->bindParam(2, $requestee);

        $statement->execute();
    }

    //Accepts a request from the request id

    /**
     * @param $requestid
     * @return void
     */
    public function acceptRequest($requestid) {
        $query = "UPDATE friends SET status='2' WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $requestid);

        $statement->execute();
    }

    //Removes a request from the request id

    /**
     * @param $requestid
     * @return void
     */
    public function declineRequest($requestid) {
        $query = "UPDATE friends SET status='1' WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $requestid);

        $statement->execute();
    }

    /**
     * @param $requestid
     * @return void
     */
    public function deleteRequest($requestid) {
        $query = "DELETE FROM friends WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $requestid);

        $statement->execute();
    }

    //Blocks all requests from a user by the request id

    /**
     * @param $requestid
     * @return void
     */
    public function blockRequest($requestid) {
        $query = "UPDATE friends SET status='3' WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $requestid);

        $statement->execute();
    }

    //Blocks a user from requesting another

    /**
     * @param $blocker
     * @param $blockee
     * @return void
     */
    public function blockUser($blocker, $blockee) {
        $query = "INSERT INTO friends (friend1, friend2, status) VALUES (?,?,'3')";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $blocker);
        $statement->bindParam(2, $blockee);

        $statement->execute();
    }

    //Returns the friendship status for a given friendship id

    /**
     * @param $friendshipid
     * @return mixed
     */
    public function checkFriendship($friendshipid) {
        $query = "SELECT status FROM friends WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $friendshipid);

        $statement->execute();

        $result = $statement->fetch();

        return $result['status'];
    }

    //Deletes a freindship from the given friendship id

    /**
     * @param $friendshipid
     * @return void
     */
    public function removeFriend($friendshipid) {
        $query = "DELETE FROM friends WHERE friendshipid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $friendshipid);

        $statement->execute();
    }

    //Updates userdata from a UserData object

    /**
     * @param $user
     * @return void
     */
    public function updateUserData($user) {
        $query = "UPDATE users SET fname=?, lname=? WHERE userid=?";
        $statement = $this->_dbHandle->prepare($query);

        $fname = $user->getFname();
        $lname = $user->getLname();
        $userid = $user->getUserId();

        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        $statement->bindParam(3, $userid);

        $statement->execute();
    }

    //Sets a new profile picture path for the given user

    /**
     * @param $userid
     * @param $name
     * @return void
     */
    public function newProfileImage($userid, $name) {

        $query = "UPDATE users SET photo=? WHERE userid=?";
        $statement = $this->_dbHandle->prepare($query);

        $statement->bindParam(1, $name);
        $statement->bindParam(2, $userid);

        $statement->execute();
    }


    /** Searches the user database for users that match the search term
     * @param $term string The term to be searched for
     * @param $limit int The limit of results to be returned
     * @return array
     */
    public function searchUser($term, $limit, array $type) {
        $searchTerm = '%' . $term . '%';
        $nextOr = false;
        $limitInt = intval(trim($limit));
        $query = "SELECT * FROM users WHERE (";
        if (count($type) == 0) {
            return array();
        }
        if (in_array('username', $type, false)) {
            $query .= 'username LIKE ?';
            $nextOr = true;
        }
        if (in_array('fname', $type, false)) {
            if ($nextOr) {
                $query .= ' OR ';
            }
            $query .= 'fname LIKE ?';
            $nextOr = true;
        }
        if (in_array('lname', $type, false)) {
            if ($nextOr) {
                $query .= ' OR ';
            }
            $query .= 'lname LIKE ?';
            $nextOr = true;
        }
        $query .= ')';
        //Adds the limit part of the statement if one has been selected
        if ($limitInt != 0) {
            $query .= " LIMIT ?";
        }
        $statement = $this->_dbHandle->prepare($query);
        for ($i = 0; $i < count($type); $i++) {
            $param = $i + 1;
            $statement->bindValue($param, $searchTerm, PDO::PARAM_STR);
        }
        //Binds the limit argument if one has been selected
        if ($limitInt != 0) {
            $statement->bindValue(count($type) + 1, $limitInt, PDO::PARAM_INT);
        }

        $statement->execute();
        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new UserData($row);
        }
        return $dataset;
    }

    public function updateUserLocation($userid, $lat, $lon) {
        $query = "UPDATE users SET lat=?, lon=? WHERE userid = ?";
        $statement = $this->_dbHandle->prepare($query);
        $statement->bindParam(1, $lat);
        $statement->bindParam(2, $lon);
        $statement->bindParam(3, $userid);
        $statement->execute();
    }

    public function getUserLocation($userid) {
        $query = "SELECT lon, lat FROM users WHERE userid = ?";
        $statement = $this->_dbHandle->prepare($query);
        $statement->bindParam(1, $userid);
        $statement->execute();

        $result = $statement->fetch();
        return array($result['lon'], $result['lat']);
    }

    public function getAllLocations() {
        $statement = $this->_dbHandle->prepare("SELECT lon, lat FROM users");
        $statement->execute();

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new Location($row['lon'], $row['lat']);
        }

        return $dataset;

    }

    public function getFriendsLocations($userid) {
        $friends = $this->fetchFriends($userid);
        $friendIdArray = [];
        for ($i = 0; $i < count($friends); $i++) {
            $friendIdArray[] = $friends[$i]->getUserid();
        }
        $queryIds = implode(',', array_fill(0, count($friendIdArray), '?'));
        $query = "SELECT lon, lat FROM users WHERE userid IN(" . $queryIds . ")";

        $statement = $this->_dbHandle->prepare($query);
        $statement->execute($friendIdArray);

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new Location($row['lon'], $row['lat']);
        }

        return $dataset;
    }

}


