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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <!------ Include the above in your HEAD tag ---------->
    <style>
        body {
            background: #fafafa;
        }

        .card {
            padding: 30px 40px;
            margin-top: 30px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.1)
        }

        .profile-img {
            text-align: center;
        }

        .profile-img img {
            width: 270px;
            height: 270px;
        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #0062cc;
        }

        .profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .proile-rating {
            font-size: 12px;
            color: #818182;
            margin-top: 5%;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .profile-work {
            padding: 14%;
            margin-top: -15%;

        }

        .profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-work a {
            text-decoration: none;

            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work .link-container {
            max-height: 100px;
            /* Set the maximum height based on your needs */
            overflow-y: auto;
        }

        .profile-work .link-container a {
            text-decoration: none;

            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work ul {
            list-style: none;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #0062cc;
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
            <div class="container-fluid ">
                <div class="row d-flex justify-content-center">
                    <div class="card">
                        <a class="back" href="member_form.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </a>
                        <form class="form-card">
                            <?php
                            include '../connect.php';
                            $con = mysqli_connect($servername, $username, $password, $dbname);
                            if (isset($_GET['page'])) {
                                $id = mysqli_real_escape_string($con, $_GET['page']);
                                $sql = "SELECT * FROM members WHERE id = '$id'";
                                $result = mysqli_query($con, $sql);
                                if ($result) {

                                    $row = mysqli_fetch_assoc($result);
                                } else {
                                    echo "Error: " . mysqli_error($con);
                                }
                                mysqli_close($con);
                            } else {
                                echo "No 'id' parameter provided.";
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img">
                                        <img style="max-width: 350px; max-height:350px; object-fit:cover;" src="data:image/jpeg;base64,<?= base64_encode($row["image_data"]) ?>" alt="" />


                                        <!-- <div class="file btn btn-lg btn-primary">
                                    Change Photo
                                    <input type="file" name="file" />
                                </div> -->
                                    </div>
                                    <div class="profile-work">
                                        <?php
                                        $con = mysqli_connect($servername, $username, $password, $dbname);
                                        if (isset($_GET['page'])) {
                                            $id = mysqli_real_escape_string($con, $_GET['page']);
                                            $sql1 = "SELECT project_user.*, project.*
                                            FROM members
                                            LEFT JOIN project_user ON members.id = project_user.user_id
                                            LEFT JOIN project ON project_user.project_id = project.project_id
                                            WHERE id = '$id'";
                                            $result1 = mysqli_query($con, $sql1);
                                            if ($result1) {
                                                $rowBranch = mysqli_fetch_assoc($result1);
                                            } else {
                                                echo "Error: " . mysqli_error($con);
                                            }
                                            mysqli_close($con);
                                        } else {
                                            echo "No 'id' parameter provided.";
                                        }
                                        ?>
                                        <p>PLAN LINK</p>
                                        <div class="link-container">
                                            <a href="">Website Link</a><br />
                                            <a href="">Bootsnipp Profile</a><br />
                                            <a href="">Bootply Profile</a>
                                            <a href="">Bootply Profile</a>
                                            <a href="">Bootply Profile</a>
                                            <a href="">Bootply Profile</a>
                                            <a href="">Bootply Profile</a>

                                        </div>
                                        <p>SKILLS</p>
                                        <a href="">Web Designer</a><br />
                                        <a href="">Web Developer</a><br />
                                        <a href="">Vue3</a><br />
                                        <a href="">Angular</a><br />
                                        <a href="">PHP, NodeJS</a><br />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-head">
                                        <h5 class="text-capitalize ">
                                            <?= $row['firstname'] . ' ' . $row['surname']; ?>
                                        </h5>
                                        <h6>
                                            สาขา <!--    Full Stack Web Developer -->
                                        </h6>
                                        <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>User Id</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>No. <?php echo $id ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Fullname</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-capitalize"> <?= $row['firstname'] . ' ' . $row['surname']; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><?= $row['email'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Phone</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                    $phone = $row['phone'];
                                                    $formattedPhone = substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6);
                                                    ?>
                                                    <p><?= $formattedPhone ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Profession</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p> Full Stack Web Developer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Experience</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Expert</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Hourly Rate</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>10$/hr</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Total Projects</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>230</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>English Level</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Expert</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Availability</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>6 months</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Your Bio</label><br />
                                                    <p>Your detail description</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2" style="  position: absolute; top:20px; right:20px">
                                    <a href="../member/member_formEdit.php?page=<?= $_GET['page'] ?>" type="submit" class="profile-edit-btn btn btn-light" style="border-radius: 50px; font-size: 14px; color: gray; font-weight: 500;">Edit Profile</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">

                                </div>
                            </div>
                        </form>
                    </div>
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