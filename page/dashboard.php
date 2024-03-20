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
            $categories = array();
            $budgets = array();
            $butgetsUsed = array();
            $sql = "SELECT
            project.*,
            COALESCE(SUM(project_user.budget_user_used), 0) AS total_budget
            FROM project
            LEFT JOIN project_user ON project.project_id = project_user.project_id
            WHERE YEAR(project.deadline) = $currentYear AND MONTH(project.deadline) = $selectedMonth
            GROUP BY project.project_id
            ORDER BY project.deadline ASC;";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($projects as $project) {
                    $categories[] = $project['project_name'];
                    $budgets[] = $project['budget'];
                    $butgetsUsed[] = $project['total_budget'];
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            if (isset($_POST['monthDate'])) {
                $selectedMonth = $_POST['monthDate'];
                $sql = "SELECT
                        project.*,
                        COALESCE(SUM(project_user.budget_user_used), 0) AS total_budget
                        FROM project
                        LEFT JOIN project_user ON project.project_id = project_user.project_id
                        WHERE YEAR(project.deadline) = $currentYear AND MONTH(project.deadline) = $selectedMonth
                        GROUP BY project.project_id
                        ORDER BY project.deadline ASC;";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    // Clear arrays before appending new data
                    $categories = array();
                    $budgets = array();
                    $butgetsUsed = array();

                    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($projects as $project) {
                        $categories[] = $project['project_name'];
                        $budgets[] = $project['budget'];
                        $butgetsUsed[] = $project['total_budget'];
                    }

                    // Free result set
                    mysqli_free_result($result);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            ?>
            <div class="container-fluid">
                <?php if (isset($_SESSION['username'])) { ?>
                    <?php if ($_SESSION['role'] != 3) { ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <?php
                                    $allYear = array();
                                    $allBudget = array();
                                    $sqlYearBudget = "SELECT
                                    years.year AS year_identifier,
                                    COALESCE(SUM(project_user.budget_user_used), 0) AS total_budget
                                    FROM (
                                        SELECT 2024 AS year
                                        UNION SELECT 2023
                                        UNION SELECT 2022
                                    ) AS years
                                    LEFT JOIN project ON YEAR(project.deadline) = years.year
                                    LEFT JOIN project_user ON project.project_id = project_user.project_id
                                    GROUP BY years.year
                                    ORDER BY years.year DESC;
                                ";
                                    $resultYearBudget = mysqli_query($conn, $sqlYearBudget);

                                    if ($result) {
                                        $yearlyData = array();

                                        while ($yearBudget = mysqli_fetch_assoc($resultYearBudget)) {
                                            $allYear[] = $yearBudget['year_identifier'];
                                            $allBudget[] = $yearBudget['total_budget'];
                                            // Check if the year is 2024
                                            if ($yearBudget['year_identifier'] == $currentYear) {
                                                // Use the total budget for the year 2024
                                                $totalBudgetCurrentYear = $yearBudget['total_budget'];
                                                $formattedTotalBudget = number_format($totalBudgetCurrentYear);
                                            } else if ($yearBudget['year_identifier'] == $currentYear - 1) {
                                                $lastYear = $currentYear - 1;
                                                $totalBudgetLastYear = $yearBudget['total_budget'];
                                                $formattedLastyearTotalBudget = number_format($totalBudgetLastYear);
                                            }

                                            // Store the data for further processing if needed
                                            $yearlyData[] = $yearBudget;
                                        }
                                        $totalBudgetLastYear == 0 ? $percentage = 0 :
                                        $percentage = ($totalBudgetCurrentYear /  $totalBudgetLastYear) * 100;

                                        $allBudget = array_map('intval', $allBudget);
                                        // Free result set
                                        // mysqli_free_result($result);
                                    } else {
                                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                    }
                                    ?>
                                    <div class="card overflow-hidden">
                                        <div class="card-body p-4">
                                            <h5 class="card-title mb-9 fw-semibold">งบประมาณที่ใช้ทั้งปี</h5>
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="fw-semibold mb-3"><?php echo  $formattedTotalBudget ?></h4>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-arrow-up-left text-success"></i>
                                                        </span>
                                                        <p class="text-dark me-1 fs-3 mb-0">+<?php echo $percentage ?>%</p>
                                                        <p class="fs-3 mb-0">last year</p>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-4">
                                                            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                            <span class="fs-2"><?php echo $currentYear ?></span>
                                                        </div>
                                                        <div class="me-4">
                                                            <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                            <span class="fs-2"><?php echo  $lastYear ?></span>
                                                        </div>
                                                        <div>
                                                            <span class="round-8 bg-dark-light rounded-circle me-2 d-inline-block"></span>
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
                            </div>

                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <!-- Monthly Earnings -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row alig n-items-start">
                                                <?php
                                                $currentMonthBudget = 0; // Default value

                                                $sqlYearBudget = "SELECT
                                                MONTH(project.deadline) AS month,
                                                COALESCE(SUM(project_user.budget_user_used), 0) AS total_budget
                                                FROM project
                                                LEFT JOIN project_user ON project.project_id = project_user.project_id
                                                WHERE YEAR(project.deadline) = $currentYear
                                                GROUP BY MONTH(project.deadline);";

                                                $resultYearBudget = mysqli_query($conn, $sqlYearBudget);

                                                if ($resultYearBudget) {
                                                    // Initialize an array to store monthly budgets
                                                    $monthlyBudgets = array_fill(1, 12, 0);

                                                    // Loop through the result set using a while loop
                                                    while ($row = mysqli_fetch_assoc($resultYearBudget)) {
                                                        // Store each month's total budget in the array
                                                        $monthlyBudgets[$row['month']] = intval($row['total_budget']);
                                                    }

                                                    // Display the results
                                                    for ($month = 1; $month <= 12; $month++) {
                                                        $monthName = date("F", mktime(0, 0, 0, $month, 1, 2024));
                                                        $budget = isset($monthlyBudgets[$month]) ? $monthlyBudgets[$month] : 0;
                                                        if ($month == $currentMonth) {
                                                            $currentMonthBudget = $budget;
                                                        }
                                                    }
                                                    $monthlyBudgets = array_values($monthlyBudgets);

                                                    // Free result set
                                                    mysqli_free_result($resultYearBudget);
                                                } else {
                                                    echo "Error: " . $sqlYearBudget . "<br>" . mysqli_error($conn);
                                                }

                                                // Close the database connection
                                                mysqli_close($conn);
                                                ?>
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">งบประมาณที่ใช้เดือนนี้</h5>
                                                    <h4 class="fw-semibold mb-3"><?php echo  number_format($currentMonthBudget) ?></h4>
                                                    <div class="d-flex align-items-center pb-1">


                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-currency-baht fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <!-- Monthly Earnings -->
                                    <div class="card" style="height: 218px;">
                                        <div class="card-body">
                                            <div class="row alig n-items-start">
                                                <?php
                                                 $conn = mysqli_connect(
                                                    $servername,
                                                    $username,
                                                    $password,
                                                    $dbname
                                                );
                        
                                                if (!$conn) {
                                                    die("Connection failed: " . mysqli_connect_error());
                                                }
                                                $sql4 = "SELECT COUNT(*) as countMonth FROM project WHERE YEAR(deadline) = $currentYear AND MONTH(deadline) = $currentMonth";
                                                $resultCountMonth = mysqli_query($conn, $sql4);
                                                $countMonth = mysqli_fetch_assoc($resultCountMonth);
                                                mysqli_close($conn);
                                                ?>
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">จำนวนการอบรมเดือนนี้</h5>
                                                    <h4 class="fw-semibold mb-3"><?php echo $countMonth['countMonth'] ?> ครั้ง</h4>
                                                    <div class="d-flex align-items-center pb-1">


                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-checklist fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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


                        </div>

                        <?php
                        $conn = mysqli_connect(
                            $servername,
                            $username,
                            $password,
                            $dbname
                        );

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql3 = "SELECT * FROM branch";
                        $resultBranch = mysqli_query($conn, $sql3);
                        ?>
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                    <h2>รายงานการอบรม</h2>
                                    <button class="btn btn-outline-success" id="exportButton"><i class="ti ti-file-spreadsheet"></i> Export to excel</button>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-outline-secondary" id="toggleDivButton"><i class="ti ti-filter"></i></button>
                                    </div>
                                    <div class="col-12" id="additionalFields" style="display: none;">
                                        <form action="get_process.php" id="trainingForm" method="post">
                                            <div class="row ">
                                                <div class="col-6">
                                                <label for="name">ชื่ออบรม:</label>
                                                <input name="projectName" class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="branch">สาขา:</label>
                                                    <select class="form-control" name="branch" id="branch">
                                                        <option value="all">All</option>
                                                        <?php
                                                        while ($branch = mysqli_fetch_assoc($resultBranch)) {
                                                            echo "<option value='{$branch['branch_id']}'>{$branch['branch_name']}</option>";
                                                        }
                                                        mysqli_data_seek($resultBranch, 0);
                                                        ?>
                                                        <!-- Add more branch options as needed -->
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label for="member">ผู้อบรม:</label>
                                                    <select class="form-control" name="member" id="member">
                                                        <option value="all">All</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3">
                                                    <label for="date">ปีที่จัดอบรมระหว่าง (ค.ศ.):</label>
                                                    <input name="yearStart" class="form-control" type="number">
                                                </div>
                                                <div class="col-3">
                                                    <label for="date">ปีที่จัดอบรมจนถึง (ค.ศ.):</label>
                                                    <input name="yearEnd" class="form-control" type="number">
                                                </div>
                                                <div class="col-3" style="margin-top: 0.2rem;">
                                                    <label for="budget">งบประมาณระหว่าง:</label>
                                                    <input name="budgetStart" class="form-control" type="number">
                                                </div>
                                                <div class="col-3" style="margin-top:0.2rem;">
                                                    <label for="budget">งบประมาณจนถึง:</label>
                                                    <input name="budgetEnd" class="form-control" type="number">
                                                </div>
                                            </div>



                                            <button class="btn btn-outline-success mt-3" type="submit">Submit</button>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div id="resultTableContainer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                    <h2>รายงานงบประมาณรวมประจำปี</h2>
                                    <button class="btn btn-outline-success" id="exportButton1"><i class="ti ti-file-spreadsheet"></i> Export to excel</button>
                                    </div>
                                  
                                    <div class="col-12 d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-outline-secondary" id="toggleDivButton1"><i class="ti ti-filter"></i></button>
                                    </div>
                                    <div class="col-12" id="additionalFields1" style="display: none;">
                                        <form action="get_budget.php" id="trainingForm1" method="post">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="branch">สาขา:</label>
                                                    <select class="form-control" name="branch" id="branch1">
                                                        <option value="all">All</option>
                                                        <?php
                                                        while ($branch = mysqli_fetch_assoc($resultBranch)) {
                                                            echo "<option value='{$branch['branch_id']}'>{$branch['branch_name']}</option>";
                                                        }
                                                        ?>
                                                        <!-- Add more branch options as needed -->
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label for="member">ผู้ไปอบรม:</label>
                                                    <select class="form-control" name="member" id="member1">
                                                        <option value="all">All</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <label for="date">ปีงบประมาณ (ค.ศ.):</label>
                                                    <input name="yearBudget" class="form-control" type="number" required>
                                                </div>
                                            </div>



                                            <button class="btn btn-outline-success mt-3" type="submit">Submit</button>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div id="resultTableContainer1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php }  ?>

                <?php  } ?>


            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/jquery.table2excel.js"></script>

    <script>
        $(document).ready(function() {

            function exportTableToExcel() {
                const table = document.getElementById("myDataTable");
                const ws = XLSX.utils.table_to_sheet(table);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                XLSX.writeFile(wb, "data_file.xlsx");
            }

            // Function to export table to Excel
            function exportTableToExcel1() {
                const table = document.getElementById("myDataTable1");
                const ws = XLSX.utils.table_to_sheet(table);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                XLSX.writeFile(wb, "budget_file.xlsx");
            }

            $("#exportButton").click(function() {
                exportTableToExcel();
            });

            // Event listener for the export button
            $("#exportButton1").click(function() {
                exportTableToExcel1();
            });
        });
    </script>




    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach a click event to the toggle button
            $('#toggleDivButton').click(function() {
                // Toggle the visibility of the additional fields div
                $('#additionalFields').toggle();
            });

            $('#toggleDivButton1').click(function() {
                // Toggle the visibility of the additional fields div
                $('#additionalFields1').toggle();
            });

            $('#trainingForm').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Send AJAX request to process_form.php
                $.ajax({
                    type: 'POST',
                    url: 'get_process.php',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Display the result table
                        $('#resultTableContainer').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error processing the form.');
                        console.error('Status Code: ' + jqXHR.status);
                        console.error('Status Text: ' + jqXHR.statusText);
                        console.error('Response Text: ' + jqXHR.responseText);
                        console.error('Text Status: ' + textStatus);
                        console.error('Error Thrown: ' + errorThrown);
                    }
                });
            });

            $('#trainingForm1').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Send AJAX request to process_form.php
                $.ajax({
                    type: 'POST',
                    url: 'get_budget.php',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Display the result table
                        $('#resultTableContainer1').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error processing the form.');
                        console.error('Status Code: ' + jqXHR.status);
                        console.error('Status Text: ' + jqXHR.statusText);
                        console.error('Response Text: ' + jqXHR.responseText);
                        console.error('Text Status: ' + textStatus);
                        console.error('Error Thrown: ' + errorThrown);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Attach change event to the branch dropdown
            $("#branch").change(function() {
                var branch = $(this).val();
                console.log(branch)
                // Send AJAX request to fetch members based on the selected branch
                $.ajax({
                    type: "POST",
                    url: "get_members.php", // Update with the actual PHP script to fetch members
                    data: {
                        branch: branch
                    },
                    success: function(response) {
                        console.log(response)
                        // Update the member dropdown with fetched options
                        $("#member").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }

                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Attach change event to the branch dropdown
            $("#branch1").change(function() {
                var branch = $(this).val();
                // Send AJAX request to fetch members based on the selected branch
                $.ajax({
                    type: "POST",
                    url: "get_members.php", // Update with the actual PHP script to fetch members
                    data: {
                        branch: branch
                    },
                    success: function(response) {
                        // Update the member dropdown with fetched options
                        $("#member1").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }

                });
            });
        });
    </script>

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
                        data: <?php echo json_encode($butgetsUsed) ?>
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
                series: <?php echo  json_encode($allBudget)  ?>,
                labels: <?php echo json_encode($allYear) ?>,
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
                colors: ["#5D87FF", "#ecf2ff", "#2A3547"],

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
                    name: "Month Used",
                    color: "#49BEFF",
                    data: <?php echo json_encode($monthlyBudgets) ?>,
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

</style>