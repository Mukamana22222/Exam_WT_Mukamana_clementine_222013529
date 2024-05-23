<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['TopicID'])) {
    $TopicID = $_REQUEST['TopicID'];
    
    $stmt = $connection->prepare("SELECT * FROM topics WHERE TopicID=?");
    $stmt->bind_param("i",$TopicID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $z = $row['TopicName'];
    
    } else {
        echo "enrollments not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update topics</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF TOPICS</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 150px; margin-top: 20px;">

        <label >TopicName:</label><br>
        <input type="text" name="TopicName" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $TopicName = $_POST['TopicName'];
    
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE topics SET TopicName=? WHERE TopicID=?");
    $stmt->bind_param("si",$TopicName,$TopicID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:topics.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
