<?php

require_once('dbconfig.php');
include('session.php');

$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");
$count_query = "SELECT SUM(quantity) FROM donation";
$result = mysqli_query($connect, $count_query);
$meals_donated = mysqli_fetch_array($result)[0];

$count_query = "SELECT COUNT(DISTINCT email) FROM recipient";
$result = mysqli_query($connect, $count_query);
$helped_people = mysqli_fetch_array($result)[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A H A A R</title>
    <link rel="stylesheet" href="assets/styles.css">
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
            <h4>Our mission is to end hunger in our community by facilitating food donations to recipient.</h4>
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

    <!-- <section id="success-stories">
        <div class="container">
            <h2>Success Stories</h2>
            <div class="stories">
                <div class="story">
                    <img src="story1.jpg" alt="Story 1">
                    <p>John's family received meals during a tough time, helping them get back on their feet.</p>
                </div>
                <div class="story">
                    <img src="story2.jpg" alt="Story 2">
                    <p>Anna was able to recipient and make a significant impact in her community.</p>
                </div>
            </div>
        </div>
    </section> -->

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

</body>
</html>
