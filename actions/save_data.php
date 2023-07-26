<?php
// save_data.php

// Your database connection code
include_once 'db.php';

// Retrieve the JSON data from the AJAX request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Process the data and insert it into the database
foreach ($data as $row) {
    $id = $row['id'];
    $amount = $row['amount'];
    $total = $row['total'];

    // Perform the database insertion using prepared statements to prevent SQL injection
    // Replace the placeholders with your actual database insert code
    $stmt = $con->prepare("UPDATE `ordered_items` SET amount=?, total=? WHERE id=?");
    $stmt->bind_param("sis", $amount, $total, $id);
    $stmt->execute();
}

// Return a response to the client
echo "Data successfully inserted into the database!";
?>