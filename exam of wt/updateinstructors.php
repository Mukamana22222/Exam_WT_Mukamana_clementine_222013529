<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['InstructorID'])) {
    $InstructorID = $_REQUEST['InstructorID'];
    
    $stmt = $connection->prepare("SELECT * FROM instructors WHERE InstructorID=?");
    $stmt->bind_param("s",$InstructorID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $z = $row['Name'];
        $y = $row['Email'];
        $w = $row['Phone'];
    
    } else {
        echo "instructors not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update instructors</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF INSTRUCTORS</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 250px; margin-top: 20px;">

        <label >Name:</label><br>
        <input type="text" name="Name" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>
        <label >Email:</label><br>
        <input type="email" name="Email" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >Phone:</label><br>
        <input type="number" name="Phone" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $Name = $_POST['Name'];
    $Email= $_POST['Email'];
    $Phone = $_POST['Phone'];
   
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE instructors SET Name=?,Email=?,Phone=? WHERE InstructorID=?");
    $stmt->bind_param("sssi",$Name, $Email, $Phone,  $InstructorID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:instructors.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
