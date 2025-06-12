<?php
// --- Configuration ---
$servername = "localhost";
$dbname     = "kindred_db";    // e.g., "sg_user_kindred_db"
$username   = "kindreduser";    // e.g., "sg_user_kindred_user"
$password   = "Lh1]5ff@r1$x"; // The password you created

// --- Set Headers ---
// This tells the browser that we are sending back JSON data, not a webpage.
header('Content-Type: application/json');
// This allows your HTML file to request data from this script.
header('Access-Control-Allow-Origin: *');


// --- Create Connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If it fails, send a clear error message.
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    die();
}

// --- Prepare and Execute SQL Query ---
// We want the newest message from the daily_logs table.
// We also want to know who sent it (the caregiver's name).
$sql = "SELECT 
            dl.content, 
            cg.name as caregiver_name 
        FROM 
            daily_logs dl
        JOIN 
            caregivers cg ON dl.caregiver_id = cg.id
        ORDER BY 
            dl.created_at DESC 
        LIMIT 1"; // Only get the single most recent log

$result = $conn->query($sql);

// --- Process and Send Response ---
if ($result->num_rows > 0) {
    // Fetch the result row as an associative array
    $row = $result->fetch_assoc();
    
    // Send the data back as JSON
    echo json_encode($row);
} else {
    // If there are no messages, send a default one.
    echo json_encode(['content' => 'No messages yet today, my dear. Thinking of you.', 'caregiver_name' => 'Kindred']);
}

// --- Close Connection ---
$conn->close();

?>
