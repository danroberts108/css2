<?php
//Creates a new class for the view
$view = new stdClass();
$view->pageTitle = 'Home';

require_once('logincontroller.php');

//Fetches the view for the page
require_once('Views/index.phtml');

unset($_SESSION['message']);