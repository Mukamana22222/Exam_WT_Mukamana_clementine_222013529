<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['WorkshopID'])) {
    $WorkshopID = $_REQUEST['WorkshopID'];
    
    $stmt = $connection->prepare("SELECT * FROM workshops WHERE WorkshopID=?");
    $stmt->bind_param("s",$WorkshopID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['Name'];
        $z = $row['Title'];
        $k = $row['Description'];
        $w = $row['Duration'];
        $t = $row['InstructorID'];
        $h = $row['Date'];
        $b = $row['Time'];
        $j = $row['Location'];
    } else {
        echo "workshops not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update workshops</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF WORKSHOPS</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 500px; margin-top: 20px;">
         <label >WorkshopID:</label><br>
        <input type="text" name="Name" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >Title:</label><br>
        <input type="text" name="Title" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >Description:</label><br>
        <input type="text" name="Description" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >Duration:</label><br>
        <input type="number" name="Duration" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >InstructorID:</label><br>
        <input type="number" name="InstructorID" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
        <br><br>
        <label >Date:</label><br>
        <input type="Date" name="Date" value="<?php echo isset($h) ? htmlspecialchars($h) : ''; ?>">
        <br><br>
        <label >Time:</label><br>
        <input type="Time" name="Time" value="<?php echo isset($b) ? htmlspecialchars($b) : ''; ?>">
        <br><br>
        <label >Location:</label><br>
        <input type="text" name="Location" value="<?php echo isset($j) ? htmlspecialchars($j) : ''; ?>">
        <br><br>
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $Name = $_POST['Name'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $Duration = $_POST['Duration'];
    $InstructorID = $_POST['InstructorID'];
    $Date = $_POST['Date'];
     $Time = $_POST['Time'];
    $Location = $_POST['Location'];
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE workshops SET Name=?, Title=?, Description=?,Duration=?,InstructorID=?,Date=?,Time=?,Location=? WHERE WorkshopID=?");
    $stmt->bind_param("sssiissss", $Name, $Title, $Description, $Duration, $InstructorID, $Date, $Time, $Location, $WorkshopID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:workshops.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
