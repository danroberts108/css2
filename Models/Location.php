<?php

class Location implements JsonSerializable
{
    protected $_userid, $_username, $_lon, $_lat;

    public function __construct($userid, $username, $lon, $lat) {
        $this->_userid = $userid;
        $this->_username = $username;
        $this->_lon = $lon;
        $this->_lat = $lat;
    }

    public function jsonSerialize() : array
    {
        return [
            '_userid' => $this->_userid,
            '_username' => $this->_username,
            '_lon' => $this->_lon,
            '_lat' => $this->_lat
        ];
    }
}