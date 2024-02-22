<?php
session_start();
require './conn/db.php';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query_check_email = "SELECT * FROM users_tb WHERE email = ?";
    $stmt_check_email = $conn->prepare($query_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    if ($result_check_email->num_rows > 0) {
        // Email exists, generate OTP
        $random_otp = mt_rand(100000, 999999);

        // Update OTP in the database
        $query_update_otp = "UPDATE users_tb SET OTP = ? WHERE email = ?";
        $stmt_update_otp = $conn->prepare($query_update_otp);
        $stmt_update_otp->bind_param("ss", $random_otp, $email);
        $stmt_update_otp->execute();

        // Store email and OTP in session
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $random_otp;

        // Redirect to reset_otp.php
        header("Location: reset_otp.php");
        exit();
    } else {
        echo "<script>alert('Email does not exist.');</script>";
    }

    $stmt_check_email->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
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
            <div class="text-center w-100"> <!-- Center align the content -->
                <a class="navbar-brand text-brand" href="index.php" style="font-size: 28px;">JJCK<span class="color-b">Realty</span></a>
            </div>
        </div>
    </nav>

    <div class="container justify-content-center">
        <div class="login-container" style="margin-top: 170px;">
            <h2 class="text-center">Reset Password</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="submit">Reset</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
