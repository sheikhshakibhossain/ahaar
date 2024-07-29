<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('../dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");
    
    include("../session.php");
    $email = $_SESSION['email'];

    // Capture and sanitize user input
    $food_name = mysqli_real_escape_string($connect, $_POST['food_name']);
    $quantity = mysqli_real_escape_string($connect, $_POST['quantity']);
    $location = mysqli_real_escape_string($connect, $_POST['location']);
    $expire_date_time = mysqli_real_escape_string($connect, $_POST['expire_date_time']);
    $postal_code = mysqli_real_escape_string($connect, $_POST['postal_code']);
    $quantity_available = $quantity;

    // Insert data into the database
    $query = "INSERT INTO donation (food_name, quantity, location, expire_date_time, donor_email, postal_code, quantity_available) 
              VALUES ('$food_name', '$quantity', '$location', '$expire_date_time', '$email', '$postal_code', '$quantity_available')";

    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "Donation Success";
        header("Location: donor.php"); // Redirecting page after successful donation
        exit(); // No further code is executed after the redirection
    } else {
        echo "Making Donation failed!";
    }
}
?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Making Donation</title>
    <link rel="stylesheet" href="donor.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Make a Donation</div>
        <div class="content">
            <form action="make_donation.php" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Food Name</span>
                        <input type="text" name="food_name" placeholder="Enter the food name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Quantity</span>
                        <input type="number" name="quantity" placeholder="Enter the quantity" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Location</span>
                        <input type="text" name="location" placeholder="Enter the location" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Expiration Date and Time</span>
                        <input type="datetime-local" name="expire_date_time" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Postal Code</span>
                        <input type="text" name="postal_code" placeholder="Enter your Postal Code" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit Donation">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
