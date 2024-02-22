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
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php
         $currentPage = 'home';
        include '../component/aside.php';

        ?>
        <div class="body-wrapper">
            <?php
            include "../component/navbar.php";
            ?>
            <div class="container-fluid">
                <div class="myTasks">
                    <!-- tasksHead start -->
                    <div class="tasksHead">
                        <h2>My Tasks (การทำงาน)</h2>
                        <div class="tasksDots">
                            <span class="material-symbols-outlined">
                                more_horiz
                            </span>
                        </div>
                    </div>
                    <!-- tasksHead end -->
                    <!-- tasks start -->
                    <div class="tasks">
                        <ul>
                            <li style="margin-top: 5px;">
                                <span class="tasksIconName">
                                    <span class="tasksIcon done">
                                        <span class="material-symbols-outlined">
                                            check
                                        </span>
                                    </span>
                                    <span class="tasksName">
                                        My Task 1
                                    </span>
                                </span>
                                <span class="tasksStar full">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon notDone"></span>
                                    <span class="tasksName">
                                        My Task 2
                                    </span>
                                </span>
                                <span class="tasksStar half">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon notDone"></span>
                                    <span class="tasksName">
                                        My Task 3
                                    </span>
                                </span>
                                <span class="tasksStar half">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon done">
                                        <span class="material-symbols-outlined">
                                            check
                                        </span>
                                    </span>
                                    <span class="tasksName tasksLine">
                                        <underline>My Task 4</underline>
                                    </span>
                                </span>
                                <span class="tasksStar half">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon done">
                                        <span class="material-symbols-outlined">
                                            check
                                        </span>
                                    </span>
                                    <span class="tasksName tasksLine">
                                        My Task 5
                                    </span>
                                </span>
                                <span class="tasksStar full">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon notDone"></span>
                                    <span class="tasksName">
                                        My Task 6
                                    </span>
                                </span>
                                <span class="tasksStar full">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="tasksIconName">
                                    <span class="tasksIcon notDone"></span>
                                    <span class="tasksName">
                                        My Task 7
                                    </span>
                                </span>
                                <span class="tasksStar half">
                                    <span class="material-symbols-outlined">
                                        star
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!-- tasks ens -->
                </div>
            </div>
        </div>
    </div>

   
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>


<style>
   .page-wrapper .body-wrapper .container-fluid .myTasks {
    position: relative;
    max-width: 600px;
    border: none !important;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 1);
    backdrop-filter: blur(5px);
    border-radius: 20px;
    box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: column;
    grid-row: 1 / 5;
    grid-column: 2 / 3;
}



.page-wrapper .body-wrapper .container-fluid  .myTasks .tasksHead {
    position: relative;
    width: 100%;
    height: 30px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasksHead h2 {
    position: relative;
    width: 100%;
    height: 100%;
    line-height: 18px;
    color: #000;
    font-size: 1.2em;
    cursor: pointer;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasksHead .tasksDots {
    position: relative;
    cursor: pointer;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasksHead .tasksDots span {
    color: #000;
    font-size: 1.8em;
    font-weight: 700;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks {
    position: relative;
    width: 100%;
    height: 100%;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks ul {
    position: relative;
    width: 100%;
    height: 100%;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks ul li {
    position: relative;
    width: 100%;
    height: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks ul li::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1.5px;
    background: rgba(0, 0, 0, .1);
}

.page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li:last-child::before {
    width: 0;
}

.page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks ul li .tasksIconName .tasksIcon {
    position: relative;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.page-wrapper .body-wrapper .container-fluid  .myTasks .tasks ul li .tasksIconName .tasksIcon.done {
    color: #fff;
    background: #69bc72;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksIconName .tasksIcon.notDone {
    background: #fff;
    border: 3px solid #999;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksIconName .tasksName {
    position: relative;
    color: #000;
    cursor: pointer;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksIconName .tasksName.tasksLine {
    color: #999;
    cursor: not-allowed;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksIconName .tasksName.tasksLine::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 1.5px;
    background: rgba(0, 0, 0, .3);
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksStar {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksStar.full {
    color: #f5c75f;
}

.page-wrapper .body-wrapper .container-fluid   .myTasks .tasks ul li .tasksStar.half {
    color: #f5c75f;
}


</style>