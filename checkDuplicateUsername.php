<?php

require_once("Models/UserOps.php");

header('Content-Type: text/plain');

$username = $_REQUEST['uname'];
$UserOps = new UserOps();

if ($UserOps->checkDuplicate($username) == true) {
    echo 'true';
} else {
    echo 'false';
}

?>