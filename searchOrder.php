<?php
include 'dbcon.php';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$search_date = "SELECT * from orders Where date BETWEEN '$start_date' AND '$end_date' ORDER BY date";
    $sqlquery2 = mysqli_query($con,$search_date);
    $res2 = [];
    while ($row2 = mysqli_fetch_array($sqlquery2)){
        array_push($res2, $row2);
    }
$output = "";

if(!empty($res2))
{
foreach($res2 as $items){
    $output .= '<a style="text-decoration: none; text-transform:capitalize; color:black;" href="orderItemDetail.php?order_id='.$items['id'].'&cust_name='.$items['customer_name'].'"><div class="m-4 bg-light p-4">
    <div class="row">
    <div class="col-2">
        <h6>'.$items['id'].'</h6>
        </div>
        <div class="col-4">
        <h6>'.$items['customer_name'].'</h6>
        </div>
        <div class="col-6">
        <h6 class="float-end">₹'.$items['total_amt'].'</h6>
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