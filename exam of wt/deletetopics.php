<?php
include('database_connection.php');

// Check if TopicID is set
if(isset($_REQUEST['TopicID'])) {
    $TopicID = $_REQUEST['TopicID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM topics WHERE TopicID=?");
    $stmt->bind_param("i", $TopicID);
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
            <input type="hidden" name="TopicID" value="<?php echo $TopicID; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
         header('Location:topics.php');
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
    echo "TopicID is not set.";
}

$connection->close();
?>