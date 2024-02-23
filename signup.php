<?php
require './conn/db.php';
session_start();

if(isset($_POST['submit'])) {
    // Storing form data in variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if email already exists
    $query_check_email = "SELECT * FROM users_tb WHERE email = ?";
    $stmt_check_email = $conn->prepare($query_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // If email already exists, return an error
    if ($result_check_email->num_rows > 0) {
        // Email already registered, display alert
        $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Email already taken.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
    } else {
        // Generating random OTP
        $random_otp = sprintf('%06d', mt_rand(0, 999999));

        // Inserting data into the database
        $query = "INSERT INTO users_tb (complete_name, address, birthdate, email, OTP, password, otp_status) VALUES (?, ?, ?, ?, ?, ?, 'not verified')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $name, $address, $birthdate, $email, $random_otp, $hashed_password);

        // Executing the query
        if ($stmt->execute()) {
            // Store email and OTP in session variables
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $random_otp;

            // Redirect to confirm_otp.php after successful registration
            header("Location: confirm_otp.php?email=$email");
            exit();
        } else {
            // Redirect back to signup page with error message
            header("Location: signup.php?error=registration_failed");
            exit();
        }
        $stmt->close();
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
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
        <div class="login-container">
            <h2 class="text-center" style="margin-bottom: 30px;">Customer Signup</h2>
            <?php echo $alert_message; ?>
            <form action="" method="post"  onsubmit="return validatePassword();">
                <div class="form-group">
                    <label for="name">Complete Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter complete name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" >
                </div>
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" >
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm password" >
                </div>
                <!-- Hidden input field to store the randomly generated number -->
                <!-- <input type="hidden" id="otp" name="otp" value="<?php echo $random_otp; ?>"> -->
                <button type="submit" class="btn btn-success btn-block" name="submit">Signup</button>
                <hr>
                <div class="text-center"> <!-- Center align span element -->
                    <span style="font-size: 14px;">Already have an account? <a href="login.php">Login here</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validatePassword() {
            var newPassword = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmpassword").value;

            if (newPassword != confirmPassword) {
                alert("Passwords do not match");
                return false;
            }
            return true;
        }
    </script>
</body>
</body>

</html>
