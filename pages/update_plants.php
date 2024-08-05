<?php
$pageTitle = "Update Plants";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/classes/Connection.php';
require_once BASE_PATH . '/helpers/functions.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {

$connection = new Connection();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $fid = $_POST['fid'];
    $lid = $_POST['lid'];

    // Check if the combination already exists
    $checkQuery = "SELECT * FROM PLANTS WHERE FID = $fid AND LID = $lid";
    $result = $connection->executeQuery($checkQuery);

    if ($connection->getNumRows($result) == 0) {
        // Insert a new row into the PLANTS table
        $insertQuery = "INSERT INTO PLANTS (FID, LID) VALUES ($fid, $lid)";
        $connection->executeQuery($insertQuery);
    } else {
        // Handle the case where the combination already exists
        echo "The selected land is already acquired by the farmer.";
    }

    // Redirect back to the page displaying available lands
    header('Location: dashboard.php');
    exit();
} else {
    // If the form is not submitted, redirect to the home page or display an error message
    header('Location: index.php');
    exit();
}
}
?>
