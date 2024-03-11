<?php
// Include database connection and other necessary configurations
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
$yearBudget = date('Y');

if(isset($_POST['yearBudget'])) {
    $yearBudget = $_POST['yearBudget'];
}

// Retrieve and sanitize form data
$branch = mysqli_real_escape_string($conn, $_POST['branch']);
$member = mysqli_real_escape_string($conn, $_POST['member']);
$yearBudget = mysqli_real_escape_string($conn, $_POST['yearBudget']);
$where = "WHERE YEAR(project.deadline) = $yearBudget";
if ($_POST['branch'] != 'all') {
    $where .= " AND members.branch_id = $branch";

    if ($_POST['member'] != 'all') {
        $where .= " AND members.id = $member";
    }   
}

// Perform your database query based on the form data
$sql = "SELECT
user_id,
members.branch_id,
members.firstname,
members.surname,
branch.branch_name,
SUM(budget_user_used) AS budget
FROM
project_user
LEFT JOIN 
project ON project.project_id = project_user.project_id
LEFT JOIN
user_auth ON user_auth.userId = project_user.user_id
LEFT JOIN
members ON members.id = user_auth.userId
LEFT JOIN
branch ON branch.branch_id = members.branch_id 
$where
GROUP BY
user_id, branch.branch_id, members.firstname, members.surname, branch.branch_name
ORDER BY
branch.branch_id ASC;
"; // Your query conditions

// Execute the query and fetch the result
$result = mysqli_query($conn, $sql);

// Build HTML table from the result
$htmlTable = '<table class="table table-bordered mt-4" style="backgrond-color: white" id="myDataTable1">
            <tr>
                <th>ชื่อ - นามสกุล</th>
                <th>สาขา</th>
                <th>งบประมาณที่ใช้ไป</th>
                <th>ปีงบประมาณ</th>
                <!-- Add more columns as needed -->
            </tr>';
while ($row = mysqli_fetch_assoc($result)) {
    // Build rows based on your database columns
    $htmlTable .= '<tr>';
    $htmlTable .= '<td>' . $row['firstname'] . ' ' . $row['surname'] .  '</td>';
    $htmlTable .= '<td>' . $row['branch_name'] . '</td>';
    $htmlTable .= '<td>' . number_format($row['budget'], 2) . ' THB' . '</td>';
    $htmlTable .= '<td>' . $yearBudget . '</td>';
    // Add more columns as needed
    $htmlTable .= '</tr>';
}
$htmlTable .= '</table>';

// Return the HTML table
echo $htmlTable;
?>
