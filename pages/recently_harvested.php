<?php
$pageTitle = "View Harvest";

// Include necessary files and initiate database connection
require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    $connection = new Connection();
    $loggedInUserFID = $_SESSION["user"]["FID"];

    $query =
        "SELECT CID, CNAME, HARVESTDATE FROM RECENTLY_HARVESTED ORDER BY CNAME DESC";
    $result = $connection->executeQuery($query);

    if ($connection->getNumRows($result) === 0) {
        echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 mx-auto text-center">
                            <div class="p-5">
                                No crops have been harvested recently.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        echo '<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class="fas fa-lock"></i>&nbsp;&nbsp;Already Harvested</h6>
    </div>
</div>';
        // Add a form with a button to clear the table
        echo '<form method="post" action="clear_harvest.php">
                <button type="submit" name="clear_table" class="btn btn-danger rounded-0 ml-1"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Harvest</button>
              </form>';
        echo '<div class="container">
                <div class="mx-2">
                    <div class="table-responsive">';
        echo '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Crop ID</th>
                            <th scope="col">Crop Name</th>
                            <th scope="col">Harvest Date</th>
                        </tr>
                    </thead>
                    <tbody>';
        while ($row = $connection->fetchRow($result)) {
            $cropId = $row["CID"];
            $cropName = $row["CNAME"];
            $harvestDate = $row["HARVESTDATE"]; // Fetch harvest_date from database

            echo "<tr>";
            echo "<td>" . $cropId . "</td>";
            echo "<td>" . $cropName . "</td>";
            echo "<td>" . date("F j, Y", strtotime($harvestDate)) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo '</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>
<?php // Include necessary files and close database connection

require_once "../includes/footer.php"; ?>
