<?php
$pageTitle = "Add Crop";

ob_start();
require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/helpers/functions.php";
require_once BASE_PATH . "/classes/Connection.php";

$connection = new Connection();

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    $cropName = $cropDesc = $plantSeason = $harvestSeason = "";
    $cropNameError = $plantSeasonError = $harvestSeasonError = "";

    $farmer_id = $_SESSION["user"]["FID"];

    $landsQuery = "SELECT L.LID, L.LNAME FROM LAND L JOIN PLANTS P ON L.LID = P.LID WHERE P.FID = $farmer_id";
    $landsResult = $connection->executeQuery($landsQuery);

    if (isPostRequested()) {
        $cropName = sanitizeString($_POST["crop_name"]);
        $cropDesc = sanitizeString($_POST["crop_desc"]);
        $plantDate = sanitizeString($_POST["plant_date"]);
        $harvestDate = sanitizeString($_POST["harvest_date"]);
        $waterIntake = (int) sanitizeString($_POST["water_intake"]);

        // Calculate harvest duration in months
        $plantDateTime = new DateTime($plantDate);
        $harvestDateTime = new DateTime($harvestDate);
        $interval = $plantDateTime->diff($harvestDateTime);
        $duration = $interval->format("%m"); // Number of months between plant and harvest

        // Calculate harvest season based on the number of months
        $harvestSeasonValue = calculateHarvestSeason($duration);

        if ($harvestSeasonValue === false) {
            echo "Invalid harvest season.";
            exit(); // Handle error gracefully
        }

        // Insert crop into CROP table
        $cropQuery = "INSERT INTO CROP (CNAME, CDESC, CPLANTSEASON, CHARVESTSEASON, WATER_INTAKE) VALUES ('$cropName', '$cropDesc', '$plantDate', '$harvestDate', '$waterIntake')";
        $cropResult = $connection->executeQuery($cropQuery);

        if ($cropResult) {
            $cropId = $connection->getInsertId();

            // Select land ID from selected option
            $landId = sanitizeString($_POST["selected_land"]);

            // Insert into HAS table
            $hasQuery = "INSERT INTO HAS (LID, CID, HSEASON, HDURATION) VALUES ('$landId', '$cropId', $harvestSeasonValue, $duration)";
            $hasResult = $connection->executeQuery($hasQuery);

            if ($hasResult) {
                redirectTo("./view_crops.php");
            } else {
                echo "Failed to associate crop with land.";
            }
        } else {
            echo "Failed to insert crop information.";
        }

        $connection->close();
    }
}

// Function to calculate harvest season based on number of months
function calculateHarvestSeason($months)
{
    // Define ranges for seasons in terms of months
    $seasons = [
        "Spring" => [3, 4, 5],
        "Summer" => [6, 7, 8],
        "Fall" => [9, 10, 11],
        "Winter" => [12, 1, 2], // Wrap around for January and February
    ];

    // If $months is 0, then it's considered as immediate harvest (same season)
    if ($months == 0) {
        // Assume the current month and return the corresponding season
        $currentMonth = (int) date("n"); // Get current month as integer (1-12)
        foreach ($seasons as $season => $monthsRange) {
            if (in_array($currentMonth, $monthsRange)) {
                // Return the corresponding integer value for the season
                return getSeasonValue($season);
            }
        }
    } else {
        // Calculate season based on the given number of months till harvest
        foreach ($seasons as $season => $monthsRange) {
            if (in_array($months % 12, $monthsRange)) {
                // Return the corresponding integer value for the season
                return getSeasonValue($season);
            }
        }
    }

    return false; // Invalid season
}

// Function to get integer value for season
function getSeasonValue($season)
{
    switch ($season) {
        case "Spring":
            return 3;
        case "Summer":
            return 6;
        case "Fall":
            return 9;
        case "Winter":
            return 12;
        default:
            return false;
    }
}
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Crop!</h1>
                        </div>
                        <form class="user" method="post" action="add_crop.php">
                            <div class="form-group">
                                <label for="crop_name">Crop Name:</label>
                                <input type="text" class="form-control" id="crop_name" name="crop_name" placeholder="Crop Name">
                            </div>

                            <div class="form-group">
                                <label for="crop_desc">Crop Description:</label>
                                <textarea class="form-control" id="crop_desc" name="crop_desc" placeholder="Crop Description..."></textarea>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="plant_date">Planting Date:</label>
                                    <input type="date" class="form-control" id="plant_date" name="plant_date">
                                </div>

                                <div class="col-sm-6">
                                    <label for="harvest_date">Harvesting Date:</label>
                                    <input type="date" class="form-control" id="harvest_date" name="harvest_date">
                                </div>
                            </div>

                            <div class="form-outline" data-mdb-input-init>
                                <label for="water_intake">Water Intake:</label>
                                <input type="number" id="water_intake" class="form-control" name="water_intake" placeholder="enter water intake in leters"/>
                            </div>

                            <div class="form-group">
                                <label for="selected_land">Select Land:</label>
                                <select class="form-control" id="selected_land" name="selected_land">
                                    <?php // Populate the dropdown with land options

while ($landRow = $connection->fetchRow($landsResult)) {
                                        echo "<option value=\"$landRow[LID]\">$landRow[LNAME]</option>";
                                    } ?>
                                </select>
                            </div>
                            <br>
                            <input href="" class="btn btn-primary btn-user btn-block" type="submit" value="Add Crop">
                            <hr>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "../includes/footer.php";
ob_end_flush();


?>
