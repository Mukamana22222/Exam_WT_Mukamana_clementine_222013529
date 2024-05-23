<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['EnrollmentID'])) {
    $EnrollmentID = $_REQUEST['EnrollmentID'];
    
    $stmt = $connection->prepare("SELECT * FROM enrollments WHERE EnrollmentID=?");
    $stmt->bind_param("s",$EnrollmentID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $z = $row['WorkshopID'];
        $y = $row['ParticipantID'];
        $w = $row['EnrollmentDate'];
    
    } else {
        echo "enrollments not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update enrollments</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF ENROLLMENTS</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 250px; margin-top: 20px;">

        <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>
        <label >ParticipantID:</label><br>
        <input type="number" name="ParticipantID" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >EnrollmentDate:</label><br>
        <input type="Date" name="EnrollmentDate" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $WorkshopID = $_POST['WorkshopID'];
    $ParticipantID = $_POST['ParticipantID'];
    $EnrollmentDate = $_POST['EnrollmentDate'];
   
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE enrollments SET WorkshopID=?, ParticipantID=?,EnrollmentDate=? WHERE EnrollmentID=?");
    $stmt->bind_param("iisi",$WorkshopID, $ParticipantID, $EnrollmentDate,  $EnrollmentID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:enrollments.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
