<?php
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

include "../connect.php";
$user = $_POST["user"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$image_name = $_FILES["myfile"]["name"];
$image_type = $_FILES["myfile"]["type"];
$email = $_POST["email"];
$mob = $_POST["mob"];
$role = $_POST["role"];
$branch = $_POST['branch'];
$pwd = $_POST['password'];
$repwd = $_POST['repassword'];
$defaultRoleId = 3;
$options = [
    'cost' => 10,
];
if ($pwd == $repwd) {
    $hashedPassword = password_hash($pwd, PASSWORD_BCRYPT, $options);

    if ($image_name <> "") {
        $image_data = addslashes(file_get_contents($_FILES["myfile"]["tmp_name"]));
    } else {
        $image_data = "";
    }

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("error" . mysqli_connect_error());
    }
    $checkUsernameQuery = "SELECT username FROM user_auth WHERE username = '$user'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

    if (mysqli_num_rows($checkUsernameResult) > 0) {
        // Username already exists, throw an error or handle it accordingly
        echo '<script>
        setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "มี Username ซ้ำกัน",
                type: "error"
            }, function() {
                window.location = "member_formAdd.php"; //หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
        </script>';
    } else {
        $sql1 = "INSERT INTO user_auth (username, password, email) VALUES ('$user', '$hashedPassword', '$email')";
        $result1 = mysqli_query($conn, $sql1);
        $userId = mysqli_insert_id($conn);
        $sql2 = "INSERT INTO members (id, firstname, surname, email, phone, image, image_type, image_data, branch_id)
             VALUES ('$userId', '$fname', '$lname', '$email', '$mob', '$image_name', '$image_type', '$image_data', '$branch')";
        $result2 = mysqli_query($conn, $sql2);

        $role_id = match ($role) {
            'admin' => 1,
            'moderator' => 2,
            default => $defaultRoleId,
        };

        $sql3 = "INSERT INTO role_user (user_id, role_id) VALUES ('$userId', '$role_id')";
        $result3 = mysqli_query($conn, $sql3);

        mysqli_autocommit($conn, false);

        if ($result1 && $result2 && $result3) {
            mysqli_commit($conn);
            echo '<script>
             setTimeout(function() {
                 swal({
                     title: "เพิ่มสำเร็จ",
                     text: "Insert successful",
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
    }
} else {
    echo '<script>
             setTimeout(function() {
                 swal({
                     title: "Error",
                     text: "รหัสผ่านไม่ตรงกัน",
                     type: "danger",
                 }, function() {
                     window.location = "member_form.php?page=1"; //หน้าที่ต้องการให้กระโดดไป
                 });
             }, 1000);
             </script>';
}




mysqli_free_result($checkUsernameResult);
mysqli_close($conn);
