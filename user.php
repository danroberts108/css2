<?php

$view = new stdClass();
$view->pageTitle = "User";

$uid = $_REQUEST['userid'];

require_once('Models/UserData.php');
require_once('Models/UserDataSet.php');

require_once('logincontroller.php');

$UserDataSet = new UserDataSet();
$UserData = $UserDataSet->fetchUser($uid)[0];

$view->user = $UserData;

require_once('Views/user.phtml');