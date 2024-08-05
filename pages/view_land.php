<?php
$pageTitle = "View Land";

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Include necessary files and initiate database connection
require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";

$connection = new Connection();
$loggedInUserFID = $_SESSION["user"]["FID"];

// Query to fetch lands and their information
$query = "SELECT L.LID, L.LNAME, L.LNUMBER, L.LSIZE, L.LSOILTYPE, L.LWATER, L.LDESC, L.WATER_LEFT
          FROM LAND L
          JOIN PLANTS P ON L.LID = P.LID
          WHERE P.FID = $loggedInUserFID";
$result = $connection->executeQuery($query);
?>

<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class='fas fa-lock'></i>&nbsp;&nbsp;Land List</h6>
    </div>
</div>
<?php
echo '<a href="./add_land.php" class="btn btn-warning rounded-0 ml-1" type="submit"><i class="fas fa-bars"></i>&nbsp;&nbsp;Add Land</a>';
if ($connection->getNumRows($result) > 0) {
    echo '<div class="container pt-2">
                        <div class="mx-2">
                            <div class="table-responsive">';
    echo '<table class="table table-hover">
        <thead>
        <tr><th scope="col">Land Name</th>
        <th scope="col">Land Number</th>
        <th scope="col">Size</th>
        <th scope="col">Soil Type</th>
        <th scope="col">Water</th>
        <th scope="col">Water Left</th>
        <th scope="col">Description</th>
        <th scope="col">Action</th></tr>
        </thead><tbody>';
    while ($row = $connection->fetchRow($result)) {
        $landId = $row["LID"]; // Assigning $landId from fetched row

        $totalWaterAvailable = $row["LWATER"];

        // Query to fetch crops and their water intake for the current land
        $queryCrop = "SELECT C.CID, C.CNAME, C.CDESC, C.CPLANTSEASON, C.CHARVESTSEASON, C.WATER_INTAKE
                      FROM CROP C
                      JOIN HAS H ON C.CID = H.CID
                      WHERE H.LID = $landId";
        $resultCrop = $connection->executeQuery($queryCrop);

        // Check if there are crops for the current land
        if ($connection->getNumRows($resultCrop) > 0) {
            // Calculate total water intake for all crops
            $totalWaterIntake = 0;
            while ($cropRow = $connection->fetchRow($resultCrop)) {
                $cropWaterIntake = $cropRow["WATER_INTAKE"];
                $totalWaterIntake += $cropWaterIntake;
            }

            $remainingWater = $totalWaterAvailable - $totalWaterIntake;

            // Update WATER_LEFT in the LAND table for the current land
            $updateQuery = "UPDATE LAND SET WATER_LEFT = $remainingWater WHERE LID = $landId";
            $connection->executeQuery($updateQuery);

            echo "<tr>";
            echo "<td>" . $row["LNAME"] . "</td>";
            echo "<td>" . $row["LNUMBER"] . "</td>";
            echo "<td>" . $row["LSIZE"] . "</td>";
            echo "<td>" . $row["LSOILTYPE"] . "</td>";
            echo "<td>" . $row["LWATER"] . "</td>";
            echo "<td>" . $remainingWater . "</td>"; // Output the updated water left
            echo "<td>" . $row["LDESC"] . "</td>";
            echo "<td>";
            echo '<a href="edit_land.php?land_id=' .
                $row["LID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #6610f2;">
                                <span class="icon text-white" title="Edit">
                                  <i class="fas fa-edit"></i>
                                </span>
                              </a>';
            echo '&nbsp;<a href="delete_land.php?land_id=' .
                $row["LID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #dc3545;">
                                <span class="icon text-white" title="Delete">
                                  <i class="fas fa-trash-alt"></i>
                                </span>
                              </a>';
            echo "</td>";
            echo "</tr>";
        } else {
            // Handle case where no crops are found for the current land
            echo "<tr>";
            echo "<td>" . $row["LNAME"] . "</td>";
            echo "<td>" . $row["LNUMBER"] . "</td>";
            echo "<td>" . $row["LSIZE"] . "</td>";
            echo "<td>" . $row["LSOILTYPE"] . "</td>";
            echo "<td>" . $row["LWATER"] . "</td>";
            echo "<td>" . $totalWaterAvailable . "</td>"; // Output the original water left
            echo "<td>" . $row["LDESC"] . "</td>";
            echo "<td>";
            echo '<a href="edit_land.php?land_id=' .
                $row["LID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #6610f2;">
                                <span class="icon text-white" title="Edit">
                                  <i class="fas fa-edit"></i>
                                </span>
                              </a>';
            echo '&nbsp;<a href="delete_land.php?land_id=' .
                $row["LID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #dc3545;">
                                <span class="icon text-white" title="Delete">
                                  <i class="fas fa-trash-alt"></i>
                                </span>
                              </a>';
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</tbody></table>";
    echo '</div>
        </div>

    </div>';
} else {
    // Display a message if no lands are found
    echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
    <div class="col-lg-6 mx-auto text-center">
    <div class="p-5">
    No lands found for the logged-in user.
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>';
}
?>
</div>

<?php require_once "../includes/footer.php";
?>
