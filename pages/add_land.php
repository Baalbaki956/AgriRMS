<?php
$pageTitle = "Add Land";

require_once "../helpers/constants.php";
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/classes/Connection.php";
require_once BASE_PATH . "/helpers/functions.php";

$connection = new Connection();
$result = "";

$query = "SELECT RSTATE, RID FROM REGION;";
$result = $connection->executeQuery($query);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection->connect()));
}
?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Land!</h1>
                        </div>
                        <form class="user" method="post" action="<?php echo HOST; ?>/pages/save_land.php">
                            <div class="form-group">
                                <label for="land_name">Land Name:</label>
                                <input type="text" class="form-control" id="land_name" name="land_name"
                                placeholder="Land Name">
                            </div>

                            <div class="form-group">
                                <label for="land_number">Number:</label>
                                <input type="text" class="form-control" id="land_number" name="land_number"
                                placeholder="Land Number">
                            </div>

                            <div class="form-group">
                                <label for="land_desc">Description:</label>
                                <textarea class="form-control" id="land_desc" name="land_desc" placeholder="Land Description..."></textarea>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="land_soil">Soil Type:</label>
                                    <input type="text" class="form-control" id="land_soil" name="land_soil"
                                    placeholder="Soil Type">
                                </div>
                                <div class="col-sm-6">
                                    <label for="land_water">Water:</label>
                                    <input type="text" class="form-control" id="land_water" name="land_water" placeholder="Water">
                                </div>
                                <br><br><br><br>
                                <div class="col-sm-6">
                                    <label for="land_size">Size:</label>
                                    <input type="text" class="form-control" id="land_size" name="land_size" placeholder="Size">
                                </div>

                                <br><br><br><br>
                                <div class="col-sm-6">
                                <label for="region">Regions:</label>
                                <select class="form-control" id="region" name="region">
                                <?php while (
                                    $row = $connection->fetchRow($result)
                                ) {
                                    echo "<option value=\"$row[RID]\">$row[RSTATE]</option>";
                                } ?>
                                </select>
                            </div>
                            </div>
                            <br>
                            <input href="" class="btn btn-primary btn-user btn-block" type="submit" value="Add Land">
                        </input>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once "../includes/footer.php";
?>
