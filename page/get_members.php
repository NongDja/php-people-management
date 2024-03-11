<?php
include '../connect.php';

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the selected branch from the AJAX request
$branch = mysqli_real_escape_string($conn, $_POST['branch']);

// Perform SQL query to fetch members based on the selected branch
$sql = "SELECT members.*, role_user.role_id FROM members LEFT JOIN role_user on role_user.user_id = members.id WHERE branch_id = '$branch' AND role_user.role_id != 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Generate HTML options for the member dropdown
$htmlOptions = '<option value="all">All</option>';
while ($member = mysqli_fetch_assoc($result)) {
    $htmlOptions .= "<option value='{$member['id']}'>{$member['firstname']}</option>";
}

echo $htmlOptions;
?>
