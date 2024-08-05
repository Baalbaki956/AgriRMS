<?php
$pageTitle = "Save Land";

require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/classes/Connection.php";
require_once BASE_PATH . "/helpers/functions.php";

$connection = new Connection();

if (isPostRequested()) {
    $landName = sanitizeString($_POST["land_name"]);
    $landNumber = sanitizeString($_POST["land_number"]);
    $landDesc = sanitizeString($_POST["land_desc"]);
    $landSoil = sanitizeString($_POST["land_soil"]);
    $landWater = sanitizeString($_POST["land_water"]);
    $landSize = sanitizeString($_POST["land_size"]);
    $landName = sanitizeString($_POST["land_name"]);
    $region_id = sanitizeString($_POST["region"]);

    // Insert data into LAND table
    $insertQuery = "INSERT INTO LAND (RID, LNAME, LNUMBER, LSIZE, LSOILTYPE, LWATER, LDESC)
                    VALUES ('$region_id', '$landName', '$landNumber', '$landSize', '$landSoil', '$landWater', '$landDesc')";

    $insertResult = $connection->executeQuery($insertQuery);

    if ($insertResult) {
        // Get the ID of the newly inserted land
        $landID = $connection->getInsertId();

        // Get the ID of the logged-in user from the session
        $userID = $_SESSION["user"]["FID"];

        // Insert data into PLANTS table
        $insertPlantsQuery = "INSERT INTO PLANTS (FID, LID) VALUES ('$userID', '$landID')";
        $insertPlantsResult = $connection->executeQuery($insertPlantsQuery);

        if ($insertPlantsResult) {
            echo "Land and Plants added successfully!";
            redirectTo("view_land.php");
        } else {
            echo "Error adding plants: " . mysqli_error($connection->connect());
        }
    } else {
        echo "Error adding land: " . mysqli_error($connection->connect());
    }
} else {
    echo "Form not submitted.";
}

require_once "../includes/footer.php";
?>
