<?php

//Redirects the user if they are not logged in
if (isset($_SESSION['login'])) {
    header("Location: register.php");
}
//Creates the object for the view
$view = new stdClass();
$view->pageTitle = 'My Friends';

require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');

require_once('logincontroller.php');

$UserDataSet = new UserDataSet();
//Logic for when the remove friend button is pressed
if (isset($_POST['removeFriend'])) {
    $UserDataSet->removeFriend($_POST['friendshipid']);
}

//Fetches all of the users friends
$dataset = $UserDataSet->fetchFriends($_SESSION['uid']);

//Sends the dataset to the view
$view->dataset = $dataset;

//Fetches the view
require_once('Views/myfriends.phtml');