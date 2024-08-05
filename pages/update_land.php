<?php
$pageTitle = "Update Land";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/classes/Connection.php';
require_once BASE_PATH . '/helpers/functions.php';

$connection = new Connection();

// Check if the form is submitted
if (isPostRequested()) {
    // Get the form data
    $landID = sanitizeString($_POST['land_id']);
    $landNumber = sanitizeString($_POST['land_number']);
    $landDesc = sanitizeString($_POST['land_desc']);
    $landSoil = sanitizeString($_POST['land_soil']);
    $landWater = sanitizeString($_POST['land_water']);
    $landSize = sanitizeString($_POST['land_size']);

    // Update data in the LAND table
    $updateQuery = "UPDATE LAND 
                    SET LNUMBER = '$landNumber', 
                        LDESC = '$landDesc', 
                        LSOILTYPE = '$landSoil', 
                        LWATER = '$landWater', 
                        LSIZE = '$landSize'
                    WHERE LID = '$landID'";
    
    $updateResult = $connection->executeQuery($updateQuery);

    if ($updateResult) {
        echo "Land updated successfully!";
        redirectTo("view_land.php");
    } else {
        echo "Error updating land: " . mysqli_error($connection->connect());
    }
} else {
    // Display an error message if the form is not submitted
    echo '<div class="container"><div class="alert alert-danger">Invalid Request</div></div>';
}

// Include necessary files and close database connection
require_once '../includes/footer.php';
?>
