<?php
$pageTitle = "View Workers";

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
    // Get the farmer ID from the session
    $farmer_id = $_SESSION["user"]["FID"];

    // Query to fetch workers associated with the farmer
    $query = "SELECT * FROM WORKER WHERE FID = $farmer_id"; // Assuming fid is the column in workers table
    $result = $connection->executeQuery($query);

    echo '<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class="fas fa-lock"></i>&nbsp;&nbsp;Workers List</h6>
    </div>
</div>';

    echo '<a href="./add_worker.php" class="btn btn-warning rounded-0 ml-1" type="submit"><i class="fas fa-bars"></i>&nbsp;&nbsp;Add Worker</a>';

    if ($result->num_rows > 0) {
        // Output table header
        echo '<div class="container pt-2">
                <div class="mx-2">
                <div class="table-responsive">';
        echo '<table class="table table-hover"><thead><tr><th scope="col">ID</th><th scope="col">Name</th><th scope="col">Last Name</th><th scope="col">Username</th><th scope="col">Role</th><th scope="col">Action</th></tr></thead><tbody>';

        // Output each worker's information
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' .
                htmlspecialchars($row["ID"]) .
                '</td>
                    <td>' .
                htmlspecialchars($row["NAME"]) .
                '</td>
                    <td>' .
                htmlspecialchars($row["LASTNAME"]) .
                '</td>
                    <td>' .
                htmlspecialchars($row["USERNAME"]) .
                '</td>
                    <td>' .
                htmlspecialchars($row["ROLE"]) .
                '</td>
                    <td>
                        <a href="edit_worker.php?worker_id=' .
                $row["ID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #6610f2;">
                            <span class="icon text-white" title="Edit">
                                <i class="fas fa-edit"></i>
                            </span>
                        </a>
                        <a href="delete_worker.php?worker_id=' .
                $row["ID"] .
                '" class="btn btn-sm rounded-0" style="background-color: #dc3545;">
                            <span class="icon text-white" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                        </a>
                    </td>
                  </tr>';
        }

        // Close table
        echo "</tbody></table></div></div></div></div></div>";
    } else {
        echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 mx-auto text-center">
                        <div class="p-5">
                            No workers available.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }
}

$connection->close();
?>

<?php
require_once "../includes/footer.php";
ob_end_flush();

?>
