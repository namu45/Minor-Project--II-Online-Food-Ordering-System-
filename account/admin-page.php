<!-- <?php
include 'includes/connect.php'; 




if($_SESSION['admin_sid']==session_id())
{
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="msapplication-tap-highlight" content="no">
<title>Food Menu</title>

<!- Favicons-->
<!-- <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32"> -->
<!-- Favicons-->
<link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
<!-- For iPhone -->
<meta name="msapplication-TileColor" content="#00bcd4">
<meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
<!-- For Windows Phone -->


<!-- CORE CSS-->
<link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- Custome CSS-->    
<link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">

 <style type="text/css">
.input-field div.error{
position: relative;
top: -1rem;
left: 0rem;
font-size: 0.8rem;
color:#FF4081;
-webkit-transform: translateY(0%);
-ms-transform: translateY(0%);
-o-transform: translateY(0%);
transform: translateY(0%);
}
.input-field label.active{
  width:100%;
}
.left-alert input[type=text] + label:after, 
.left-alert input[type=password] + label:after, 
.left-alert input[type=email] + label:after, 
.left-alert input[type=url] + label:after, 
.left-alert input[type=time] + label:after,
.left-alert input[type=date] + label:after, 
.left-alert input[type=datetime-local] + label:after, 
.left-alert input[type=tel] + label:after, 
.left-alert input[type=number] + label:after, 
.left-alert input[type=search] + label:after, 
.left-alert textarea.materialize-textarea + label:after{
  left:0px;
}
.right-alert input[type=text] + label:after, 
.right-alert input[type=password] + label:after, 
.right-alert input[type=email] + label:after, 
.right-alert input[type=url] + label:after, 
.right-alert input[type=time] + label:after,
.right-alert input[type=date] + label:after, 
.right-alert input[type=datetime-local] + label:after, 
.right-alert input[type=tel] + label:after, 
.right-alert input[type=number] + label:after, 
.right-alert input[type=search] + label:after, 
.right-alert textarea.materialize-textarea + label:after{
  right:70px;
}
#header.page-topbar {
    background-color: #f0f0f0; /* Light gray background */
}

#header.page-topbar .navbar-fixed .navbar-color {
    background-color: #f0f0f0; /* Ensures the navbar inside the header has the same color */
}
</style> 
</head>

<body>
<!-- Start Page Loading -->
<div id="loader-wrapper">
  <div id="loader"></div>        
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->

<!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <!-- <ul class="left">                      
                  <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/logo.png" alt="logo"></a> <span class="logo-text">Logo</span></h1></li>
                </ul> -->
            </div>
        </nav>
    </div>
    <!-- end header nav-->
</header>
<!-- END HEADER -->

