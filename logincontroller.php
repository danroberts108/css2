<?php
session_start();

require_once('Models/UserOps.php');

//Logic for when the login button is pressed
if (isset($_POST['loginbutton'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Attempts to log the user in
    if ($username != "" && $password != "") {
        $UserOps = new UserOps();
        $userid = $UserOps->loginUser($username, $password);
    }
    else
    {
        $_SESSION['message'] = "Username or password blank. Please try again.";
    }
}

//Logic for when the logout button is pressed
if (isset($_POST["logoutbutton"])) {
    unset($_SESSION["login"]);
    unset($_SESSION["uid"]);
    session_destroy();
    header("Location: index.php");
}