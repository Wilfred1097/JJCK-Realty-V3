<?php
require './conn/db.php';
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
      <a class="navbar-brand text-brand" href="index.php" style="margin: auto;">JJCK<span class="color-b">Realty</span></a>
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="about.html">About</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link active" href="property-grid.php">Property</a>
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
                        <a class="nav-link" href="logout.php">Logout</a>
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

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Our Amazing Lot listings</h1>
            <!-- <span class="color-text-a">Grid Properties</span> -->
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Lots Grid
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Grid Star /-->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="grid-option">
              <form method="GET">
                  <select class="custom-select" name="sort_by">
                      <option value="0" style="font-size: 13px;">Order By</option>
                      <option value="1" style="font-size: 12px;" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 1 ? 'selected' : ''; ?>>by Price</option>
                      <option value="2" style="font-size: 12px;" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 2 ? 'selected' : ''; ?>>by block</option>
                      <option value="3" style="font-size: 12px;" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 3 ? 'selected' : ''; ?>>by Dimension</option>
                  </select>
                  <button type="submit" class="btn btn-success btn-md" style="font-size: 16px">Apply</button>
              </form>
          </div>
        </div>
        <?php
        require './conn/db.php';

        // Number of listings per page
        $limit = 15;

        // Get the current page number
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Calculate the offset for pagination
        $offset = ($page - 1) * $limit;

        // SQL query to count total number of rows
        $countQuery = "SELECT COUNT(*) as total FROM lot_table";
        $countResult = $conn->query($countQuery);
        $countRow = $countResult->fetch_assoc();
        $totalRows = $countRow['total'];

        // Calculate total number of pages
        $totalPages = ceil($totalRows / $limit);

        // Initialize sorting column and default sort order
        $sort_column = 'lot_Id';
        $sort_order = 'ASC';

        // Check if sort_by parameter is set
        if (isset($_GET['sort_by'])) {
            switch ($_GET['sort_by']) {
                case 1:
                    $sort_column = 'price';
                    break;
                case 2:
                    $sort_column = 'block_number';
                    break;
                case 3:
                    $sort_column = 'dimension';
                    break;
                default:
                    // Default sorting column (if sort_by value is invalid)
                    $sort_column = 'lot_Id';
            }
        }

        // SQL query to select limited data from users table based on pagination and sorting
        $sql = "SELECT * FROM lot_table ORDER BY $sort_column $sort_order LIMIT $limit OFFSET $offset";


        // // SQL query to select limited data from users table based on pagination
        // $sql = "SELECT * FROM lot_table LIMIT $limit OFFSET $offset";

        // Execute query
        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Access the data using $row['column_name']
                ?>
                <div class="col-md-4">
                    <div class="carousel-item-b">
                        <div class="card-box-a card-shadow">
                            <div class="img-box-a">
                                <?php
                                // Directly use the data URI stored in the database
                                ?>
                                <img src="<?php echo $row['image']; ?>" alt="" class="img-a img-fluid">
                            </div>
                            <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                    <div class="card-header-a">
                                    </div>
                                    <div class="card-body-a">
                                        <div class="price-box d-flex">
                                            <span class="price-a">BUY | &#8369; <?php echo $row['price']; ?></span>
                                        </div>
                                        <a href="property-single.php?lot_Id=<?php echo $row['lot_Id']; ?>" class="link-a">Click here to view
                                            <span class="ion-ios-arrow-forward"></span>
                                        </a>
                                    </div>
                                    <div class="card-footer-a">
                                        <ul class="card-info d-flex justify-content-around">
                                            <li>
                                                <h4 class="card-info-title">Dimension</h4>
                                                <span><?php echo $row['dimension']; ?> m<sup>2</sup></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Block</h4>
                                                <span><?php echo $row['block_number']; ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Lot</h4>
                                                <span><?php echo $row['lot_number']; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();
        ?>
      </div>
        <div class="col-sm-12">
            <nav class="pagination-a">
                <ul class="pagination justify-content-end">
                    <!-- Previous Page Link -->
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">
                            <span class="ion-ios-arrow-back"></span>
                        </a>
                    </li>
                    <?php
                    // Pagination links
                    for ($i = 1; $i <= ceil($totalPages); $i++) {
                        ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                    <!-- Next Page Link -->
                    <li class="page-item <?php echo $page >= ceil($totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                            <span class="ion-ios-arrow-forward"></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
  </section>
  <!--/ Property Grid End /-->

  </section> -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="nav-footer">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="index.php">Home</a>
              </li>
              <!-- <li class="list-inline-item">
                <a href="#">About</a>
              </li> -->
              <li class="list-inline-item">
                <a href="#">Property</a>
              </li>
              <!-- <li class="list-inline-item">
                <a href="#">Blog</a>
              </li> -->
              <li class="list-inline-item">
                <a href="index.php#contact">Contact</a>
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
          <div class="copyright-footer">
            <p class="copyright color-text-a">
              &copy; Copyright
              <span class="color-a">JJCKRealty</span> All Rights Reserved.
            </p>
          </div>
          <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=EstateAgency
            -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
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