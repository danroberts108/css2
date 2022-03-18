<?php

if (isset($_SESSION['login'])) {
    header("Location: register.php");
}

require_once('Models/UserDataSet.php');
require_once('Models/UserData.php');
//Creates class for the view
$view = new stdClass();
$view->pageTitle = 'My Profile';

require_once('logincontroller.php');

//Creates new UserDataSet object
$UserDataSet = new UserDataSet();

$user = $UserDataSet->fetchUser($_SESSION['uid']);

//Logic for if the save button is pressed
if (isset($_POST['save'])) {
    $newData = array(
        "userid" => $_POST['userid'],
        "username" => $_POST['username'],
        "email" => $_POST['email'],
        "photo" => $user->getPhoto(),
        "fname" => $_POST['fname'],
        "lname" => $_POST['lname'],
        "lat" => $_POST['lat'],
        "lon" => $_POST['lon']
    );

    $newUserData = new UserData($newData);

    $UserDataSet->updateUserData($newUserData);
}

//Logic for if a new photo is uploaded
if (isset($_POST['photo'])) {
    //Checks if the photo was uploaded okay
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $dir = "./images/";
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileName = $_FILES['picture']['name'];
        $fileSize = $_FILES['picture']['size'];
        $fileType = $_FILES['picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $imageSize = getimagesize($_FILES['picture']['tmp_name']);

        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $newFilename = $_SESSION['uid'] . "." . $fileExtension;

        //Checks if the file is of the allowed file types
        if(in_array($fileExtension, $allowedFiles)) {

            $fullPath = $dir . $newFilename;

            //Checks the image is inbetween the allowed dimensions
            if (!($imageSize[0] > 160 || $imageSize[0] < 80 || $imageSize[1] > 160 || $imageSize[1] < 80)) {
                //Runs logic if the file gets uploaded correctly
                if (move_uploaded_file($fileTmpPath, $fullPath)) {
                    //Sets the message type to success and sets the message to a success message
                    $_SESSION['messageType'] = "success";
                    $_SESSION['message'] = "Success!";
                    //Changes the path to the new profile image
                    $UserDataSet->newProfileImage($_SESSION['uid'], $newFilename);
                } else {
                    $_SESSION['messageType'] = "danger";
                    $_SESSION['message'] = "Error uploading image";
                }
            } else {
                $_SESSION['messageType'] = "danger";
                $_SESSION['message'] = "Image too big or small. Needs to be between 80x80px and 160x160px.";
            }


        } else {
            $_SESSION['messageType'] = "danger";
            $_SESSION['message'] = 'File type not accepted. Accepted types: png, jpg, jpeg';
        }

    } else {
        $_SESSION['messageType'] = "danger";
        $_SESSION['message'] = "File could not be uploaded.";
    }

}
//Sends the user details to the view
$view->user = $user;
//Fetches the required view
require_once('Views/profile.phtml');