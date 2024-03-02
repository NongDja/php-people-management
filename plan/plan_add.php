<!DOCTYPE html>
<?php
include "../auth/checklogin.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/a.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Plan</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            ;
            background-repeat: no-repeat;
            background-size: 100% 100%
        }

        .card {
            padding: 30px 40px;
            margin-top: 15px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
        }

        .blue-text {
            color: #00BCD4
        }

        .form-control-label {
            margin-bottom: 0
        }

        input,
        textarea,
        button {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight: 400
        }

        .btn-block {
            text-transform: uppercase;
            font-size: 15px !important;
            font-weight: 400;
            height: 43px;
            cursor: pointer
        }

        .btn-block:hover {
            color: #fff !important
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0
        }



        .back:hover svg {
            transform: scale(1.2);
        }

        .back:hover svg path {
            fill: #ff0000;
        }
    </style>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['plan']) && isset($_POST['level']) && isset($_POST['date']) && isset($_POST['person']) && isset($_POST['budget'])) {
            echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
            if (isset($_FILES["pdfFile"])) {
                // Check if there are no errors during the file upload
                if ($_FILES["pdfFile"]["error"] == UPLOAD_ERR_OK) {
                    $pdfFile = $_FILES["pdfFile"]["tmp_name"];
                    $pdfContent = file_get_contents($pdfFile);

                    // Your other form data
                    $plan = $_POST['plan'];
                    $level = $_POST['level'];
                    $date = $_POST['date'];
                    $description = $_POST['description'];
                    $budget = $_POST['budget'];

                    // Your database connection code
                    include "../connect.php";
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    if (!$conn) {
                        die("error" . mysqli_connect_error());
                    }

                    // Escape variables to prevent SQL injection
                    $plan = mysqli_real_escape_string($conn, $plan);
                    $level = mysqli_real_escape_string($conn, $level);
                    $date = mysqli_real_escape_string($conn, $date);
                    $description = mysqli_real_escape_string($conn, $description);
                    $pdfContent = mysqli_real_escape_string($conn, $pdfContent);
                    $budget = mysqli_real_escape_string($conn, $budget);
                    // Your SQL query
                    $sql = "INSERT INTO project (project_name, level, deadline, description, pdf_data, budget) VALUES ('$plan', '$level', '$date', '$description', '$pdfContent',$budget)";

                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        // Get the last inserted project_id
                        $lastProjectId = mysqli_insert_id($conn);

                        // Insert into project_user table for each selected user
                        foreach ($_POST['person'] as $userId) {
                            $sqlProjectUser = "INSERT INTO project_user (project_id, user_id, train,budget_user_used) VALUES ('$lastProjectId', '$userId', 0,0)";
                            $resultProjectUser = mysqli_query($conn, $sqlProjectUser);

                            if (!$resultProjectUser) {
                                mysqli_rollback($conn);
                                die('Transaction failed: ' . $e->getMessage());
                                echo '<script>
                            setTimeout(function() {
                                swal({
                                    title: "เกิดข้อผิดพลาด",
                                    text: "ไม่สามารถบันทึกข้อมูล user_id=' . $userId . ' ได้",
                                    type: "error"
                                }, function() {
                                    window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                                });
                            }, 1000);
                            </script>';
                                exit(); // Exit the script if any user insertion fails
                            }
                        }

                        echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "บันทึกข้อมูลเรียบร้อย",
                            text: "บันทึกข้อมูลเรียบร้อยแล้ว",
                            type: "success"
                        }, function() {
                            window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                    }, 1000);
                    </script>';
                    } else {
                        mysqli_rollback($conn);
                        die('Transaction failed: ' . $e->getMessage());
                        echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "ไม่สามารถบันทึกข้อมูล project ได้",
                            type: "error"
                        }, function() {
                            window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                    }, 1000);
                    </script>';
                    }
                } else {
                    mysqli_rollback($conn);
                    die('Transaction failed: ' . $e->getMessage());
                    echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "กรุณากรอกข้อมูลให้ครบ",
                            type: "error"
                        }, function() {
                            window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                    }, 1000);
                    </script>';
                }
            }
        } else {
            mysqli_rollback($conn);
            die('Transaction failed: ' . $e->getMessage());
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "กรุณากรอกข้อมูลให้ครบ",
                            type: "error"
                        }, function() {
                            window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                    }, 1000);
                    </script>';
        }
    } ?>
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
            <div class="container-fluid ">
                <?php
                include '../connect.php';
                $con = mysqli_connect($servername, $username, $password, $dbname);
                $sql = "SELECT members.*, role_user.* FROM members LEFT JOIN role_user ON members.id = role_user.user_id WHERE role_user.role_id != 1  ORDER BY branch_id";
                $stmt = mysqli_prepare($con, $sql);
                $stmt->execute();
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                ?>
                <div class="row d-flex justify-content-center">
                    <div class="card">
                        <a class="back" href="../page/plan.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </a>
                        <h5 class="text-center mb-4">Add Plan</h5>
                        <form class="form-card" action="" method="post" enctype="multipart/form-data">

                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">ชื่อการอบรม<span class="text-danger"> *</span></label> <input type="text" required id="plan" name="plan" placeholder="Enter your plan"> </div>
                                <div class="col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3 pb-1">หน่วยงาน<span class="text-danger"> *</span></label>

                                    <select required name="level" class="form-control select2" style="width: 100%; padding: 8px 15px; font-size: 18px; margin-top: 5px; height: 50px;">
                                        <option value="" disabled selected>เลือกหน่วยงาน</option>
                                        <?php
                                        $sql = "SELECT or_id, or_name FROM organization";
                                        $levelResult = mysqli_query($con, $sql);

                                        while ($row = mysqli_fetch_assoc($levelResult)) {
                                            $levelId = $row['or_id'];
                                            $levelName = $row['or_name'];
                                        ?>
                                            <option class="dropdown-item text-capitalize" value="<?php echo $levelId; ?>">
                                            <?php echo $levelId . ' - ' . $levelName; ?>
                                            </option>
                                        <?php
                                        }
                                        // Close the result set
                                        mysqli_free_result($levelResult);
                                        ?>
                                    </select>

                                </div>

                            </div>
                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">วันที่<span class="text-danger"> *</span></label>
                                    <input type="datetime-local" name="date" placeholder="Select Date">
                                </div>

                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">บุคลากร<span class="text-danger"> *</span></label>

                                    <select name="person[]" class="form-control js-select2" multiple="multiple">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $rowId = $row['id'];
                                            $firstname = $row['firstname'];
                                            $surname = $row['surname'];
                                            $branch_id = $row['branch_id'];
                                        ?>
                                            <option data-badge="" value="<?php echo $rowId; ?>"> <?php echo  '000' . $branch_id . ' ' . $firstname . ' ' . $surname; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">งบประมาณ<span class="text-danger"> *</span></label>
                                    <input type="number" required id="budget" name="budget" placeholder="Enter your budget">
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">รายละเอียดการอบรม<span class="text-danger"> *</span></label>
                                    <input type="file" name="pdfFile" accept=".pdf" />
                                </div>
                            </div>
                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">ข้อมูลเพิ่มเติม<span class="text-danger"> *</span></label>
                                    <textarea name="description" id="" cols="30" rows="4"></textarea>
                                </div>
                            </div>


                            <div class="row justify-content-end">
                                <div class="d-grid gap-2" style="padding-left: 80px; padding-right: 80px;"> <button type="submit" class="btn-block btn-primary">Submit</button> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("input[type=datetime-local]", {
            minDate: "today",
        })
    </script>
</body>

</html>