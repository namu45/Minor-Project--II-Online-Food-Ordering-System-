<?php
include 'includes/connect.php';
// Make sure session is started

// Store the POST data for use if user goes back
$_SESSION['order_data'] = $_POST;

$continue = 0;
$total = 0;

if ($_SESSION['customer_sid'] == session_id()) {
    $user_id = $_SESSION['user_id'];

    // Allow all payment methods except wallet
    $continue = 1;

    $result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $contact = $row['contact'];
        $role = "Customer"; // add a default role
    }
} else {
    // Not logged in
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Provide Order Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="css/materialize.min.css" rel="stylesheet">
  <link href="css/style.min.css" rel="stylesheet">
  <link href="css/custom/custom.min.css" rel="stylesheet">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <style>
    #header.page-topbar {
    background-color: #f0f0f0; /* Light gray background */
}

#header.page-topbar .navbar-fixed .navbar-color {
    background-color: #f0f0f0; /* Ensures the navbar inside the header has the same color */
}
  </style>
</head>
<body>

<header id="header" class="page-topbar">
  <div class="navbar-fixed">
    <nav class="navbar-color">
      <div class="nav-wrapper">
        <ul class="left">                      
          <!-- <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo"><img src="images/logo.png" alt="logo"></a> <span class="logo-text">Logo</span></h1></li> -->
        </ul>
      </div>
    </nav>
  </div>
</header>

<div id="main">
  <div class="wrapper">

    <aside id="left-sidebar-nav">
      <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
          <div class="row">
            <div class="col s4">
              <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
            </div>
            <div class="col s8">
              <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name; ?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
              <p class="user-roal"><?php echo $role; ?></p>
            </div>
          </div>
        </li>
        <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Order Food</a></li>
        <li class="bold"><a href="orders.php" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Orders</a></li>
        <!-- <li class="bold"><a href="tickets.php" class="waves-effect waves-cyan"><i class="mdi-action-question-answer"></i> Tickets</a></li> -->
        <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Edit Details</a></li>
      </ul>
      <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
    </aside>

    <section id="content">
      <!-- <div id="breadcrumbs-wrapper">
        <div class="container">
          <div class="row">
            <div class="col s12">
              <h5 class="breadcrumbs-title">Provide Order Details</h5>
            </div>
          </div>
        </div>
      </div> -->
      <div id="breadcrumbs-wrapper">
  <div class="container">
    <div class="row">
      <div class="col s12">
        <h5 class="breadcrumbs-title" style="display: flex; align-items: center;">
          <a href="place-order.php" class="btn-flat waves-effect" style="margin-right: 10px;">
            <i class="material-icons">arrow_back</i>
          </a>
          Provide Order Details
        </h5>
      </div>
    </div>
  </div>
</div>


      <div class="container">
        <p class="caption">Receipt</p>
        <div class="divider"></div>

        <div class="row">
          <ul class="collection" id="issues-collection">
            <?php
            // Display user information
            echo '<li class="collection-item avatar">
              <i class="mdi-content-content-paste red circle"></i>
              <p><strong>Name:</strong> ' . $name . '</p>
              <p><strong>Contact Number:</strong> ' . $contact . '</p>
              <p><strong>Address:</strong> ' . htmlspecialchars($_POST['address']) . '</p>  
              <p><strong>Payment Type:</strong> ' . $_POST['payment_type'] . '</p>
              <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
              </li>';

            // Loop through the order items and calculate the total dynamically
            foreach ($_POST as $key => $value) {
              if (is_numeric($key)) {
                // Get item details
                $item_query = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
                if ($item_query && mysqli_num_rows($item_query) > 0) {
                  $item_row = mysqli_fetch_assoc($item_query);
                  $price = $item_row['price'];
                  $item_name = $item_row['name'];
                  $item_id = $item_row['id'];
                  $subtotal = $value * $price; // Calculate subtotal for the item
                  $total += $subtotal; // Add to the total

                  // Display the item details with item name, quantity, and subtotal
                  echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s7"><p class="collections-title"><strong>#' . $item_id . ' </strong>' . $item_name . '</p></div>
                            <div class="col s2"><span>' . $value . ' Pieces</span></div>
                            <div class="col s3"><span>Rs. ' . $subtotal . '</span></div>
                          </div>
                        </li>';
                }
              }
            }

            // Display the total at the end
            echo '<li class="collection-item">
                    <div class="row">
                      <div class="col s7"><p class="collections-title">Total</p></div>
                      <div class="col s2">&nbsp;</div>
                      <div class="col s3"><strong>Rs. ' . $total . '</strong></div>
                    </div>
                  </li>';

            // Display the note if provided
            if (!empty($_POST['description'])) {
              echo '<li class="collection-item avatar"><p><strong>Note: </strong>' . htmlspecialchars($_POST['description']) . '</p></li>';
            }
            ?>

            <!-- Form for order confirmation -->
            <form action="routers/order-router.php" method="post">
              <?php
              // Pass the item ids and quantities to the next page
              foreach ($_POST as $key => $value) {
                if (is_numeric($key)) {
                  echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                }
              }
              ?>
              <input type="hidden" name="payment_type" value="<?php echo $_POST['payment_type']; ?>">
              <input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address']); ?>">
              <?php if (isset($_POST['description'])) echo '<input type="hidden" name="description" value="' . htmlspecialchars($_POST['description']) . '">'; ?>
              <input type="hidden" name="total" value="<?php echo $total; ?>"> <!-- Send the calculated total -->
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Confirm Order
                  <i class="mdi-content-send right"></i>
                </button>
              </div>
            </form>
          </ul>
        </div>
      </div>
    </section>
  </div>
</div>

<footer class="page-footer">
  <div class="footer-copyright">
    <div class="container">
      <span>Copyright © NYS. All rights reserved.</span>
      <!-- <span class="right">Design and Developed by Students</span> -->
    </div>
  </div>
</footer>

<script src="js/plugins/jquery-1.11.2.min.js"></script>
<script src="js/plugins/angular.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="js/plugins.min.js"></script>
<script src="js/custom-script.js"></script>

</body>
</html>
