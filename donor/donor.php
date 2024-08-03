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

// Fetch the latest disaster alert
$alert_query = "SELECT warning_text FROM warning_table WHERE user_email = '$email' ORDER BY id DESC LIMIT 1";
$alert_result = mysqli_query($connect, $alert_query);
$latest_alert = mysqli_fetch_array($alert_result)['warning_text'];

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Style for the floating notification button */
        .floating-btn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background-color: #ff5050;
            background: linear-gradient(135deg, #523aaa, #e66565);
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
            margin-bottom: 10;
        }
        .floating-btn:hover {
            background-color: #e04e4e;
        }
        .floating-btn i {
            font-size: 24px;
            line-height: 1; /* This ensures the icon is vertically centered */
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
            position: fixed;
            bottom: 90px;
            right: 40px;
            background: linear-gradient(135deg, #523aaa, #e66565);
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
                modalContent.innerHTML = "<b>Message from Admin:</b> " + alertMessage + ".<br><br><b>Note:</b> Admin can ban you in case of similar mistakes ever happend again.";
                modal.style.display = "block";
            } else {
                var modal = document.getElementById("alertModal");
                var modalContent = document.getElementById("modalContent");
                modalContent.innerHTML = "No Message from Admin";
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

    <!-- Floating Notification Button -->
    <button class="floating-btn" onclick="showAlert()">
        <i class="bi-bell"></i>
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
