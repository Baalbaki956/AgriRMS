<?php
$pageTitle = "Delete Crop";

require_once "../helpers/functions.php";
require_once '../helpers/constants.php';
require_once BASE_PATH . '/classes/Connection.php';

session_start();

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
    $connection = new Connection();

    $userId = $_SESSION['user']['FID'];
    $cropId = $_GET['crop_id'];

    // Delete from the referencing table (has)
    $deleteHasQuery = "DELETE FROM HAS WHERE CID = $cropId";
    $deleteHasResult = $connection->executeQuery($deleteHasQuery);

    // Check if the deletion was successful before proceeding
    if ($deleteHasResult) {
        // Delete from the referenced table (crop)
        $deleteCropQuery = "DELETE FROM CROP WHERE CID = $cropId";
        $deleteCropResult = $connection->executeQuery($deleteCropQuery);

        if ($deleteCropResult) {
            echo "Crop details deleted successfully.";
            redirectTo("view_crops.php");
        } else {
            echo "Error deleting crop details.";
        }
    } else {
        echo "Error deleting crop details from HAS table.";
    }
}



?>