<?php
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

include "../connect.php";
$userId = $_POST["userId"];
$fname = isset($_POST["fname"]) ? $_POST["fname"] : null;
$lname = isset($_POST["lname"]) ? $_POST["lname"] : null;
$image_name = isset($_FILES["myfile"]["name"]) ? $_FILES["myfile"]["name"] : null;
$image_type = isset($_FILES["myfile"]["type"]) ? $_FILES["myfile"]["type"] : null;
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$mob = isset($_POST["mob"]) ? $_POST["mob"] : null;
$role = isset($_POST["role"]) ? $_POST["role"] : null;
$pwd = isset($_POST["password"]) ? $_POST["password"] : null;
$repwd = isset($_POST["repassword"]) ? $_POST["repassword"] : null;
$branch = isset($_POST["branch"]) ? $_POST["branch"] : null;
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

$email = mysqli_real_escape_string($conn, $email); 

$sql_check_email = "SELECT COUNT(*) AS email_count FROM user_auth WHERE email = '$email' AND userId != $userId";
$result_check_email = mysqli_query($conn, $sql_check_email);
$row = mysqli_fetch_assoc($result_check_email);
$email_count = $row['email_count'];

if ($email_count > 0) {
    echo '<script>
    setTimeout(function() {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: "มี Email ซ้ำกัน",
            type: "error"
        }, function() {
            window.location = "member_form.php"; //หน้าที่ต้องการให้กระโดดไป
        });
    }, 1000);
    </script>';
    return;
}


if ($pwd != null && $repwd != null && $pwd === $repwd) {
    echo 'test';
    $options = [
        'cost' => 10,
    ];
    $hashedPassword = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    // Update password in user_auth table
    $sql3 = "UPDATE user_auth SET password = ? WHERE userId = ?";
    $stmt3 = mysqli_prepare($conn, $sql3);
    if ($stmt3) {
        mysqli_stmt_bind_param($stmt3, "si", $hashedPassword, $userId);
        $result3 = mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);
    }
}
if ($image_name <> "") {
    $sql_update_email = "UPDATE user_auth SET email = '$email' WHERE userId = $userId";
    $result_update_email = mysqli_query($conn, $sql_update_email);

    $sql_update_members = "UPDATE members SET firstname = '$fname', surname = '$lname', phone = '$mob', image_data = '$image_data', branch_id = $branch WHERE id = $userId";
    $result_update_members = mysqli_query($conn, $sql_update_members);
} else {
    $sql_update_email = "UPDATE user_auth SET email = '$email' WHERE userId = $userId";
    $result_update_email = mysqli_query($conn, $sql_update_email);

    $sql_update_members = "UPDATE members SET firstname = '$fname', surname = '$lname', phone = '$mob', branch_id = $branch WHERE id = $userId";
    $result_update_members = mysqli_query($conn, $sql_update_members);
}
$role_id = match ($role) {
    'Admin' => 1,
    'moderator' => 2,
    default => $defaultRoleId,
};

$sql2 = "UPDATE role_user SET role_id = $role_id WHERE user_id = $userId";
$result2 = mysqli_query($conn, $sql2);

mysqli_autocommit($conn, false);

if ($result_update_members && $result2) {
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
