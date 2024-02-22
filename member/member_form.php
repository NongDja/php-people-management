<!DOCTYPE html>
<?php session_start(); 
include "../auth/checklogin.php";
if (isset($_GET["search"]))
    $search = $_GET["search"];
else
    $search = "";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/a.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Member</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    
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
     
        <div class="row">
            <div class="col-md-12"> <br>
                <div class="row">
                    <div class="col-6">
                
                        <h3>รายการสมาชิก <?php if ($_SESSION['role'] != 3) { ?> <a style="font-size: 14px;" href="member_formAdd.php" class="btn btn-info">+เพิ่มข้อมูล</a> <?php } ?> </h3>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <form action="member_form.php" method="get" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" value="<?php echo $search; ?>">
                                <button class="btn btn-sidebar" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <?php
                include '../connect.php';
                $con = mysqli_connect($servername, $username, $password, $dbname);
                $perpage = 5;
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                $start = ($page - 1) * $perpage;
                $sql = "SELECT * FROM members WHERE members.firstname LIKE '%$search%'
                OR members.id LIKE '%$search%' limit {$start} , {$perpage}";
                $stmt = mysqli_prepare($con, $sql);
                $stmt->execute();
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                foreach ($result as $k) {
                ?>
                    <div class="border rounded container-xl mx-auto shadow-sm p-4 my-4">
                        <div class="row p-1">
                            <div class="col-2">
                                <img src="data:image/jpeg;base64,<?= base64_encode($k["image_data"]) ?>" style=" overflow: hidden; max-width: 80px; height: 70px; border:1px solid #000000!important">
                            </div>
                            <div class="col-4 d-flex align-items-center text-capitalize " style="font-weight: bold;"><?= $k['firstname'] . ' ' . $k['surname']; ?></div>
                            <div class="col-3 d-flex align-items-center">Faculty</div>
                            <div class="col-3 d-flex align-items-center gap-3 <?php  echo ($_SESSION['role'] == 3) ? 'justify-content-center' : ''; ?>">
                                <a href="member_detail.php?page=<?php echo $k['id']; ?>" type="button" class="btn btn-info"><i class="fa fa-info-circle me-1"></i>Detail</a>
                                <?php if ($_SESSION['role'] != 3) { ?> <a href="member_formEdit.php?page=<?php echo $k['id']; ?>" type="button" class="btn btn-warning"><i class="fa fa-edit me-1"></i> Edit</a>  <?php } ?> 
                                <?php if ($_SESSION['role'] != 3) { ?> <a href="#" class="btn btn-danger" onclick="confirmDelete(<?php echo $k['id']; ?>)">
                                    <i class="fa fa-trash me-1"></i>Delete
                                </a> <?php } ?> 
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
        <?php
        $sql2 = "select * from members ";
        $query2 = mysqli_query($con, $sql2);
        $total_record = mysqli_num_rows($query2);
        $total_page = ceil($total_record / $perpage);
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end py-4">
                <li class="page-item  <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
                    <a href="member_form.php?page=1" aria-label="Previous" class="page-link">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="member_form.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item  <?php echo ($current_page == $total_page) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="member_form.php?page=<?php echo $total_page; ?>" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        

    </div>
        </div>
</div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'member_delete.php?id=' + id;
            }
        });
    }
</script>