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
            <h2>About Us</h2>
            <h4>Our mission is to end hunger in our community by facilitating food donations to recipients.</h4>
            <div class="stats">
                <div>
                    <h3><?php echo $meals_donated; ?></h3>
                    <p>Meals Donated</p>
                </div>
                <div>
                    <h3><?php echo $helped_people; ?></h3>
                    <p>Families Helped</p>
                </div>
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
