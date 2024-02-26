<?php
session_start();

// Check if lot_Id is set and is not empty
if(isset($_GET['lot_Id']) && !empty($_GET['lot_Id'])) {
    // Retrieve the lot_Id from the URL parameter
  $lot_Id = $_GET['lot_Id'];
  
  // Include the database connection file
  require_once './conn/db.php';

    // Prepare and execute the SQL query to select data from lot_table based on lot_Id
  $sql = "SELECT * FROM lot_tb WHERE lot_Id = $lot_Id";
  $result = $conn->query($sql);

    // Check if there are any rows returned
  if ($result->num_rows > 0) {
        // Fetch the row data
    $row = $result->fetch_assoc();
    // Close the database connection
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <title>JJCKRealty</title>
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="keywords">
      <meta content="" name="description">

      <!-- Favicons -->
      <link href="img/favicon.png" rel="icon">
      <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

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
    <!--/ Nav Star /-->
    <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
      <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
        aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand" href="index.php" style="margin: auto;">JJCK<span class="color-b">Realty</span></a>
    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="property-grid.php">Property</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php#contact">Contact</a>
        </li>
        <?php
          if (isset($_COOKIE['user_token'])) {
              // If user_token cookie exists, show Logout link and Account link
              echo '<li class="nav-item">
                      <a class="nav-link" href="account.php">Account</a>
                  </li>';
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
</div>
</nav>
<!--/ Nav End /-->

<!--/ Property Single Star /-->
<section class="property-single nav-arrow-b" style="margin-top: 80px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
          <div class="card border-0"style="display: flex; justify-content: center; align-items: center;">
            <img class="card-img-top" src="data:image/jpeg;base64,<?php echo $row['image']; ?>" alt="Lot Image" style="max-width: 100%; height: 100%;">
          </div>
        </div>
        <div class="row">
		 <div class="col">
            <div class="property-summary">
              <div class="row mt-4">
                <div class="col-sm-12">
                  <div class="title-box-d">
                    <h3 class="title-d">Quick Summary</h3>
                  </div>
                </div>
              </div>
              <div class="summary-list">
                  <ul class="list">
                    <li class="d-flex justify-content-between">
                      <strong>Block:</strong>
                      <span><?php echo $row['block_number']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Lot:</strong>
                      <span><?php echo $row['lot_number']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Term:</strong>
                      <span><?php echo $row['term']; ?> years</span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Dimension:</strong>
                      <span><?php echo $row['dimension']; ?> m<sup>2</sup></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Price:</strong>
                      <span>&#8369; <?php echo number_format($row['price']); ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Downpayment:</strong>
                      <span>&#8369; <?php echo number_format($row['downpayment']); ?></span>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
          <div class="col">
            <div class="property-summary">
              <div class="row mt-4">
                <div class="col-sm-12">
                  <div class="title-box-d">
                    <h3 class="title-d">Payment Confirmation</h3>
                  </div>
                </div>
              </div>
              <?php
				// Check if user_id is set in the session
				if(isset($_SESSION['user_id'])) {
				    // Retrieve the user_id from the session
				    $user_id = $_SESSION['user_id'];

				    // Include the database connection file
				    require_once './conn/db.php';

				    // Prepare and execute the SQL query to select all data from database where id = user_id
				    $user_sql = "SELECT * FROM users_tb WHERE id = $user_id";
				    $user_result = $conn->query($user_sql);

				    // Check if there are any rows returned
				    if ($user_result->num_rows > 0) {
				        // Fetch the row data
				        $user_row = $user_result->fetch_assoc();

				        // Close the database connection
				        $conn->close(); // Close connection after fetching data
				    } else {
				        // If no rows are returned, handle accordingly
				        echo "No user data found.";
				        $conn->close(); // Close connection if no data found
				        exit(); // Exit script
				    }
				} else {
				    // If user_id is not set in the session, display error message or handle accordingly
				    echo "User ID is missing from session.";
				    exit(); // Exit script
				}
				?>
				<form action="process_payment.php" method="post" style="width: 400px;">
				    <div class="form-group">
				        <label for="name">Complete Name</label>
				        <input type="text" class="form-control" id="name" name="name" placeholder="Enter complete name" value="<?php echo isset($user_row['complete_name']) ? $user_row['complete_name'] : ''; ?>" readonly>
				    </div>
				    <div class="form-group">
				        <label for="phone">Phone</label>
				        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="<?php echo isset($user_row['phone_number']) ? $user_row['phone_number'] : ''; ?>" readonly>
				    </div>
				    <div class="form-group">
				        <label for="email">Email</label>
				        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo isset($user_row['email']) ? $user_row['email'] : ''; ?>" readonly>
				        <button type="submit" class="btn btn-success btn-block mt-3" name="pay">Pay &#8369; <?php echo number_format($row['downpayment']); ?></button>
				    </div>
				</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Property Single End /-->

<!--/ footer Star /-->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="nav-footer">
          <ul class="list-inline">
            <li class="list-inline-item">
              <a href="index.php">Home</a>
            </li>
            <li class="list-inline-item">
              <a href="property-grid.php">Property</a>
            </li>
          </ul>
        </nav>
        <div class="socials-a">
          <ul class="list-inline">
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-pinterest-p" aria-hidden="true"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-dribbble" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--/ Footer End /-->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<div id="preloader"></div>

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/popper/popper.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/scrollreveal/scrollreveal.min.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>

<!-- JavaScript for SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>

<?php
} else {
  // If no matching lot found, display error message
  echo "Lot not found.";
}
} else {
  // If lot_Id parameter is not set or empty, display error message
  echo "Lot Id is missing.";
}
?>