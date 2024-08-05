<?php
$pageTitle = "Edit Worker";

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
    // Get worker ID from the query string
    if (isset($_GET["worker_id"])) {
        $worker_id = intval($_GET["worker_id"]);

        // Fetch worker data
        $query = "SELECT * FROM WORKER WHERE ID = $worker_id";
        $result = $connection->executeQuery($query);

        if ($result->num_rows > 0) {
            $worker = $result->fetch_assoc();
        } else {
            echo "Worker not found.";
            exit();
        }
    } else {
        echo "Invalid worker ID.";
        exit();
    }
}

$connection->close();
?>

<div class="container">
    <h2>Edit Worker</h2>
    <form action="update_worker.php" method="post">
        <input type="hidden" name="worker_id" value="<?php echo htmlspecialchars(
            $worker["ID"]
        ); ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars(
                $worker["NAME"]
            ); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars(
                $worker["LASTNAME"]
            ); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars(
                $worker["USERNAME"]
            ); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="supervisor" <?php if (
                    $worker["ROLE"] == "supervisor"
                ) {
                    echo "selected";
                } ?>>Supervisor</option>
                <option value="harvesting" <?php if (
                    $worker["ROLE"] == "harvesting"
                ) {
                    echo "selected";
                } ?>>Harvesting</option>
                <option value="planting" <?php if (
                    $worker["ROLE"] == "planting"
                ) {
                    echo "selected";
                } ?>>Planting</option>
                <!-- Add other roles as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>

<?php
require_once "../includes/footer.php";
ob_end_flush();


?>
