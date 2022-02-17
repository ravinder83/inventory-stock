<?php
$con =new mysqli("localhost","root","","inventory");

if($con->connect_error){
    echo "Failed to connect: ".$con->connect_error;
    die();
}else{
    //echo "Success to connect: ";
}
?>