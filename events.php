<?php

require_once('dbconfig.php');
include('session.php');

$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");

// Fetch upcoming donations (not expired)
$current_date = date('Y-m-d H:i:s');
$events_query = "SELECT donation_id, food_name, quantity, quantity_available, location, expire_date_time 
                 FROM donation 
                 WHERE expire_date_time > '$current_date' AND quantity_available > 0";
$events_result = mysqli_query($connect, $events_query);

$events = [];
while ($event_row = mysqli_fetch_assoc($events_result)) {
    $events[] = $event_row;
}

// Handle take donation request
if (isset($_GET['take_donation'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $donation_id = $_GET['take_donation'];

        $count_query = "SELECT COUNT(*) FROM `donation_taken` WHERE recipient_email = '$email' AND donation_id = '$donation_id'";
        $result = mysqli_query($connect, $count_query);
        $count = mysqli_fetch_array($result)[0];
        if ($count == 0) {
            $update_query = "UPDATE donation 
                             SET quantity_available = quantity_available - 1 
                             WHERE donation_id = '$donation_id' AND quantity_available > 0";
            
            if (mysqli_query($connect, $update_query)) {
                echo "<script>alert('Donation taken successfully!');</script>";
            } else {
                echo "<script>alert('Failed to take donation.');</script>";
            }
    
            $track_donation_query = "INSERT INTO `donation_taken`(`donation_id`, `recipient_email`) VALUES ('$donation_id','$email')";
            if (mysqli_query($connect, $track_donation_query)) {
                echo "<script>alert('Donation tracking successful!');</script>";
            } else {
                echo "<script>alert('Failed to track donation.');</script>";
            }

            echo "<script>window.location.href = 'events.php';</script>";
            exit();

        } else {
            echo "<script>alert('Already taken this donation once');</script>";
            echo "<script>window.location.href = 'events.php';</script>";
        }
    
    } else {
        echo "<script>alert('Please login first');</script>";
        echo "<script>window.location.href = 'recipient_login.php';</script>";
        exit();
    }
}

?>


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
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
        .event {
            width: calc(33% - 20px);
            height: auto;
            background-color: #FFF;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .event:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .event p {
            margin: 0;
            padding: 0;
        }
        .event .food-name {
            font-size: 24px;
            font-weight: 500;
            color: #1E90FF;
            margin-bottom: 10px;
        }
        .event .location {
            font-size: 20px;
            font-weight: 300;
            color: #FF8C00;
            margin-bottom: 5px;
        }
        .event .expire-date {
            font-size: 18px;
            font-weight: 300;
            color: #808080;
            margin-bottom: 5px;
        }
        .event .quantity {
            font-size: 16px;
            font-weight: 300;
            color: #696969;
            margin-bottom: 10px;
        }
        .event .button {
            text-align: center;
        }
        @media (max-width: 768px) {
            .event {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .event {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div id="container">
    <h2>Upcoming Events</h2>
    <?php
    // Display upcoming donations
    foreach ($events as $event) {
    ?>
        <div class="event">
            <p class="food-name"><?php echo htmlspecialchars($event['food_name']); ?></p>
            <p class="quantity">Quantity Available: <?php echo htmlspecialchars($event['quantity_available']); ?></p>
            <p class="location">Location: <?php echo htmlspecialchars($event['location']); ?></p>
            <p class="expire-date">Expires on: <?php echo htmlspecialchars($event['expire_date_time']); ?></p>
            <div class="button">
                <a href="?take_donation=<?php echo $event['donation_id']; ?>" class="btn btn-primary">Take Donation</a>
            </div>
        </div>
    <?php
    }
    ?>
</div>

</body>
</html>
