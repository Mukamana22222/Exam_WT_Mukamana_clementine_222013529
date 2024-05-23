<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Connection details
include('database_connection.php');
    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'attendence' => "SELECT AttendenceStatus FROM attendence WHERE AttendenceStatus LIKE '%$searchTerm%'",
        'certificates' => "SELECT CertificateURL FROM certificates WHERE CertificateURL LIKE '%$searchTerm%'",
        'enrollments' => "SELECT EnrollmentDate FROM enrollments WHERE EnrollmentDate LIKE '%$searchTerm%'",
        'feedback' => "SELECT Comment FROM feedback WHERE Comment LIKE '%$searchTerm%'",
        'instructors' => "SELECT Name FROM instructors WHERE Name LIKE '%$searchTerm%'",
        'participants' => "SELECT Name FROM participants WHERE Name LIKE '%$searchTerm%'",
        'resources' => "SELECT Title FROM resources WHERE Title LIKE '%$searchTerm%'",
        'sessions' => "SELECT Description FROM sessions WHERE Description LIKE '%$searchTerm%'",
        'topics' => "SELECT TopicName FROM topics WHERE TopicName LIKE '%$searchTerm%'",
        'workshops' => "SELECT Location FROM workshops WHERE Location LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
