<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Food Donation System</h1>
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
            <button onclick="window.location.href='#donate'">Donate Now</button>
            <button onclick="window.location.href='#get-involved'">Get Involved</button>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>Our mission is to end hunger in our community by facilitating food donations and volunteer work.</p>
            <div class="stats">
                <div>
                    <h3>10,000+</h3>
                    <p>Meals Donated</p>
                </div>
                <div>
                    <h3>5,000+</h3>
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
                    <img src="assets/collect.png" alt="Collect">
                    <p>Collect</p>
                </div>
                <div class="step">
                    <img src="assets/donate.png" alt="Donate">
                    <p>Donate</p>
                </div>
                <div class="step">
                    <img src="assets/distribute.png" alt="Distribute">
                    <p>Distribute</p>
                </div>
                <div class="step">
                    <img src="assets/support.png" alt="Support">
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
                    <p>Anna was able to volunteer and make a significant impact in her community.</p>
                </div>
            </div>
        </div>
    </section> -->

    <section id="get-involved">
        <div class="container">
            <h2>Get Involved</h2>
            <p>Join us in our mission by volunteering or participating in our events.</p>
            <button onclick="window.location.href='#volunteer'">Volunteer</button>
            <button onclick="window.location.href='events.php'">Upcoming Events</button>
        </div>
    </section>

    <footer>
        <section id="contact-info">
        <div class="container">
            <div class="contact-info">
                <h3>Contact Us</h3>
                <p>Address: 1100 Wari, Dhaka, Bangladesh</p>
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

    <script src="scripts.js"></script>
</body>
</html>
