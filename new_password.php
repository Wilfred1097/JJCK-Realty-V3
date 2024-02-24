<?php
session_start();

$alert_message = '';

if(isset($_POST['submit'])) {
    // Get new password from the form
    $newPassword = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';

    // Get email from the session
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    // Update the password in the database
    require './conn/db.php'; // Include your database connection file

    $query_update_password = "UPDATE users_tb SET password = ? WHERE email = ?";
    $stmt_update_password = $conn->prepare($query_update_password);

    if (!$stmt_update_password) {
        // Handle preparation error
        echo "<script>alert('Preparation error: " . $conn->error . "');</script>";
    } else {
        $stmt_update_password->bind_param("ss", password_hash($newPassword, PASSWORD_DEFAULT), $email);

        if ($stmt_update_password->execute()) {
            // Password updated successfully
            $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Password Change Successfully
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
            header("Location: login.php");
        } else {
            // Handle execution error
            echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
        }

        // Close statement and connection
        $stmt_update_password->close();
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
            <h2 class="text-center">Enter New Password</h2>
            <form method="POST" onsubmit="return validatePassword();">
                <div class="form-group">
                    <label for="newpassword" style="font-size: 14px;">New Password</label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label for="confirmnewpassword" style="font-size: 14px;">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" placeholder="Confirm new password" required>
                </div>
                <div id="passwordMismatchAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    Passwords do not match.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="passwordCriteriaAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    Password must contain at least one uppercase letter and one special character.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="passwordCLengthAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    Password must be at least 8 character
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validatePassword() {
            var newPassword = document.getElementById("newpassword").value;
            var confirmPassword = document.getElementById("confirmnewpassword").value;

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                document.getElementById("passwordMismatchAlert").style.display = "block";
                document.getElementById("passwordCriteriaAlert").style.display = "none";
                return false;
            }

            // Check if password meets criteria (at least one uppercase letter and one special character)
            var uppercaseRegex = /[A-Z]/;
            var specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;

            if (!uppercaseRegex.test(newPassword) || !specialCharRegex.test(newPassword)) {
                document.getElementById("passwordCriteriaAlert").style.display = "block";
                document.getElementById("passwordMismatchAlert").style.display = "none";
                return false;
            }

            if (!uppercaseRegex.test(newPassword) || !specialCharRegex.test(newPassword) || newPassword.length < 8) {
                document.getElementById("passwordCLengthAlert").style.display = "block";
                return false;
            }

            // Reset the alerts if the password meets all criteria
            document.getElementById("passwordMismatchAlert").style.display = "none";
            document.getElementById("passwordCriteriaAlert").style.display = "none";
            return true;
        }
    </script>

</body>

</html>
