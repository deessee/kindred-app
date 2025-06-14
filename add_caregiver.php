<?php
require_once 'config.php';

// --- Security Check ---
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['hub_password']) || $_POST['hub_password'] !== $hub_secret_password) {
    die("Access Denied.");
}

// --- Get Data from Form ---
$new_name = $_POST['new_name'];
$new_relationship = $_POST['new_relationship'];

// --- Create Connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Prepare and Execute SQL to Insert New Caregiver ---
$stmt = $conn->prepare("INSERT INTO caregivers (name, relationship) VALUES (?, ?)");
$stmt->bind_param("ss", $new_name, $new_relationship); // 'ss' because both are strings

// --- Provide Feedback ---
if ($stmt->execute()) {
    echo "<h1>Family Member Added Successfully!</h1>";
    echo "<p><strong>{$new_name}</strong> has been added to the system.</p>";
    echo "<p><a href='hub.php'>Return to the Family Hub</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

// --- Close Connections ---
$stmt->close();
$conn->close();

?>