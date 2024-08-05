<?php
session_start();

require_once "../helpers/constants.php";
require_once BASE_PATH . "/classes/Connection.php";
require_once BASE_PATH . "/helpers/functions.php";

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connection = new Connection();

        // Get the worker ID and new role from the POST request
        $worker_id = intval($_POST["worker_id"]);
        $new_role = sanitizeString($_POST["role"]);

        // Update the worker's role in the database
        $query = "UPDATE WORKER SET ROLE = '$new_role' WHERE ID = $worker_id";
        if ($connection->executeQuery($query)) {
            echo "Worker role updated successfully.";
        } else {
            echo "Error updating worker role: " . $connection->error;
        }

        // Redirect back to the workers list
        redirectTo("./view_workers.php", 3);
    } else {
        echo "Invalid request method.";
    }
}

?>
