<?php
    include 'dbcon.php';
    $itemid =  $_GET['delete'];
    $sql = "Delete from product where id = '$itemid'";
    $sqlquery = mysqli_query($con,$sql);
    header('location:items.php');
    
?>