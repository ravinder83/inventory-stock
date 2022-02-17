<?php
include 'dbcon.php';
// print_r($_POST)
$item_id = $_POST['ItemId'];
$prev_qty = $_POST['qty'];
$current_qty = $_POST['current_qty'];

$updated_qty = $prev_qty + $current_qty;
//echo $updated_qty;

$sql = "Update product Set qty = '$updated_qty' Where id='$item_id'";
mysqli_query($con,$sql);
echo "true";


?>