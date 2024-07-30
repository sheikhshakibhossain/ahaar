<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once('../dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");

    $query = "SELECT COUNT(*) FROM donor WHERE email = '$email' AND passwd = '$password'";
    $result = mysqli_query($connect, $query);
    
    $count = mysqli_fetch_array($result)[0];

    if ($count == 0) {
        echo "Invalid email or password";
    }
    else if ($count >= 1) {
        include("../session.php");
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = 'admin';
            echo "Login Success!";
            header("Location: dashboard.php"); // redirecting page
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Admin Login</div>
        <form action="index.php" method="POST">
            <div class="field">
                <input type="text" name="email" required>
                <label>Email Address</label>
            </div>
            <div class="field">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="field">
                <input type="submit" value="Login">
            </div>

        </form>
    </div>
</body>
</html>