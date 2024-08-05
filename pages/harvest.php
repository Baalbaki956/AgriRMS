<?php
session_start();
ob_start();
require_once '../helpers/constants.php';
require_once BASE_PATH . '/helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/includes/sidebar.php';
require_once BASE_PATH . '/includes/topbar.php';
require_once BASE_PATH . '/classes/Connection.php';
require_once BASE_PATH . '/helpers/functions.php';

$connection = new Connection();
$loggedInUserFID = $_SESSION['user']['FID'];

if (isset($_GET['cropId'])) {
    $cropId = $_GET['cropId'];

    // Query the database to get crop details
    $query = "SELECT CID, CNAME, CHARVESTSEASON
              FROM CROP
              WHERE CID = $cropId
              LIMIT 1";
    $result = $connection->executeQuery($query);
    $cropDetails = $connection->fetchRow($result);

    if ($cropDetails) {
        // Insert into RecentlyHarvested table
        $insertQuery = "INSERT INTO RECENTLY_HARVESTED (CID, CNAME, HarvestDate) 
                        VALUES ({$cropDetails['CID']}, '{$cropDetails['CNAME']}', '{$cropDetails['CHARVESTSEASON']}')";
        $insertResult = $connection->executeQuery($insertQuery);

        if ($insertResult) {
            // Delete associated rows from the HAS table
            $deleteHasQuery = "DELETE FROM HAS WHERE CID = $cropId";
            $deleteHasResult = $connection->executeQuery($deleteHasQuery);

            if ($deleteHasResult) {
                // Delete the harvested crop from the CROP table
                $deleteQuery = "DELETE FROM CROP WHERE CID = $cropId";
                $deleteResult = $connection->executeQuery($deleteQuery);

                if ($deleteResult) {
                    // Redirect to the recently harvested page
                    redirectTo("recently_harvested.php");
                } else {
                    echo 'Failed to delete the harvested crop from the CROP table.';
                }
            } else {
                echo 'Failed to delete associated rows from the HAS table.';
            }
        } else {
            echo 'Failed to insert into RecentlyHarvested table.';
        }
    } else {
        echo 'Crop details not found.';
    }
} else {
    echo 'Crop ID not provided.';
}

require_once BASE_PATH . '/includes/footer.php';
ob_end_flush();
?>
