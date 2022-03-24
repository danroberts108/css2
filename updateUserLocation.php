<?php

include_once('Models/UserDataSet.php');

session_start();

$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$userid = $_REQUEST['userid'];
$sessionToken = $_SESSION['ajaxToken'];
$requestToken = $_REQUEST['ajaxToken'];

if ($sessionToken != $requestToken) {
    echo 'false';
    exit();
}

$UserDataSet = new UserDataSet();

$UserDataSet->updateUserLocation($userid, $lat, $lon);

echo 'true';