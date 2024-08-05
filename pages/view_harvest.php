<?php
$pageTitle = "View Harvest";

// Include necessary files and initiate database connection
require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";

$remainingTime = 0;

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    $connection = new Connection();
    $loggedInUserFID = $_SESSION["user"]["FID"];

    $query = "SELECT C.CID, C.CNAME, C.CPLANTSEASON, C.CHARVESTSEASON, H.HSEASON, H.HDURATION, L.LID, L.LNAME, L.LNUMBER,
            GREATEST(0, ROUND((UNIX_TIMESTAMP(C.CHARVESTSEASON) - UNIX_TIMESTAMP(NOW())) / (30 * 24 * 60 * 60))) AS remainingTime
          FROM PLANTS P
          JOIN HAS H ON P.LID = H.LID
          JOIN CROP C ON H.CID = C.CID
          JOIN LAND L ON P.LID = L.LID
          WHERE P.FID = $loggedInUserFID
          ORDER BY remainingTime ASC";

    $result = $connection->executeQuery($query);

    if ($connection->getNumRows($result) === 0) {
        echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 mx-auto text-center">
                            <div class="p-5">
                                No crops found for the logged-in user and associated lands.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        echo '<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class="fas fa-lock"></i>&nbsp;&nbsp;To Harvest</h6>
    </div>
</div>';
        echo '<div class="container">
                        <div class="mx-2">
                            <div class="table-responsive">';
        echo '<table class="table table-hover"><thead><tr><th scope="col">Land ID</th><th scope="col">Land Number</th><th scope="col">Land Name</th><th scope="col">Crop Name</th><th scope="col">Plant Date</th><th scope="col">Harvest Date</th><th scope="col">Till Harvest (Months)</th>
                    </tr></thead><tbody>';
        while ($row = $connection->fetchRow($result)) {
            $currentDate = strtotime(date("Y-m-d"));
            $plantDate = strtotime($row["CPLANTSEASON"]);
            $harvestDate = strtotime($row["CHARVESTSEASON"]);

            $remainingTime = max(
                0,
                round(($harvestDate - $currentDate) / (30 * 24 * 60 * 60))
            ); // Round to the nearest month

            echo "<tr>";
            echo "<td>" . $row["LID"] . "</td>";
            echo '<td><a style="text-decoration: underline;" href="info_land.php?land_id=' .
                $row["LID"] .
                '">' .
                $row["LNUMBER"] .
                "</a></td>";

            echo "<td>" . $row["LNAME"] . "</td>";
            echo "<td>" . $row["CNAME"] . "</td>";
            echo "<td>" . $row["CPLANTSEASON"] . "</td>";
            echo "<td>" . $row["CHARVESTSEASON"] . "</td>";
            echo "<td>" . $remainingTime . "</td>";

            if ($row["remainingTime"] == 0) {
                //echo '<form method="get" action="harvest.php">';
                //echo '<td><input type="hidden" name="cropId" value="' . $row["CID"] . '"><input class="btn btn-success" type="submit" name="harvest" value="Harvest"></td>';
                //echo '</form>';

                echo '<td><a href="harvest.php?cropId=' .
                    $row["CID"] .
                    '" class="btn btn-sm rounded-0" style="background-color: #6610f2;">
                            <span class="icon text-white" title="Harvest">
                              <i class="fas fa-hammer"></i>
                            </span>
                          </a>';
            } else {
                echo "<td></td>";
            }

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
