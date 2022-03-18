<?php
//Redirects the user if they arent logged in
if (isset($_SESSION['login'])) {
    header("Location: index.php");
}

require_once('Models/UserOps.php');
require_once('Models/RandomFloat.php');
//Creates object for the view
$view = new stdClass();
$view->pageTitle = 'Register';

$view->dbMessage = "";
$view->loginError = false;
//Logic for when the register button is pressed
if (isset($_POST["registerButton"])) {
    //New userops object
    $userops = new UserOps();

    //Creates random longitude and latitude for user
    $random = new RandomFloat();
    $lon = $random->rfloat(-90, 90, 6);
    $lat = $random->rfloat(-10, 10, 6);

    //Creates the user using the function in the UserOps class
    $result = $userops->registerUser($_POST["username"], $_POST["email"], "defaultPhoto.png", $_POST["password"], $lat, $lon, $_POST["fname"], $_POST["lname"]);

}
//Fetches the view
require_once('Views/register.phtml');