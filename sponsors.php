<?php

    require_once('dbconfig.php');
    $connect = mysqli_connect(HOST, USER, PASS, DB) or die("Can not connect");
    
    $results = mysqli_query($connect, "SELECT email FROM donor WHERE donor.email IN (SELECT email FROM sponsors)")
        or die("Can not execute query");
    
    $sponsors = [];
    while ($rows = mysqli_fetch_array($results)) {
        extract($rows);
        $sponsors[] = $email;
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Sponsors</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #30b7e6, #3aaa3c);
        }
        #container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
        }
        #container h2 {
            width: 100%;
            text-align: center;
            color: #FFF;
            font-weight: 500;
            font-size: 40px;
            margin-bottom: 30px;
        }
        .user {
            width: calc(33% - 20px);
            height: 330px;
            background-color: #FFF;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .user:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .user p {
            margin: 0;
            padding: 0;
        }
        .user .name {
            font-size: 24px;
            font-weight: 500;
            color: #1E90FF;
            margin-bottom: 10px;
        }
        .user .location {
            font-size: 20px;
            font-weight: 300;
            color: #FF8C00;
            margin-bottom: 5px;
        }
        .user .email {
            font-size: 18px;
            font-weight: 300;
            color: #808080;
            margin-bottom: 5px;
        }
        .user .current-work {
            font-size: 16px;
            font-weight: 300;
            color: #696969;
        }
        @media (max-width: 768px) {
            .user {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .user {
                width: 100%;
            }
        }
    </style>

    <style>
        body {
            background-color: #E1F7F5; 
        }
    </style>
</head>
<body>

<div id="container">
    <h2>Our Sponsors</h2>
    <?php
    // Loop through each sponsor ID and fetch their details
    foreach ($sponsors as $sponsor_email) {
        
        $sponsor_query = mysqli_query($connect, "SELECT name, phone, email, address, restaurant_name, gender FROM donor WHERE email = '$sponsor_email'");
        $sponsor_data = mysqli_fetch_assoc($sponsor_query);
    ?>

    <a class="user">
        <?php 
            $profile_picture = 'donor/profile.svg';
            $gender = $sponsor_data['gender'];
            if ($gender == "Female") {
                $profile_picture = "assets/images/girl.jpg";
            }
        ?>
        <img class="rounded-circle mt-3" width="150px" src="<?php echo $profile_picture; ?>">
        <p class="name"><?php echo $sponsor_data['name']; ?></p>
        <p class="email"><?php echo $sponsor_data['address']; ?></p>

        <p class="address">
            <?php
                $email = $sponsor_data['email'];
                $query_ = "SELECT SUM(quantity) FROM donation WHERE donor_email = '$email'";
                $result_ = mysqli_query($connect, $query_);
                $donation_count = mysqli_fetch_array($result_)[0];

                if ($donation_count > 0) {
                    $donation_count = "Total Meals Donated: ". $donation_count;
                    echo $donation_count;
                }
            ?>
        </p>
        <p class="location">
            <?php
                if ($sponsor_data['restaurant_name'] != null) {
                    $restaurant_name = $sponsor_data['restaurant_name']; 
                    $restaurant_name = "Owner at ". $restaurant_name;
                    echo $restaurant_name;
                }
            ?>
        </p>
    </a>
    <?php
    }
    ?>
</div>


</body>
</html>
