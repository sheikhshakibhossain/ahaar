<?php

include("../session.php");
require_once('../dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

$email = $_SESSION['email'];

// Fetch recipient details
$query_ = "SELECT name, phone, address FROM recipient WHERE email = '$email'";
$result_ = mysqli_query($connect, $query_);
$row = mysqli_fetch_array($result_);

$name = $row['name'];
$phone = $row['phone'];
$address = $row['address'];

// Fetch donations taken by the recipient
$donations_query = "SELECT d.food_name, d.quantity, d.location, d.expire_date_time 
                    FROM donation_taken dt 
                    JOIN donation d ON dt.donation_id = d.donation_id 
                    WHERE dt.recipient_email = '$email'";
$donations_result = mysqli_query($connect, $donations_query);

$donations = [];
while ($donation_row = mysqli_fetch_assoc($donations_result)) {
    $donations[] = $donation_row;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="food_list.css">
    <title>Recipient's Profile</title>
</head>
<body>

    <!-- profile -->
    <div class="profile-container">
        <div class="img"></div>
        <h3> <?php echo htmlspecialchars($name); ?> </h3>
        <h6>Recipient</h6>
        
        <div class="contact-info">
            <br>
            <p><i class="bi bi-envelope-fill"></i> <?php echo $email; ?> </p>
            <br>
            <p><i class="bi bi-telephone-fill"></i> <?php echo $phone; ?> </p>
            <br>
            <p><i class="bi bi-geo-alt-fill"></i> <?php echo $address; ?> </p>
        </div>
        
        <div class="previous-donations">
            <h4>
                <a href="../events.php"> <button>Find Events</button></a>
                <a href="../logout.php"><button>Logout</button></a>
            </h4>
        </div>

    </div>

    <!-- donation history -->
    <div class="container">
        <div class="donated-foods">
            <h2>Received Donations</h2>
            <div class="food-list">
                <?php if (empty($donations)): ?>
                    <p>No donations received.</p>
                <?php else: ?>
                    <?php foreach ($donations as $donation): ?>
                        <div class="food-item">
                            <h3><?php echo $donation['food_name']; ?></h3>
                            <p>Location: <?php echo $donation['location']; ?></p>
                            <p>Expires on: <?php echo $donation['expire_date_time']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
