<?php
include('../session.php');
include("../check_user.php");

// Ensure only authorized users can access this page
if (isset($_SESSION['email']) && $_SESSION['user_type'] == 'admin') {
    $email = $_SESSION['email'];
} else {
    echo "<script>alert('Access denied. Only admins can review applications.');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

require_once('../dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    
    if ($action == 'accept' || $action == 'reject') { // sponsor application
        $user_email = mysqli_real_escape_string($connect, $_POST['email']);
    } else { // rotten food report
        $user_email = mysqli_real_escape_string($connect, $_POST['donor_email']);
    }
    
    if ($action == 'accept') {
        // Accept the application
        $query_accept = "INSERT INTO sponsors (email) VALUES ('$user_email')";
        $query_update_status = "UPDATE sponsors_application SET status = 'accepted' WHERE email = '$user_email'";

        if (mysqli_query($connect, $query_accept) && mysqli_query($connect, $query_update_status)) {
            echo "<script>alert('Application accepted!');</script>";
        } else {
            echo "<script>alert('Failed to accept application!');</script>";
        }
    } elseif ($action == 'reject') {
        // Reject the application
        $query_update_status = "UPDATE sponsors_application SET status = 'rejected' WHERE email = '$user_email'";

        if (mysqli_query($connect, $query_update_status)) {
            echo "<script>alert('Application rejected!');</script>";
        } else {
            echo "<script>alert('Failed to reject application!');</script>";
        }
    } elseif ($action == 'ban') {
        // Ban the user
        $query_ban = "INSERT INTO blocklist (user_email) VALUES ('$user_email')";
        if (mysqli_query($connect, $query_ban)) {
            echo "<script>alert('User banned!');</script>";
        } else {
            echo "<script>alert('Failed to ban user! " . mysqli_error($connect) . "');</script>";
        }
    } elseif ($action == 'warn') {
        // Warn the user
        $warning_text = mysqli_real_escape_string($connect, $_POST['warning_text']);
        $query_warn = "INSERT INTO warning_table (user_email, warning_text) VALUES ('$user_email', '$warning_text')";
        if (mysqli_query($connect, $query_warn)) {
            echo "<script>alert('Warning issued!');</script>";
        } else {
            echo "<script>alert('Failed to issue warning! " . mysqli_error($connect) . "');</script>";
        }
    } else if ($action == "alert") {
        $alert_text = mysqli_real_escape_string($connect, $_POST['alert_text']);
        $query_alert = "INSERT INTO disaster_alert(title) VALUES ('$alert_text')";
        if (mysqli_query($connect, $query_alert)) {
            echo "<script>alert('Alert submitted!');</script>";
        } else {
            echo "<script>alert('Failed to submit alert! " . mysqli_error($connect) . "');</script>";
        }
    }
    echo "<script>window.location.href = 'dashboard.php';</script>";
}

// Fetch all queued sponsor applications
$query_sponsor = "SELECT email, description FROM sponsors_application WHERE status = 'Queued'";
$result_sponsor = mysqli_query($connect, $query_sponsor);

// Fetch all feedback marked as "Rotten" excluding donors in blocklist
$query_rotten = "SELECT d.donor_email, dt.donation_id, COUNT(dt.feedback) AS feedback_count
                 FROM donation_taken dt
                 JOIN donation d ON dt.donation_id = d.donation_id
                 LEFT JOIN blocklist b ON d.donor_email = b.user_email
                 WHERE dt.feedback = 'Rotten' AND b.user_email IS NULL
                 GROUP BY dt.donation_id, d.donor_email
                 ORDER BY feedback_count DESC";
$result_rotten = mysqli_query($connect, $query_rotten);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Review Sponsor Applications</div>
        <div class="content">
            <?php if (mysqli_num_rows($result_sponsor) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_sponsor)): ?>
                    <div class="container">
                        <div class="input-box">
                            <span class="details">Email: <?php echo $row['email']; ?></span>
                        </div>
                        <div class="input-box">
                            <span class="details">Description: <?php echo $row['description']; ?></span>
                        </div>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                            <button type="submit" name="action" value="accept">Accept</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No queued applications.</p>
            <?php endif; ?>
        </div>
        <br><br><br>
        <div class="title">Make a Alert</div>
        <div class="content">
            
            <div class="input-box">
                <span class="details">Description: <?php echo $row['description']; ?></span>
            </div>
            <form action="dashboard.php" method="POST">
                <div>
                    <input type="text" name="alert_text" placeholder="Enter Alert description">
                    <button type="submit" name="action" value="alert">Submit</button>
                </div>
            </form>
                   
        </div>
        <br><br><br>
        <a href="../logout.php"><button>Logout</button></a>
    </div>

    <div class="container">
        <div class="title">Review Rotten Food Reports</div>
        <div class="content">
            <?php if (mysqli_num_rows($result_rotten) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_rotten)): ?>
                    <div class="container">
                        <div class="input-box">
                            <span class="details">Email: <?php echo $row['donor_email']; ?></span>
                        </div>
                        <div class="input-box">
                            <span class="details">Total Feedbacks: <?php echo $row['feedback_count']; ?></span>
                        </div>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="donor_email" value="<?php echo $row['donor_email']; ?>">
                            <button type="submit" name="action" value="ban">Ban User</button>
                            <div>
                                <input type="text" name="warning_text" placeholder="Enter warning text">
                                <button type="submit" name="action" value="warn">Issue Warning</button>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No rotten feedback reports.</p>
            <?php endif; ?>
        </div>
    </div>

    <br><br><br><br>

</body>
</html>
