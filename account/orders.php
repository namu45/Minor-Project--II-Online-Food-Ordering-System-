<?php
include 'includes/connect.php';
include 'includes/wallet.php';

if ($_SESSION['customer_sid'] == session_id()) {

    // Define user variables if not already set
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Past Orders</title>

  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
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
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <!-- Header -->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <!-- <ul class="left">
            <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/logo.png" alt="logo"></a> <span class="logo-text">Logo</span></h1></li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li><a href="#" class="waves-effect waves-block waves-light"><i class="mdi-editor-attach-money"><?php echo $balance; ?></i></a></li>
          </ul> -->
        </div>
      </nav>
    </div>
  </header>

  <!-- Main -->
  <div id="main">
    <div class="wrapper">
      <!-- Sidebar -->
      <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
          <li class="user-details cyan darken-2">
            <div class="row">
              <div class="col s4">
                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
              </div>
              <div class="col s8">
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name; ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role; ?></p>
              </div>
              <ul id="profile-dropdown" class="dropdown-content">
                <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>
              </ul>
            </div>
          </li>
          <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Order Food</a></li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan active"><i class="mdi-editor-insert-invitation"></i> Orders</a>
                <div class="collapsible-body">
                  <ul>
                    <!-- All Orders Link -->
                    <li class="<?php if (!isset($_GET['status'])) echo 'active'; ?>"><a href="orders.php">All Orders</a></li>

                    <!-- Cancelled Orders Link -->
                    <li class="<?php if (isset($_GET['status']) && $_GET['status'] == 'Cancelled by Customer') echo 'active'; ?>">
                      <a href="orders.php?status=Cancelled by Customer">Cancelled by Customer</a>
                    </li>

                    <!-- Yet to be Delivered Orders Link -->
                    <li class="<?php if (isset($_GET['status']) && $_GET['status'] == 'Yet to be Delivered') echo 'active'; ?>">
                      <a href="orders.php?status=Yet to be Delivered">Yet to be Delivered</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
          <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Edit Details</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
      </aside>

      <!-- Content -->
      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Past Orders</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">List of your past orders with details</p>
          <div class="divider"></div>
          <div id="work-collections" class="section">
            <?php
            $status_filter = isset($_GET['status']) ? $_GET['status'] : '%';
            $orders_query = mysqli_query($con, "SELECT * FROM orders WHERE customer_id = $user_id AND status LIKE '$status_filter'");
            echo '<div class="row"><div><h4 class="header">List</h4><ul id="issues-collection" class="collection">';

            if (mysqli_num_rows($orders_query) == 0) {
              echo '<li class="collection-item">No orders found.</li>';
            }
            while ($order = mysqli_fetch_array($orders_query)) {
              $order_id = $order['id'];
              $status = $order['status'];
              echo '<li class="collection-item avatar">
                <i class="mdi-content-content-paste red circle"></i>
                <span class="collection-header">Order No. ' . $order['id'] . '</span>
                <p><strong>Date:</strong> ' . $order['date'] . '</p>
                <p><strong>Payment Type:</strong> ' . $order['payment_type'] . '</p>
                <p><strong>Address:</strong> ' . $order['address'] . '</p>
                <p><strong>Status:</strong> ' . ($status == 'Paused' ? 'Paused <a data-tooltip="Please contact administrator for further details." class="btn-floating tooltipped cyan">?</a>' : $status) . '</p>';
              if (!empty($order['description'])) {
                echo '<p><strong>Note:</strong> ' . $order['description'] . '</p>';
              }
              echo '<a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a></li>';

              $details_query = mysqli_query($con, "SELECT * FROM order_details WHERE order_id = $order_id");
              while ($detail = mysqli_fetch_array($details_query)) {
                $item_id = $detail['item_id'];
                $item_result = mysqli_query($con, "SELECT name FROM items WHERE id = $item_id");
                $item = mysqli_fetch_assoc($item_result);
                $item_name = $item['name'];

                echo '<li class="collection-item">
                        <div class="row">
                          <div class="col s7">
                            <p class="collections-title"><strong>#' . $item_id . '</strong> ' . $item_name . '</p>
                          </div>
                          <div class="col s2"><span>' . $detail['quantity'] . ' Pieces</span></div>
                          <div class="col s3"><span>Rs. ' . $detail['price'] . '</span></div>
                        </div>
                      </li>';
              }

              echo '<li class="collection-item">
                      <div class="row">
                        <div class="col s7"><p class="collections-title">Total</p></div>
                        <div class="col s2"><span></span></div>
                        <div class="col s3"><span><strong>Rs. ' . $order['total'] . '</strong></span></div>';
              if (!preg_match('/^Cancelled/', $status) && $status != 'Delivered') {
                echo '<form action="routers/cancel-order.php" method="post">
                        <input type="hidden" name="id" value="' . $order_id . '">
                        <input type="hidden" name="status" value="Cancelled by Customer">
                        <input type="hidden" name="payment_type" value="' . $order['payment_type'] . '">
                        <button class="btn waves-effect waves-light right submit" type="submit" name="action">Cancel Order
                          <i class="mdi-content-clear right"></i>
                        </button>
                      </form>';
              }
              echo '</div></li>';
            }
            echo '</ul></div></div>';
            ?>
          </div>
        </div>
      </section>
    </div>
  </div>

  <!-- Footer -->
  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2025 <a class="grey-text text-lighten-4" href="#">NYS</a> All rights reserved.</span>
        <!-- <span class="right">Design and Developed by <a class="grey-text text-lighten-4" href="#">Students</a></span> -->
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript">
    $(window).on('load', function () {
      $('#loader-wrapper').fadeOut('slow');
    });
  </script>
</body>

</html>
<?php
} else {
  if ($_SESSION['admin_sid'] == session_id()) {
    header("location:all-orders.php");
  } else {
    header("location:login.php");
  }
}
?>
