<?php
$pageTitle = "View Region";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/includes/functions.php";
require_once BASE_PATH . '/classes/Connection.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {

$connection = new Connection();
$query = "SELECT * FROM region";

$result = $connection->executeQuery($query);

if ($connection->getNumRows($result) > 0) {
     echo '<div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="mx-auto">
                        <div class="p-5">';
    echo '<table class="table"><thead><tr><th scope="col">Region ID</th><th scope="col">Region State</th><th scope="col">Region Address</th><th scope="col">Temperature</th><th scope="col">Humidity</th>';
    
    while ($row = $connection->fetchRow($result)) {
        echo '<tr>';
        echo '<td>' . $row["RID"] . '</td>';
        echo '<td>' . $row["RSTATE"] . '</td>';
        echo '<td>' . $row["RADDRESS"] . '</td>';
        echo '<td>' . $row["RTEMP"] . '</td>';
        echo '<td>' . $row["RHUMIDITY"] . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
    echo '</div>
                    </div>
                </div>
            </div>
        </div>

    </div>';
} else {
    echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="p-5">
                        No regions and lands found.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
}
$connection->close();
}
?>