<!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START MAIN -->
<div id="main">
<!-- START WRAPPER -->
<div class="wrapper">

  <!-- START LEFT SIDEBAR NAV-->
  <aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
        <div class="row">
            <div class="col col s4 m4 l4">
                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
            </div>
             <div class="col col s8 m8 l8">
                <ul id="profile-dropdown" class="dropdown-content">
                    <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col col s8 m8 l8">
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name;?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role;?></p>
            </div>
        </div>
        </li>
        <li class="bold active"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Food Menu</a>
        </li>


            <!-- <li class="no-padding"> 
                <ul class="collapsible collapsible-accordion"> 
                    <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Orders</a>
                        <div class="collapsible-body">
                            <ul>
                            <li><a href="all-orders.php">All Orders</a>
                            </li> 
                             <?php 
                                // $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                                // while($row = mysqli_fetch_array($sql)){
                                // echo '<li><a href="all-orders.php?status='.$row['status'].'">'.$row['status'].'</a>
                                // </li>';
                                // }
                                 ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li> -->
            <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold"><a class="collapsible-header waves-effect waves-cyan active"><i class="mdi-editor-insert-invitation"></i> Orders</a>
                <div class="collapsible-body">
                  <ul>
                    <li class="<?php if (!isset($_GET['status'])) echo 'active'; ?>"><a href="all-orders.php">All Orders</a></li>
                    <?php
                    $allowed_statuses = array('Yet to be delivered', 'Cancelled by Customer', 'Paused');
                    foreach ($allowed_statuses as $allowed_status) {
                      $active = (isset($_GET['status']) && $_GET['status'] == $allowed_status) ? 'active' : '';
                      echo '<li class="'.$active.'"><a href="all-orders.php?status='.$allowed_status.'">'.$allowed_status.'</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
              
            
        <li class="bold"><a href="users.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Users</a>
        </li>				
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
    </aside>
  <!-- END LEFT SIDEBAR NAV-->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START CONTENT -->
  <section id="content">

    <!--breadcrumbs start-->
    
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container">
      
      <!-- <form class="formValidate" id="formValidate" method="post" action="routers/menu-router.php" novalidate="novalidate"> -->
       <form class="formValidate" id="formValidate" method="post" action="routers/menu-router.php" enctype="multipart/form-data" novalidate="novalidate">

      <div class="row">
          <div class="col s12 m4 l3">
            <h4 class="breadcrumbs-title">Edit Menu Items</h4>
          </div>
          <div>
            <table id="data-table-admin" class="responsive-table display" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Item Price/Piece</th>
                    <th>Image</th>
                  </tr>
                </thead>

                <tbody>
<?php
$result = mysqli_query($con, "SELECT * FROM items");
while($row = mysqli_fetch_array($result))
{
    echo '<tr>';

    // Name input
    echo '<td><div class="input-field">';
    echo '<input value="'.htmlspecialchars($row["name"]).'" id="'.$row["id"].'_name" name="'.$row["id"].'_name" type="text">';
    echo '<label for="'.$row["id"].'_name" class="active">Name</label>';
    echo '</div></td>';

    // Price input
    echo '<td><div class="input-field">';
    echo '<input value="'.htmlspecialchars($row["price"]).'" id="'.$row["id"].'_price" name="'.$row["id"].'_price" type="text">';
    echo '<label for="'.$row["id"].'_price" class="active">Price</label>';
    echo '</div></td>';

    // Image display and upload
    
    echo '<td>';
    if (!empty($row['image'])) {
        echo '<div style="position: relative; width: 200px; height: 200px; overflow: hidden; border-radius: 10px; margin-bottom: 10px;">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" style="width:100%; height:100%; object-fit:cover;">';
    
        // Overlay button
        echo '<div style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.5); text-align: center;">';
        echo '<label style="color: #fff; padding: 5px 0; display: block; cursor: pointer;">Change';
        echo '<input type="file" name="'.$row['id'].'_image" accept="image/*" style="display:none;">';
        echo '</label>';
        echo '</div>';
    
        echo '</div>';
    } else {
        echo '<span style="display:block; margin-bottom:10px;">No Image</span>';
        echo '<div class="file-field input-field">';
        echo '<div class="btn"><span>Change</span>';
        echo '<input type="file" name="'.$row['id'].'_image" accept="image/*">';
        echo '</div>';
        echo '<div class="file-path-wrapper">';
        echo '<input class="file-path validate" type="text" placeholder="Upload new image (optional)">';
        echo '</div></div>';
    }
    
    echo '</td>';
    echo '</tr>';
    
}
?>
</tbody>
 


</table>
          </div>
          <div class="input-field col s12">
                          <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Modify
                            <i class="mdi-content-send right"></i>
                          </button>
                        </div>
        </div>
        </form>
      <form class="formValidate" id="formValidate1" method="post" action="routers/add-item.php" novalidate="novalidate" enctype="multipart/form-data">
<div class="row">
    <div class="col s12 m4 l3">
        <h4 class="header">Add Item</h4>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th data-field="id">Name</th>
                    <th data-field="name">Item Price/Piece</th>
                    <th data-field="image">Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr><td><div class="input-field col s12"><label for="name">Name</label>';
                echo '<input id="name" name="name" type="text" data-error=".errorTxt01"><div class="errorTxt01"></div></td>';					
                echo '<td><div class="input-field col s12"><label for="price" class="">Price</label>';
                echo '<input id="price" name="price" type="text" data-error=".errorTxt02"><div class="errorTxt02"></div></td>';
                echo '<td><div class="input-field col s12">';
                echo '<input type="file" id="image" name="image" data-error=".errorTxt01"><div class="errorTxt01"></div></td>';                   
                echo '<td></tr>';
                ?>
            </tbody>
        </table>
    </div>
    <div class="input-field col s12">
        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Add
            <i class="mdi-content-send right"></i>
        </button>
    </div>
</div>
</form>

<!-- Add some styling to make images the same size -->
<style>
.item-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 5px;
}
</style>





<!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START FOOTER -->
<footer class="page-footer">
<div class="footer-copyright">
  <div class="container">
    <span>Copyright © 2025 <a class="grey-text text-lighten-4" href="#" target="_blank">NYS</a> All rights reserved.</span>
    <!-- <span class="right"> Design and Developed by <a class="grey-text text-lighten-4" href="#">Students</a></span> -->
    </div>
</div>
</footer>
<!-- END FOOTER -->



<!-- ================================================
Scripts
================================================ -->


<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
<!--angularjs-->
<script type="text/javascript" src="js/plugins/angular.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.min.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- data-tables -->
<script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/data-tables/data-tables-script.js"></script>

<script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.min.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>
    <script type="text/javascript">
$("#formValidate").validate({
    rules: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items");
        while($row = mysqli_fetch_array($result))
        {
            echo $row["id"].'_name:{
            required: true,
            minlength: 5,
            maxlength: 20 
            },';
            echo $row["id"].'_price:{
            required: true,	
            min: 0
            },';				
        }
    echo '},';
    ?>
    messages: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items");
        while($row = mysqli_fetch_array($result))
        {  
            echo $row["id"].'_name:{
            required: "Ener item name",
            minlength: "Minimum length is 5 characters",
            maxlength: "Maximum length is 20 characters"
            },';
            echo $row["id"].'_price:{
            required: "Ener price of item",
            min: "Minimum item price is Rs. 0"
            },';				
        }
    echo '},';
    ?>
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
 });
</script>
<script type="text/javascript">
$("#formValidate1").validate({
    rules: {
    name: {
            required: true,
            minlength: 5
        },
    price: {
            required: true,
            min: 0
        },
},
    messages: {
    name: {
            required: "Enter item name",
            minlength: "Minimum length is 5 characters"
        },
     price: {
            required: "Enter item price",
            minlength: "Minimum item price is Rs.0"
        },
},
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
 });
</script>
</body>

</html>
<?php
}
else
{
    if($_SESSION['customer_sid']==session_id())
    {
        header("location:index.php");		
    }
    else{
        header("location:login.php");
    }
}
?>