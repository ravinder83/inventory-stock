<?php

include 'dbcon.php';
$cust_id = $_GET['cust_id'];



// fetchimg customer pending orders id.
$sql2 = "SELECT DISTINCT orderitems.order_id from orderitems INNER JOIN orders ON orderitems.order_id = orders.id where orders.pending_amt != 0 AND orders.customer_id = '$cust_id'";
$sqlquery2 = mysqli_query($con,$sql2);
$res2 = [];
while ($row2 = mysqli_fetch_array($sqlquery2)){
    array_push($res2, $row2);
}

$idd = [];
foreach($res2 as $arr)
{
  array_push($idd,$arr['order_id']);
}
$encoded_data = json_encode($idd);
// echo $encoded_data;


// $jsonData = $_GET['order_id'];
// json_decode($jsonData);
$string =  str_replace('"','',$encoded_data);
$newString =  str_replace('[','',$string);
$finalString =  str_replace(']','',$newString);
// echo $finalString;

// $order_id = $_GET['order_id'];
// $customer_name = $_GET['cust_name'];
// $sql = "Select orders.id,orders.paid_amt,orders.pending_amt,orders.total_amt,orderitems.product_name,orderitems.price,orderitems.qty,DATE_FORMAT(orderitems.date, '%e/%c/%Y') as 'date' from orders INNER JOIN orderitems ON orders.id = orderitems.order_id where orders.pending_amt != 0 AND orders.id IN ($finalString) ORDER BY date";

$sql = "Select orders.id,orders.paid_amt,orders.pending_amt,orders.total_amt,orderitems.product_name,orderitems.price,orderitems.qty,DATE_FORMAT(orderitems.date, '%e/%c/%Y') as 'date' from orders INNER JOIN orderitems ON orders.id = orderitems.order_id where orders.pending_amt != 0 AND orders.customer_id = '$cust_id' ORDER BY date";
$result = mysqli_query($con,$sql);
$list = [];
while($output = $result->fetch_object()){

    $list[$output->id][] =  $output;
}

    echo "<pre>";
print_r( $list );
echo "</pre>";


// $totalprice = 0;
// $paid_pending = "Select sum(paid_Amt) as 'paid_amt',sum(pending_amt) as 'pending_amt' from orders where pending_amt != 0 AND id IN ($finalString)";
// $exec = mysqli_query($con,$paid_pending);
// $total_paid_pending = mysqli_fetch_array($exec);

// print_r($total_paid_pending);
// die;

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>Outstanding Customer Detail</title>
  <style>  
    body {  
        font-size:14px;
        line-height:16px;
    }  
</style>   
</head>

<body style="background-color: #f0f2f7;">
    <?php // include 'header.php'; ?>
    <h3 class="text-primary m-2"><a href="outstanding2.php"><i class="fas fa-backward"></i></a></h3>
    <h5 class="container m-4">Pending Customer Orders</h5>
    <p class="text-danger" style="text-transform: capitalize;margin-left:5%;"><b><?php echo $cust_id; ?></b></p>

    <div>
       
                <?php
                $count = count($list);
                $html = "";
                $parent = "";
                $childHtml = "";
                $filterKey = ['product_name','price','qty'];
                $tot_amt = 0;
                $pend_amt =  0;
                $paid_amt = 0;
                $date = "";
                
                        foreach ($list as $orderKey => $innerorder) {
                                $parent .= "<div class='parent'>";
                                $date = $innerorder[0]->date;
                                $childHtml .= "<div class='date'>
                                <div class='order_date'>
                                    <label class=''>Date</label>
                                    <span class=''>$date</span>
                                </div>
                            </div>";
                                foreach ($innerorder as $key=> $order) {
                                    $tot_amt = $order->total_amt;
                                    $pend_amt = $order->pending_amt;
                                    $paid_amt = $order->paid_amt;
                                   
                                    foreach($order as $keyp => $value){
                                       if(in_array($keyp,$filterKey))
                                       {
                                        $childHtml .= "
                                        <div class='row'>
                                        <div class='col-4 text-danger d-flex'>
                                            <span>".$value."</span>
                                        </div>
                                        </div>
                                    ";
                                       }
                                        
                                    }
                                    
                                    
                                }
                                $childHtml .= "<hr></div>";
                                $childHtml .= "<div class='amoumt'>
                                    <div class='tot_amt'>
                                        <label>Total Amount</label>
                                        <span>$tot_amt</span>
                                        <label>Paid Amount</label>
                                        <span>$paid_amt</span>
                                        <label>Pending Amount</label>
                                        <span>$pend_amt</span>
                                    </div>
                                </div>";
                            
        
                            // $childHtml .= "</div>";
                        }
                        $parent .=  $childHtml;
                        $parent .= "</div>";
                        $html = $parent;
                        echo ( $html );
                        
                  ?>
                    


                  
            <!-- <div class="container mt-2">
                <div class="row">
                <div class="col-4">
                        <h6>Total</h6>
                        <input class="w-50" type="number" style="border: none; text-align:center;font-weight:bold;" value="<?php echo $totalprice ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Paid</h6>
                        <input class="w-50 text-success" type="number" style="border: none; text-align:center;font-weight:bold;"  value="<?php echo $total_paid_pending['paid_amt'] ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Pending</h6>
                        <input class="w-50 text-danger" type="number" style="border: none; text-align:center; font-weight:bold;"  value="<?php echo $total_paid_pending['pending_amt'] ?>" readonly>
                    </div>
                </div>
            </div> -->
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>