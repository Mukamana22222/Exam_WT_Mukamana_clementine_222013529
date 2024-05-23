<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>insert workshops</title>
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
  <h5>WORKSHOPS INFORMATION</h5>
  <form action="workshops.php" method="POST" onsubmit="return confirmInsert();" style="background-color: white; align-items: center; width: 300px; height: 400px; margin-top: 20px;">
    <label>Enter Name:</label><br>
    <input type="text" name="Name" required><br>
    <label>Enter Title:</label><br>
    <input type="text" name="Title" required><br>
    <label>Enter Description:</label><br>
    <input type="text" name="Description" required><br>
    <label>Enter Duration:</label><br>
    <input type="number" name="Duration" required><br>
    <label>Enter InstructorID:</label><br>
    <input type="number" name="InstructorID" required><br>
    <label>Enter Date:</label><br>
    <input type="Date" name="Date" required><br>
    <label>Enter Time:</label><br>
    <input type="Time" name="Time" required><br>
    <label>Enter Location:</label><br>
    <input type="text" name="Location" required><br>
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
    $stmt = $connection->prepare("INSERT INTO workshops ( Name, Title, Description ,Duration, InstructorID, Date, Time, Location) VALUES (?, ?, ?, ?,?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $Name, $Title, $Description, $Duration, $InstructorID, $Date, $Time, $Location);

    // Set parameters and execute
    $Name = $_POST['Name'];
    $Title = $_POST['Title'];
    $Description = $_POST['Description'];
    $Duration = $_POST['Duration'];
    $InstructorID = $_POST['InstructorID'];
    $Date = $_POST['Date'];
    $Time = $_POST['Time'];
    $Location = $_POST['Location'];
    
    
    if ($stmt->execute()) {
        echo "<p>New record has been added successfully</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Select data from the table
$sql = "SELECT * FROM workshops";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of workshops</title>
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
    <center><h2>TABLE OF WORKSHOPS DATA</h2></center>
    
    <table id="dataTable">
        <tr>
            <th>WorkshopID</th>
            <th>Name</th>
            <th>Title</th>
            <th>Description</th>
            <th>Duration</th>
            <th>InstructorID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>UPDATE</th>
            <th>DELETE</th>
        </tr>
        <?php
        // Output data of each row
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $WorkshopID = $row['WorkshopID'];
                echo "<tr><td>" . $row["WorkshopID"] .
                     "</td><td>" . $row["Name"] .
                     "</td><td>" . $row["Title"] .
                     "</td><td>" . $row["Description"] .
                     "</td><td>" . $row["Duration"] .
                     "</td><td>" . $row["InstructorID"] .
                     "</td><td>" . $row["Date"] .
                     "</td><td>" . $row["Time"] .
                     "</td><td>" . $row["Location"] .
                     "</td><td><a href='updateworkshops.php?WorkshopID=$WorkshopID'>Update</a>
                     </td><td><a href='deleteworkshops.php?WorkshopID=$WorkshopID'>Delete</a></td>
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
