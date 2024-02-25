<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $password = $_POST["pwd"];

    // Validate and sanitize user input (you should implement proper validation)
    $f_name = filter_var($f_name, FILTER_SANITIZE_STRING);
    $l_name = filter_var($l_name, FILTER_SANITIZE_STRING);

    // Connect to database
    $servername = "localhost";
    $dbusername = "Victor";
    $dbpassword = "kipkemei@22";
    $dbname = "barber";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $sql = "SELECT f_name, l_name, password FROM register WHERE f_name = ? AND l_name = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $f_name, $l_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // User exists, verify the password
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                // Password is correct, create a session
                $_SESSION["f_name"] = $row["f_name"];
                $_SESSION["l_name"] = $row["l_name"];


                // Redirect to a welcome page or dashboard
                header("Refresh:5; URL=services.html");
                exit();
            } else {
                // Password is incorrect
                $login_error = "Invalid password. Please try again.";
            }
        } else {
            // User does not exist
            $login_error = "User not found. Please check your credentials.";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

