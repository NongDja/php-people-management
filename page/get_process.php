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
// Retrieve and sanitize form data
$projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
$branch = mysqli_real_escape_string($conn, $_POST['branch']);
$member = mysqli_real_escape_string($conn, $_POST['member']);
$yearStart = mysqli_real_escape_string($conn, $_POST['yearStart']);
$yearEnd = mysqli_real_escape_string($conn, $_POST['yearEnd']);
$budgetStart = mysqli_real_escape_string($conn, $_POST['budgetStart']);
$budgetEnd = mysqli_real_escape_string($conn, $_POST['budgetEnd']);
$where = "";
$conditions = array();

if(!empty($projectName)) {
    $conditions[] = "project.project_name LIKE '%$projectName%'";
}

if (!empty($yearStart) && !empty($yearEnd)) {
    $conditions[] = "YEAR(project.deadline) BETWEEN $yearStart AND $yearEnd";
}

if (!empty($budgetStart) && !empty($budgetEnd)) {
    $conditions[] = "project.budget BETWEEN $budgetStart AND $budgetEnd";
}

if ($branch != 'all') {
    $conditions[] = "members.branch_id = $branch";
}

if ($member != 'all') {
    $conditions[] = "members.id = $member";
}

if (!empty($conditions)) {
    $where = "WHERE " . implode(" AND ", $conditions);
}

$sql = "SELECT project_user.project_id,
        project.project_name,
        members.firstname,
        members.surname,
        project_user.train,
        project_user.budget_user_used,
        project.status,
        project.level,
        project.deadline,
        project.description,
        project.budget
        FROM project_user
        INNER JOIN project ON project.project_id = project_user.project_id
        INNER JOIN members ON members.id = project_user.user_id
        $where
        ORDER BY project_user.project_id ASC;";
// Execute the query and fetch the result
$result = mysqli_query($conn, $sql);

// Build HTML table from the result
$htmlTable = '<table class="table table-bordered mt-4" style="backgrond-color: white" id="myDataTable">
            <tr>
                <th>ชื่อการไปอบรม</th>
                <th>ชื่อจริง - นามสกุล</th>
                <th>การตอบรับ</th>
                <th>งบประมาณ</th>
                <th>จำนวนเงินที่ใช้ไป</th>
                <th>สถานะการอบรม</th>
                <th>ระดับการอบรม</th>
                <th>วันที่ไปอบรม</th>
               
                <!-- Add more columns as needed -->
            </tr>';
while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['status'];

switch ($status) {
    case 1:
        $statusText = 'สำเร็จ';
        break;
    case 2:
        $statusText = 'กำลังดำเนินการ';
        break;
    case 3:
        $statusText = 'ไม่สำเร็จ';
        break;
    default:
        $statusText = $status;
}

$level = $row['level'];

switch ($level) {
    case 1:
        $levelText = 'หน่วยงานราชการ';
        break;
    case 2:
        $levelText = 'หน่วยงานเอกชน';
        break;
    case 3:
        $levelText = 'หน่วยงานอิสระ';
        break;
    default:
        $levelText = $level;
}


    // Build rows based on your database columns
    $htmlTable .= '<tr>';
    $htmlTable .= '<td>' . $row['project_name'] . '</td>';
    $htmlTable .= '<td>' . $row['firstname'] . ' ' . $row['surname'] . '</td>';
    $htmlTable .= '<td>' . ($row['train'] == 0 ? 'ไม่ไป' : 'ไป') . '</td>';
    $htmlTable .= '<td>' . number_format($row['budget'], 2) . ' THB' .'</td>';
    $htmlTable .= '<td>' . number_format($row['budget_user_used'], 2) . ' THB' .'</td>';
    $htmlTable .= '<td>' .  $statusText . '</td>';    
    $htmlTable .= '<td>' . $levelText . '</td>';
    $htmlTable .= '<td>' . $row['deadline'] . '</td>';
    // Add more columns as needed
    $htmlTable .= '</tr>';
}
$htmlTable .= '</table>';

// Return the HTML table
echo $htmlTable;
?>
