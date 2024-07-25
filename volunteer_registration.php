<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $query_ = "SELECT COUNT(*) FROM volunteer WHERE email = '$email'";
    $result_ = mysqli_query($connect, $query_);
    
    $count = mysqli_fetch_array($result_)[0];

    if ($count > 0) {
        echo "User Already exists";
    } else {

        // Insert data into database
        $query = "INSERT INTO volunteer(name, email, passwd, phone, gender) 
                VALUES ('$username', '$email', '$password', '$phone', '$gender')";

        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "Registration Success";
            header("Location: volunteer_login.php"); // redirecting page
            exit(); // no further code is executed after the redirection
        } else {
            echo "Volunteer Registration failed!";

        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Registration</title>
    <link rel="stylesheet" href="assets/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
            <form action="volunteer_registration.php" method="POST">
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
                <div class="button">
                    <input type="submit" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>
</html>