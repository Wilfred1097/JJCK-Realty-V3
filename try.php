<?php
require './conn/db.php';

// SQL query to select all data from users table
$sql = "SELECT * FROM lot_table";

// Execute query
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Access the data using $row['column_name']
        echo "Dimension: " . $row["dimension"]. "Block #: " . $row["block_number"]. "Lot #: " . $row["lot_number"]. "Downpayment: " . $row["downpayment"]. " - Price: " . $row["price"]. " - Term: " . $row["term"]. " - Image: " . $row["image"]."<br>";
        // You can access other columns in a similar way
    }
} else {
    echo "0 results";
}
?>