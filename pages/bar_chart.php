<?php
$pageTitle = "Bar Chart";

require_once '../helpers/constants.php';
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
?>
<canvas id="chartContainer" style="height: 300px; width: 100%;"></canvas>

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
        type: 'bar',
        data: {
            labels: ['Crops Added', 'Lands Added', 'Recently Harvested'], // Move labels here
            datasets: [{
                label: 'Counts',
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php  
require_once "../includes/footer.php";
?>
