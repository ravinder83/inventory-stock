<?php

include 'dbcon.php';
$cust_id = $_GET['cust_id'];

// $sql = "Select orders.id,orders.paid_amt,orders.pending_amt,orders.total_amt,orderitems.product_name,orderitems.price,orderitems.qty,DATE_FORMAT(orderitems.date, '%e/%c/%Y') as 'date' from orders INNER JOIN orderitems ON orders.id = orderitems.order_id where orders.pending_amt != 0 AND orders.customer_id = '$cust_id' ORDER BY date";
// $result = mysqli_query($con,$sql);
// $list = [];
// while($output = $result->fetch_object()){

//     $list[$output->id][] =  $output;
// }
$sql = "Select * from orders where pending_amt != 0 AND customer_id = '$cust_id'";
$result = mysqli_query($con,$sql);
$list = [];
while($output = $result->fetch_object()){
    $list[$output->id][] =  $output;
}
// echo "<pre>";
// print_r($list);
foreach($list as $sublist)
{
    $sql2 = "select * from orderitems where c_id = '$sublist->customer_id'";
    $result2 = mysqli_query($con,$sql2);
    $list2 = [];
    while($row = $result2->fetch_object()){
        $list2[] = $output;
    } 
}

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

    <!-- <div>
       
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
                                $childHtml .= "<div class='child'><hr>";
                                foreach ($innerorder as $key=> $order) {
                                    $tot_amt = $order->total_amt;
                                    $pend_amt = $order->pending_amt;
                                    $paid_amt = $order->paid_amt;
                                    $date = $order->date;
                                    $childHtml .= "<div class='date'>
                                    <div class='order_date'>
                                        <label class=''>Date</label>
                                        <span class=''>$date</span>
                                    </div>
                                </div>";
                                    foreach($order as $keyp => $value){
                                       if(in_array($keyp,$filterKey))
                                       {
                                        $childHtml .= "
                                        <div class='items'>
                                            <label>".$keyp."</label>
                                            <span>".$value."</span>
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
    </div> -->
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>