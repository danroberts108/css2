<?php

class Location implements JsonSerializable
{
    protected $_lon, $_lat;

    public function __construct($lon, $lat) {
        $this->_lon = $lon;
        $this->_lat = $lat;
    }

    public function jsonSerialize() : array
    {
        return [
            '_lon' => $this->_lon,
            '_lat' => $this->_lat
        ];
    }
}