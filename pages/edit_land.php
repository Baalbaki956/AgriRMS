<?php
$pageTitle = "Edit Lands";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . '/classes/Connection.php';
require_once BASE_PATH . '/helpers/functions.php';

$connection = new Connection();

// Check if the form is submitted
if (isGetRequested()) {
    // Get the land ID from the form submission
    $landID = sanitizeString($_GET['land_id']);

    // Fetch land details for the given land ID
    $query = "SELECT * FROM LAND WHERE LID = '$landID'";
    $result = $connection->executeQuery($query);

    // Check if a land with the given ID is found
    if ($connection->getNumRows($result) > 0) {
        $landDetails = $connection->fetchRow($result);

        // Display the form with the fetched land details for editing
        ?>

        <!-- Your HTML form for editing land details goes here -->
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-7">
                            <!-- Go back (Dashboard) -->
                       
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edit Land!</h1>
                                </div>
                                <form method="post" action="update_land.php">
                                    <div class="form-group">
                                    <!-- Add your form fields with current land details for editing -->
                                        <input class="form-control" type="hidden" name="land_id" value="<?php echo $landDetails['LID']; ?>">
                                        <label for="land_number">Land Number:</label>
                                        <input type="text" class="form-control" id="land_number" name="land_number" value="<?php echo $landDetails['LNUMBER']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="land_desc">Land Description:</label>
                                        <textarea class="form-control" id="land_desc" name="land_desc"><?php echo $landDetails['LDESC']; ?></textarea>
                                    </div>
                                    <label for="land_soil">Soil Type:</label>
                                    <input type="text" class="form-control" id="land_soil" name="land_soil" value="<?php echo $landDetails['LSOILTYPE']; ?>">
                                    
                                    <label for="land_water">Water:</label>
                                    <input type="text" class="form-control" id="land_water" name="land_water" value="<?php echo $landDetails['LWATER']; ?>">
                                    
                                    <label for="land_size">Size:</label>
                                    <input type="text" class="form-control" id="land_size" name="land_size" value="<?php echo $landDetails['LSIZE']; ?>">
                                    
                                    <!-- Add other fields as needed -->
                                    <br><br>
                                    <button type="submit" class="btn btn-success mt-4 rounded-0">
                                      <span class="icon text-white">
                                        <i class="fas fa-check"></i>
                                      </span>
                                      <span class="text">Save Changes</span>
                                    </button>
                                    <!-- <button type="submit" class="btn btn-primary btn-user btn-block">Update Land</button> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        // Display an error message if the land ID is not valid
        echo '<div class="container"><div class="alert alert-danger">Invalid Land ID</div></div>';
    }
} else {
    // Display an error message if the form is not submitted
    echo '<div class="container"><div class="alert alert-danger">Invalid Request</div></div>';
}

// Include necessary files and close database connection
require_once '../includes/footer.php';
?>
