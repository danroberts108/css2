<?php
//Create the object for the view
$view = new stdClass();
$view->pageTitle = 'Users';

require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');

require_once('logincontroller.php');

$UserDataSet = new UserDataSet();

//Logic for when the request button is pressed
if (isset($_POST['requestFriend'])) {
    $UserDataSet->requestFriend($_SESSION['uid'], $_POST['friendID']);
}
//Logic for when the block button is pressed
if (isset($_POST['blockUser'])) {
    $UserDataSet->blockUser($_SESSION['uid'], $_POST['friendID']);
}
//Decides whether to show all users or just non friends depending on if the user is logged in or not
if (isset($_POST['search'])) {
    $searchType = array();
    if (isset($_POST['usernameCheck'])) {
        $searchType[] = "username";
    }
    if (isset($_POST['fnameCheck'])) {
        $searchType[] = 'fname';
    }
    if (isset($_POST['lnameCheck'])) {
        $searchType[] = 'lname';
    }
    $dataset = $UserDataSet->searchUser($_POST['searchTerm'], $_POST['limit'], $searchType);
}  elseif (!isset($_SESSION['login'])) {
    $dataset = $UserDataSet->fetchAllUsers();
} else {
    $dataset = $UserDataSet->fetchNonFriends($_SESSION['uid']);
}
//Sends the data set to the view
$view->dataset = $dataset;
//Fetches the view
require_once('Views/users.phtml');