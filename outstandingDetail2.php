<?php

include 'dbcon.php';
$cust_id = $_GET['cust_id'];

$customer = "select * from customer where id = '$cust_id'";
$query = mysqli_query($con,$customer);
$customer_name = mysqli_fetch_assoc($query);

$sql = "Select orders.id,orders.paid_amt,orders.pending_amt,orders.total_amt,orders.payment_mode,orderitems.product_name,orderitems.price,orderitems.qty,DATE_FORMAT(orderitems.date, '%e/%c/%Y') as 'date' from orders INNER JOIN orderitems ON orders.id = orderitems.order_id where orders.pending_amt != 0 AND orders.customer_id = '$cust_id' ORDER BY date desc";
$result = mysqli_query($con,$sql);
$list = [];
while($output = $result->fetch_object()){
    $list[$output->id][] =  $output;
}
// echo "<pre>";
// print_r($list);
// echo "</pre>";
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
    <?php  include 'header.php'; ?>
    <h3 class="text-primary m-2"><a href="outstanding2.php"><i class="fas fa-backward"></i></a></h3>
    <h5 class="container m-4">Pending Customer Orders</h5>
    <p class="text-danger" style="text-transform: capitalize;margin-left:5%;"><b><?php echo $customer_name['name']; ?></b></p>

    <div>
    <?php 
            foreach ($list as $orderKey => $innerorder) {          
                ?>    <table class="table">
                <thead>
                  <tr>
                  <div class="card-header bg-dark text-light mt-4">
                        <div class="row">
                        <div class="col-5">
                        <p style="font-size: 13px;"><b> Date : <?php echo $innerorder[0]->date ?></b></p>
                        </div>
                        <div class="col-7">
                        <p style="font-size: 13px;"><b> Payment Mode : <?php echo $innerorder[0]->payment_mode ?></b></p>
                        </div>
                        </div>                  
                    </div> 
                    <th scope="col">product</th>
                    <th scope="col">qty</th>
                    <th scope="col">price</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($innerorder as $key=> $order){
                $tot_amt = $order->total_amt;
                $pend_amt = $order->pending_amt;
                $paid_amt = $order->paid_amt;
                    ?><tr>
                    <th scope="row"><?php echo $order->product_name ?></th>
                    <td><?php echo $order->qty ?></td>
                    <td><?php echo $order->price ?></td>
                    </tr><?php
                }?>
                    
                </tbody>
                </table>
                <div class="container">
                <div class="row">
                <div class="col-4">
                        <h6>Total</h6>
                        <input class="w-50" type="number" style="border: none; text-align:center;font-weight:bold;" value="<?php echo $tot_amt; ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Paid</h6>
                        <input class="w-50 text-success" type="number" style="border: none; text-align:center;font-weight:bold;"  value="<?php echo $paid_amt ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Pending</h6>
                        <input class="w-50 text-danger" type="number" style="border: none; text-align:center; font-weight:bold;"  value="<?php echo $pend_amt ?>" readonly>
                    </div>
                </div>
            </div>
            <hr>
                 <?php 
                  
            }
        ?>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>