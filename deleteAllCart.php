<?php
    include 'dbcon.php';
    $customer_id = $_GET['cust_id'];
    $sql = "Delete from temp_cart where c_id = '$customer_id'";
    $sqlquery = mysqli_query($con,$sql);
    header('location:cart.php?customerId='.$customer_id.'');    
?>