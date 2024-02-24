<?php
// Include the database connection file
require_once 'conn/db.php';

// Function to sanitize input values
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input));
}

// Check if all required data is received
if (isset($_POST['user_id'], $_POST['lot_Id'], $_POST['tour_date'], $_POST['status'])) {
    // Sanitize and validate received data
    $user_id = sanitize($conn, $_POST['user_id']);
    $lot_Id = sanitize($conn, $_POST['lot_Id']);
    $tour_date = sanitize($conn, $_POST['tour_date']);
    $status = sanitize($conn, $_POST['status']);

    // Check if the combination of lot_Id, userId, and request_date already exists in the database
    $check_sql = "SELECT * FROM tour_request_table WHERE userId = '$user_id' AND lot_Id = '$lot_Id' AND request_date = '$tour_date'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Combination already exists, send response to property_single.php
        echo "Tour request already exists for this user, lot, and date.";
    } else {
        // Combination does not exist, proceed to insert data into tour_request_table
        $insert_sql = "INSERT INTO tour_request_table (userId, lot_Id, request_date, status) VALUES ('$user_id', '$lot_Id', '$tour_date', '$status')";
        if ($conn->query($insert_sql) === TRUE) {
            // Tour request submitted successfully, send response to property_single.php
            echo "Tour request submitted successfully.";
        } else {
            // Error occurred during insertion, send response to property_single.php
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
    // Incomplete data received, send response to property_single.php
    echo "Incomplete data received.";
}
?>
