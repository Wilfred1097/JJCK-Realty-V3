<?php
require './conn/db.php';
session_start();

if(isset($_POST['submit'])) {
    // Get OTP from the form
    $entered_otp = isset($_POST['otp']) ? $_POST['otp'] : '';

    // Get email from the session
    $email = isset($_GET['email']) ? $_GET['email'] : '';

    // Query to check if the entered OTP matches the stored OTP for the email
    $query_check_otp = "SELECT OTP FROM users_tb WHERE email = ?";
    $stmt_check_otp = $conn->prepare($query_check_otp);

    if (!$stmt_check_otp) {
        // Handle preparation error
        echo "<script>alert('Preparation error: " . $conn->error . "');</script>";
    } else {
        $stmt_check_otp->bind_param("s", $email);
        $stmt_check_otp->execute();
        $result_check_otp = $stmt_check_otp->get_result();

        // Check if the entered OTP matches the stored OTP
        if ($result_check_otp->num_rows === 1) {
            $row = $result_check_otp->fetch_assoc();
            $stored_otp = $row['OTP'];

            if ($entered_otp == $stored_otp) {
                // Update otp_status to 'verified' if OTPs match
                $query_update_otp_status = "UPDATE users_tb SET otp_status = 'verified' WHERE email = ?";
                $stmt_update_otp_status = $conn->prepare($query_update_otp_status);

                if (!$stmt_update_otp_status) {
                    // Handle preparation error
                    echo "<script>alert('Preparation error: " . $conn->error . "');</script>";
                } else {
                    $stmt_update_otp_status->bind_param("s", $email);
                    $stmt_update_otp_status->execute();
                    echo "<script>alert('OTP verified');</script>";
                    $stmt_update_otp_status->close();
                    header("Location: index.php");
                }
            } else {
                echo "<script>alert('Invalid OTP');</script>";
            }
        } else {
            echo "<script>alert('Email not found');</script>";
        }

        // Close statement and connection
        $stmt_check_otp->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Confirmation</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 450px;
            margin: auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
        <div class="container">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
                aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a class="navbar-brand text-brand" href="index.php" style="font-size: 28px;">JJCK<span class="color-b">
                    Realty</span></a>
        </div>
    </nav>

    <div class="container justify-content-center">
        <div class="login-container" style="margin-top: 170px;">
            <h2 class="text-center">Enter OTP</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="number" class="form-control" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="submit">Confirm</button><hr>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Ajax to send email in the background -->
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "GET",
                url: "send_email.php", // Path to the send_email.php script
                success: function(response){
                    console.log(response); // Log the response from the server
                }
            });
        });
    </script>
</body>

</html>
