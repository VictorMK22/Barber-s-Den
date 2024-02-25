<?php
// Database connection configuration
$db_host = "localhost"; // Change to your database host
$db_username = "Victor"; // Change to your database username
$db_password = "kipkemei@22"; // Change to your database password
$db_name = "barber"; // Change to your database name

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["f_name"]) && isset($_POST["l_name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
        $f_name = $_POST["f_name"];
        $l_name = $_POST["l_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO register (f_name, l_name, email, password) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $f_name, $l_name, $email, $hashed_password);
            if ($stmt->execute()) {
                echo "Registered successfully.";
                // Redirect to login page after registration (change URL as needed)
                sleep(5);
                
                header("Location: login.html");
                exit(); // Make sure to exit to prevent further script execution
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Handle missing form fields
        echo "One or more required fields are missing.";
    }
}

// Close the database connection
$conn->close();
?>
