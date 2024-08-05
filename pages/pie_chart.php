<?php
$pageTitle = "Pie Chart";

require_once '../helpers/constants.php';
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
?>
<div style="width: 300px; height: 300px; margin-left: 100px;"> <!-- Adjust the container size -->
    <canvas id="chartContainer" width="500" height="500"></canvas> <!-- Decrease width and height -->
</div>

<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Prepare data
    var cropCount = <?php echo isset($_SESSION['cropCount']) ? $_SESSION['cropCount'] : 0; ?>;
    var landCount = <?php echo isset($_SESSION['landCount']) ? $_SESSION['landCount'] : 0; ?>;
    var harvestedCount = <?php echo isset($_SESSION['recently_harvested_count']) ? $_SESSION['recently_harvested_count'] : 0; ?>;

    // Initialize Chart
    var ctx = document.getElementById('chartContainer').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Crops Added', 'Lands Added', 'Recently Harvested'],
            datasets: [{
                labels: ['Crops Added', 'Lands Added', 'Recently Harvested'],
                data: [cropCount, landCount, harvestedCount],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Disable responsiveness
            maintainAspectRatio: false // Disable aspect ratio
        }
    });
</script>

<?php  
require_once "../includes/footer.php";
?>
