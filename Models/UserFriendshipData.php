<?php

class UserFriendshipData extends UserData // Uses the UserData as a parent to inherit all the fields from that
{
    protected $friendshipid;

    //Constructor using the parent classes constructor and then additional code for this class
    public function __construct($dbRow)
    {
        parent::__construct($dbRow);
        $this->friendshipid = $dbRow['friendshipid'];
    }

    //Returns the friendshipid
    public function getFriendshipid(): int {
        return $this->friendshipid;
    }

    //Sets the friendship id to the given value
    public function setFriendshipid($friendshipid) {
        $this->friendshipid = $friendshipid;
    }
}