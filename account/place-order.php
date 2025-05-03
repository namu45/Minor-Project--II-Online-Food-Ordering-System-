<?php
include 'includes/connect.php';
include 'includes/wallet.php';
$total = 0;

if ($_SESSION['customer_sid'] == session_id()) {
    $result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $address = $row['address'];
        $contact = $row['contact'];
        $verified = $row['verified'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Provide Order Details</title>

    <!-- CORE CSS-->
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- Leaflet CSS (for the map) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

    <style type="text/css">
        #map {
            height: 300px;
            width: 100%;
        }

        .input-field div.error {
            position: relative;
            top: -1rem;
            left: 0rem;
            font-size: 0.8rem;
            color: #FF4081;
            transform: translateY(0%);
        }

        .input-field label.active {
            width: 100%;
        }

        .input-field i.prefix {
            position: absolute;
            top: 0;
            left: 10px;
            padding: 0;
            line-height: 3rem;
            font-size: 1.5rem;
        }

        .input-field textarea {
            padding-left: 40px;
            margin-top: 1rem;
            min-height: 80px;
            height: auto;
        }

        .input-field select {
            padding-left: 2rem;
        }

        #content {
            padding-left: 240px;
        }

        @media only screen and (max-width: 992px) {
            #content {
                padding-left: 0;
            }
        }

        #estimated-receipt {
            margin-left: 240px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media only screen and (max-width: 992px) {
            #estimated-receipt {
                margin-left: 0;
            }
        }

        .container {
            padding-left: 0;
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
  
    <header id="header" class="page-topbar">
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper"></div>
            </nav>
        </div>
    </header>

    <div id="main">
        <div class="wrapper">
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li class="user-details cyan darken-2">
                        <div class="row">
                            <div class="col s4 m4 l4">
                                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
                            </div>
                            <div class="col s8 m8 l8">
                                <a href="#" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn"><?php echo $name;?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                                <p class="user-roal"><?php echo $role;?></p>
                            </div>
                        </div>
                    </li>
                    <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Order Food</a></li>
                    <li class="bold"><a href="orders.php" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Orders</a></li>
                    <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Edit Details</a></li>  
                </ul>
            </aside>

            <div class="container">
                <p class="caption">Provide required delivery and payment details.</p>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s12 m4 l3">
                        <h4 class="header">Details</h4>
                    </div>
                    <div class="card-panel">
                        <div class="row">
                            <form class="formValidate col s12 m12 l6" id="formValidate" method="post" action="confirm-order.php" novalidate="novalidate">
                                
                                <div class="input-field col s12">
                                    <i class="mdi-action-payment prefix"></i>
                                    <select id="payment_type" name="payment_type" class="browser-default">
                                        <option value="Cash On Delivery" selected>Cash on Delivery</option>
                                        <!-- <option value="eSewa">eSewa</option> -->
                                    </select>
                                    <label for="payment_type" class="active">Payment Type</label>
                                </div>
                                 
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="mdi-action-home prefix"></i>
                                        <textarea name="address" id="address" class="materialize-textarea validate" data-error=".errorTxt1"><?php echo $address;?></textarea>
                                        <label for="address" class="">Address</label>
                                        <div class="errorTxt1"></div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <div id="map"></div>
                                    </div>
                                </div>

                                <!-- Hidden inputs to pass selected food items to confirm-order.php -->
<?php
foreach ($_POST as $key => $value) {
    if ($value == '' || $value == 0) {
        continue;
    }
    echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
}
?>

<div class="row">
    <div class="input-field col s12">
        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
            <i class="mdi-content-send right"></i>
        </button>
    </div>
</div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container" id="estimated-receipt">
        <p class="caption">Estimated Receipt</p>
        <div class="divider"></div>

        <div id="work-collections" class="section">
            <div class="row">
                <div>
                    <ul id="issues-collection" class="collection">
                        <?php
                        echo '<li class="collection-item avatar">
                            <i class="mdi-content-content-paste red circle"></i>
                            <p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>
                            <p><strong>Contact Number:</strong> ' . htmlspecialchars($contact) . '</p>
                            <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                        </li>';

                        // Initialize total amount
                        $total = 0;

                        // Loop through the POST data (selected items)
                        foreach ($_POST as $key => $value) {
                            if ($value == '' || $value == 0) {
                                continue; // Skip empty or zero values (unchecked items)
                            }
                            // Fetch item details from the database based on POST data
                            $result = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $item_name = $row['name'];
                                $price_per_item = $row['price'];

                                // Calculate the price for the selected quantity
                                $item_total_price = $value * $price_per_item;
                                $total += $item_total_price;

                                // Display only the selected items
                                echo '<li class="collection-item">
                                    <div class="row">
                                        <div class="col s7">
                                            <p class="collections-title"><strong>' . htmlspecialchars($item_name) . '</strong></p>
                                        </div>
                                        <div class="col s2">
                                            <span>' . intval($value) . ' Pieces</span>
                                        </div>
                                        <div class="col s3">
                                            <span>Rs. ' . number_format($item_total_price, 2) . '</span>
                                        </div>
                                    </div>
                                </li>';
                            }
                        }

                        // Display total amount
                        echo '<li class="collection-item">
                            <div class="row">
                                <div class="col s7">
                                    <p class="collections-title">Total</p>
                                </div>
                                <div class="col s2">
                                    <span>&nbsp;</span>
                                </div>
                                <div class="col s3">
                                    <span><strong>Rs. ' . number_format($total, 2) . '</strong></span>
                                </div>
                            </div>
                        </li>';

                        // Display any additional note
                        if (!empty($_POST['description'])) {
                            echo '<li class="collection-item avatar">
                                <p><strong>Note: </strong>' . htmlspecialchars($_POST['description']) . '</p>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
  
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                <span>Copyright © 2025 <a class="grey-text text-lighten-4" href="#" target="_blank">NYS</a> All rights reserved.</span>
            </div>
        </div>
    </footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([28.2096, 83.9856], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([27.7172, 85.3240], { draggable: true }).addTo(map);

    function updateAddress(lat, lng) {
        const addressField = document.getElementById('address');

        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    addressField.value = data.display_name;
                } else {
                    addressField.value = `Latitude: ${lat}, Longitude: ${lng}`;
                }

                M.textareaAutoResize(addressField);
                addressField.dispatchEvent(new Event('input'));
                addressField.classList.add('valid');
            });
    }

    map.on('click', function(e) {
        var latLng = e.latlng;
        marker.setLatLng(latLng);
        updateAddress(latLng.lat, latLng.lng);
    });

    marker.on('dragend', function(e) {
        var latLng = e.target.getLatLng();
        updateAddress(latLng.lat, latLng.lng);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var selectElems = document.querySelectorAll('select');
        M.FormSelect.init(selectElems);

        var addressField = document.getElementById('address');
        M.textareaAutoResize(addressField);
    });
</script>

</body>
</html>
<?php
} else {
    if ($_SESSION['admin_sid'] == session_id()) {
        header("location:admin-page.php");
    } else {
        header("location:login.php");
    }
}
