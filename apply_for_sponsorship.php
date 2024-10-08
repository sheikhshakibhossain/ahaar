<?php

include('session.php');

require_once('dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");

if (isset($_SESSION['email']) && $_SESSION['user_type'] == 'donor') {
    $email = $_SESSION['email'];
} else {
    echo "<script>alert('Please login first');</script>";
    echo "<script>window.location.href = 'donor_login.php';</script>";
    exit();
}

$check = "SELECT COUNT(*) FROM sponsors WHERE email = '$email'";
$check_result = mysqli_query($connect, $check);
$check_count = mysqli_fetch_array($check_result)[0];

if ($check_count > 0) {
    echo "You're already a sponsor!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $description = mysqli_real_escape_string($connect, $_POST['description']);

    $query_ = "SELECT COUNT(*) FROM sponsors_application WHERE email = '$email' AND status = 'Queued'";
    $result_ = mysqli_query($connect, $query_);
    $count = mysqli_fetch_array($result_)[0];

    if ($count > 0) {
        echo "<script>alert('Application already exists');</script>";
        echo "<script>window.location.href = 'sponsors.php';</script>";
    } else {
        // Insert data into database
        $query = "INSERT INTO sponsors_application(email, description, status) 
                VALUES ('$email', '$description', 'Queued')";

        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "Application Success";
            echo "<script>alert('Application submitted!');</script>";
            echo "<script>window.location.href = 'sponsors.php';</script>";
        } else {
            echo "<script>alert('Application failed!');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Sponsor Application</title>
    <link rel="stylesheet" href="assets/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Sponsor Application</div>
        <div class="content">
            <form action="apply_for_sponsorship.php" method="POST">
                <div class="user-details">

                    <div class="input-box">
                        <span class="details">
                            1. Why you wanna be a Sponsor? <br>
                            2. How often can you Donate? <br>
                            (daily/some days in a week/weekly/monthly)
                        </span>
                        <input type="text" name="description" placeholder="Enter your description" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit Application">
                </div>
            </form>
        </div>
    </div>
</body>
</html>