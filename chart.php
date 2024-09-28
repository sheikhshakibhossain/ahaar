<?php
// Calculations
$bangladesh_daily_emissions = 4250000 * 0.1294; // 42.5 million kg CO2e
$donation_service_reduction = 1250; // 1250 kg CO2e

// Prepare data for the pie chart
$data = [
    'Daily Food Waste Emissions in Bangladesh' => $bangladesh_daily_emissions,
    'Emissions Reduced by Donation Service' => $donation_service_reduction
];

// Convert the data to JSON for use in JavaScript
$jsonData = json_encode($data);

// Calculate total and percentage
$total_emissions = $bangladesh_daily_emissions + $donation_service_reduction;
$reduction_percentage = ($donation_service_reduction / $total_emissions) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Food Waste Emissions Comparison</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
        }
        .info h3 {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <div class="info">
            <h3><?php echo number_format($donation_service_reduction, 2); ?> kg CO2e</h3>
            <p>Daily Carbon Emissions Reduced by Donation Service</p>
            <h3><?php echo number_format($reduction_percentage, 4); ?>%</h3>
            <p>Percentage of Daily Food Waste Emissions Reduced</p>
        </div>
        <canvas id="pieChart"></canvas>
    </div>

    <script>
    // Parse the PHP data
    var data = <?php echo $jsonData; ?>;

    // Prepare the data for Chart.js
    var labels = Object.keys(data);
    var values = Object.values(data);

    // Create the pie chart
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    'rgba(255, 10, 0, 0.8)', // Red for Bangladesh emissions
                    'rgba(0, 200, 0, 0.8)'  // Green for donation service reduction
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: true,
                text: 'Daily Food Waste Emissions in Bangladesh vs. Donation Service Reduction'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.round((currentValue/total) * 100000) / 1000; // Round to 3 decimal places
                        return data.labels[tooltipItem.index] + ': ' + currentValue.toLocaleString() + ' kg CO2e (' + percentage + '%)';
                    }
                }
            }
        }
    });
    </script>
</body>
</html>