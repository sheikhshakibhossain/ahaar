<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        echo "Email: $email<br>";
        echo "Password: $password";
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Volunteer Login</title>
      <link rel="stylesheet" href="assets/login.css">
   </head>
   <body>
      <div class="wrapper">
         <div class="title">
            Login 
         </div>
         <form action="volunteer_login.php" method="POST">
            <div class="field">
               <input type="text" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" required>
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
               Not a member? <a href="volunteer_registration.php">Signup now</a>
            </div>
         </form>
      </div>
   </body>
</html>