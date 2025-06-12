<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kindred Family Hub</title>
    <link rel="stylesheet" href="style.css"> <!-- We can reuse the same style for now -->
    <style>
        /* A few extra styles just for the hub */
        .container { max-width: 800px; margin: 40px auto; }
        textarea { width: 100%; min-height: 150px; font-size: 1.2rem; padding: 10px; }
        select, input[type="password"], button { width: 100%; padding: 15px; font-size: 1.2rem; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kindred Family Hub</h1>
        <p>Add a new message for Mom below.</p>

        <form action="submit_message.php" method="POST">
            <label for="message">New Message:</label>
            <textarea id="message" name="message" required></textarea>

<label for="caregiver">Your Name:</label>
<select id="caregiver" name="caregiver_id" required>
    <option value="" disabled selected>-- Select Your Name --</option>
    <?php
        // This PHP block will run on the server before the page is sent
        // --- Configuration ---
        // NOTE: We have to reconnect to the database here as well.
        $servername = "localhost";
        $dbname     = "kindred_db";
        $username   = "kindreduser"; // e.g., "sg_user_kindred_user"
        $password   = "Lh1]5ff@r1$x"; // The password you created

        // --- Create Connection ---
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            // Don't die, just show an error in the dropdown
            echo "<option value=''>Error: Could not connect</option>";
        } else {
            // --- Fetch all caregivers ---
            $sql = "SELECT id, name FROM caregivers ORDER BY name ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each caregiver and create an <option> for them
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            } else {
                echo "<option value=''>No caregivers found</option>";
            }
            $conn->close();
        }
    ?>
</select>

            <label for="password">Password:</label>
            <input type="password" id="password" name="hub_password" required>

            <button type="submit">Submit New Message</button>
        </form>
                <!-- This is the end of the first form -->
        </form>

        <hr style="margin: 40px 0;">

        <h2>Add a New Family Member</h2>
        <form action="add_caregiver.php" method="POST">
            <label for="new_name">New Member's Name:</label>
            <input type="text" id="new_name" name="new_name" required>
            
            <label for="new_relationship">Relationship to Mom (e.g., Grandson):</label>
            <input type="text" id="new_relationship" name="new_relationship">

            <label for="admin_password">Admin Password:</label>
            <input type="password" id="admin_password" name="hub_password" required>

            <button type="submit">Add Family Member</button>
        </form>
    </div>
    <!-- The rest of the file stays the same -->
</body>
</html>
    </div>
</body>
</html>