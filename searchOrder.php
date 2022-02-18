<?php
include 'dbcon.php';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$search_date = "SELECT * from orders Where date BETWEEN '$start_date' AND '$end_date' ORDER BY date desc";
    $sqlquery2 = mysqli_query($con,$search_date);
    $res2 = [];
    while ($row2 = mysqli_fetch_array($sqlquery2)){
        array_push($res2, $row2);
    }
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