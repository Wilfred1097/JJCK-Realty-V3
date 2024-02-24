<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        .login-container {
            max-width: 450px;
            margin: auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .user-info p {
            margin: 3px;
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
      <a class="navbar-brand text-brand" href="index.php" style="font-size: 28px; margin: auto;">JJCK<span class="color-b"> Realty</span></a>
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="property-grid.php">Property</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#contact">Contact</a>
              </li>
              <?php
              if (isset($_COOKIE['user_token'])) {
                  // If user_token cookie exists, show Logout link and Account link
                  echo '<li class="nav-item">
                          <a class="nav-link" href="logout.php" >Logout</a>
                      </li>';

              } else {
                  // If user_token cookie does not exist, show Login link
                  echo '<li class="nav-item">
                          <a class="nav-link" href="login.php">Login</a>
                      </li>';
              }
              ?>
          </ul>
      </div>
      <!-- <a href="login.php"><button class="btn btn-b">Login</button></a> -->
  </nav>

  <container class="container fluid">
     <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: #2FCC6D; color: white;">
                        Information
                    </div>
                    <div class="card-body">
                    <?php
                    // Initialize variables
                    $currentIndex = 0;
                    $totalRequests = 0;

                    // Database connection
                    require './conn/db.php';

                    // Check if user_token cookie exists
                    if (isset($_COOKIE['user_token'])) {
                        $user_token = $_COOKIE['user_token'];

                        // Decode the token to extract user ID
                        $payload_json = base64_decode($user_token);
                        $payload = json_decode($payload_json, true);

                        if(isset($payload['user_id'])){
                            $user_id = $payload['user_id'];

                            // Query to fetch user data using user ID
                            $query = "SELECT * FROM users_tb WHERE id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if user data exists
                            if ($result->num_rows > 0) {
                                $user = $result->fetch_assoc();
                                echo "<div class='user-info'>";
                                echo "<p>Name: " . $user['complete_name'] . "</p>";
                                echo "<p>Address: " . $user['address'] . "</p>";
                                echo "<p>Birthdate: " . $user['birthdate'] . "</p>";
                                echo "<p>Phone #: " . $user['phone_number'] . "</p>";
                                echo "<p>Email: " . $user['email'] . "</p>";
                                echo "<p>Date Registered: " . $user['date_registered'] . "</p>";
                                echo "</div>";
                            } else {
                                echo "User data not found.";
                            }

                            // Close statement and connection
                            $stmt->close();
                        } else {
                            echo "User ID not found in token payload.";
                        }
                    } else {
                        echo "User token not found.";
                    }

                    // Close database connection
                    $conn->close();
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: #2FCC6D; color: white;">
                        Tour Request
                    </div>
                    <div class="card-body">
                        <?php
                        // Database connection
                        require './conn/db.php';

                        // Check if user_token cookie exists
                        if (isset($_COOKIE['user_token'])) {
                            $user_token = $_COOKIE['user_token'];

                            // Decode the token to extract user ID
                            $payload_json = base64_decode($user_token);
                            $payload = json_decode($payload_json, true);

                            if (isset($payload['user_id'])) {
                                $user_id = $payload['user_id'];

                                // Query to fetch user tour request data using user ID
                                $query = "SELECT * FROM user_tour_request_view WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Check if user tour request data exists
                                if ($result->num_rows > 0) {
                                    // Fetch all rows into an array
                                    $tourRequests = $result->fetch_all(MYSQLI_ASSOC);

                                    // Get the total number of tour requests
                                    $totalRequests = count($tourRequests);

                                    // Check if there are any tour requests
                                    if ($totalRequests > 0) {
                                        // Determine the current index to display
                                        $currentIndex = isset($_GET['index']) ? $_GET['index'] : 0;

                                        // Display the tour request at the current index
                                        $currentRequest = $tourRequests[$currentIndex];

                                        echo "<div class='user-tour-request-info'>";
                                        echo "<div class='user-info'>";
                                        echo "<p>Block #: " . $currentRequest['block_number'] . "&emsp;&emsp;&emsp;Lot #:" . $currentRequest['lot_number'] . "</p>";
                                        echo "<p>Request Date: " . $currentRequest['request_date'] . "</p>";
                                        echo "<p>Date Requested: " . $currentRequest['date_requested'] . "</p>";
                                        echo "<p>Status: " . $currentRequest['status'] . "</p>";
                                        echo "</div>";
                                        echo "</div>";

                                    } else {
                                        echo "You have no tour request.";
                                    }
                                } else {
                                    echo "You have no tour request.";
                                }

                                // Close statement and connection
                                $stmt->close();
                            } else {
                                echo "User ID not found in token payload.";
                            }
                        } else {
                            echo "User token not found.";
                        }

                        // Close database connection
                        $conn->close();
                        ?>
                    </div>
                    <div class="card-footer" style="overflow: hidden; background-color: white;">
                    <div class="float-left">
                        <?php
                        // Display Previous button on the lower left
                        if ($currentIndex > 0) {
                            echo "<a href='account.php?index=" . ($currentIndex - 1) . "' class='btn btn-success mr-2'><</a>";
                        }
                        ?>
                    </div>
                    <div class="float-right">
                        <?php
                        // Display Next button on the lower right
                        if ($currentIndex < $totalRequests - 1) {
                            echo "<a href='account.php?index=" . ($currentIndex + 1) . "' class='btn btn-success'>></a>";
                        }
                        ?>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: #2FCC6D; color: white;">
                        Billing
                    </div>
                    <div class="card-body">
                        <!-- Content for Billing -->
                    </div>
                </div>
            </div>
        </div>
    </div>
  </container>

    <!-- Bootstrap JS and dependencies (optional if you need JavaScript functionality) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
