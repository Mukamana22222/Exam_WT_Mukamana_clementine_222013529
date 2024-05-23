<?php
include('database_connection.php');
// Check if patient_Id is set
if(isset($_REQUEST['AttendenceID'])) {
    $AttendenceID = $_REQUEST['AttendenceID'];
    
    $stmt = $connection->prepare("SELECT * FROM attendence WHERE AttendenceID=?");
    $stmt->bind_param("s",$AttendenceID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['AttendenceStatus'];
        $z = $row['CheckInTime'];
        $k = $row['CheckOutTime'];
        $w = $row['WorkshopID'];
        $t = $row['ParticipantID'];
    } else {
        echo "attendence not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update attendence</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF ATTENDENCES</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 350px; margin-top: 20px;">
         <label >AttendenceStatus:</label><br>
        <input type="text" name="AttendenceStatus" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >CheckInTime:</label><br>
        <input type="DateTime-local" name="CheckInTime" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >CheckOutTime:</label><br>
        <input type="DateTime-local" name="CheckOutTime" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >ParticipantID:</label><br>
        <input type="number" name="ParticipantID" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
        <br><br>
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $AttendenceStatus = $_POST['AttendenceStatus'];
    $CheckInTime = $_POST['CheckInTime'];
    $CheckOutTime = $_POST['CheckOutTime'];
    $WorkshopID = $_POST['WorkshopID'];
    $ParticipantID = $_POST['ParticipantID'];
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE attendence SET AttendenceStatus=?, CheckInTime=?, CheckOutTime=?,WorkshopID=?,ParticipantID=? WHERE AttendenceID=?");
    $stmt->bind_param("sssiii", $AttendenceStatus, $CheckInTime, $CheckOutTime, $WorkshopID, $ParticipantID, $AttendenceID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:attendences.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
