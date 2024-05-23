<?php
include('database_connection.php');

// Check if patient_Id is set
if(isset($_REQUEST['FeedbackID'])) {
    $FeedbackID = $_REQUEST['FeedbackID'];
    
    $stmt = $connection->prepare("SELECT * FROM feedback WHERE FeedbackID=?");
    $stmt->bind_param("s",$FeedbackID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['WorkshopID'];
        $z = $row['ParticipantID'];
        $k = $row['Rating'];
        $w = $row['Comment'];
        $t = $row['FeedbackDate'];
        
    } else {
        echo " feedback not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update feedback</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF FEEDBACK</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 390px; margin-top: 20px;">
         <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >ParticipantID:</label><br>
        <input type="number" name="ParticipantID" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >Rating:</label><br>
        <input type="number" name="Rating" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >Comment:</label><br>
        <input type="text" name="Comment" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >FeedbackDate:</label><br>
        <input type="Date" name="FeedbackDate" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
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
    $Rating = $_POST['Rating'];
    $Comment = $_POST['Comment'];
    $FeedbackDate = $_POST['FeedbackDate'];
   
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE feedback SET WorkshopID=?, ParticipantID=?, Rating=?,Comment=?,FeedbackDate=? WHERE FeedbackID=?");
    $stmt->bind_param("issssi", $WorkshopID, $ParticipantID, $Rating, $Comment, $FeedbackDate,$FeedbackID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:feedback.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
