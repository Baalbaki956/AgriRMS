<?php
$pageTitle = "Add Worker";

ob_start();
require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/classes/Connection.php';

$connection = new Connection();

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
    if (isset($_POST['submit'])) {
        $wname = sanitizeString($_POST['wname']);
        $wlname = sanitizeString($_POST['wlname']);
        $username = sanitizeString($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = sanitizeString($_POST['role']);

        // Get farmer ID from session
        $fid = $_SESSION['user']['FID'];

        // Validate inputs (you can add more validation as needed)
        if (empty($wname) || empty($wlname) || empty($username) || empty($_POST['password'])) {
            echo "All fields are required.";
        } else {
            // Insert worker into database including FID
            $query = "INSERT INTO WORKER (NAME, LASTNAME, USERNAME, PASSWORD, FID, ROLE) VALUES ('$wname', '$wlname', '$username', '$password', '$fid', '$role')";
            $result = $connection->executeQuery($query);

            if ($result) {
                echo "Worker added successfully.";
                redirectTo("view_workers.php");
            } else {
                echo "Error adding worker: ";
            }
        }
    }
}
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Worker</h1>
                        </div>
                        <form class="user" method="post" action="add_worker.php">
                            <div class="form-group">
                                <input type="text" class="form-control" id="wname" name="wname" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="wlname" name="wlname" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                            <label class="label label-default" for="role">Role:</label>
                            <select class="form-select" name="role" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="harvesting">Harvesting</option>
                                <option value="planting">Planting</option>
                            </select><br>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Add Worker">
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
