<?php

require_once("Models/UserDataSet.php");
require_once("Models/UserData.php");

header('Content-Type: text/plain');

session_start();
$term = $_REQUEST['term'];
$requestToken = $_REQUEST['ajaxToken'];
$sessionToken = $_SESSION['ajaxToken'];
$limit = $_REQUEST['limit'];
$types = $_REQUEST['searchType'];
$typeArray = explode(',', $types);

if (!is_numeric($limit)) {
    echo 'false';
    exit;
}

if(isset($_SESSION['ajaxToken'])) {
    if ($requestToken !== $sessionToken) {
        echo 'false';
        exit;
    }
} else {
    echo 'false';
    exit;
}

$UserDataSet = new UserDataSet();

$UserArray = $UserDataSet->searchUser($term, $limit, $typeArray);

$jsonArray = [];

for ($i = 0; $i < count($UserArray); $i++) {
    $jsonArray[] = (object) $UserArray[$i]->jsonSerialize();
}

echo json_encode($jsonArray);