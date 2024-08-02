<?php

include("../session.php");
include("../check_user.php");

require_once('../dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

$email = $_SESSION['email'];
$query_ = "SELECT name, phone, address, gender FROM donor WHERE email = '$email'";
$result_ = mysqli_query($connect, $query_);
$row = mysqli_fetch_array($result_);

$name = $row['name'];
$phone = $row['phone'];
$address = $row['address'];
$gender = $row['gender'];

// Fetch the donations made by the user
$donations_query = "SELECT food_name, quantity, location, expire_date_time FROM donation WHERE donor_email = '$email'";
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
    <title>Donor's Profile</title>
</head>
<body>

    <!-- profile -->
    <div class="profile-container">

        <?php
            if ($gender == "Female") {
                $photo_name = "../assets/images/girl.jpg";
            } else {
                $photo_name = "profile.svg";
            }   
        ?>
        
        <div class="img" style="background-image: url('<?php echo $photo_name; ?>');"></div>
        <h3> <?php echo $name; ?> </h3>
        <h6>Donor</h6>
        
        <div class="contact-info">
            <br>
            <p><i class="bi bi-envelope-fill"></i> <?php echo $email; ?>  </p>
            <br>
            <p><i class="bi bi-telephone-fill"></i> <?php echo $phone; ?>  </p>
            <br>
            <p><i class="bi bi-geo-alt-fill"></i> <?php echo $address; ?>  </p>
        </div>
        
        <div class="previous-donations">
            <h4>
                <a href="make_donation.php"> <button>Donate Now</button></a>
                <a href="../events.php"> <button>Event</button></a>
            </h4>
        </div>

        <div class="logout">
            <a href="../logout.php"><button>Logout</button></a>
        </div>

    </div>

    <!-- donation history -->
    <div class="container">
        <div class="donated-foods">
            <h2>Donated Foods</h2>
            <div class="food-list">
                <?php if (empty($donations)): ?>
                    <p>No donations found.</p>
                <?php else: ?>
                    <?php foreach ($donations as $donation): ?>
                        <div class="food-item">
                            <h3><?php echo htmlspecialchars($donation['food_name']); ?></h3>
                            <p>Quantity: <?php echo htmlspecialchars($donation['quantity']); ?></p>
                            <p>Location: <?php echo htmlspecialchars($donation['location']); ?></p>
                            <p>Expires on: <?php echo htmlspecialchars($donation['expire_date_time']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
