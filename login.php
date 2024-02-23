<?php
session_start();
require './conn/db.php'; // Include your database connection file

$alert_message = ""; // Initialize alert message

if(isset($_POST['submit'])) {
    if(isset($_POST['email']) && isset($_POST['password'])) {
        // Get email and password from the form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query to fetch the hashed password from the database
        $query = "SELECT id, password FROM users_tb WHERE email = ? AND otp_status = ?";
        $stmt = $conn->prepare($query);
        $otp_status = "verified"; // Dynamically set the value of otp_status
        $stmt->bind_param("ss", $email, $otp_status);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row with the given email is found
        if ($result->num_rows == 1) {
            // Fetch the hashed password and user ID from the result
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            $user_id = $row['id'];

            // Verify the entered password against the hashed password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session variables if needed
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;

                // Create payload for the token
                $payload = array(
                    'user_id' => $user_id,
                    'email' => $email
                );

                // Encode the payload as JSON
                $payload_json = json_encode($payload);

                // Encode the payload using base64
                $payload_base64 = base64_encode($payload_json);

                // Generate a token (you can also add other fields such as expiration time)
                $token = $payload_base64;

                // Pass token to client-side along with other necessary data
                $response = array(
                    'success' => true,
                    'token' => $token,
                    'message' => 'Login successful'
                );

                // Output JSON response
                header("Location: index.php");
                // echo json_encode($response);
                exit();
            } else {
                // Invalid username or password
                $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Invalid email or password.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            }
        } else {
            // Invalid username or password
            $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Invalid email or password.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Redirect back to login page if email and password are not set
        $alert_message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email and password are required.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            <h2 class="text-center">Login</h2>
            <?php echo $alert_message; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="email" style="font-size: 14px;">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password" style="font-size: 14px;">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-success btn-block" name="submit">Login</button>
                <hr>
                <div class="text-center"> <!-- Center align span elements -->
                    <span style="font-size: 15px;">No account yet? <a href="signup.php">Sign up here</a></span><br><hr/>
                    <span style="font-size: 14px;">Forgot Password? <a href="reset_password.php">Reset here</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', // Point AJAX to the current PHP file
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Store the token in a cookie
                            document.cookie = "token=" + response.token + "; path=/"; // Set the cookie with the token
                            // Redirect to another page or perform other actions
                            window.location.href = 'index.php'; // Replace 'index.php' with the desired page
                        } else {
                            // Handle invalid credentials or other errors
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>
