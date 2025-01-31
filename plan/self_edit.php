<!DOCTYPE html>
<?php
include "../auth/checkuser.php";
$userId = $_SESSION['userId']
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

        if (isset($_POST['plan']) && isset($_POST['level']) && isset($_POST['date'])) {
            echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

            include "../connect.php";
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("error" . mysqli_connect_error());
            }
            $id = mysqli_real_escape_string($conn, $_GET['page']);
            $plan = $_POST['plan'];
            $level = $_POST['level'];
            $date = $_POST['date'];
            $description = $_POST['description'];

            $train = $_POST['train'];
            $dateToGo = $_POST['dateToGo'];

            $budgetUserUsed = $_POST['budgetUsed'];

            if (isset($_FILES["newPdfFile"])) {
                $newPdfFile = $_FILES["newPdfFile"]["tmp_name"]; 
            }

            mysqli_begin_transaction($conn);

            try {
                // Update project table
                if (isset($newPdfFile) && $_FILES["newPdfFile"]["error"] == UPLOAD_ERR_OK) {

                    $pdfContent = file_get_contents($newPdfFile);
                    $pdfContent = mysqli_real_escape_string($conn, $pdfContent);
                    $sqlUpdateProject = "UPDATE project SET project_name = '$plan', level = '$level', deadline = '$date', description = '$description', pdf_data = '$pdfContent' WHERE project_id = '$id'";
                    $resultUpdateProject = mysqli_query($conn, $sqlUpdateProject);
                } else {
                    $sqlUpdateProject = "UPDATE project SET project_name = '$plan', level = '$level', deadline = '$date', description = '$description'  WHERE project_id = '$id'";
                    $resultUpdateProject = mysqli_query($conn, $sqlUpdateProject);
                }

                if (!$resultUpdateProject) {
                    mysqli_rollback($conn);
                    die('Error updating project: ' . mysqli_error($conn));
                }
                if(isset($_FILES['userFile']) && $_FILES['userFile']['error'] == UPLOAD_ERR_OK) {
                    $file_name = $_FILES["userFile"]["name"];
                    $file_tmp = $_FILES["userFile"]["tmp_name"];
                    $file_content = file_get_contents($file_tmp);
                    $file_content = mysqli_real_escape_string($conn, $file_content);
                    $file_name = mysqli_real_escape_string($conn, $file_name);
                    $sqlProjectUser = "UPDATE project_user SET train = $train, date_to_go = '$dateToGo', budget_user_used = $budgetUserUsed, file_name =  '$file_name' , file_content = '$file_content' WHERE project_id = '$id' AND user_id = $userId";
                    $resultProjectUser = mysqli_query($conn, $sqlProjectUser);
                }
                else {
                    $sqlProjectUser = "UPDATE project_user SET train = $train, date_to_go = '$dateToGo', budget_user_used = $budgetUserUsed WHERE project_id = '$id' AND user_id = $userId";
                    $resultProjectUser = mysqli_query($conn, $sqlProjectUser);
                }
               

                if (!$resultProjectUser) {
                    mysqli_rollback($conn);
                    die('Error inserting project_user record: ' . mysqli_error($conn));
                }

                mysqli_commit($conn);

                echo '<script>
                setTimeout(function() {
                    swal({
                        title: "สำเร็จ",
                        text: "อัพเดตข้อมูลสำเร็จ",
                        type: "success"
                    }, function() {
                        window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
                    });
                }, 1000);
                </script>';
                exit(); 
            } catch (Exception $e) {
                mysqli_rollback($conn);
                die('Transaction failed: ' . $e->getMessage());
            }
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
                if (isset($_GET['page'])) {
                    $id = mysqli_real_escape_string($con, $_GET['page']);
                    $sql = "SELECT project.*, project_user.*
                    FROM project
                    JOIN project_user ON project.project_id = project_user.project_id
                    WHERE project.project_id = $id AND project_user.user_id = $userId;";
                    $stmt = mysqli_prepare($con, $sql);
                    $stmt->execute();
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($result) {
                        while ($project = mysqli_fetch_array($result)) {
                            $projectName = $project['project_name'];
                            $projectLevel = $project['level'];
                            $projectStatus = $project['status'];
                            $projectDeadline = $project['deadline'];
                            $projectDescription = $project['description'];
                            $projectTrain = $project['train'];
                            $projectTogo = $project['date_to_go'];
                            $projectBudget = $project['budget'];
                            $projectAdminCreate = $project['admin_create'];
                            $projectBudgetUserUsed = $project['budget_user_used'];
                            $projectPdf = $project['pdf_data'];
                            if ($projectPdf !== null) {
                                $pdfBase64 = base64_encode($projectPdf);
                            }
                        }
                    }
                }
                ?>

                <div class="row d-flex justify-content-center">
                    <div class="card">
                        <a class="back" href="../page/plan.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </a>
                        <h5 class="text-center mb-4">Edit Plan</h5>
                        <form class="form-card" action="" method="post" enctype="multipart/form-data">

                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> 
                                    <label class="form-control-label px-3 pb-1">ชื่อการอบรม<span class="text-danger"> *</span></label> 
                                    <input value="<?php echo $projectName; ?>" <?php echo ($projectAdminCreate == 1 ? 'readonly' : ''); ?>  type="text" maxlength="50" required id="plan" name="plan" placeholder="ระบุชื่อการอบรม"> </div>
                                <div class="col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3 pb-1">เลือกหน่วยงาน<span class="text-danger"> *</span></label>
                                    <?php if ($projectAdminCreate == 1) { ?>
                                    <input type="hidden" name="level" value="<?php echo $projectLevel; ?>" />
                                   <?php } ?>
                                    <select required name="level"  <?php echo ($projectAdminCreate == 1 ? 'disabled' : ''); ?>  class="form-control select2" style="width: 100%; padding: 8px 15px; font-size: 18px; margin-top: 5px; height: 50px;">
                                        <option value="" disabled selected>เลือกหน่วยงาน</option>
                                        <?php
                                        $sql = "SELECT or_id, or_name FROM organization";
                                        $levelResult = mysqli_query($con, $sql);

                                        while ($row = mysqli_fetch_assoc($levelResult)) {
                                            $levelId = $row['or_id'];
                                            $levelName = $row['or_name'];
                                            $selected = ($projectLevel == $levelId) ? 'selected' : '';
                                        ?>
                                            <option class="dropdown-item text-capitalize" value="<?php echo $levelId; ?>" <?php echo $selected; ?> > 
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
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">วันที่จัดอบรม<span class="text-danger"> *</span></label>
                                    <input  <?php echo ($projectAdminCreate == 1 ? 'disabled' : ''); ?>  type="datetime-local" name="date" placeholder="เลือกวันที่">
                                    <?php if ($projectAdminCreate == 1) {
                                        echo '<input type="hidden" name="date" value="' . $projectDeadline . '" />';
                                     } ?>
                                </div>

                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">รายละเอียดการอบรม<span class="text-danger"> *</span></label>
                                    <input <?php echo ($projectAdminCreate == 1 ? 'disabled' : ''); ?> type="file" name="newPdfFile" accept=".pdf" />
                                </div>
                            </div>

                            <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">งบประมาณการอบรม<span class="text-danger"> *</span></label>
                                    <input value="<?php echo number_format($projectBudget); ?> " disabled type="text">
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">งบประมาณที่ใช้ไป <span class="text-danger">*</span></label>
                                    <input value="<?php echo $projectBudgetUserUsed; ?>" name="budgetUsed" type="number">
                                </div>
                            </div>



                            <div class="row justify-content-between text-left p-4">
                                
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">การไปอบรม<span class="text-danger"> *</span></label>
                                    <select required name="train" class="form-control select2" style="width: 100%; padding: 8px 15px; font-size: 18px;  margin-top: 5px; height: 50px;">
                                        <option value="" disabled selected>การไปอบรม</option>
                                        <?php
                                        $trainMapping = ['ไม่ไป' => 0, 'ไป' => 1];
                                        foreach ($trainMapping as $trainName => $numericValue) {
                                            $selected = ($numericValue == $projectTrain) ? 'selected' : '';
                                        ?>
                                            <option class="dropdown-item text-capitalize" value="<?php echo $numericValue; ?>" <?php echo $selected; ?>> <?php echo $trainName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                        
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">วันที่ไป<span class="text-danger"> *</span></label>
                                    <input type="datetime-local-togo" name="dateToGo" placeholder="เลือกวันที่">
                                </div>

                                
                            </div>

                            <div class="row justify-content-between text-left p-4">
                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">ใบรับรองการอบรม<span class="text-danger"> *</span></label>
                                    <input type="file" name="userFile" accept=".pdf, .rar, .zip" />
                                </div>
                               
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">ข้อมูลเพิ่มเติม<span class="text-danger"> *</span></label>
                                    <textarea  <?php echo ($projectAdminCreate == 1 ? 'readonly' : ''); ?>  name="description" id="" cols="30" rows="4"><?php echo  $projectDescription ?> </textarea>
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
            defaultDate: '<?php echo $projectDeadline; ?>',
        })
    </script>

<script>
    flatpickr("input[type=datetime-local-togo]", {
        minDate: "today",
        defaultDate: <?php
       
            echo "'" . $projectTogo . "',";
        ?>
    });
</script>
</body>

</html>