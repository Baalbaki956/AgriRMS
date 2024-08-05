<?php
$pageTitle = "Dashboard";

require_once "../includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";

// require_once ROOT . "../includes/topbar.php";
require_once CURRENT_PATH . "/functions.php";

if (!isset($_SESSION["user"])) {
    redirectPage("../index.php", 3);
} else {
    if ($_SESSION["user"]) {
        $loggedInUserFID = $_SESSION["user"]["FID"];
    } else {
        $admin = $_SESSION["admin"]["ID"];
    }

    require_once BASE_PATH . "/includes/header.php";
    require_once BASE_PATH . "/classes/Connection.php";
    $connection = new Connection();

    $landIdQuery = "SELECT LID FROM PLANTS WHERE FID = $loggedInUserFID;";
    $landIdResult = $connection->executeQuery($landIdQuery);
    $result = "";

    if ($landIdResult !== null) {
        $landRow = $connection->fetchRow($landIdResult);

        if ($landRow !== null) {
            $landId = $landRow["LID"];

            $query = "SELECT COUNT(*) AS cropCount
                      FROM CROP C
                      JOIN HAS H ON C.CID = H.CID
                      WHERE H.LID = $landId";

            $queryLandCount = "SELECT COUNT(*) AS landCount, GROUP_CONCAT(L.LNAME SEPARATOR ', ') AS landNames
                               FROM LAND L
                               JOIN PLANTS P ON L.LID = P.LID
                               WHERE P.FID = $loggedInUserFID";

            $result = $connection->executeQuery($query);
            $row = $connection->fetchRow($result);

            $resultLandCount = $connection->executeQuery($queryLandCount);
            $rowLandCount = $connection->fetchRow($resultLandCount);

            $landNames = $rowLandCount["landNames"];

            $_SESSION["cropCount"] = isset($row["cropCount"])
                ? $row["cropCount"]
                : 0;
            $_SESSION["landCount"] = isset($rowLandCount["landCount"])
                ? $rowLandCount["landCount"]
                : 0;

            // Query to get count of recently harvested crops
            $queryRecentlyHarvestedCount = "SELECT COUNT(*) AS recentlyHarvestedCount
                                            FROM RECENTLY_HARVESTED";
            $resultRecentlyHarvested = $connection->executeQuery(
                $queryRecentlyHarvestedCount
            );
            $rowRecentlyHarvested = $connection->fetchRow(
                $resultRecentlyHarvested
            );
            $recentlyHarvestedCount = isset(
                $rowRecentlyHarvested["recentlyHarvestedCount"]
            )
                ? $rowRecentlyHarvested["recentlyHarvestedCount"]
                : 0;
            $_SESSION["recently_harvested_count"] = $recentlyHarvestedCount;

            $queryWorkersCount = "SELECT COUNT(*) AS workerCount FROM WORKER";
            $resultWorkersCount = $connection->executeQuery($queryWorkersCount);
            $rowWorkersCount = $connection->fetchRow($resultWorkersCount);
            $workerCount = isset($rowWorkersCount["workerCount"])
                ? $rowWorkersCount["workerCount"]
                : 0;
            $_SESSION["worker_count"] = $workerCount;

            $queryWorkersCountRolePlanting = "SELECT COUNT(*) AS workerCountRolePlanting
                         FROM WORKER
                         WHERE role = 'planting'";
            $resultWorkersCountRolePlanting = $connection->executeQuery(
                $queryWorkersCountRolePlanting
            );
            $rowWorkersCountRolePlanting = $connection->fetchRow(
                $resultWorkersCountRolePlanting
            );
            $workerCountRolePlanting = isset(
                $rowWorkersCountRolePlanting["workerCountRolePlanting"]
            )
                ? $rowWorkersCountRolePlanting["workerCountRolePlanting"]
                : 0;
            $_SESSION["worker_count_role_planting"] = $workerCountRolePlanting;

            $queryWorkersCountRoleHarvesting = "SELECT COUNT(*) AS workerCountRoleHarvesting
                         FROM WORKER
                         WHERE role = 'harvesting'";
            $resultWorkersCountRoleHarvesting = $connection->executeQuery(
                $queryWorkersCountRoleHarvesting
            );
            $rowWorkersCountRoleHarvesting = $connection->fetchRow(
                $resultWorkersCountRoleHarvesting
            );
            $workerCountRoleHarvesting = isset(
                $rowWorkersCountRoleHarvesting["workerCountRoleHarvesting"]
            )
                ? $rowWorkersCountRoleHarvesting["workerCountRoleHarvesting"]
                : 0;
            $_SESSION[
                "worker_count_role_harvesting"
            ] = $workerCountRoleHarvesting;

            $queryWorkersCountRoleSupervisor = "SELECT COUNT(*) AS workerCountRoleSupervisor
                         FROM WORKER
                         WHERE role = 'supervisor'";
            $resultWorkersCountRoleSupervisor = $connection->executeQuery(
                $queryWorkersCountRoleSupervisor
            );
            $rowWorkersCountRoleSupervisor = $connection->fetchRow(
                $resultWorkersCountRoleSupervisor
            );
            $workerCountRoleSupervisor = isset(
                $rowWorkersCountRoleSupervisor["workerCountRoleSupervisor"]
            )
                ? $rowWorkersCountRoleSupervisor["workerCountRoleSupervisor"]
                : 0;
            $_SESSION[
                "worker_count_role_supervisor"
            ] = $workerCountRoleSupervisor;
        }
        // Harvesting
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

        <!-- Custom Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Crops Added</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if (isset($row) && $row !== null) {
                                    echo $row["cropCount"];
                                } else {
                                    echo "0";
                                } ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-leaf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Card Example for Harvests Added -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Recently Harvested</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo isset($recentlyHarvestedCount)
                                    ? $recentlyHarvestedCount
                                    : "0"; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tractor fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Card Example for Workers Added -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Workers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo isset($workerCount)
                                    ? $workerCount
                                    : "0"; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tractor fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Lands Added</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if (
                                    isset($rowLandCount) &&
                                    $row !== null
                                ) {
                                    echo $rowLandCount["landCount"];
                                } else {
                                    echo "0";
                                } ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-atlas fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Lands Available Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Lands Available
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if (
                                    isset($rowLandCount) &&
                                    $rowLandCount !== null
                                ): ?>
                                    <?php echo htmlspecialchars(
                                        $rowLandCount["landCount"]
                                    ); ?>
                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </div>
                            <div class="text-xs mt-1">
                                <?php if (
                                    isset($landNames) &&
                                    $landNames !== null
                                ): ?>
                                    <ul class="pl-3">
                                        <?php
                                        $landNamesArray = explode(
                                            ",",
                                            $landNames
                                        );

                                        foreach ($landNamesArray as $landName) {
                                            echo "<li>" .
                                                htmlspecialchars(
                                                    trim($landName)
                                                ) .
                                                "</li>";
                                        }
                                        ?>
                                    </ul>
                                <?php else: ?>
                                    Land Names: None
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Card Example  Roles -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Workers Supervising</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo isset($workerCountRoleSupervisor)
                                    ? $workerCountRoleSupervisor
                                    : "0"; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-atlas fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Workers Planting</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo isset($workerCountRolePlanting)
                                    ? $workerCountRolePlanting
                                    : "0"; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-atlas fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Workers Harvesting</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo isset($workerCountRoleHarvesting)
                                    ? $workerCountRoleHarvesting
                                    : "0"; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-atlas fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
<!-- /.container-fluid -->
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="./logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<?php require_once BASE_PATH . "/includes/footer.php";
?>
