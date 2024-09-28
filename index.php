<?php

require_once('dbconfig.php');
include('session.php');

$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");

// Fetch total meals donated
$count_query = "SELECT SUM(quantity) FROM donation";
$result = mysqli_query($connect, $count_query);
$meals_donated = mysqli_fetch_array($result)[0];

// Fetch number of unique recipients
$count_query = "SELECT COUNT(DISTINCT email) FROM recipient";
$result = mysqli_query($connect, $count_query);
$helped_people = mysqli_fetch_array($result)[0];

// Fetch the latest disaster alert
$alert_query = "SELECT title FROM disaster_alert ORDER BY id DESC LIMIT 1";
$alert_result = mysqli_query($connect, $alert_query);
$latest_alert = mysqli_fetch_array($alert_result)['title'];

$sql = "SELECT donation_taken.feedback, SUM(donation.quantity) AS total_quantity
            FROM donation
            INNER JOIN donation_taken ON donation.donation_id = donation_taken.donation_id
            GROUP BY donation_taken.feedback";
$chart_1 = mysqli_query($connect, $sql);

// Initialize arrays for labels and data
$labels = [];
$data = [];

// Fetch results from the query
while ($row = mysqli_fetch_assoc($chart_1)) {
    $labels[] = $row['feedback'];         // Feedback labels (Good, Rotten, Average)
    $data[] = $row['total_quantity'];     // Total quantity of donations per feedback
}

$chart2_sql = "SELECT donor.name AS donor_name,
IF(sponsors.email IS NOT NULL, 'Sponsor', 'Regular Donor') AS donor_type,
COALESCE(SUM(donation.quantity), 0) AS total_quantity
FROM donor
LEFT JOIN donation ON donor.email = donation.donor_email
LEFT JOIN sponsors ON donor.email = sponsors.email
GROUP BY donor.email";

$chart_2 = mysqli_query($connect, $chart2_sql);

// Initialize arrays for labels and data
$labels_2 = [];
$data_2 = [];

// Fetch chart_2s from the query
if ($chart_2 && mysqli_num_rows($chart_2) > 0) {
    while ($row = mysqli_fetch_assoc($chart_2)) {
        // Include both sponsors and regular donors, but exclude those with no donations
        if ($row['total_quantity'] > 0) {
            $labels_2[] = $row['donor_type'] . ' (' . $row['donor_name'] . ')';  // e.g., Sponsor (John Doe)
            $data_2[] = $row['total_quantity'];   // Total quantity of donations for that donor
        }
    }
} else {
    echo "<p>No results found from the database query.</p>";
}

?>


