<?php

require_once("Models/UserDataSet.php");
require_once("Models/UserData.php");

header('Content-Type: text/plain');

$term = $_REQUEST['term'];

$UserDataSet = new UserDataSet();

$UserArray = $UserDataSet->searchUser($term);

$jsonArray = [];
for ($i = 0; $i < count($UserArray); $i++) {
    $item = (object) [
        'userid' => $UserArray[$i]->getUserId(),
        'username' => $UserArray[$i]->getUsername(),
        'fname' => $UserArray[$i]->getFname(),
        'lname' => $UserArray[$i]->getLname(),
        'photo' => $UserArray[$i]->getPhoto()
    ];
    $jsonArray[] = json_encode($item);
}

echo json_encode($jsonArray);

?>