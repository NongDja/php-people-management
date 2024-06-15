<!DOCTYPE html>
<?php session_start();
// include "../auth/checklogin.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./image/a.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
        body {
            background: #fafafa;
        }

        .timeline-widget {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php
        $currentPage = 'timeline';
        include '../component/aside.php';

        ?>
        <div class="body-wrapper">
            <?php
            include "../component/navbar.php";
            include "../connect.php";
            // $delete_id = ($_GET['id']);
            $conn = mysqli_connect(
                $servername,
                $username,
                $password,
                $dbname
            );
            if (!$conn) {
                die("error" . mysqli_connect_error());
            }
            $currentDate = date('Y-m-d');

            if (isset($_SESSION['role'])) {
                $id = $_SESSION['userId'];
                $sql = "";
                if ($_SESSION['role'] == 1) {
                    $sql = "SELECT *
                    FROM project
                    WHERE deadline >= CURDATE() AND deadline <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
                    ORDER BY deadline ASC;
                    ";
                } else if ($_SESSION['role'] == 2) {
                    $sql = "SELECT project.*
                FROM project
                INNER JOIN project_user ON project.project_id = project_user.project_id
                WHERE deadline >= CURDATE() AND deadline <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH) 
                AND project_user.user_id = $id
                ORDER BY deadline ASC;";
                }

                if (!empty($sql)) {
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                } else {
                    echo "Invalid role or no query to execute.";
                }
            } else {
                echo "Role is not set in the session.";
            }
        



            $borderClass = 'border-primary';


            ?>
            <div class="container-fluid">
                <?php if (isset($_SESSION['username'])) { ?>
                    <div class="row">
                        <div class="col-lg-4 d-flex align-items-stretch">
                            <div class="card w-100">
                                <?php if (!empty($result)) { ?>
                                    <div class="card-body p-4">
                                    <div class="mb-4">
                                        <h5 class="card-title fw-semibold">Upcoming Timeline</h5>
                                    </div>
                                    <ul class="timeline-widget mb-0 position-relative">
                                        <?php
                                        $lastIteration = true;
                                        $num = mysqli_num_rows($result);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $status = $row['status'];
                                            $originalDate = $row['deadline'];

                                            if ($num == 1) {
                                                $lastIteration = false;
                                            }
                                            if ($status == 1) {
                                                $borderClass = 'border-success';
                                            } elseif ($status == 2) {
                                                $borderClass = 'border-warning';
                                            } elseif ($status == 3) {
                                                $borderClass = 'border-danger';
                                            }

                                            $formattedDate = date("d F Y", strtotime($originalDate));
                                        ?>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div style="width: 150px;" class="timeline-time text-dark flex-shrink-0 text-end"><?php echo $formattedDate ?></div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border <?php echo $borderClass; ?> flex-shrink-0 my-8"></span>
                                                    <?php if ($lastIteration) : ?>
                                                        <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1"><?php echo $row['project_name'] ?></div>
                                            </li>
                                        <?php
                                            $num--;
                                        } ?>
                                    </ul>
                                </div>
                                    <?php } ?>
                                
                            </div>
                        </div>
                        <div class="content col-lg-8 p-0">
                            <div id='calendar'></div>
                        </div>
                    </div>
                <?php  } ?>


            </div>

        </div>
    </div>
    <?php
    if (isset($_SESSION['username'])) {
        if ($_SESSION['role'] == 1) {
            $sql1 = "SELECT *
            FROM project
            ORDER BY deadline ASC;
            ";
        } else {
            $sql1 = "SELECT project.*
            FROM project
            INNER JOIN project_user ON project.project_id = project_user.project_id
            WHERE project_user.user_id = $id
            ORDER BY deadline ASC;
            ";
        }
        $result1 = mysqli_query($conn, $sql1);
        $events = [];

        while ($row1 = mysqli_fetch_assoc($result1)) {
            $eventStart = $row1['deadline'];
    
            $event = [
                'title' => $row1['project_name'],
                'url' => '../plan/plan_detail.php?page=' . $row1['project_id'],
                'start' => $eventStart,
            ];
    
            $events[] = $event;
        }
    
        $eventsJson = json_encode($events);
    }
    ?>


    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>

    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/interaction/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid'],
                defaultDate: '<?php echo $currentDate; ?>',
                // editable: true,
                eventLimit: true, 
                events: <?php echo $eventsJson; ?>,
            });

            calendar.render();
        });
    </script>
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



    .page-wrapper .body-wrapper .container-fluid .myTasks .tasksHead {
        position: relative;
        width: 100%;
        height: 30px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasksHead h2 {
        position: relative;
        width: 100%;
        height: 100%;
        line-height: 18px;
        color: #000;
        font-size: 1.2em;
        cursor: pointer;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasksHead .tasksDots {
        position: relative;
        cursor: pointer;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasksHead .tasksDots span {
        color: #000;
        font-size: 1.8em;
        font-weight: 700;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li {
        position: relative;
        width: 100%;
        height: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li::before {
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

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksIcon {
        position: relative;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksIcon.done {
        color: #fff;
        background: #69bc72;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksIcon.notDone {
        background: #fff;
        border: 3px solid #999;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksName {
        position: relative;
        color: #000;
        cursor: pointer;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksName.tasksLine {
        color: #999;
        cursor: not-allowed;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksIconName .tasksName.tasksLine::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1.5px;
        background: rgba(0, 0, 0, .3);
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksStar {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksStar.full {
        color: #f5c75f;
    }

    .page-wrapper .body-wrapper .container-fluid .myTasks .tasks ul li .tasksStar.half {
        color: #f5c75f;
    }
</style>