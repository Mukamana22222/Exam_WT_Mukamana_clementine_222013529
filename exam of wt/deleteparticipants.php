<?php
include('database_connection.php');

// Check if ParticipantID is set
if(isset($_REQUEST['ParticipantID'])) {
    $ParticipantID = $_REQUEST['ParticipantID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM participants WHERE ParticipantID=?");
    $stmt->bind_param("i", $ParticipantID);
      ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="ParticipantID" value="<?php echo $ParticipantID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
         header('Location:participants.php');
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "ParticipantID is not set.";
}

$connection->close();
?>