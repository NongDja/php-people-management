<?php 

include "../session.php"; 
if(!isset($_SESSION['userId']) || $_SESSION['role'] != 1)
{
    echo '<meta http-equiv="refresh" content="0;url=../component/404.php">';
    exit();
  }

?>