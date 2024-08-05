<?php
session_start();
require_once "../helpers/functions.php";
require_once "../helpers/constants.php";
require_once BASE_PATH . "/classes/Connection.php";

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    $connection = new Connection();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clear_table"])) {
        $clearQuery = "TRUNCATE TABLE RECENTLY_HARVESTED";
        $connection->executeQuery($clearQuery);
    }
    redirectTo("./recently_harvested.php");
}
?>
