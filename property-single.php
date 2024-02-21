<?php
// Check if lot_Id is set and is not empty
if(isset($_GET['lot_Id']) && !empty($_GET['lot_Id'])) {
    // Retrieve the lot_Id from the URL parameter
  $lot_Id = $_GET['lot_Id'];
  
    // Include the database connection file
  require_once './conn/db.php';

    // Prepare and execute the SQL query to select data from lot_table based on lot_Id
  $sql = "SELECT * FROM lot_table WHERE lot_Id = $lot_Id";
  $result = $conn->query($sql);

    // Check if there are any rows returned
  if ($result->num_rows > 0) {
        // Fetch the row data
    $row = $result->fetch_assoc();
        // Close the database connection
    $conn->close();
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

  <!-- =======================================================
    Theme Name: EstateAgency
    Theme URL: https://bootstrapmade.com/real-estate-agency-bootstrap-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
    ======================================================= -->
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
      <a class="navbar-brand text-brand" href="index.php">JJCK<span class="color-b">Realty</span></a>
      <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse"
      data-target="#navbarTogglerDemo01" aria-expanded="false">
      <span class="fa fa-search" aria-hidden="true"></span>
    </button>
    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="property-grid.php">Property</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="blog-grid.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php#contact">Contact</a>
        </li>
      </ul>
    </div>
      <a href="login.php"><button class="btn btn-b">Login</button></a>
</div>
</nav>
<!--/ Nav End /-->

<!--/ Property Single Star /-->
<section class="property-single nav-arrow-b" style="margin-top: 80px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
          <div class="card border-0">
            <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="Lot Image">
          </div>
        </div>
        <div class="row">
          <div class="col mt-4">
            <form class="form-a contactForm">
              <div class="row">
                <h3 class="title-d">Request a Tour</h3>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="tourDate" class="mt-4"><strong>Tour Date</strong></label>
                  <input type="date" id="tourDate" name="tourDate" class="form-control" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
                  <!-- This sets the minimum date to three days after the current date -->
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-b">Submit</button>
                </div>
              </div>
            </form>
          </div>
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
                      <strong>Lot ID:</strong>
                      <span><?php echo $row['lot_Id']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Block:</strong>
                      <span><?php echo $row['block_number']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Lot:</strong>
                      <span><?php echo $row['lot_number']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Dimension:</strong>
                      <span><?php echo $row['dimension']; ?> m<sup>2</sup></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Term:</strong>
                      <span><?php echo $row['term']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Price:</strong>
                      <span>&#8369; <?php echo $row['price']; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Downpayment:</strong>
                      <span>&#8369; <?php echo $row['downpayment']; ?></span>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 offset-md-1">
        <ul class="nav nav-pills-a nav-pills mb-3 section-t3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map"
            aria-selected="false">Ubication</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade" id="pills-plans" role="tabpanel" aria-labelledby="pills-plans-tab">
            <img src="img/plan2.jpg" alt="" class="img-fluid">
          </div>
          <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1422937950147!2d-73.98731968482413!3d40.75889497932681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes+Square!5e0!3m2!1ses-419!2sve!4v1510329142834"
            width="100%" height="460" frameborder="0" style="border:0" allowfullscreen></iframe>
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
            <li class="list-inline-item">
              <a href="login.php">Login</a>
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
<!-- Contact Form JavaScript File -->
<script src="contactform/contactform.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>

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