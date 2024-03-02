<?php
 include "../connect.php";
 $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'], $_GET['project_id'])) {
    $memberId = $_GET['id'];
    $projectId = $_GET['project_id'];
    $memberId = filter_var($memberId, FILTER_SANITIZE_NUMBER_INT);
    $projectId = filter_var($projectId, FILTER_SANITIZE_NUMBER_INT);
    // Fetch file details from the database
    $sql = "SELECT file_name, file_content FROM project_user WHERE project_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $projectId, $memberId);  // "ii" indicates two integer parameters
   if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($file_name, $file_content);
            $stmt->fetch();

            // Send appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');

            // Output the file content
            echo $file_content;

            exit;
        } else {
            echo "No matching record found.";
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
