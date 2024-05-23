<?php
include('database_connection.php');
// Check if patient_Id is set
if(isset($_REQUEST['CertificateID'])) {
    $CertificateID = $_REQUEST['CertificateID'];
    
    $stmt = $connection->prepare("SELECT * FROM certificates WHERE CertificateID=?");
    $stmt->bind_param("s",$CertificateID); // Assuming patient_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['ParticipantID'];
        $z = $row['WorkshopID'];
        $k = $row['IssueDate'];
        $w = $row['ExpiryDate'];
        $t = $row['CertificateURL'];
    } else {
        echo "certificates not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update certificates</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body bgcolor="pink"><center>
    <!-- Update patients form -->
    <h4>UPDATE INFORMATION OF CERTIFICATES</h4>
    <form method="POST" onsubmit="return confirmUpdate();" style="background-color: white; align-items: center; width: 300px; height: 350px; margin-top: 20px;">
         <label >ParticipantID:</label><br>
        <input type="number" name="ParticipantID" value="<?php echo isset($y) ? htmlspecialchars($y) : ''; ?>">
        <br><br>

        <label >WorkshopID:</label><br>
        <input type="number" name="WorkshopID" value="<?php echo isset($z) ? htmlspecialchars($z) : ''; ?>">
        <br><br>

        <label >IssueDate:</label><br>
        <input type="Date" name="IssueDate" value="<?php echo isset($k) ? htmlspecialchars($k) : ''; ?>">
        <br><br>

        <label >ExpiryDate:</label><br>
        <input type="Date" name="ExpiryDate" value="<?php echo isset($w) ? htmlspecialchars($w) : ''; ?>">
        <br><br>
        <label >CertificateURL:</label><br>
        <input type="text" name="CertificateURL" value="<?php echo isset($t) ? htmlspecialchars($t) : ''; ?>">
        <br><br>
        
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form

    $ParticipantID = $_POST['ParticipantID'];
    $WorkshopID = $_POST['WorkshopID'];
    $IssueDate = $_POST['IssueDate'];
    $ExpiryDate = $_POST['ExpiryDate'];
    $CertificateURL = $_POST['CertificateURL'];
    
    // Update the patient in the database
    $stmt = $connection->prepare("UPDATE certificates SET ParticipantID=?,WorkshopID=?, IssueDate=?,ExpiryDate=?,CertificateURL=? WHERE CertificateID=?");
    $stmt->bind_param("iisssi", $ParticipantID, $WorkshopID, $IssueDate, $ExpiryDate, $CertificateURL, $CertificateID);
    $stmt->execute();
    
    // Redirect to patient.php
    header('Location:certificates.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
