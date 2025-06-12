<?php
// Our Ultimate Database Connection Test

// Force PHP to show us any and all errors.
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Kindred Database Test</h1>";

// --- Configuration ---
// VERY IMPORTANT: Copy these values EXACTLY from your hub.php file.
$servername = "localhost";
$dbname     = "dbgrcokiwsbh3p_kindred_db";
$username   = "ufpsf9t9w7trg_kindreduser";
$password   = "+f}f#__z216s"; // The password you set in SiteGround.

echo "<p><strong>Attempting to connect with the following details:</strong></p>";
echo "<ul>";
echo "<li>Database Name: " . $dbname . "</li>";
echo "<li>Username: " . $username . "</li>";
echo "</ul>";

// --- The Test ---
// Create a new mysqli connection object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If it fails, the script STOPS here and prints the error.
    echo "<h2>RESULT: <span style='color: red;'>CONNECTION FAILED</span></h2>";
    echo "<p><strong>Error Message:</strong> " . $conn->connect_error . "</p>";
    die(); // Stop the script.
}

// If we get past the 'if' statement, it means the connection was successful!
echo "<h2>RESULT: <span style='color: green;'>CONNECTION SUCCESSFUL!</span></h2>";
echo "<p>The PHP script successfully logged into the MySQL database.</p>";
echo "<hr>";


// --- Second Test: Query the Caregivers Table ---
echo "<h2>Attempting to read from the 'caregivers' table...</h2>";

$sql = "SELECT id, name FROM caregivers";
$result = $conn->query($sql);

if ($result) {
    echo "<h3 style='color: green;'>Query Successful!</h3>";
    echo "<p>Found <strong>" . $result->num_rows . "</strong> rows in the table.</p>";
    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>ID: " . $row['id'] . " - Name: " . $row['name'] . "</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<h3 style='color: red;'>Query FAILED!</h3>";
    echo "<p><strong>Error:</strong> " . $conn->error . "</p>";
}

$conn->close();

?>