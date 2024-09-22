<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Debugging: Print the received POST data
    echo "</pre>";
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validate form data
if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    // Prepare SQL query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO info (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        echo "Data successfully saved!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Please fill all the fields.";
}

// Close connection
$conn->close();
?>
