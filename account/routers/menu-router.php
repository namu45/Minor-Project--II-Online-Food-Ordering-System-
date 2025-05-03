<?php
include '../includes/connect.php';

// Check if database connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

foreach ($_POST as $key => $value) {
    // Update item name
    if (preg_match("/^([0-9]+)_name$/", $key, $matches)) {
        $id = $matches[1];
        if ($value != '') {
            $name = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $stmt = $con->prepare("UPDATE items SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $name, $id);
            if (!$stmt->execute()) {
                echo 'Error updating name for item ID ' . $id . '<br>';
            }
        }
    }

    // Update item price
    if (preg_match("/^([0-9]+)_price$/", $key, $matches)) {
        $id = $matches[1];
        if (is_numeric($value) && $value > 0) {
            $stmt = $con->prepare("UPDATE items SET price = ? WHERE id = ?");
            $stmt->bind_param("di", $value, $id);
            if (!$stmt->execute()) {
                echo 'Error updating price for item ID ' . $id . '<br>';
            }
        }
    }
}

// Handle image uploads separately
foreach ($_FILES as $key => $file) {
    if (preg_match("/^([0-9]+)_image$/", $key, $matches)) {
        $id = $matches[1];

        if ($file['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $file['tmp_name'];
            $fileType = $file['type'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $allowedTypes)) {
                $fileContent = file_get_contents($fileTmpPath);

                // Store image as BLOB using "s" for string
                $stmt = $con->prepare("UPDATE items SET image = ? WHERE id = ?");
                $stmt->bind_param("si", $fileContent, $id);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo 'Image updated for item ID ' . $id . '<br>';
                    } else {
                        echo 'No change to image for item ID ' . $id . '<br>';
                    }
                } else {
                    echo 'Image update failed for item ID ' . $id . ': ' . $stmt->error . '<br>';
                }
            } else {
                echo 'Invalid file type for item ID ' . $id . '. Allowed: JPEG, PNG, GIF.<br>';
            }
        } elseif ($file['error'] != UPLOAD_ERR_NO_FILE) {
            echo 'Upload error for item ID ' . $id . ': Error Code ' . $file['error'] . '<br>';
        }
    }
}

header("Location: ../admin-page.php");
exit();
?>
