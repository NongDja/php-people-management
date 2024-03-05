<?php
if(isset($_GET['id'])) {
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    
    include "../connect.php";
    $delete_id = ($_GET['id']);
    $conn = mysqli_connect($servername,$username,
  $password,$dbname);
 if(!$conn)
 { die("error".mysqli_connect_error()); }

 $sql = "DELETE FROM user_auth WHERE userId='$delete_id'";
 if(mysqli_query($conn,$sql)) {
    echo '<script>
    setTimeout(function() {
        swal({
            title: "Success",
            text: "Delete successful",
            type: "success",
        }, function() {
            window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
        });
    }, 1000);
    </script>';
    } else {
        echo '<script>
        setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "ไม่สามารถลบได้",
                type: "warning"
            }, function() {
                window.location = "../page/plan.php"; //หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
        </script>';
    }
    
    // Close the statement and connection
    mysqli_close($conn);
}
?>