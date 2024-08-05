<?php
require_once "../helpers/constants.php";
require_once "../helpers/functions.php";
require_once BASE_PATH . "/classes/Connection.php";

$connection = new Connection();

if (isset($_GET["control_id"])) {
    $controlId = intval($_GET["control_id"]);

    // Ensure controlId is valid
    if ($controlId > 0) {
        // Prepare delete query
        $query = "DELETE FROM CONTROL WHERE ID = $controlId";

        if ($connection->executeQuery($query)) {
            redirectTo("view_controls.php", 3);
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Invalid control ID.";
    }
} else {
    echo "Control ID not provided.";
}

$connection->close();
?>
