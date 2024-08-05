<?php
$pageTitle = "Land Info";

require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";

$connection = new Connection();

if (isset($_GET["land_id"])) {
    $landId = intval($_GET["land_id"]);

    // Fetch land details
    $landQuery = "SELECT L.LID, L.LNAME, L.LNUMBER, L.LSIZE, L.LSOILTYPE, L.LWATER, L.LDESC, L.WATER_LEFT
                  FROM LAND L
                  WHERE L.LID = $landId";
    $landResult = $connection->executeQuery($landQuery);
    $landDetails = $connection->fetchRow($landResult);

    if ($landDetails) {
        // Fetch associated crops for the specified land
        $cropsQuery = "SELECT C.CID, C.CNAME, C.CPLANTSEASON, C.CHARVESTSEASON
                       FROM HAS H
                       JOIN CROP C ON H.CID = C.CID
                       WHERE H.LID = $landId";
        $cropsResult = $connection->executeQuery($cropsQuery);

        // Fetch associated controls for the specified land
        $controlsQuery = "SELECT C.ID, C.TYPE, C.DESCRIPTION, C.DATE_ADDED
                          FROM CONTROL C
                          WHERE C.LNAME = (SELECT LNAME FROM LAND WHERE LID = $landId)";
        $controlsResult = $connection->executeQuery($controlsQuery);

        // Display land details
        echo '<div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                    <div class="mx-auto">
                        <div class="p-5">';
        echo "<h2>Land Details</h2>";
        echo "<p>Land ID: " . htmlspecialchars($landDetails["LID"]) . "</p>";
        echo "<p>Land Name: " .
            htmlspecialchars($landDetails["LNAME"]) .
            "</p>";
        echo "<p>Land Number: " .
            htmlspecialchars($landDetails["LNUMBER"]) .
            "</p>";
        echo "<p>Land Size: " .
            htmlspecialchars($landDetails["LSIZE"]) .
            "</p>";
        echo "<p>Soil Type: " .
            htmlspecialchars($landDetails["LSOILTYPE"]) .
            "</p>";
        echo "<p>Water: " . htmlspecialchars($landDetails["LWATER"]) . "</p>";
        echo "<p>Water Left: " .
            htmlspecialchars($landDetails["WATER_LEFT"]) .
            "</p>";
        echo "<p>Description: " .
            htmlspecialchars($landDetails["LDESC"]) .
            "</p>";

        // Display associated crops
        echo "<h2>Associated Crops</h2>";
        echo '<table class="table">
                <tr>
                    <th>Crop ID</th>
                    <th>Crop Name</th>
                    <th>Plant Season</th>
                    <th>Harvest Season</th>
                </tr>';

        while ($crop = $connection->fetchRow($cropsResult)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($crop["CID"]) . "</td>";
            echo "<td>" . htmlspecialchars($crop["CNAME"]) . "</td>";
            echo "<td>" . htmlspecialchars($crop["CPLANTSEASON"]) . "</td>";
            echo "<td>" . htmlspecialchars($crop["CHARVESTSEASON"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Display associated controls
        echo "<h2>Associated Controls</h2>";
        echo '<table class="table">
                <tr>
                    <th>Control ID</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date Added</th>
                </tr>';

        while ($control = $connection->fetchRow($controlsResult)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($control["ID"]) . "</td>";
            echo "<td>" . htmlspecialchars($control["TYPE"]) . "</td>";
            echo "<td>" . htmlspecialchars($control["DESCRIPTION"]) . "</td>";
            echo "<td>" . htmlspecialchars($control["DATE_ADDED"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo '</div>
                    </div>
            </div>
        </div>
    </div>';
    } else {
        echo "Land not found.";
    }
} else {
    echo "Land ID not provided.";
}

require_once "../includes/footer.php";
?>
