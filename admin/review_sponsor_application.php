<?php
include('../session.php');

// // Ensure only authorized users can access this page
// if (isset($_SESSION['email']) && $_SESSION['user_type'] == 'admin') {
//     $email = $_SESSION['email'];
// } else {
//     echo "<script>alert('Access denied. Only admins can review applications.');</script>";
//     echo "<script>window.location.href = 'donor_login.php';</script>";
//     exit();
// }

require_once('../dbconfig.php');
$connect = mysqli_connect(HOST, USER, PASS, DB) or die("Cannot connect");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $applicant_email = mysqli_real_escape_string($connect, $_POST['email']);

    if ($action == 'accept') {
        // Accept the application
        $query_accept = "INSERT INTO sponsors (email) VALUES ('$applicant_email')";
        $query_update_status = "UPDATE sponsors_application SET status = 'accepted' WHERE email = '$applicant_email'";

        if (mysqli_query($connect, $query_accept) && mysqli_query($connect, $query_update_status)) {
            echo "<script>alert('Application accepted!');</script>";
        } else {
            echo "<script>alert('Failed to accept application!');</script>";
        }
    } elseif ($action == 'reject') {
        // Reject the application
        $query_update_status = "UPDATE sponsors_application SET status = 'rejected' WHERE email = '$applicant_email'";

        if (mysqli_query($connect, $query_update_status)) {
            echo "<script>alert('Application rejected!');</script>";
        } else {
            echo "<script>alert('Failed to reject application!');</script>";
        }
    }
    echo "<script>window.location.href = 'review_sponsor_application.php';</script>";
}

// Fetch all queued sponsor applications
$query = "SELECT email, description FROM sponsors_application WHERE status = 'Queued'";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Review Sponsor Applications</title>
    <link rel="stylesheet" href="../assets/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="title">Review Sponsor Applications</div>
        <div class="content">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="container">
                        <div class="input-box">
                            <span class="details">Email: <?php echo $row['email']; ?></span>
                        </div>
                        <div class="input-box">
                            <span class="details">Description: <?php echo $row['description']; ?></span>
                        </div>
                        <form action="review_sponsor_application.php" method="POST">
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
    </div>
</body>
</html>
