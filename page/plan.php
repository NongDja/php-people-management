<!DOCTYPE html>
<?php session_start();
include "../auth/checklogin.php";
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
    <!-- <link rel="stylesheet" href="../assets/css/main.css"> -->
    <style>
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

        .container-fluid .projectCard .projectTop h2 {
            color: #000;
            font-size: 1.2em;
            line-height: 18px;
            cursor: pointer;
        }

        .container-fluid .projectCard .projectTop h2:hover {
            color: #0D6EFD
        }

        .container-fluid .projectCard .projectTop h2 span {
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

        /* .container-fluid  .projectCard .projectProgress .priority::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                width: 8px;
                height: 8px;
                transform: translate(-50%, -50%);
                background: #ff0000;
                border-radius: 50%;
                box-shadow: 0 0 2px #ff0000,
                    0 0 5px #ff000077;
            } */

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

        .container-fluid .projectCard .groupImg a:last-child {
            border: 3px solid #999;
            border-radius: 50%;
            background: #fff;
        }

        .container-fluid .projectCard .groupImg a:last-child span {
            color: #999;
            font-size: 1.2em;
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
                                                                                    echo './home.php';
                                                                                } ?>" class="btn btn-info">+เพิ่มข้อมูล</a></h3>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <!-- <div>
                                    <button class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sort</a>

                                        <ul class="dropdown-menu">
                                            <li class="nav-item dropend">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Status
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Success</a></li>
                                                    <li><a class="dropdown-item" href="#">In Progress</a></li>
                                                    <li><a class="dropdown-item" href="#">Failed</a></li>
                                                </ul>
                                            </li>
                                            <li class="nav-item dropend">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Level
                                                </a>

                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Easy</a></li>
                                                    <li><a class="dropdown-item" href="#">Medium</a></li>
                                                    <li><a class="dropdown-item" href="#">Hard</a></li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </button>
                                </div> -->

                                <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script> -->
                            </div>
                        </div>
                    </div>

                    <?php
                    include '../connect.php';
                    $id = $_SESSION["userId"];
                    $con = mysqli_connect($servername, $username, $password, $dbname);
                    if ($_SESSION['role'] != 3) {
                        $sql = "SELECT project.project_id, 
                        (SELECT COUNT(DISTINCT project_user.project_id) FROM project_user) AS projectCount, 
                        project.*
                 FROM project 
                 JOIN project_user ON project_user.project_id = project.project_id
                 JOIN members ON members.id = project_user.user_id
                 GROUP BY project.project_id, members.image_data, members.firstname, members.surname;
                 ";
                    } else {
                        $sql = "SELECT project.*,members.image_data, members.firstname, members.surname FROM project LEFT JOIN members ON members.id = project.user_id JOIN project_user ON user_auth.userId = project_user.user_id
                        JOIN project ON project_user.project_id = project.project_id WHERE project_user.user_id = '$id'";
                    }

                    $stmt = mysqli_prepare($con, $sql);
                    $stmt->execute();
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($project = mysqli_fetch_assoc($result)) {
                        $projectId = $project['project_id'];
                        $projectLevel = $project['level'];
                        $projectStatus = $project['status'];
                        $projectCount = $project['projectCount'];
                        $projectName = $project['project_name'];
                        // $projectDescription = $row['project_description'];
                        // $imageData = $project['image_data'];
                        // $firstname = $project['firstname'];
                        // $surname = $project['surname'];
                        $projectDate = $project['deadline'];
                        // Perform further actions as needed
                        echo "Project ID: $projectId, Project Count: $projectCount, Project Name: $projectName";
                        $userQuery = "SELECT members.image_data FROM members 
                        JOIN project_user ON members.id = project_user.user_id
                        WHERE project_user.project_id = ?";
                        $userStmt = mysqli_prepare($con, $userQuery);
                        mysqli_stmt_bind_param($userStmt, "i", $projectId);
                        mysqli_stmt_execute($userStmt);
                        $userResult = mysqli_stmt_get_result($userStmt);
                    }
                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($i <= $projectCount) {
                            $i++;
                            $dateTime = new DateTime($projectDate);
                            $formattedDate = $dateTime->format('d F Y'); ?>
                            <div class="projectCard projectCard2">
                                <div class="projectTop">
                                <?php
                                    $j = 1;
                                    $pic = 0;
                                    while ($user = mysqli_fetch_assoc($userResult)) { ?>

                                     <?php } ?>
                                    <h2><?php echo $projectName ?><br><span> Name</span></h2>

                                    <div class="projectDots">
                                        <li class="material-symbols-outlined dropdown " id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            more_horiz

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="#">แก้ไขชื่อ</a></li>
                                                <li><a class="dropdown-item" onclick="confirmDelete(<?php echo $row['project_id']; ?>)">ลบ</a></li>
                                            </ul>
                                        </li>
                                    </div>
                                </div>
                                <div class="projectProgress">
                                    <div class="process" style=" <?php echo $projectStatus === 1 ? 'background: #dffde0;' : ($projectStatus === 2 ? 'background: #fdf5df;' : 'background: #fddfdf;') ?>">
                                        <h2 style="<?php echo $projectStatus === 1 ? 'color: #69bc72;' : ($projectStatus === 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo $projectStatus = $projectStatus === 1 ? 'Success' : ($projectStatus === 2 ? 'In Progress' : 'Failed'); ?></h2>
                                    </div>
                                    <div class="priority">
                                        <h2 style="<?php echo $projectLevel === 1 ? 'color: #69bc72;' : ($projectStatus === 2 ? 'color: #e1701a;' : 'color: #ec0b0b;') ?>"><?php echo $projectLevel = $projectLevel === 1 ? 'Low Priority' : ($projectLevel === 2 ? 'Medium Priority' : 'High Priority'); ?></h2>
                                    </div>
                                </div>
                                <div class="task">
                                    <h2>Task Done: <bold>35</bold> / 50</h2>
                                    <span class="line"></span>
                                </div>
                                <!-- <div class="divider"></div> -->
                                <div class="due">
                                    <h2>Due Date: <?php echo $formattedDate; ?></h2>
                                </div>

                                <div class='groupImg'>
                                    <?php
                                    $j = 1;
                                    $pic = 0;
                                    while ($user = mysqli_fetch_assoc($userResult)) {
                                        $imageData = $user['image_data'];
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
                                    }
                                    ?>
                                    <a style="--left: -<?php echo ($j - 1) * 10; ?>px;     border: 3px solid #999;
                                        border-radius: 50%;
                                        background: #fff;">
                                        <span class="number">+<?php echo $j - 1; ?></span>
                                    </a>
                    



                                </div>
                            </div>
                            <?php }
                    } else {
                    }

                            ?>
                </div>
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

                <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
                <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../assets/js/sidebarmenu.js"></script>
                <script src="../assets/js/app.min.js"></script>
                <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
                <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
                <script src="../assets/js/dashboard.js"></script>
</body>