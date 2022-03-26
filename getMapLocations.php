<?php

require_once('Models/UserDataSet.php');

header('Content-Type: text/plain');

$UserDataSet = new UserDataSet();

$requestToken = $_REQUEST['ajaxToken'];
$sessionToken = $_SESSION['ajaxToken'];

$locations = $UserDataSet->getAllLocations();

$jsonArray = [];

for ($i = 0; $i < count($locations); $i++) {
    $jsonArray[] = (object) $locations[$i]->jsonSerialize();
}

echo json_encode($jsonArray);