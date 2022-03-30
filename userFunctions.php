<?php

require_once('Models/UserDataSet.php');

session_start();

$requestToken = $_REQUEST['ajaxToken'];
$sessionToken = $_SESSION['ajaxToken'];

$request = $_REQUEST['requestType'];
$userid = $_REQUEST['userid'];

$UserDataSet = new UserDataSet();



if ($requestToken != $sessionToken) {
    exit();
}

switch ($request) {
    case "request":
        $UserDataSet->requestFriend($_SESSION['uid'], $userid);
        break;
    case "block":
        $UserDataSet->blockUser($_SESSION['uid'], $userid);
        break;
    case "remove":
        $UserDataSet->removeFriend();
}