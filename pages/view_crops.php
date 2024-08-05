<?php
$pageTitle = "View Crops";

require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";
require_once BASE_PATH . "/helpers/functions.php";

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    $connection = new Connection();

    $loggedInUserFID = $_SESSION["user"]["FID"];
    $landId = "";

    $landIdQuery = "SELECT LID FROM PLANTS WHERE FID = $loggedInUserFID;";
    $landIdResult = $connection->executeQuery($landIdQuery);

    echo '<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class="fas fa-lock"></i>&nbsp;&nbsp;Available Crop</h6>
    </div>
</div>';

    echo '<a href="./add_crop.php" class="btn btn-warning rounded-0 ml-1" type="submit"><i class="fas fa-bars"></i>&nbsp;&nbsp;Add Crop</a>';

    if ($landIdResult !== null) {
        $landRow = $connection->fetchRow($landIdResult);

        if ($landRow !== null) {
            $landId = $landRow["LID"];

            $query = "SELECT C.CID, C.CNAME, C.CDESC, C.CPLANTSEASON, C.CHARVESTSEASON, C.WATER_INTAKE
            FROM CROP C
            JOIN HAS H ON C.CID = H.CID
            WHERE H.LID = $landId";

            $result = $connection->executeQuery($query);

            // Rest of your code to display crops
            if ($connection->getNumRows($result) > 0) {
                // Display the table
                echo '<div class="container pt-2">
                <div class="mx-2">
                <div class="table-responsive">';
                echo '<table class="table table-hover"><thead><tr><tr><th scope="col">Crop ID</th><th scope="col">Crop Name</th><th scope="col">Crop Description</th><th scope="col">Plant Date</th><th scope="col">Harvest Date</th><th scope="col">Water Intake</th><th scope="col">Action</th>
                </tr></thead><tbody>';

                while ($row = $connection->fetchRow($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["CID"] . "</td>";
                    echo "<td>" . $row["CNAME"] . "</td>";
                    echo "<td>" . $row["CDESC"] . "</td>";
                    echo "<td>" . $row["CPLANTSEASON"] . "</td>";
                    echo "<td>" . $row["CHARVESTSEASON"] . "</td>";
                    echo "<td>" . $row["WATER_INTAKE"] . "L" . "</td>";
                    //echo '<td><form method="post" action="edit_crop.php">';
                    //echo '<input type="hidden" name="crop_id" value="' . $row["CID"] . '">';
                    //echo '<button type="submit" class="btn btn-secondary btn-sm">Edit</button>';
                    //echo '</form></td>';

                    echo '<td><a href="edit_crop.php?crop_id=' .
                        $row["CID"] .
                        '" class="btn btn-sm rounded-0" style="background-color: #6610f2;">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a>';

                    echo '&nbsp;<a href="delete_crop.php?crop_id=' .
                        $row["CID"] .
                        '" class="btn btn-sm rounded-0" style="background-color: #dc3545;">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>';

                    //echo '<td><form method="post" action="delete_crop.php">';
                    //echo '<input type="hidden" name="crop_id" value="' . $row["CID"] . '">|&nbsp;&nbsp;&nbsp;';
                    //echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                    //echo '</form></td>';
                    echo "</td></tr>";
                }
                echo "</tbody></table>";
                echo '</div>
                </div>

                </div>';
            } else {
                // Display a message if no crops are found
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
            }
        } else {
            // Display an error message if $landRow is null
            echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
            <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
            <div class="col-lg-6 mx-auto text-center">
            <div class="p-5">
            You haven\'t acquired a land. Please acquire a land before adding crops.
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>';
        }
    } else {
        // Display an error message and optionally redirect
        echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
        <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
        <div class="col-lg-6 mx-auto text-center">
        <div class="p-5">
        Error: Unable to retrieve land information.
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
    }
    $connection->close();
}

require_once "../includes/footer.php";
