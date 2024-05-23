<?php

include('database_connection.php');

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving form data
    $fname  = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $telephone = $_POST['telephone'];
    $DoB = $_POST['DoB'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $activation_code = $_POST['activation_code'];
    
    // Preparing SQL query
    $sql = "INSERT INTO users (firstname, lastname, email, username,gender, password, telephone,DoB, activation_code) VALUES ('$fname','$lname','$email', '$username', '$gender', '$password','$telephone','$DoB','$activation_code')";

    // Executing SQL query
    if ($connection->query($sql) === TRUE) {
        // Redirecting to login page on successful registration
        header("Location:login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Closing database connection
$connection->close();
?>
