<?php
    include 'dbcon.php';
    $cartid =  $_GET['id'];
    $customer_id = $_GET['customer_id'];
    $sql = "Delete from temp_cart where id = '$cartid'";
    $sqlquery = mysqli_query($con,$sql);
    header('location:cart.php?customerId='.$customer_id.'');    
?>