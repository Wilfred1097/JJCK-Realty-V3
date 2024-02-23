<?php
session_start();
require './conn/db.php'; // Include your database connection file

// Function to generate and send OTP
function sendOTP($email, $otp) {
    // Here, you would implement your code to send the OTP via email
    // For demonstration purposes, let's assume the OTP is sent successfully
    return true;
}

$alert_message = ""; // Initialize alert message

if(isset($_POST['submit'])) {
    // Get entered OTP from the form
    $entered_otp = isset($_POST['otp']) ? $_POST['otp'] : '';

    // Get email from the session
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    // Query to fetch OTP from the database for the corresponding email
    $query_fetch_otp = "SELECT OTP FROM users_tb WHERE email = ?";
    $stmt_fetch_otp = $conn->prepare($query_fetch_otp);

    if (!$stmt_fetch_otp) {
        // Handle preparation error
        $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Preparation error: ' . $conn->error . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        $stmt_fetch_otp->bind_param("s", $email);
        $stmt_fetch_otp->execute();
        $stmt_fetch_otp->store_result();

        // Check if the email exists in the database
        if ($stmt_fetch_otp->num_rows === 1) {
            $stmt_fetch_otp->bind_result($stored_otp);
            $stmt_fetch_otp->fetch();

            // Check if entered OTP matches stored OTP
            if ($entered_otp === $stored_otp) {
                // Redirect to new_password.php if OTPs match
                header("Location: new_password.php");
                exit();
            } else {
                // Display error message if OTPs do not match
                $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Invalid OTP
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            }
        } else {
            // Display error message if email not found
            $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Email does not exist.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }

        // Close statement and connection
        $stmt_fetch_otp->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <div class="login-container"  style="margin-top: 170px;">
            <h2 class="text-center">Reset Password</h2>
            <form method="POST">
                <?php echo $alert_message; ?>
                <div class="form-group">
                    <label for="otp" style="font-size: 14px;">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="submit">CONFIRM OTP</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            // Send OTP asynchronously when the document is ready
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
