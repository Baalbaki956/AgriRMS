<?php
$pageTitle = "View Controls";

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
}

$query = "SELECT * FROM CONTROL";
$result = $connection->executeQuery($query);

echo '<div class="mx-auto">
    <div class="ml-0">
        <h6 class="p-3 bg-primary text-white"><i class="fas fa-lock"></i>&nbsp;&nbsp;Controls List</h6>
    </div>
</div>';

echo '<a href="add_control.php" class="btn btn-warning rounded-0 ml-1" type="submit"><i class="fas fa-bars"></i>&nbsp;&nbsp;Add Control</a>';

if ($result->num_rows > 0) {
    echo '<div class="container pt-2">
            <div class="mx-2">
            <div class="table-responsive">';
    echo '<table class="table table-hover"><thead><tr><th scope="col">ID</th><th scope="col">Type</th><th scope="col">Description</th><th scope="col">Land Name</th><th scope="col">Date Added</th><th scope="col">Action</th></tr></thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' .
            htmlspecialchars($row["ID"]) .
            '</td>
                <td>' .
            htmlspecialchars($row["TYPE"]) .
            '</td>
                <td>' .
            htmlspecialchars($row["DESCRIPTION"]) .
            '</td>
                <td>' .
            htmlspecialchars($row["LNAME"]) .
            '</td>
                <td>' .
            htmlspecialchars($row["DATE_ADDED"]) .
            '</td>
                <td>
                    <a href="delete_control.php?control_id=' .
            $row["ID"] .
            '" class="btn btn-sm rounded-0" style="background-color: #dc3545;">
                        <span class="icon text-white" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </span>
                    </a>
                </td>
              </tr>';
    }

    echo "</tbody></table></div></div></div></div>";
} else {
    echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="p-5">
                        No controls available.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
}

$connection->close();
?>

<?php
require_once "../includes/footer.php";
ob_end_flush();


?>
