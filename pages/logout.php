<?php
require_once '../helpers/constants.php';
require_once BASE_PATH . '/helpers/functions.php';

session_start();
$_SESSION = array();

session_destroy();

redirectTo("../index.php");
exit();
?>