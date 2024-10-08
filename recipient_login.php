<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once('dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

    $query = "SELECT COUNT(*) FROM recipient WHERE email = '$email' AND passwd = '$password'";
    $result = mysqli_query($connect, $query);
    
    $count = mysqli_fetch_array($result)[0];

    if ($count == 0) {
        echo "Invalid email or password";
    }
    else if ($count >= 1) {
        include ("session.php");
        $_SESSION['email'] = $email;
            echo "Login Success!";
            header("Location: recipient/recipient.php"); // redirecting page
            exit(); // no further code is executed after the redirection
        } else {
            echo "Login failed!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Recipient Login</title>
    <link rel="stylesheet" href="assets/login.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Recipient Login</div>
        <form action="recipient_login.php" method="POST">
            <div class="field">
                <input type="text" name="email" required>
                <label>Email Address</label>
            </div>
            <div class="field">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" id="remember-me">
                    <label for="remember-me">Remember me</label>
                </div>
            </div>
            <div class="field">
                <input type="submit" value="Login">
            </div>
            <div class="signup-link">
                Not a member? <a href="recipient_registration.php">Signup now</a>
            </div>
        </form>
    </div>
</body>
</html>