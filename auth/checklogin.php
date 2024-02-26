<?php 
 function checkuser($user_login)
 {
 include "../connect.php"; 
  $con = mysqli_connect($servername,$username,$password,$dbname);
                 if(mysqli_connect_errno()) 
                   { echo "Fail to connect to MySQL"; exit();
                      }
 $sql= "SELECT * FROM user_auth WHERE user_auth.username='$user_login'";
   
 $result = mysqli_query($con,$sql);                     
 $row = mysqli_fetch_array($result);
 $rowcount=mysqli_num_rows($result);
 if($rowcount==0) 
 {
   return "no";
 }
 else
 {
   return "yes";
 }
}


include "../session.php"; 
if(!isset($_SESSION['userId']))
{
    echo '<meta http-equiv="refresh" content="0;url=../component/404.php">';
    exit();
  }

?>