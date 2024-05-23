<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>insert attendences</title>
  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  
</head>
<header>
<body bgcolor="pink">

<!-- <div class="col-3 offset">-->
  
  <form class="d-flex" role="search" action="search.php" >
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query"  >
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>



<nav>
  <ul style="list-style-type: none; padding: 0;">
    <img src="image/logo.JPEG" width="80" height="80">
    <li style="display: inline; margin-right: 0px;"><a href="./home.html">Home</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./about us.html"  >About us</a></li>
    <li style="display: inline; margin-right:0px;"><a href="./Contact.html">Contact us</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./attendences.php" >Attendance</a></li>
    <li style="dcertificatesisplay: inline; margin-right: 0px;"><a href="./certificates.php" >Certificates</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./enrollments.php">Enrollments</a></li>
    <li style="display: inline; margin-right:0px;"><a href="./feedback.php" >Feedback</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./instructors.php" >Instructors</a></li>
    <li style="display: inline; margin-right:0px;"><a href="./participants.php" >Participants</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./resources.php">Resources</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./sessions.php" >Sessions</a></li>
    <li style="display: inline; margin-right:0px;"><a href="./topics.php" >Topics</a></li>
    <li style="display: inline; margin-right: 0px;"><a href="./workshops.php">Workshops</a></li>
    
    <li class="dropdown" style="display: inline; margin-right: 0px;">
      <a href="#" style="padding: 5px; color: black; background-color:orange; text-decoration: none; margin-right: 1px;">Setting</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li>
  </ul>
  </nav>
  </header>

<center>
  <h5>ATTENDENCE INFORMATION</h5>
  <form action="attendences.php" method="POST" onsubmit="return confirmInsert();" style="background-color: white; align-items: center; width: 300px; height: 300px; margin-top: 20px;"><br><br>
    
    <label>Enter AttendenceStatus:</label><br>
    <input type="text" name="AttendenceStatus" required><br>
    <label>Enter CheckInTime:</label><br>
    <input type="DateTime-local" name="CheckInTime" required><br>
    <label>Enter CheckOutTime:</label><br>
    <input type="DateTime-local" name="CheckOutTime" required><br>
    <label>Enter WorkshopID:</label><br>
    <input type="number" name="WorkshopID" required><br>
    <label>Enter ParticipantID:</label><br>
    <input type="number" name="ParticipantID" required><br>
    
    <input type="submit" name="submit" value="INSERT"> 
    <input type="reset" value="Cancel">
  </form>
</center>

<?php
// Connection
include('database_connection.php');

// Insert data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO attendence ( AttendenceStatus, CheckInTime, CheckOutTime ,WorkshopID, ParticipantID) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $AttendenceStatus, $CheckInTime, $CheckOutTime, $WorkshopID, $ParticipantID);

    // Set parameters and execute
    
    $AttendenceStatus = $_POST['AttendenceStatus'];
    $CheckInTime = $_POST['CheckInTime'];
    $CheckOutTime = $_POST['CheckOutTime'];
    $WorkshopID = $_POST['WorkshopID'];
    $ParticipantID = $_POST['ParticipantID'];
   
    
    
    if ($stmt->execute()) {
        echo "<p>New record has been added successfully</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Select data from the table
$sql = "SELECT * FROM attendence";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of attendence</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>TABLE OF ATTENDENCES DATA</h2></center>
    
    <table id="dataTable">
        <tr>
            <th>AttendenceID</th>
            <th>AttendenceStatus</th>
            <th>CheckInTime</th>
            <th>CheckOutTime</th>
            <th>WorkshopID</th>
            <th>ParticipantID</th>
            <th>UPDATE</th>
            <th>DELETE</th>
        </tr>
        <?php
        // Output data of each row
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                  $AttendenceID = $row['AttendenceID'];
                echo "<tr><td>" . $row["AttendenceID"] .
                     "</td><td>" . $row["AttendenceStatus"] .
                     "</td><td>" . $row["CheckInTime"] .
                     "</td><td>" . $row["CheckOutTime"] .
                     "</td><td>" . $row["WorkshopID"] .
                     "</td><td>" . $row["ParticipantID"] .
                     "</td><td><a href='updateattendences.php?AttendenceID=$AttendenceID'>Update</a>
                     </td><td><a href='deleteattendences.php?AttendenceID=$AttendenceID'>Delete</a></td>
                     </tr>";       
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close connection
$connection->close();
?>
