<?php
// --- Configuration ---
$servername = "localhost";
$dbname     = "kindre_db";
$username   = "kindreduser";
$password   = "Lh1]5ff@r1$x"; // IMPORTANT: Change this to your actual password!
$hub_secret_password = "mableeatsbirds!"; // IMPORTANT: Change this!

// --- Security Check ---
// First, check if the form was submitted and the password is correct.
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['hub_password']) || $_POST['hub_password'] !== $hub_secret_password) {
    // If not, deny access.
    die("Access Denied.");
}

// --- Get Data from Form ---
$message_content = $_POST['message'];
$caregiver_id = $_POST['caregiver_id'];

// --- Create Connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Prepare and Execute SQL to Insert New Message ---
// We use a "prepared statement" to prevent security issues (SQL injection).
$stmt = $conn->prepare("INSERT INTO daily_logs (content, caregiver_id) VALUES (?, ?)");
// 's' means the content is a string, 'i' means the ID is an integer.
$stmt->bind_param("si", $message_content, $caregiver_id);

// --- Provide Feedback ---
if ($stmt->execute()) {
    // If successful, show a success message and a link back to the main app.
    echo "<h1>Message Submitted Successfully!</h1>";
    echo "<p><a href='https://kindred.hear2learn.com/'>View the app</a> or <a href='hub.html'>add another message</a>.</p>";
} else {
    // If it fails, show an error.
    echo "Error: " . $stmt->error;
}

// --- Close Connections ---
$stmt->close();
$conn->close();

?>