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
        $currentPage = 'dashbaord';
        include '../component/aside.php';

        ?>
        <div class="body-wrapper">
            <?php
            include "../component/navbar.php";

            $monthsData = array();

            // ระบุปีปัจจุบัน
            $currentYear = date('Y');
            $currentMonth = date('n');
            $selectedMonth = $currentMonth;
            // สร้าง array ข้อมูลเดือน
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date('F', mktime(0, 0, 0, $month, 1));

                // เพิ่มข้อมูลเดือนลงใน array
                $monthsData[] = array(
                    'name' => $monthName . ' ' . $currentYear,
                    'month' => $month,
                    'year' => $currentYear
                );
            }
            include "../connect.php";
            $conn = mysqli_connect(
                $servername,
                $username,
                $password,
                $dbname
            );
            if (!$conn) {
                die("error" . mysqli_connect_error());
            }
            $sql = "SELECT *
            FROM project
            WHERE YEAR(deadline) = 2024 AND MONTH(deadline) = 3;";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
                foreach ($projects as $project) {
                    $categories[] = $project['project_name'];
                    $budgets[] = $project['budget'];
                }

                // Free result set
                mysqli_free_result($result);
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            if (isset($_POST['monthDate'])) {
                $selectedMonth = $_POST['monthDate'];
                $sql = "SELECT *
                FROM project
                WHERE YEAR(deadline) = $currentYear AND MONTH(deadline) = $selectedMonth;";
                
                $result = mysqli_query($conn, $sql);
                $categories = array();
                $budgets = array();
                if ($result) {
                    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
                    foreach ($projects as $project) {
                        $categories[] = $project['project_name'];
                        $budgets[] = $project['budget'];
                    }

                    // Free result set
                    mysqli_free_result($result);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                echo "Categories:<br>";
                print_r($categories);
            }
            ?>
            <div class="container-fluid">
                <?php if (isset($_SESSION['username'])) { ?>
                    <?php if ($_SESSION['role'] != 3) { ?>
                        <div class="row">
                            <div class="col-lg-12 d-flex align-items-strech">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                                <h5 class="card-title fw-semibold">Budgets Overview</h5>
                                            </div>
                                            <div>
                                                <form id="myForm" action="" method="post">
                                                    <select name="monthDate" id="monthDate" class="form-select">
                                                        <?php foreach ($monthsData as $monthInfo) : ?>
                                                            <option value="<?php echo $monthInfo['month']; ?>" <?php echo ($monthInfo['month'] == $selectedMonth) ? 'selected' : ''; ?>>
                                                                <?php echo $monthInfo['name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </form>

                                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#monthDate').change(function() {
                                                            $('#myForm').submit();
                                                        });
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                        <div id="chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="card overflow-hidden">
                                            <div class="card-body p-4">
                                                <h5 class="card-title mb-9 fw-semibold">Budgets Used</h5>
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="fw-semibold mb-3">36,358</h4>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-arrow-up-left text-success"></i>
                                                            </span>
                                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                            <p class="fs-3 mb-0">last year</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-4">
                                                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                                <span class="fs-2">2024</span>
                                                            </div>
                                                            <div class="me-4">
                                                                <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                                <span class="fs-2">2023</span>
                                                            </div>
                                                            <div>
                                                                <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                                <span class="fs-2">2022</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="d-flex justify-content-center">
                                                            <div id="breakup"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <!-- Monthly Earnings -->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row alig n-items-start">
                                                    <div class="col-8">
                                                        <h5 class="card-title mb-9 fw-semibold"> Monthly Used</h5>
                                                        <h4 class="fw-semibold mb-3">6,820</h4>
                                                        <div class="d-flex align-items-center pb-1">
                                                            <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-arrow-down-right text-danger"></i>
                                                            </span>
                                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                                            <p class="fs-3 mb-0">last month</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="d-flex justify-content-end">
                                                            <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-currency-dollar fs-6"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="earning"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-8 d-flex align-items-strech">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                                <h5 class="card-title fw-semibold">Budgets Overview</h5>
                                            </div>
                                            <div>
                                                <select class="form-select">
                                                    <option value="1">March 2023</option>
                                                    <option value="2">April 2023</option>
                                                    <option value="3">May 2023</option>
                                                    <option value="4">June 2023</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="chart1"></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    <?php }  ?>

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
    <script>
        $(function() {


            // =====================================
            // Profit
            // =====================================
            var chart = {
                series: [{
                        name: "Budgets:",
                        data: <?php echo  json_encode($budgets) ?>
                    },
                    {
                        name: "Budget Used:",
                        data: [35000, 25000, 32500, 9100, 6250, 33100, 62800, 25000,3000, 25000,3000,3000]
                    },
                ],

                chart: {
                    type: "bar",
                    height: 345,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: {
                        enabled: false
                    },
                },


                colors: ["#5D87FF", "#49BEFF"],


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },

                dataLabels: {
                    enabled: false,
                },


                legend: {
                    show: false,
                },


                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },

                xaxis: {
                    type: "category",
                    categories: <?php echo json_encode($categories); ?>,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },


                yaxis: {
                    show: true,
                    min: 0,
                    max: 100000,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },


                tooltip: {
                    theme: "light"
                },

                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]


            };

            var chart = new ApexCharts(document.querySelector("#chart"), chart);
            chart.render();


            // =====================================
            // Breakup
            // =====================================
            var breakup = {
                color: "#adb5bd",
                series: [38, 40, 25],
                labels: ["2022", "2021", "2020"],
                chart: {
                    width: 180,
                    type: "donut",
                    fontFamily: "Plus Jakarta Sans', sans-serif",
                    foreColor: "#adb0bb",
                },
                plotOptions: {
                    pie: {
                        startAngle: 0,
                        endAngle: 360,
                        donut: {
                            size: '75%',
                        },
                    },
                },
                stroke: {
                    show: false,
                },

                dataLabels: {
                    enabled: false,
                },

                legend: {
                    show: false,
                },
                colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],

                responsive: [{
                    breakpoint: 991,
                    options: {
                        chart: {
                            width: 150,
                        },
                    },
                }, ],
                tooltip: {
                    theme: "dark",
                    fillSeriesColor: false,
                },
            };

            var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
            chart.render();



            // =====================================
            // Earning
            // =====================================
            var earning = {
                chart: {
                    id: "sparkline3",
                    type: "area",
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                    group: "sparklines",
                    fontFamily: "Plus Jakarta Sans', sans-serif",
                    foreColor: "#adb0bb",
                },
                series: [{
                    name: "Earnings",
                    color: "#49BEFF",
                    data: [25, 66, 20, 40, 12, 58, 20],
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                fill: {
                    colors: ["#f3feff"],
                    type: "solid",
                    opacity: 0.05,
                },

                markers: {
                    size: 0,
                },
                tooltip: {
                    theme: "dark",
                    fixed: {
                        enabled: true,
                        position: "right",
                    },
                    x: {
                        show: false,
                    },
                },
            };
            new ApexCharts(document.querySelector("#earning"), earning).render();



            var chart = {
                series: [{
                        name: "Earnings this month:",
                        data: [200, 390, 300, 350, 390, 180, 355, 390]
                    },
                    {
                        name: "Expense this month:",
                        data: [280, 250, 325, 215, 250, 310, 280, 250]
                    },
                ],

                chart: {
                    type: "bar",
                    height: 345,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: {
                        enabled: false
                    },
                },


                colors: ["#5D87FF", "#49BEFF"],


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },

                dataLabels: {
                    enabled: false,
                },


                legend: {
                    show: false,
                },


                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },

                xaxis: {
                    type: "category",
                    categories: ["16/08", "17/08", "18/08", "19/08", "20/08", "21/08", "22/08", "23/08"],
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },


                yaxis: {
                    show: true,
                    min: 0,
                    max: 400,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },


                tooltip: {
                    theme: "light"
                },

                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]


            };

            var chart = new ApexCharts(document.querySelector("#chart1"), chart);
            chart.render();
        })
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