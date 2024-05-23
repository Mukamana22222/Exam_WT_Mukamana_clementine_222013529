<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['ResourceID'])) {
    $ResourceID = $_REQUEST['ResourceID'];
    
    $stmt = $connection->prepare("SELECT * FROM resources WHERE ResourceID=?");
    $stmt->bind_param("s",$ResourceID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $z = $row['WorkshopID'];
        $k = $row['Title'];
        $w = $row['Description'];
        $t = $row['Link'];
    } else {
        echo "certificates not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update resources</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF RESOURCES</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 350px; margin-top: 20px;">
         

        <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >Title:</label><br>
        <input type="text" name="Title" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >Description:</label><br>
        <input type="text" name="Description" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >Link:</label><br>
        <input type="text" name="Link" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
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
    $Link = $_POST['Link'];
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE resources SET WorkshopID=?, Title=?,Description=?,Link=? WHERE ResourceID=?");
    $stmt->bind_param("isssi", $WorkshopID, $Title, $Description, $Link, $ResourceID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:resources.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
