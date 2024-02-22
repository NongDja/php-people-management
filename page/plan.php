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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/main.css">


</head>

<body>
    <div class="container">
        <?php
        $currentPage = 'plan';
        include "../component/navbar.php";
        ?>
        <div class="row mb-3">
            <div class="col-md-12"> <br>
                <div class="row">
                    <div class="col-6 ">
                        <h3>แผนงานของฉัน <?php if ($_SESSION['role'] != 3) { ?> <a href="member_formAdd.php" class="btn btn-info">+เพิ่มข้อมูล</a> <?php } ?> </h3>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div>
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
                        </div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
                    </div>
                </div>
            </div>

            <?php
            include '../connect.php';
            $id = $_SESSION["userId"];
            $con = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT project.*,members.image_data, members.firstname, members.surname FROM project LEFT JOIN members ON members.id = project.user_id WHERE members.id = $id";
            $stmt = mysqli_prepare($con, $sql);
            $stmt->execute();
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $projectName = $row['project_name'];
                    $projectLevel = $row['level'];
                    $projectStatus = $row['status'];
                    $firstname = $row['firstname'];
                    $surname = $row['surname'];
                    $projectDate = $row['deadline'];
                    $dateTime = new DateTime($projectDate);
                    $formattedDate = $dateTime->format('d F Y'); ?>

                    <div class="projectCard projectCard2">
                        <div class="projectTop">
                            <h2><?php echo $projectName ?><br><span>Company Name</span></h2>
                           
                            <div class="projectDots">
                                <li class="material-symbols-outlined dropdown " id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    more_horiz

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">แก้ไขชื่อ</a></li>
                                        <li><a class="dropdown-item" href="#">ลบ</a></li>
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
                        <div class="messagesUser">
                            <div class="messagesUserImg">
                                <img src="data:image/jpeg;base64,<?= base64_encode($row["image_data"]) ?>" alt="img1">
                            </div>
                            <h2> <?= $firstname . ' ' . $surname; ?><br><span>สาขา</span></h2>
                        </div>
                    </div>

            <?php }
            } else {
            }
            ?>



        </div>



    </div>
    <style>
        .divider {
            width: 100%;
            height: 1px;
            /* Adjust the height as needed */
            background-color: #000;
            /* Adjust the color as needed */
            margin-top: 20px
        }
   


        .dropdown:hover>.dropdown-menu,
        .dropend:hover>.dropdown-menu{
            display: block;
            margin-top: .1em;
            margin-left: .1em;
        }

        @media screen and (min-width:769px) {
            .dropend:hover>.dropdown-menu {
                position: absolute;
                top: 0;
                left: 100%;
            }
        }
    </style>

</body>