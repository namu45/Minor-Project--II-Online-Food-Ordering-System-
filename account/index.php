<?php
include 'includes/connect.php';
include 'includes/wallet.php';

if($_SESSION['customer_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Order Food</title>

  <!-- CORE CSS -->
  <link href="css/materialize.min.css" rel="stylesheet">
  <link href="css/style.min.css" rel="stylesheet">
  <link href="css/custom/custom.min.css" rel="stylesheet">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" rel="stylesheet">

  <style>
    .food-item-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;
    }

    .card {
      transition: box-shadow 0.3s ease-in-out;
      border-radius: 6px;
    }

    .card:hover {
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .card-content {
      padding: 16px;
    }

    .card-title {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 8px;
      color: #444;
    }

    .card-content p {
      margin-bottom: 12px;
      color: #777;
    }

    .input-field input[type="number"] {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 4px 8px;
    }

    .input-field label {
      font-size: 0.9rem;
      color: #999;
    }

    .btn {
      border-radius: 20px;
      padding: 0 20px;
    }
    #header.page-topbar {
    background-color: #f0f0f0; /* Light gray background */
}

#header.page-topbar .navbar-fixed .navbar-color {
    background-color: #f0f0f0; /* Ensures the navbar inside the header has the same color */
}

/* Error Message Styling */
#error-message {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  /* background-color: #f8d7da; */
  color: red;
  font-size: 18px;
  border-radius: 8px;
  z-index: 9999;
  text-align: center;
  width: 80%;
  max-width: 500px; /* Maximum width for large screens */
}

#error-message p {
  margin: 0;
  font-weight: bold;
}


  </style>
</head>
<body>
  <!-- LOADER -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <!-- HEADER -->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper"></div>
      </nav>
    </div>
  </header>
  <!-- Error Message Container -->
<div id="error-message" class="error-message" style="display: none;">
  <p>Please select at least one item before placing the order.</p>
</div>



  <!-- MAIN -->
  <div id="main">
    <div class="wrapper">

      <!-- SIDEBAR -->
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
            </div>
          </li>

          <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                        </li>
                    </ul>
                </div>

          

          <li class="bold active"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Order Food</a></li>

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

      <!-- CONTENT -->
      <section id="content">
        <div class="container">
          <form class="formValidate" id="formValidate" method="post" action="place-order.php" novalidate>
            <div class="row">
              <div class="col s12">
                <h4 class="header">🍽️ Order Your Food</h4>
              </div>

              <!-- Grid Cards -->
              <div class="row">
                <?php
                $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
                while($row = mysqli_fetch_array($result)) {
                ?>
                <div class="col s12 m6 l4">
                  <div class="card z-depth-1">
                    <div class="card-image">
                      <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" class="food-item-image">
                    </div>
                    <div class="card-content">
                      <span class="card-title"><?php echo $row["name"]; ?></span>
                      <p>₹<?php echo $row["price"]; ?></p>
                      <div class="input-field">
                        <input id="<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" type="number" min="0" max="10" value="0" data-error=".errorTxt<?php echo $row["id"]; ?>">
                        <label for="<?php echo $row["id"]; ?>">Quantity</label>
                        <div class="errorTxt<?php echo $row["id"]; ?>"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>

              <!-- Optional Notes -->
              <div class="input-field col s12">
                <i class="mdi-editor-mode-edit prefix"></i>
                <textarea id="description" name="description" class="materialize-textarea"></textarea>
                <label for="description">Any note (optional)</label>
              </div>

              <!-- Submit Button -->
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Place Order
                  <i class="mdi-content-send right"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2025 <a class="grey-text text-lighten-4" href="#">NYS</a> All rights reserved.</span>
      </div>
    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="js/plugins/jquery-1.11.2.min.js"></script>    
  <script src="js/plugins/angular.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script src="js/plugins/data-tables/data-tables-script.js"></script>
  <script src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="js/plugins.min.js"></script>
  <script src="js/custom-script.js"></script>

  <!-- Form Validation Script -->
  <script>
    $("#formValidate").validate({
      rules: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
        while($row = mysqli_fetch_array($result)) {
          echo $row["id"] . ": { min: 0, max: 10 },";
        }
        ?>
      },
      messages: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
        while($row = mysqli_fetch_array($result)) {
          echo $row["id"] . ": { min: 'Minimum 0', max: 'Maximum 10' },";
        }
        ?>
      },
      errorElement: 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error);
        } else {
          error.insertAfter(element);
        }
      }
    });
  </script>
  <script>
  $(document).ready(function() {
    // Form validation before submitting
    $("#formValidate").submit(function(event) {
      var isItemSelected = false;

      // Hide error message initially
      $("#error-message").hide();

      // Check if any quantity is greater than 0
      $("input[type='number']").each(function() {
        if ($(this).val() > 0) {
          isItemSelected = true;
          return false;  // Stop the loop once an item is selected
        }
      });

      // If no item is selected, prevent form submission and show error message
      if (!isItemSelected) {
        event.preventDefault(); // Prevent form submission
        // Show the error message
        $("#error-message").fadeIn(); // Fade in for smooth appearance

        // Set timeout to hide the message after 3 seconds (3000 milliseconds)
        setTimeout(function() {
          $("#error-message").fadeOut(); // Fade out the message after the time
        }, 2000); // 3000ms = 3 seconds
      }
    });
  });
</script>


</body>
</html>
<?php
} else {
  if($_SESSION['admin_sid'] == session_id()) {
    header("location:admin-page.php");		
  } else {
    header("location:login.php");
  }
}
?>
