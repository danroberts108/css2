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
$view->duplicate = false;
$view->fname = null;
$view->lname = null;
$view->username = null;
$view->email = null;
//Logic for when the register button is pressed
if (isset($_POST["registerButton"])) {
    //New userops object
    $userops = new UserOps();

    //Creates random longitude and latitude for user
    $random = new RandomFloat();
    $lon = 0;
    $lat = 0;

    //Creates the user using the function in the UserOps class
    $result = $userops->registerUser($_POST["username"], $_POST["email"], "defaultPhoto.png", $_POST["password"], $lat, $lon, $_POST["fname"], $_POST["lname"]);

    if (!$result) {
        $view->duplicate = true;
        $view->fname = $_POST['fname'];
        $view->lname = $_POST['lname'];
        $view->username = $_POST['username'];
        $view->email = $_POST['email'];
    }

}
//Fetches the view
require_once('Views/register.phtml');