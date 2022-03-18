<?php

//Creates a new class for the view
$view = new stdClass();
$view->pageTitle = 'Error';

require_once('logincontroller.php');

require_once('Views/error.phtml');