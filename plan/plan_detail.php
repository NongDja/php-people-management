<!DOCTYPE html>
<?php
include "../auth/checklogin.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./image/a.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Plan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
        body {
            background: #fafafa;
        }

        .card {
            padding: 30px 40px;
            margin-top: 30px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.1);
        }

        .back:hover svg {
            transform: scale(1.2);
        }

        .back:hover svg path {
            fill: #ff0000;
        }

        .form-label {
            font-size: 25px;
            font-weight: 500;
        }

        .card-body h2 {
            color: #5d5c5c;
        }

        .content {
            margin-top: 10px;
        }

        .member-info {
            display: flex;
            justify-content: space-between;
        }

        .not-going {
            color: red;
        }

        .going {
            color: green;
        }
    </style>
</head>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php
        $currentPage = 'plan';
        include '../component/aside.php';
        ?>
        <div class="body-wrapper">
            <?php
            include "../component/navbar.php";
            ?>
            <div class="container-fluid">
                <?php
                include '../connect.php';
                $con = mysqli_connect($servername, $username, $password, $dbname);
                if (isset($_GET['page'])) {
                    $id = mysqli_real_escape_string($con, $_GET['page']);
                    $sql = "SELECT project.*, organization.* FROM project 
                    JOIN organization ON project.level = organization.or_id
                    WHERE project.project_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $projectId = $row['project_id'];
                        $projectName = $row['project_name'];
                        $projectLevel = $row['level'];
                        $projectStatus = $row['status'];
                        $projectDeadline = $row['deadline'];
                        $projectDescription = $row['description'];
                        $projectPdf = $row['pdf_data'];
                        $projectOrganizeName = $row['or_name'];
                        $projectBudget = $row['budget'];
                        $totalBudgetUsed = 0;
                        $sql1 = "SELECT * FROM project_user WHERE project_id = $id";
                        $result1 = mysqli_query($con, $sql1);

                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            $budgetUsed = $row1['budget_user_used'];

                            // Display or use $budgetUsed as needed
                            $totalBudgetUsed += $budgetUsed;
                        }
                        if ($projectPdf !== null) {
                            $pdfBase64 = base64_encode($projectPdf);
                        }
                        $timestamp = strtotime($projectDeadline);
                        $thaiMonths = array(
                            'January' => 'มกราคม',
                            'February' => 'กุมภาพันธ์',
                            'March' => 'มีนาคม',
                            'April' => 'เมษายน',
                            'May' => 'พฤษภาคม',
                            'June' => 'มิถุนายน',
                            'July' => 'กรกฎาคม',
                            'August' => 'สิงหาคม',
                            'September' => 'กันยายน',
                            'October' => 'ตุลาคม',
                            'November' => 'พฤศจิกายน',
                            'December' => 'ธันวาคม'
                        );
                        $englishMonth = date('F', $timestamp); // ดึงเดือนในรูปแบบอังกฤษ
                        $thaiMonth = $thaiMonths[$englishMonth]; // แปลงเดือนเป็นภาษาไทย

                        $formattedDate = date("d $thaiMonth Y", $timestamp);
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    mysqli_close($con);
                } else {
                    echo "No 'id' parameter provided.";
                } ?>
                <div class="card">
                    <a class="back" href="../page/plan.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                        </svg>
                    </a>
                    <a class="back" href="./plan_edit.php?page=<?php echo $id ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" style="position: absolute; top: 60px; right: 60px;" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                        </svg>
                    </a>
                    <div class="card-body ">
                        <div>
                            <h1 style="display: inline; "><?php echo $projectName; ?></h1>
                        </div>

                        <div class="mt-4">
                            <label class="form-label" for="projectName" style="display: inline;">หน่วยงาน: </label>
                            <h2 style="display: inline; margin-left:15px; <?php echo $projectLevel == 1 ? 'color: #69bc72;' : ($projectLevel == 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo  $projectOrganizeName; ?></h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">สถานะแผนงาน: </label>
                            <h2 style="display: inline;  margin-left:15px;  <?php echo $projectStatus == 1 ? 'color: #69bc72;' : ($projectStatus == 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo $projectStatus = $projectStatus == 1 ? 'Success' : ($projectStatus == 2 ? 'In Progress' : 'Failed'); ?></h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">ระยะเวลาเริ่มในการดำเนินงาน: </label>
                            <h2 style="display: inline;  margin-left:15px;">วันที่ <?php echo $formattedDate; ?></h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">ระยะเวลาสิ้นสุดการดําเนินงาน: </label>
                            <h2 style="display: inline;  margin-left:15px;  ">วันที่ <?php echo $formattedDate; ?></h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">งบประมาณ: </label>
                            <h2 style="display: inline; margin-left:15px;">
                                <?php echo number_format($projectBudget); ?> บาท
                            </h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">งบประมาณที่ใช้ไป: </label>
                            <h2 style="display: inline; margin-left:15px;">
                                <?php echo number_format($totalBudgetUsed); ?> บาท
                            </h2>
                        </div>
                        <div class="content">
                            <label class="form-label" for="projectName" style="display: inline;">ข้อมูลเพิ่มเติม: </label>
                            <p style="display: inline; font-size:16px;  margin-left:15px; "><?php echo $projectDescription; ?></p>
                        </div>
                        <div class="content">
                            <label class="form-label" for="form-label">รายละเอียดการอบรม PDF:</label>
                            <?php
                            if ($projectPdf !== null) {
                                echo '<embed type="application/pdf" src="data:application/pdf;base64,' . $pdfBase64 . '" width="100%" height="600px" />';
                            } else {
                                echo '<h2  style="display: inline;  margin-left:15px;">No file</h2>';
                            }
                            ?>

                            <br>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    กดดูรายชื่อผู้เข้าอบรม
                                </button>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="exampleModalLabel">รายชื่อสมาชิกที่ไปอบรม</h2>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="padding: 0px;">
                                            <?php
                                            $con = mysqli_connect($servername, $username, $password, $dbname);
                                            if (isset($_GET['page'])) {
                                                $sql = "SELECT
                                                members.id,
                                                members.firstname,
                                                members.surname,
                                                members.branch_id as memberB_id,
                                                branch.branch_name,
                                                branch.branch_id,
                                                project_user.train,
                                                project_user.file_name,
                                                project_user.file_content,
                                                (
                                                    SELECT COUNT(members.id)
                                                    FROM project_user
                                                    JOIN members ON members.id = project_user.user_id
                                                    WHERE project_user.project_id = project.project_id
                                                ) AS memberCount,
                                                (
                                                    SELECT COUNT(DISTINCT members.branch_id)
                                                    FROM project_user
                                                    JOIN members ON members.id = project_user.user_id
                                                    WHERE project_user.project_id = project.project_id
                                                ) AS branchCount
                                                FROM project
                                                JOIN project_user ON project_user.project_id = project.project_id
                                                JOIN members ON members.id = project_user.user_id
                                                JOIN branch ON branch.branch_id = members.branch_id
                                                WHERE project.project_id = '$id' ORDER BY branch.branch_id";
                                                $result = mysqli_query($con, $sql);

                                                if ($result) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $memberId = $row['id'];
                                                        $branchName = $row['branch_name'];
                                                        $branchId = $row['branch_id'];
                                                        $memberBranch = $row['memberB_id'];
                                                        $memberFirstname = $row['firstname'];
                                                        $memberSurname = $row['surname'];
                                                        $memberCount = $row['memberCount'];
                                                        $memberTrain = $row['train'];
                                                        $memberFileName = $row['file_name'];
                                                        $memberFileContent = $row['file_content'];

                                                        if (!isset($branchData[$branchId])) {
                                                            $branchData[$branchId] = array(
                                                                'branch_name' => $branchName,
                                                                'members' => array()
                                                            );
                                                        }

                                                        $branchData[$branchId]['members'][] = array(
                                                            'member_id' => $memberId,
                                                            'firstname' => $memberFirstname,
                                                            'surname' => $memberSurname,
                                                            'train' => $memberTrain,
                                                            'file_content' => $memberFileContent,
                                                            'file_name' => $memberFileName
                                                        );
                                            ?>

                                            <?php  }
                                                    foreach ($branchData as $branchId => $branch) {
                                                        echo '<div class="p-4">';
                                                        echo '<h3>' . $branch['branch_name'] . '</h3>';
                                                        foreach ($branch['members'] as $member) {
                                                            echo '<div class="member-info">';
                                                            $colorClass = ($member['train'] == 0 ? 'not-going' : 'going');
                                                            echo '<span class="' . $colorClass . '">' . $member['firstname'] . ' ' . $member['surname'] . ' ' . ($member['train'] == 0 ? '(ไม่ไป)' : '(ไป)') . '</span>';

                                                            if ($member['file_content'] !== null) {
                                                                echo '<a href="download.php?id=' . $member['member_id'] . '&project_id=' . $projectId  . '">Download File</a>';
                                                            }
                                                            echo '</div><br>';
                                                        }
                                                        echo '</div>';
                                                    }
                                                }
                                                mysqli_close($con);
                                            } else {
                                                echo "No 'id' parameter provided.";
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" style="margin-top: 3px;" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <h2 style="margin-left: 5px;"> <?php echo  $memberCount; ?>/88</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>