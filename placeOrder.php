<?php
include 'dbcon.php';
$customer_id = $_POST['customer_id'];
$customer_name = $_POST['customer_name'];
$mobile = $_POST['mobile'];
$grand_total = $_POST['grand_total'];
$paid_amt = $_POST['paid_amt'];
$pending_amt = $_POST['pending_amt'];
$payment_mode = $_POST['payment_mode'];

date_default_timezone_set("Asia/Kolkata");
$dateHalf = date('Y-m-d');
$dateFull = date('Y-m-d H:i:s');

// 1. insert order placed info in order table
$placeOrder = "Insert Into orders (customer_id,customer_name,mobile_no,payment_mode,paid_amt,pending_amt,total_amt,date)
                Values('$customer_id','$customer_name','$mobile','$payment_mode','$paid_amt','$pending_amt','$grand_total','$dateHalf')";
$exec_placeOrder = mysqli_query($con,$placeOrder);

$getOrderId = "Select id from orders Order By id desc;";
$runQuery = mysqli_query($con,$getOrderId);
$rowId = mysqli_fetch_array($runQuery);
$order_id = $rowId['id'];

// 2. insert no.of order item that have been placed in order_detail table
$cart = "select temp_cart.*,product.id,product.name,product.selling_price From temp_cart LEFT JOIN product ON temp_cart.p_id = product.id Where temp_cart.c_id = '$customer_id'";
$exec_cart = mysqli_query($con,$cart);
$cart_data = [];
while($row = mysqli_fetch_array($exec_cart)){
    array_push($cart_data,$row);
}

foreach($cart_data as $item){
    $product_name = $item['product_name'];
    $price = $item['selling_price'];
    $qty = $item['qty'];
    $c_id = $item['c_id'];
    $store = $item['store'];
    $sql = "insert into orderitems(c_id, order_id, product_name,price,qty,store,date) values('$c_id', '$order_id', '$product_name','$price','$qty','$store','$dateFull')";
    $exec_sql = mysqli_query($con,$sql);
}
// 3. empty user cart
$empty_cart = "Delete from temp_cart where c_id = '$customer_id'";
$exec_empty_cart = mysqli_query($con,$empty_cart);
echo "Order Placed Successfully";
?>