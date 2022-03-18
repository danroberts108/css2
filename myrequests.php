<?php
//Redirects the user if they aren't logged in
if (isset($_SESSION['login'])) {
    header("Location: register.php");
}

//Creates a new object for the view
$view = new stdClass();
$view->pageTitle = "My Requests";

require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');

require_once('logincontroller.php');

$UserDataSet = new UserDataSet();
//Logic for when the accept button is pressed
if (isset($_POST['acceptRequest'])) {
    $UserDataSet->acceptRequest($_POST['friendshipid']);
}
//Logic for when the delete request button is pressed
if (isset($_POST['declineRequest'])) {
    $UserDataSet->deleteRequest($_POST['friendshipid']);
}
//Logic for when the block request button is pressed
if (isset($_POST['blockRequest'])) {
    $UserDataSet->blockRequest($_POST['friendshipid']);
}

if (isset($_POST['deleteRequest'])) {
    $UserDataSet->deleteRequest($_POST['friendshipid']);
}
//Fetches all the requests for the given user
$dataset = $UserDataSet->fetchRequests($_SESSION['uid']);
$datasetReq = $UserDataSet->fetchSentRequests($_SESSION['uid']);
//Sends the dataset to the view
$view->dataset = $dataset;
$view->datasetReq = $datasetReq;
//Fetches the view
require_once('Views/myrequests.phtml');