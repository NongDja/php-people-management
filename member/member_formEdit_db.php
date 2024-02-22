<?php
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

include "../connect.php";
$userId = $_POST["userId"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$image_name = $_FILES["myfile"]["name"];
$image_type = $_FILES["myfile"]["type"];
$email = $_POST["email"];
$mob = $_POST["mob"];
$role = $_POST["role"];
$job = $_POST["job"];
$defaultRoleId = 3;

if ($image_name <> "") {
    $image_data = addslashes(file_get_contents($_FILES["myfile"]["tmp_name"]));
} else {
    $image_data = "";
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("error" . mysqli_connect_error());
}


$sql1 = "UPDATE members SET firstname = '$fname', surname = '$lname', email = '$email', phone = '$mob', image_data = '$image_data' WHERE id = $userId";
$result1 = mysqli_query($conn, $sql1);

$role_id = match ($role) {
    'admin' => 1,
    'moderator' => 2,
    default => $defaultRoleId,
};

$sql2 = "UPDATE role_user SET role_id = $role_id WHERE user_id = $userId";
$result2 = mysqli_query($conn, $sql2);

mysqli_autocommit($conn, false);

if ($result1 && $result2) {
    mysqli_commit($conn);
    echo '<script>
         setTimeout(function() {
             swal({
                 title: "อัพเดตข้อมูลสำเร็จ",
                 text: "Update successful",
                 type: "success",
             }, function() {
                 window.location = "member_form.php?page=1"; //หน้าที่ต้องการให้กระโดดไป
             });
         }, 1000);
         </script>';
} else {
    mysqli_rollback($conn);
    echo "Transaction failed: " . mysqli_error($conn);
}
mysqli_autocommit($conn, true);



mysqli_close($conn);
?>
