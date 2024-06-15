<?php
 session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
   
    include "../connect.php";

    $user = $_POST['username']; 
    $enteredPassword = $_POST['password'];
    
    $con = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_errno()) {
        echo "Fail to connect to MySQL"; 
        exit();
    }
    
    $sql = "SELECT user_auth.*, members.image_data, role_user.role_id 
            FROM user_auth 
            JOIN members ON user_auth.userId = members.id
            LEFT JOIN role_user ON user_auth.userId = role_user.user_id
            WHERE user_auth.username = ? OR user_auth.email = ?";
    
    $stmt = mysqli_prepare($con, $sql);
    
    mysqli_stmt_bind_param($stmt, "ss", $user, $user);
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount == 1) {
        $row = mysqli_fetch_array($result);
        $hashedPassword = $row['password'];
        $verifyPassword = password_verify($enteredPassword, $hashedPassword);
        if ($verifyPassword) {
            $_SESSION["username"] = $row['username'];
            $_SESSION["userId"] = $row["userId"];
            $_SESSION["role"] = $row['role_id'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["image_data"] = $row['image_data'];
            
            echo '<script>
            setTimeout(function() {
                swal({
                    title: "Login",
                    text: "เข้าสู่ระบบสำเร็จ",
                    type: "success",
                }, function() {
                    window.location = "../page/home.php"; 
                });
            }, 500);
            </script>';
        } 
        else {
            session_destroy();
            echo '<script>
            setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                    type: "warning"
                }, function() {
                    window.location = "login.php"; 
                });
            }, 500);
            </script>';
        }
    }
     else {
        session_destroy();
        echo '<script>
        setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                type: "warning"
            }, function() {
                window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
            });
        }, 500);
        </script>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
