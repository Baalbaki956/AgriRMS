<?php
$pageTitle = "Delete Land";

require_once '../includes/header.php';
require_once '../classes/Connection.php';
require_once '../helpers/functions.php';

$connection = new Connection();
$loggedInUserFID = $_SESSION['user']['FID']; // Assuming you have the user's ID in the session

if (isset($_GET['land_id'])) {
    $landId = $_GET['land_id'];

    // Check if the logged-in user has added crops to the land in the HAS table
    // $cropCountQuery = "SELECT COUNT(*) AS crop_count
                       //FROM PLANTS
                       //WHERE LID = $landId";
    $cropCountQuery = "SELECT COUNT(*) AS crop_count
                   FROM HAS
                   WHERE LID = $landId";
    $cropCheckResult = $connection->executeQuery($cropCountQuery);
    $cropCount = $connection->fetchRow($cropCheckResult)['crop_count'];

    if ($cropCount > 0) {
        // Display the message that the land has associated crops in the HAS table
        ?>
        <script type="text/javascript">
            alert("Cannot delete land, there is crops linked to it!.");
            window.location.href = "view_land.php";
        </script>
        <?php
    } else {
        // If no crops in the HAS table, proceed with deleting the land
        $deletePlantsQuery = "DELETE FROM PLANTS WHERE LID = $landId AND FID = $loggedInUserFID";
        $deletePlantsResult = $connection->executeQuery($deletePlantsQuery);

        if ($deletePlantsResult) {
            // Delete the land only if associated plants are deleted successfully
            $deleteLandQuery = "DELETE FROM LAND WHERE LID = $landId";
            $deleteLandResult = $connection->executeQuery($deleteLandQuery);

            if ($deleteLandResult) {
                echo "Land and associated plants deleted successfully!";
                redirectTo("view_land.php");
            } else {
                echo "Error deleting land: " . mysqli_error($connection->connect());
            }
        } else {
            echo "Error deleting associated plants: " . mysqli_error($connection->connect());
        }
    }
}

require_once '../includes/footer.php';
?>
