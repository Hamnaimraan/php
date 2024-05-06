<?php
session_start(); // Start session

// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "ecommerce"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["name"];
    $password = $_POST["pass"];

    // Validate form data
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Hash the password because ive saved in hashed form in database
        $hashed_password = md5($password);

        // SQL query to check if the username and password match a record in the database
        $sql = "SELECT * FROM login WHERE username='$username' AND password='$hashed_password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Login successful
            $_SESSION["username"] = $username;
            header("Location: index.html"); 
            exit();
        } else {
            
            $error = "Invalid username or password. Please try again.";
        }
    }
}

// Close connection
$conn->close();
?>
