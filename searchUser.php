<?php

require_once("Models/UserDataSet.php");
require_once("Models/UserData.php");

header('Content-Type: text/plain');

$term = $_REQUEST['term'];
$UserDataSet = new UserDataSet();

$UserArray = $UserDataSet->searchUser($term);

$jsonArray = json_encode($UserArray, JSON_FORCE_OBJECT);

echo $jsonArray;

?>