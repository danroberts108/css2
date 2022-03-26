<?php

require_once('Models/UserDataSet.php');

header('Content-Type: text/plain');

session_start();

$UserDataSet = new UserDataSet();

$requestToken = $_REQUEST['ajaxToken'];
$sessionToken = $_SESSION['ajaxToken'];

if ($requestToken != $sessionToken) {
    echo 'false';
    exit();
}

$locations = $UserDataSet->getFriendsLocations($_SESSION['uid']);

$jsonArray = [];

for ($i = 0; $i < count($locations); $i++) {
    $jsonArray[] = (object) $locations[$i]->jsonSerialize();
}

echo json_encode($jsonArray);