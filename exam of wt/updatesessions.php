<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['SessionID'])) {
    $SessionID = $_REQUEST['SessionID'];
    
    $stmt = $connection->prepare("SELECT * FROM sessions WHERE SessionID=?");
    $stmt->bind_param("s",$SessionID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['WorkshopID'];
        $z = $row['Title'];
        $k = $row['Description'];
        $w = $row['SessionDate'];
        $t = $row['StartTime'];
        $h = $row['EndTime'];
    } else {
        echo "attendence not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update sessions</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF SESSIONS</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 390px; margin-top: 20px;">
         <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >Title:</label><br>
        <input type="text" name="Title" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >Description:</label><br>
        <input type="text" name="Description" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >SessionDate:</label><br>
        <input type="Date" name="SessionDate" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >StartTime:</label><br>
        <input type="Time" name="StartTime" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
        <br><br>
        <label >EndTime:</label><br>
        <input type="Time" name="EndTime" value="<?php echo isset($h) ? htmlspecialchars($h) : ''; ?>">
        <br><br>
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $WorkshopID = $_POST['WorkshopID'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $SessionDate = $_POST['SessionDate'];
    $StartTime = $_POST['StartTime'];
    $EndTime = $_POST['EndTime'];
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE sessions SET WorkshopID=?, Title=?, Description=?,SessionDate=?,StartTime=?,EndTime=? WHERE SessionID=?");
    $stmt->bind_param("isssssi", $WorkshopID, $Title, $Description, $SessionDate, $StartTime, $EndTime, $SessionID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:sessions.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
