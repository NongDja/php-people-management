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
    <title>Member</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background: #fafafa;
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

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        .back:hover svg {
            transform: scale(1.2);
        }

        .back:hover svg path {
            fill: #ff0000;
        }
    </style>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php
         $currentPage = 'member';
        include '../component/aside.php';

        ?>
        <div class="body-wrapper">
            <?php
            include "../component/navbar.php";
            ?>
    <div class="container-fluid">
       
        <div class="row d-flex justify-content-center">
            <div class="card">
                <?php
                include '../connect.php';
                $con = mysqli_connect($servername, $username, $password, $dbname);
                if (isset($_GET['page'])) {
                    $id = mysqli_real_escape_string($con, $_GET['page']);
                    $sql = "SELECT members.*, roles.name, user_auth.username
                        FROM members
                        INNER JOIN user_auth ON members.id = user_auth.userId
                        INNER JOIN role_user ON members.id = role_user.user_id
                        INNER JOIN roles ON role_user.role_id = roles.id
                        WHERE members.id = '$id'";
                    $result = mysqli_query($con, $sql);
                    if ($result) {

                        $membersRow  = mysqli_fetch_assoc($result);
                        $memberBranch = $membersRow['branch_id'];
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    $rolesQuery = "SELECT * FROM roles";
                    $roleResult = mysqli_query($con, $rolesQuery);
                    while ($rolesRow = mysqli_fetch_assoc($roleResult)) {
                        // Access data from the roles table
                        $roleId = $rolesRow['id'];
                        $roleName = $rolesRow['name'];
                    }
                    mysqli_close($con);
                } else {
                    echo "No 'id' parameter provided.";
                }
                ?>
                <a class="back" href="member_form.php?page=1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                        <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </a>
                <h5 class="text-center mb-4">Edit <?php echo $membersRow["username"] ?> </h5>
                <form class="form-card" action="member_formEdit_db.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="userId" value="<?php echo $membersRow['id']; ?>">
                    <div>
                        <label class="d-flex flex-column w-32 h-32 border-4">
                            <div class="d-flex flex-column align-items-center justify-content-center pt-2">
                                <img id="previewImage" src="data:image/jpeg;base64,<?= base64_encode($membersRow["image_data"]) ?>" style="max-width: 300px; max-height: 300px; " />
                                <svg id="uploadIcon" style="height:100px; width: 100px; position: relative;  <?php echo base64_encode($membersRow["image_data"] != '#') ? 'display: none;' : ''; ?>" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                    Select a photo
                                </p>
                            </div>
                            <input class="opacity-0" type="file" id="imageInput" name="myfile">

                        </label>
                    </div>
                    <div class="row justify-content-between text-left p-4">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">Username<span class="text-danger"> *</span></label> <input value="<?php echo $membersRow["username"] ?>" type="text" disabled required id="user" name="user" placeholder="Enter your username"> </div>
                        <div class="col-sm-6 flex-column d-flex">
                            <label class="form-control-label px-3 pb-1">Role<span class="text-danger"> *</span></label>

                            <select required name="role" onchange="showRole(this.value)" class="form-control select2" style="width: 100%; padding: 8px 15px; font-size: 18px; margin-top: 5px; height: 45px;">
                                <?php foreach ($roleResult as $item) { ?>
                                    <option value="<?php echo $item['name']; ?>" <?php echo ($membersRow['name'] == $item['name']) ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-between text-left p-4">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">First name<span class="text-danger"> *</span></label> <input value="<?php echo $membersRow["firstname"] ?>"  type="text" id="fname" name="fname" placeholder="Enter your first name"> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">Last name<span class="text-danger"> *</span></label> <input value="<?php echo $membersRow["surname"] ?>"  type="text" id="lname" name="lname" placeholder="Enter your last name"> </div>
                    </div>
                    <div class="row justify-content-between text-left p-4">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">Email<span class="text-danger"> *</span></label> <input value="<?php echo $membersRow["email"] ?>"  type="text" id="email" name="email" placeholder=""> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">Phone number<span class="text-danger"> *</span></label> <input value="<?php echo $membersRow["phone"] ?>"  type="text" id="mob" name="mob" placeholder=""> </div>
                    </div>
                    <div class="row justify-content-between text-left p-4">
                                <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3 pb-1">เลือกสาขา<span class="text-danger"> *</span></label>
                                    <select required name="branch" class="form-control select2" style="width: 100%; padding: 8px 15px; font-size: 18px; margin-top: 5px; height: 50px;">
                                        <option value="" disabled selected>เลือกสาขา</option>
                                        <?php
                                        include '../connect.php';
                                        $con = mysqli_connect($servername, $username, $password, $dbname);
                                        $sql = "SELECT * FROM branch";
                                        $branchResult = mysqli_query($con, $sql);

                                        while ($row = mysqli_fetch_assoc($branchResult)) {
                                            $branchId = $row['branch_id'];
                                            $branchName = $row['branch_name'];
                                            $selected = ($memberBranch == $branchId) ? 'selected' : '';
                                        ?>
                                            <option class="dropdown-item text-capitalize" value="<?php echo $branchId; ?>" <?php echo $selected; ?>>
                                                <?php echo $branchId . ' - ' . $branchName; ?>
                                            </option>
                                        <?php
                                        }
                                        // Close the result set

                                        ?>
                                    </select>
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



    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var previewImage = document.getElementById('previewImage');
            var uploadIcon = document.getElementById('uploadIcon');

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    uploadIcon.style.display = 'none'; // Hide the SVG
                };
                reader.readAsDataURL(file);
            } else {
                // Reset to default state if no file is selected
                previewImage.src = '#';
                previewImage.style.display = 'none';
                uploadIcon.style.display = 'block'; // Show the SVG
            }
        });
    </script>

    <script>
        function showRole(str) {
            var xhttp;
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };

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

</html>