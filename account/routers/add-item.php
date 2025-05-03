<?php
include '../includes/connect.php';

// Get the data from the form
$name = $_POST['name'];
$price = $_POST['price'];

// Check if the image is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    // Get the image content
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    
    // Prepare the SQL query
    $sql = "INSERT INTO items (name, price, image) VALUES ('$name', $price, '$image')";
} else {
    // If no image is uploaded, you can either use a default image or do nothing. Here, it's assumed to use a default.
    $default_image = 'path_to_default_image.jpg';
    
    // Prepare the SQL query with the default image
    $sql = "INSERT INTO items (name, price, image) VALUES ('$name', $price, '$default_image')";
}

// Execute the query
if ($con->query($sql)) {
    // If insertion is successful, redirect to the admin page (or a success page)
    header("Location: ../admin-page.php");
} else {
    // If there's an error, display the error message
    echo "Error: " . $con->error;
}
?>
