<!DOCTYPE html>
<?php
include "../auth/checklogin.php";
$userId = $_SESSION['userId']
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/a.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Plan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- <link rel="stylesheet" href="../assets/css/main.css"> -->
    <style>
        body {
            background: #fafafa;
        }

        .divider {
            width: 100%;
            height: 1px;
            /* Adjust the height as needed */
            background-color: #000;
            /* Adjust the color as needed */
            margin-top: 20px
        }


        .container-fluid .projectCard {
            position: relative;
            max-width: 370px;
            width: 100%;
            height: 300px;
            border: none !important;
            background-color: rgba(255, 255, 255, 1);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
            grid-row: 1 / 4;
            margin: 10px;
        }

        .container-fluid .projectCard .projectTop {
            position: relative;
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container-fluid .projectCard .projectTop a {
            color: #000;
            font-size: 1.2em;
            line-height: 18px;
            cursor: pointer;
        }

        .container-fluid .projectCard .projectTop a:hover {
            color: #0D6EFD
        }

        .container-fluid .projectCard .projectTop a span {
            color: #999;
            font-size: 0.8em;
        }

        .container-fluid .projectCard .projectTop .projectDots {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        /* ตรวจสอบว่าไม่มีข้อความหรือ comment ที่ทำให้มีปัญหา */
        .container-fluid .projectCard .projectTop .projectDots li {
            color: #000;
            font-size: 1.8em;
            font-weight: 700;
            text-decoration: none;
        }

        .container-fluid .projectCard .projectTop .projectDots li:hover {
            color: red;
        }


        .container-fluid .projectCard .projectTop .projectDots ul .dropdown-item {
            font-size: 1rem;
            font-weight: 400;
        }



        .container-fluid .projectCard .projectProgress {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container-fluid .projectCard .projectProgress .process {
            position: relative;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .container-fluid .projectCard .projectProgress .process h2 {
            color: #8389f9;
            white-space: nowrap;
            font-size: 1em;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .container-fluid .projectCard .projectProgress .priority {
            position: relative;
            padding: 5px 10px;
            cursor: pointer;
        }



        .container-fluid .projectCard .projectProgress .priority h2 {

            white-space: nowrap;
            font-size: 1em;
            font-weight: 500;
        }

        .container-fluid .projectCard .task {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-direction: column;
            margin: 10px 0;
        }

        .container-fluid .projectCard .task h2 {
            color: #999;
            font-size: 1em;
        }

        .container-fluid .projectCard .task h2 bold {
            color: #000;
        }

        .container-fluid .projectCard .task .line {
            position: relative;
            width: 100%;
            height: 5px;
            background: rgba(0, 0, 0, .1);
            border-radius: 50px;
            z-index: -1;
            overflow: hidden;
        }

        .container-fluid .projectCard .task .line::before {
            content: '';
            position: absolute;
            left: 0;
            width: calc(100% - 25%);
            height: 100%;
            background: #6577ff;
            z-index: 1;
            border-radius: 50px;
        }

        .container-fluid .projectCard .due {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            cursor: pointer;
        }

        .container-fluid .projectCard .due::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1.5px;
            background: rgba(0, 0, 0, .1);
        }

        .container-fluid .projectCard .due h2 {
            padding: 0px 10px;
            border: 2px solid #f5b5f5;
            border-radius: 5px;
            font-size: 1.1em;
            color: #f5b5f5;
        }


        .container-fluid .projectCard.projectCard2 {
            grid-row: 4 / 7;
        }

        /* .container-fluid  .projectCard.projectCard2 .projectProgress .priority::before {
                  background: #69bc72;
             box-shadow: 0 0 2px #69bc72,
                0 0 5px #69bc7277;
                }
            .container-fluid .projectCard.projectCard2 .projectProgress .priority h2 {
                    color: #69bc72;
            } */


        .container-fluid .projectCard.projectCard2 .task .line::before {
            background: #f5c75f;
        }

        .container-fluid .projectCard.projectCard2 .messagesUser {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 10px;
        }


        .container-fluid .projectCard.projectCard2 .messagesUser .messagesUserImg {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }

        .container-fluid .projectCard.projectCard2 .messagesUser .messagesUserImg img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .container-fluid .projectCard.projectCard2 .messagesUser h2 {
            position: relative;
            color: #000;
            cursor: pointer;
            font-size: 1.2em;
            line-height: 18px;
        }

        .container-fluid .projectCard.projectCard2 .messagesUser h2 span {
            color: #999;
            font-size: 0.8em;
        }

        .container-fluid .projectCard .groupImg {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 15px 0;
        }


        .container-fluid .projectCard .groupImg a {
            position: relative;
            width: 40px;
            height: 40px;

            overflow: hidden;
            border-radius: 50%;
            left: var(--left);
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container-fluid .projectCard .groupImg a img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .container-fluid .projectCard .groupImg a:last-child span {
            color: #999;
            font-size: 1.2em;
        }
    </style>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../plan/plan_delete.php?id=' + id;
                }
            });
        }
    </script>
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
            include '../connect.php';
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $branchFilter = isset($_GET['branch_filter']) ? $_GET['branch_filter'] : '';
            $con = mysqli_connect($servername, $username, $password, $dbname);
            $queryBranch = "SELECT * FROM branch";
            $stbh = mysqli_prepare($con, $queryBranch);
            mysqli_stmt_execute($stbh);
            $resultBranch = mysqli_stmt_get_result($stbh);
            $con->close();
            ?>
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-12"> <br>
                        <div class="row">

                            <div class="col-6 ">
                                <h3> <?php if ($_SESSION['role'] != 3) {
                                            echo 'แผนงาน';
                                        } else {
                                            echo 'แผนงานของฉัน';
                                        } ?> <a style="font-size: 14px;" href="<?php if ($_SESSION['role'] != 3) {
                                                                                    echo '../plan/plan_add.php';
                                                                                } else {
                                                                                    echo '../plan/self_add.php';
                                                                                } ?>" class="btn btn-info">+เพิ่มข้อมูล</a></h3>
                            </div>
                            <div class="col-4 d-flex justify-content-end">
                                <?php
                               echo "<form class='input-group' method='get' action=''>";
                               echo "<input style='background: #fff;' class='form-control' type='text' name='search' placeholder='Search by name' value='$search' />";
                               echo "<input type='hidden' name='branch_filter' value='$branchFilter' />";
                               echo "<div class='input-group-append'>";
                               echo "<button class='btn btn-secondary' style='margin-top:2px; margin-left:2px;' type='submit'>";
                               echo '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                     <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                     <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                     <path d="M21 21l-6 -6" />
                                   </svg>';
                               echo "</button>";
                               echo "</div>";
                               echo "</form>";
                                ?>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        สาขา
                                    </button>
                                    <div class="dropdown">
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <?php
                                              echo "<li><a class='dropdown-item' href='?page=1&search={$search}&branch_filter='''  </a>All</li>";
                                            while ($row = mysqli_fetch_assoc($resultBranch)) {
                                                $selected = ($row['branch_id'] == $branchFilter) ? 'selected' : '';
                                                echo "<li><a class='dropdown-item' href='?page=1&search={$search}&branch_filter={$row['branch_id']}' {$selected}>{$row['branch_name']}</a></li>";
                                            }
                                          
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php

                    $recordsPerPage = 9;

                    // Get the current page number from the URL
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $startFrom = ($currentPage - 1) * $recordsPerPage;

                    // Process the search query

                    $id = $_SESSION["userId"];
                    $con = mysqli_connect($servername, $username, $password, $dbname);
                    if ($_SESSION['role'] != 3) {
                        $sql = "SELECT DISTINCT project.project_id, 
                        (SELECT COUNT(DISTINCT project_user.project_id) FROM project_user) AS projectCount, 
                        project.*, organization.or_name 
                        FROM project 
                        JOIN project_user ON project_user.project_id = project.project_id
                        JOIN organization ON project.level = organization.or_id
                        JOIN members ON members.id = project_user.user_id 
                        JOIN branch ON branch.branch_id = members.branch_id
                        WHERE (
                            project.project_id LIKE '%$search%' 
                            OR project.project_name LIKE '%$search%'  
                            OR members.firstname LIKE '%$search%' 
                            OR members.surname LIKE '%$search%'
                        ) AND ('$branchFilter' = '' OR members.branch_id = '$branchFilter')
                        ORDER BY project.project_id DESC
                        LIMIT $startFrom, $recordsPerPage;";
                    } else {
                        $sql = "SELECT DISTINCT project.project_id, 
                        (SELECT COUNT(DISTINCT project_user.project_id) 
                         FROM project_user 
                         WHERE project_user.user_id = '$id') AS projectCount, 
                        project.*, organization.or_name 
                        FROM project 
                        JOIN project_user ON project_user.project_id = project.project_id
                        JOIN organization ON project.level = organization.or_id
                        JOIN members ON members.id = project_user.user_id 
                        JOIN branch ON branch.branch_id = members.branch_id
                        WHERE project_user.user_id = '$id' 
                        AND ( project.project_id LIKE '%$search%' 
                            OR project.project_name LIKE '%$search%'  
                            OR members.firstname LIKE '%$search%' 
                            OR members.surname LIKE '%$search%'
                            )
                        AND members.branch_id = '$branchFilter'
                        ORDER BY project.project_id DESC
                        LIMIT $startFrom, $recordsPerPage";
                    }

                    $stmt = mysqli_prepare($con, $sql);
                    $stmt->execute();
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


                    if (mysqli_num_rows($result) > 0) {
                        if ($_SESSION['role'] != 3) {
                            $queryCount = "SELECT COUNT(DISTINCT project.project_id) AS total 
                            FROM project 
                            JOIN project_user ON project_user.project_id = project.project_id
                            JOIN members ON members.id = project_user.user_id
                            WHERE (project.project_id LIKE '%$search%' 
                            OR project.project_name LIKE '%$search%' 
                            OR members.firstname LIKE '%$search%' 
                            OR members.surname LIKE '%$search%')
                            AND ('$branchFilter' = '' OR members.branch_id = '$branchFilter')";
                        } else {
                            $queryCount = "SELECT COUNT(DISTINCT project.project_id) AS total 
                            FROM project 
                            JOIN project_user ON project_user.project_id = project.project_id
                            WHERE project_user.user_id = '$id'
                            AND (project.project_id LIKE '%$search%' OR project.project_name LIKE '%$search%')";
                        }

                        $resultCount = $con->query($queryCount);
                        $rowCount = $resultCount->fetch_assoc();


                        $totalPages = ceil($rowCount['total'] / $recordsPerPage);

                        while ($project = mysqli_fetch_assoc($result)) {
                            $projectId = $project['project_id'];
                            $projectLevel = $project['level'];
                            $projectStatus = $project['status'];
                            $projectProcess = $project['process'];
                            $projectCount = $project['projectCount'];
                            $projectName = $project['project_name'];
                            $projectDescription = $project['description'];
                            $projectDate = $project['deadline'];
                            $projectOrganizeName = $project['or_name'];

                            $userQuery = "SELECT project_user.user_id,members.image_data, project_user.file_name
                            FROM members 
                            JOIN project_user ON members.id = project_user.user_id
                            WHERE project_user.project_id = ?
                            ORDER BY 
                            CASE WHEN project_user.user_id = '$userId' THEN 0 ELSE 1 END,
                            project_user.user_id;";
                            $userStmt = mysqli_prepare($con, $userQuery);
                            mysqli_stmt_bind_param($userStmt, "i", $projectId);
                            mysqli_stmt_execute($userStmt);
                            $userResult = mysqli_stmt_get_result($userStmt);
                            $dateTime = new DateTime($projectDate);
                            $formattedDate = $dateTime->format('d F Y');
                            $userFileCon = 0;
                            $userCount = 0;
                            while ($Count = mysqli_fetch_assoc($userResult)) {
                                $userAwaitCount = $Count['user_id'];
                                $file_name = $Count['file_name'];
                                if ($userAwaitCount) {
                                    $userCount++;
                                }
                                if ($file_name != null) {
                                    $userFileCon++;
                                }
                            }
                            $Process = ($userCount > 0) ? ($userFileCon / $userCount * 100) : 0;
                            mysqli_data_seek($userResult, 0);
                    ?>
                            <div class="projectCard projectCard2">
                                <div class="projectTop">

                                    <a href="../plan/plan_detail.php?page=<?php echo $projectId ?>"><?php echo $projectName; ?><br><span> <?php echo (strlen($projectDescription) > 30) ? substr($projectDescription, 0, 30) . '...' : $projectDescription; ?></span></a>
                                    <div class="projectDots">
                                        <div class="dropdown">
                                            <a class="btn btn-ghost dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="<?php if ($_SESSION['role'] != 3) { ?>../plan/plan_edit.php?page=<?php echo $projectId;
                                                                                                                                                } else { ?>../plan/self_edit.php?page=<?php echo $projectId;
                                                                                                                                                                                    } ?>">แก้ไข</a></li>
                                                <?php if ($_SESSION['role'] != 3) { ?>
                                                    <li><a class="dropdown-item" onclick="confirmDelete(<?php echo $projectId; ?>)">ลบ</a></li>
                                                <?php    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>


                                </div>
                                <div class="projectProgress">
                                    <div class="process" style=" <?php echo $projectStatus === 1 ? 'background: #dffde0;' : ($projectStatus === 2 ? 'background: #fdf5df;' : 'background: #fddfdf;') ?>">
                                        <h2 style="<?php echo $projectStatus === 1 ? 'color: #69bc72;' : ($projectStatus === 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo $projectStatus = $projectStatus === 1 ? 'Success' : ($projectStatus === 2 ? 'In Progress' : 'Failed'); ?></h2>
                                    </div>
                                    <div class="priority">
                                        <h2 style="<?php echo $projectLevel === 1 ? 'color: #69bc72;' : ($projectStatus === 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo  $projectOrganizeName; ?></h2>
                                    </div>
                                </div>
                                <div class="task">
                                    <h2>Task Done: <bold><?php echo $Process ?></bold> / 100</h2>
                                    <div class="progress" style="width: 100%;">
                                        <div class="progress-bar <?= $projectProcess >= 80 ? 'bg-success' : ($Process > 25 ? 'bg-info' : 'bg-danger'); ?>" role="progressbar" style="width: <?php echo $Process; ?>%;" aria-valuenow="<?php echo $Process ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $Process ?>%</div>
                                    </div>

                                </div>
                                <!-- <div class="divider"></div> -->
                                <div class="due">
                                    <h2>Due Date: <?php echo $formattedDate; ?></h2>
                                </div>

                                <div class='groupImg'>
                                    <?php
                                    $j = 0;

                                    $pic = 0;
                                    while ($user = mysqli_fetch_assoc($userResult)) {
                                        $imageData = $user['image_data'];
                                        $userAwaitCount = $user['user_id'];
                                        $file_name = $user['file_name'];
                                        $altAttribute = "img$j";

                                        // Calculate left offset, but skip -10 for the first element
                                        $leftOffset = - ($pic * 10);

                                        // Your code to display user information, e.g., image, etc.
                                        echo "
                                        <a href='#' style='--left: {$leftOffset}px;'>
                                            <img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='$altAttribute'>
                                        </a>";
                                        $j++;
                                        $pic++;
                                        if ($pic >= 5) {
                                            break;
                                        }
                                    }

                                    if ($j > 5) {
                                    ?>
                                        <a style="--left: -<?php echo ($j - 1) * 10; ?>px;     border: 3px solid #999;
                                        border-radius: 50%;
                                        background: #fff;">
                                            <span class="number">+<?php echo $j - 5; ?></span>
                                        </a>

                                    <?php } ?>

                                </div>
                            </div>
                        <?php }
                    }

                    if (isset($totalPages) && $totalPages > 0) { ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end py-4">
                                <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
                                    <a href="?page=<?php echo ($currentPage - 1); ?>&search=<?php echo urlencode($search); ?>&branch_filter=<?php echo $branchFilter ?>" aria-label="Previous" class="page-link">Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search) ?>&branch_filter=<?php echo $branchFilter ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo ($currentPage + 1); ?>&search=<?php echo urlencode($search); ?>&branch_filter=<?php echo $branchFilter ?>" aria-label="Next">
                                        <span aria-hidden="true">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php } else {
                        echo "No results found.";
                    }
                    ?>

                </div>


                <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../assets/js/sidebarmenu.js"></script>
                <script src="../assets/js/app.min.js"></script>
                <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>