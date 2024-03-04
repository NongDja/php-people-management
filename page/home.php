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

    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
        body {
            background: #fafafa;
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
            ?>
            <div class="container-fluid">
                <?php if (isset($_SESSION['username'])) { ?>
                        <div class="row">
                            <div class="col-lg-4 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <h5 class="card-title fw-semibold">Recent Timeline</h5>
                                        </div>
                                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment received from John Doe of $385.90</div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">10:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-info flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment was made of $64.95 to Michael</div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-warning flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New sale recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">09:30 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-8"></span>
                                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">New arrival recorded
                                                </div>
                                            </li>
                                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                                <div class="timeline-time text-dark flex-shrink-0 text-end">12:00 am</div>
                                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                                    <span class="timeline-badge border-2 border border-success flex-shrink-0 my-8"></span>
                                                </div>
                                                <div class="timeline-desc fs-3 text-dark mt-n1">Payment Done</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-semibold mb-4">Recent Timeline</h5>
                                        <div class="table-responsive">
                                            <table class="table text-nowrap mb-0 align-middle">
                                                <thead class="text-dark fs-4">
                                                    <tr>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Id</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Assigned</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Name</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Priority</h6>
                                                        </th>
                                                        <th class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">Budget</h6>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">1</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                                                            <span class="fw-normal">Web Designer</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Elite Admin</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-primary rounded-3 fw-semibold">Low</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$3.9</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">2</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Andrew McDownland</h6>
                                                            <span class="fw-normal">Project Manager</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Real Homes WP Theme</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-secondary rounded-3 fw-semibold">Medium</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$24.5k</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">3</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Christopher Jamil</h6>
                                                            <span class="fw-normal">Project Manager</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">MedicalPro WP Theme</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-danger rounded-3 fw-semibold">High</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$12.8k</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0">4</h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1">Nirav Joshi</h6>
                                                            <span class="fw-normal">Frontend Engineer</span>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <p class="mb-0 fw-normal">Hosting Press HTML</p>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-success rounded-3 fw-semibold">Critical</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0 fs-4">$2.4k</h6>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php  } ?>


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