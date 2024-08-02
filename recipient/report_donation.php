<?php

include('../session.php');
include('../check_user.php');

require_once('../dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    
    $donation_id = $_GET['id'];
    $email = $_SESSION['email'];

    $description = mysqli_real_escape_string($connect, $_POST['description']);

    $query_ = "UPDATE `donation_taken` SET `feedback`= '$description' WHERE donation_id = '$donation_id' and recipient_email = '$email'";
    $result_ = mysqli_query($connect, $query_);

    if ($result_) {
        echo "<script>alert('Thank you for your feedback!');</script>";
        echo "<script>window.location.href = 'recipient.php';</script>";
    } else {

        echo "<script>alert('Failed!');</script>";
        echo "<script>window.location.href = 'recipient.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Donation Feedback</title>
    <link rel="stylesheet" href="../assets/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Donation Feedback</div>
        <div class="content">
            <form action="report_donation.php?id=<?php echo $_GET['id'];?>" method="POST">
                <div class="user-details">

                    <div class="input-box">
                        <span class="details">
                            * How was the food? <br>
                            (Good/Bad/Rotten)
                        </span>
                        <input type="text" name="description" placeholder="Write your Feedback" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit Feedback">
                </div>
            </form>
        </div>
    </div>
</body>
</html>