<!-- background: linear-gradient(135deg, #30b7e6, #3aaa3c); -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A H A A R</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Style for the floating notification button */
        .floating-btn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background-color: #ff5050;
            background: linear-gradient(135deg, #30b7e6, #3aaa3c);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .floating-btn:hover {
            background-color: #e04e4e;
        }

        .floating-btn i {
            font-size: 24px;
        }

        /* Style for the alert modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            /* background-color: #fefefe; */
            position: fixed;
            bottom: 90px;
            right: 40px;
            background: linear-gradient(135deg, #30b7e6, #3aaa3c);
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            font-size: larger;
            color: white;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .chart-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .meals-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .meals-info h3 {
            margin-bottom: 5px;
        }

        .div2 {}
    </style>
    <script>
        // Function to show alert notification
        function showAlert() {
            var alertMessage = "<?php echo htmlspecialchars($latest_alert); ?>";
            if (alertMessage) {
                var modal = document.getElementById("alertModal");
                var modalContent = document.getElementById("modalContent");
                modalContent.textContent = "Latest Alert: " + alertMessage;
                modal.style.display = "block";
            }
        }

        // Function to close the alert modal
        function closeModal() {
            var modal = document.getElementById("alertModal");
            modal.style.display = "none";
        }
    </script>
</head>

<body>
    <header>
        <div class="container">
            <h1>A H A A R</h1>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#get-involved">Get Involved</a></li>
                    <li><a href="#contact-info">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="hero">
        <div class="hero-content">
            <h2>Help End Hunger in Our Community</h2>
            <p>Donate food and make a difference today.</p>
            <button onclick="window.location.href='events.php'">Upcoming Events</button>
            <button onclick="window.location.href='sponsors.php'">Our Sponsors</button>
            <button onclick="window.location.href='#get-involved'">Get Involved</button>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>Donation Statistics</h2>
            <!-- <h4>Our mission is to end hunger in our community by facilitating food donations to recipients.</h4> -->
            <div class="stats">
                <div>
                    <canvas id="donationFeedbackChart"></canvas>
                </div>

                <div>
                    <canvas id="donationByTypeChart"></canvas>
                </div>

                <div class="chart-container">
                    <div class="meals-info">
                        <p>Carbon Emmition Reduced</p>
                    </div>
                    <canvas id="pieChart"></canvas>
                </div>

                <script>
                    const cty = document.getElementById('donationFeedbackChart').getContext('2d');
                    const donationFeedbackChart = new Chart(cty, {
                        type: 'bar', // Bar chart for comparison
                        data: {
                            labels: <?php echo json_encode($labels); ?>, // Feedback labels (Good, Rotten, Average)
                            datasets: [{
                                label: 'Total Donations (Quantity)',
                                data: <?php echo json_encode($data); ?>, // Total quantity of donations
                                backgroundColor: [
                                    'rgba(255, 206, 86, 0.9)',
                                    'rgba(75, 192, 192, 0.9)',
                                    'rgba(255, 0, 0, 0.9)'
                                ],
                                borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Feedback Rating'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Total Quantity of Donations'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Function to generate a random color
                    function generateUniqueColor() {
                        const randomColor = () => Math.floor(Math.random() * 256); // Random RGB values
                        return `rgba(${randomColor()}, ${randomColor()}, ${randomColor()}, 0.6)`; // RGBA format with opacity
                    }

                    // Create an array of unique colors based on the number of labels
                    const uniqueColors = Array.from({ length: <?php echo count($labels_2); ?> }, generateUniqueColor);

                    const ctz = document.getElementById('donationByTypeChart').getContext('2d');
                    const donationByTypeChart = new Chart(ctz, {
                        type: 'pie', // Pie chart to compare donations by type
                        data: {
                            labels: <?php echo json_encode($labels_2); ?>, // Labels: Sponsor (John Doe) or Regular Donor (Jane Doe)
                            datasets: [{
                                label: 'Total Donations (Quantity)',
                                data: <?php echo json_encode($data_2); ?>,  // Total quantity of donations for each donor
                                backgroundColor: uniqueColors, // Use dynamically generated unique colors
                                borderColor: uniqueColors.map(color => color.replace(/rgba\((\d+), (\d+), (\d+), (\d+)\)/, 'rgba($1, $2, $3, 1)')), // Corresponding border colors
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            return `${tooltipItem.label}: ${tooltipItem.raw}`; // Customize tooltip label
                                        }
                                    }
                                }
                            }
                        }
                    });

                </script>

            </div>
        </div>
    </section>

    <section id="how-it-works">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <img src="assets/images/collect.png" alt="Collect">
                    <p>Collect</p>
                </div>
                <div class="step">
                    <img src="assets/images/donate.png" alt="Donate">
                    <p>Donate</p>
                </div>
                <div class="step">
                    <img src="assets/images/distribute.png" alt="Distribute">
                    <p>Distribute</p>
                </div>
                <div class="step">
                    <img src="assets/images/support.png" alt="Support">
                    <p>Support</p>
                </div>
            </div>
        </div>
    </section>

    <section id="get-involved">
        <div class="container">
            <h2>Get Involved</h2>
            <h4>Join us in our mission by donating or participating in our events.</h4>
            <button onclick="window.location.href='recipient_login.php'">Recipient</button>
            <button onclick="window.location.href='donor_login.php'">Donor</button>
        </div>
    </section>

    <footer>
        <section id="contact-info">
            <div class="container">
                <div class="contact-info">
                    <h3>Contact Us</h3>
                    <p>Address: Dhaka, Bangladesh</p>
                    <p>Phone: (+880) 192123123</p>
                    <p>Email: info@ahaar.com</p>
                    <div class="social-media">
                        <a href="https://www.facebook.com/ahaar">Facebook</a>
                        <a href="https://www.twitter.com/ahaar">Twitter</a>
                        <a href="https://www.instagram.com/ahaar">Instagram</a>
                    </div>
                </div>
            </div>
        </section>
    </footer>

    <!-- Floating Notification Button -->
    <button class="floating-btn" onclick="showAlert()">
        <i class="bi bi-bell"></i>
    </button>

    <!-- Alert Modal -->
    <div id="alertModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalContent"></p>
        </div>
    </div>

</body>

</html>