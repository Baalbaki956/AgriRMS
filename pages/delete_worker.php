<?php
$pageTitle = "Delete Worker";

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
require_once "../helpers/functions.php";
require_once '../helpers/constants.php';
require_once BASE_PATH . '/classes/Connection.php';

// Start output buffering
ob_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo "no user logged.";
    //redirectPage('../index.php', 3);
} else {
    $connection = new Connection();

    $farmerId = $_SESSION['user']['FID'];
    $workerId = $_GET['worker_id'];

    $query = "DELETE FROM WORKER WHERE ID = $workerId AND FID = $farmerId";
    $res = $connection->executeQuery($query);

    // Check if the deletion was successful before proceeding
    if ($res) {
        redirectTo("view_workers.php");
    } else {
        
    }
    echo "Error deleting worker: " . mysqli_error($connection->getCon());   

    // Close connection
    $connection->close();
}

// End output buffering and flush
ob_end_flush();
?>
