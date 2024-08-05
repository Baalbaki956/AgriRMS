<?php
$pageTitle = "Add Control";

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

$lands = [];
$query = "SELECT * FROM LAND";
$result = $connection->executeQuery($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lands[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = sanitizeString($_POST["type"]);
    $description = sanitizeString($_POST["description"]);
    $land_id = intval($_POST["land_id"]);

    // Ensure land_id is not zero or invalid
    if ($land_id > 0) {
        $query = "INSERT INTO CONTROL (TYPE, DESCRIPTION, LNAME) VALUES ('$type', '$description', (SELECT LNAME FROM LAND WHERE LID = $land_id))";
        if ($connection->executeQuery($query)) {
            echo "Control record added successfully.";
            redirectTo("view_controls.php", 3);
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Invalid land selected.";
    }
}

$connection->close();
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Control</h1>
                        </div>
    <form action="add_control.php" method="post">
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="land_id">Land Name</label>
            <select class="form-control" id="land_id" name="land_id" required>
                <option value="">Select Land</option>
                <?php foreach ($lands as $land): ?>
                    <option value="<?php echo $land[
                        "LID"
                    ]; ?>"><?php echo htmlspecialchars(
    $land["LNAME"]
); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Control</button>
    </form>
</div>

<?php
require_once "../includes/footer.php";
ob_end_flush();


?>
