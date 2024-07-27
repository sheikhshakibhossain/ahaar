<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];
    $user_type = $_POST['user_type'];
    $restaurant_name = isset($_POST['restaurant_name']) ? $_POST['restaurant_name'] : null;

    $query_ = "SELECT COUNT(*) FROM donor WHERE email = '$email'";
    $result_ = mysqli_query($connect, $query_);
    
    $count = mysqli_fetch_array($result_)[0];

    if ($count > 0) {
        echo "Donor Already exists";
    } else {
        if ($user_type == 'Restaurant Owner' && empty($restaurant_name)) {
            echo "Restaurant name is required for Restaurant Owners.";
        } else {
            // Insert data into database
            $query = "INSERT INTO donor(name, email, passwd, phone, gender, address, postal_code, user_type, restaurant_name) 
                    VALUES ('$username', '$email', '$password', '$phone', '$gender', '$address', '$postal_code', '$user_type', '$restaurant_name')";

            $result = mysqli_query($connect, $query);

            if ($result) {
                echo "Registration Success";
                header("Location: donor_login.php"); // redirecting page
                exit(); // no further code is executed after the redirection
            } else {
                echo "Donor Registration failed!";
            }
        }
    }
    
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Donor Registration</title>
    <link rel="stylesheet" href="assets/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function toggleRestaurantName() {
            var userType = document.querySelector('input[name="user_type"]:checked').value;
            var restaurantNameField = document.getElementById('restaurant_name_field');
            if (userType === 'Restaurant Owner') {
                restaurantNameField.style.display = 'block';
            } else {
                restaurantNameField.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="title">Donor Registration</div>
        <div class="content">
            <form action="donor_registration.php" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Username</span>
                        <input type="text" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your Address" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Postal Code</span>
                        <input type="text" name="postal_code" placeholder="Enter your Postal Code" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phone" placeholder="Enter your number" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="gender-details">
                    <input type="radio" name="gender" id="dot-1" value="Male" required>
                    <input type="radio" name="gender" id="dot-2" value="Female">
                    <input type="radio" name="gender" id="dot-3" value="Prefer not to say">
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                </div>

                <div class="gender-details">
                    <input type="radio" name="user_type" id="dot-4" value="Regular" onclick="toggleRestaurantName()" required>
                    <input type="radio" name="user_type" id="dot-5" value="Restaurant Owner" onclick="toggleRestaurantName()">
                    <span class="gender-title">User Type</span>
                    <div class="category">
                        <label for="dot-4">
                            <span class="dot four"></span>
                            <span class="gender">Regular</span>
                        </label>
                        <label for="dot-5">
                            <span class="dot five"></span>
                            <span class="gender">Restaurant Owner</span>
                        </label>
                    </div>
                </div>

                <div class="user-details" id="restaurant_name_field" style="display: none;">
                    <div class="input-box">
                        <span class="details">Restaurant Name</span>
                        <input type="text" name="restaurant_name" placeholder="Enter restaurant name">
                    </div>
                </div>

                <div class="button">
                    <input type="submit" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
