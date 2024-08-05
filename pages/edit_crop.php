<?php  
$pageTitle = "Edit Crops";

require_once "../includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/classes/Connection.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
    $cropName = $cropDesc = $plantSeason = $harvestSeason = "";

$connection = new Connection();
$userId = $_SESSION['user']['FID'];
$cropId = $_GET['crop_id'];

$landIdQuery = "SELECT LID FROM PLANTS WHERE FID = $userId;";
$landIdResult = $connection->executeQuery($landIdQuery);

if ($landIdResult !== null) {
    $landRow = $connection->fetchRow($landIdResult);

    if ($landRow !== null) {
        $landId = $landRow['LID'];

        $query = "SELECT C.CID, C.CNAME, C.CDESC, C.CPLANTSEASON, C.CHARVESTSEASON
                  FROM CROP C
                  JOIN HAS H ON C.CID = H.CID
                  WHERE H.LID = $landId AND C.CID = $cropId LIMIT 1;";

        $result = $connection->executeQuery($query);

        if ($row = $connection->fetchRow($result)) {
            $cropName = $row['CNAME'];
            $cropDesc = $row['CDESC'];
            $plantSeason = $row['CPLANTSEASON'];
            $harvestSeason = $row['CHARVESTSEASON'];
        }
    }
}
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
                                    <h1 class="h4 text-gray-900 mb-4">Edit Crop!</h1>
                                </div>
                                <form class="user" method="post" action="save_crop.php">
                                        <div class="form-group">
                                            <label for="crop_name">Crop Name:</label>
                                            <input type="text" class="form-control" id="crop_name" name="crop_name" 
                                                placeholder="Crop Name" value="<?php echo $cropName; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="crop_desc">Crop Description:</label>
                                            <textarea class="form-control" id="crop_desc" name="crop_desc" placeholder="Crop Description..."><?php echo $cropDesc; ?></textarea>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="plant_season">Planting Season:</label>
                                                <input type="text" class="form-control" id="plant_season" name="plant_season" 
                                                placeholder="Planting Season" value="<?php echo $plantSeason; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="harvest_season">Harvest Season:</label>
                                                <input type="text" class="form-control" id="harvest_season" name="harvest_season" placeholder="Harvest Season" value="<?php echo $harvestSeason; ?>">
                                            </div>
                                        </div>
                                       <br>
                                    <input type="hidden" name="crop_id" value="<?php echo $cropId; ?>"></input>
                                    <!-- <input href="" class="btn btn-primary btn-user btn-block" type="submit" value="Save"> -->

                                    <!-- </input> -->
                                    <button type="submit" class="btn btn-success mt-4 rounded-0">
                                      <span class="icon text-white">
                                        <i class="fas fa-check"></i>
                                      </span>
                                      <span class="text">Save Changes</span>
                                    </button>
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
?>