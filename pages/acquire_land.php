<?php  
$pageTitle = "Acquire Land";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . '/classes/Connection.php';
require_once BASE_PATH . '/helpers/functions.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
}

$connection = new Connection();
if (isPostRequested()) {
    $fid = $_POST['FID'];
    $lid = $_POST['LID'];

    $query = "INSERT INTO PLANTS (FID, LID) VALUES ('$fid', '$lid')";

    try {
        $result = $connection->executeQuery($query);
        redirectTo("../index.php");
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo '<div class="col-xl-10 col-lg-12 col-md-9 mx-auto">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 mx-auto text-center">
                                <div class="p-5">
                                    Duplicate entry error: This record already exists.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } finally {
        $connection->close();
    }
}
?>