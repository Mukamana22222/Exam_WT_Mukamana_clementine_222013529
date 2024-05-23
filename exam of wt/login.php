<?php
session_start(); // Start the session

include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username=?"; 
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            
            header("Location:home.html");
        
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "User not found";
    }
}

$connection->close();
?>
