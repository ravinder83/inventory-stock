<?php
    include 'dbcon.php';
    $itemid =  $_GET['delete'];
    $sql = "Delete from customer where id = '$itemid'";
    $sqlquery = mysqli_query($con,$sql);
    header('location:contacts.php');
    
?>