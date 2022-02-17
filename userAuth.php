<?php
// session_start();
if(!isset($_COOKIE['loginid']))  
  {
    header('location:login.php');
  }
?>