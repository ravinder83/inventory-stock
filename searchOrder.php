<?php
include 'dbcon.php';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$store_value = $_POST['storeValue'];
$search_date = "SELECT orders.id,orders.customer_name,orders.total_amt,orders.date,orderitems.store from orders JOIN orderitems ON orderitems.order_id = orders.id WHERE orderitems.store LIKE '%$store_value%' AND orders.date BETWEEN '$start_date' AND '$end_date' GROUP BY orders.total_amt ORDER BY orders.date desc";
    $sqlquery2 = mysqli_query($con,$search_date)or die( mysqli_error($con));
    $res2 = [];
    while ($row2 = mysqli_fetch_array($sqlquery2)){
        array_push($res2, $row2);
    }
    // echo "<pre>";
    // print_r($res2);
    // die;
$output = "";

if(!empty($res2))
{
foreach($res2 as $items){
    $output .= '<a style="text-decoration: none; text-transform:capitalize; color:black;" href="orderItemDetail.php?order_id='.$items['id'].'&cust_name='.$items['customer_name'].'"><div class="m-4 bg-light py-3">
    <div class="row">
    <div class="col-5">
        <h6 style="font-size: 13px;">'.$items['date'].'</h6>
        </div>
        <div class="col-4">
        <h6 style="font-size: 13px;">'.$items['customer_name'].'</h6>
        </div>
        <div class="col-3">
        <h6 style="font-size: 13px;" class="float-end">₹'.$items['total_amt'].'</h6>
        </div>
    </div>
    </div></a>';
 }
 echo $output;
}else{
    $output .= '<div class="alert alert-warning" role="alert">
    No Data Found!
  </div>';
  echo $output;
}
            
?>