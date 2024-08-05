<?php
$pageTitle = "Save Crops";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/helpers/constants.php';
require_once BASE_PATH . "/helpers/functions.php";
require_once BASE_PATH . '/classes/Connection.php';

session_start();

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
    $connection = new Connection();

$userId = $_SESSION['user']['FID'];
$cropId = $_POST['crop_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cropName = sanitizeString($_POST["crop_name"]);
    $cropDesc = sanitizeString($_POST["crop_desc"]);
    $plantSeason = sanitizeString($_POST["plant_season"]);
    $harvestSeason = sanitizeString($_POST["harvest_season"]);

    if (!empty($cropName) && !empty($cropDesc) && !empty($plantSeason) && !empty($harvestSeason)) {
        $landIdQuery = "SELECT LID FROM PLANTS WHERE FID = $userId;";
        $landIdResult = $connection->executeQuery($landIdQuery);

        if ($landIdResult !== null) {
            $landRow = $connection->fetchRow($landIdResult);

            if ($landRow !== null) {
                $landId = $landRow['LID'];
                $updateQuery = "UPDATE CROP 
                                SET CNAME = '$cropName', CDESC = '$cropDesc', 
                                    CPLANTSEASON = '$plantSeason', CHARVESTSEASON = '$harvestSeason'
                                WHERE CID = $cropId";

                $updateResult = $connection->executeQuery($updateQuery);

                if ($updateResult) {
                    echo "Crop details updated successfully.";
                    redirectTo("view_crops.php");
                } else {
                    echo "Error updating crop details.";
                }
            }
        }
    } else {
        echo "Please fill the empty fields.";
    }
}
}


?>
