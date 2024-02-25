<?php
// Database connection configuration
$db_host = "localhost";
$db_username = "Victor";
$db_password = "kipkemei@22";
$db_name = "barber";

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $service = $_POST["select_a_service"];
    $date = $_POST["preferred_date"];
    $time = $_POST["preferred_time"];
    $comments = $_POST["additional_comments"];

    // Insert data into the appointments table
    $sql = "INSERT INTO booking (name, email, phone, select_a_service, preferred_date, preferred_time, additional_comments) VALUES ('$name', '$email', '$phone', '$service', '$date', '$time', '$comments')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully.";

        // Redirect to services.html after 2 seconds
        echo '<meta http-equiv="refresh" content="2;url=services.html">';
        exit(); // Make sure to exit to prevent further script execution
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

