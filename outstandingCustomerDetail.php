<?php

include 'dbcon.php';
$jsonData = $_GET['order_id'];
json_decode($jsonData);
$string =  str_replace('"','',$jsonData);
$newString =  str_replace('[','',$string);
$finalString =  str_replace(']','',$newString);
echo $finalString;
$order_id = $_GET['order_id'];
$customer_name = $_GET['cust_name'];
$sql = "Select orders.paid_amt,orders.pending_amt,orders.total_amt,orderitems.product_name,orderitems.price,orderitems.qty,DATE_FORMAT(orderitems.date, '%l:%i %p %b %e, %Y') as 'date' from orders INNER JOIN orderitems ON orders.id = orderitems.order_id where orders.pending_amt != 0 AND orders.id IN ($finalString)";
$result = mysqli_query($con,$sql);
$list = [];
while($output = mysqli_fetch_array($result)){
   array_push($list,$output);
}
    //   echo "<pre>";
    //   print_r($list);
    //   die; 
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
</head>

<body style="background-color: #f0f2f7;">
    <?php include 'header.php'; ?>
    <h5 class="container m-4">Pending Customer Detail</h5>
    <p class="text-danger" style="text-transform: capitalize;;"><b><?php echo $customer_name; ?></b></p>
<!-- <?php
    foreach ($list as $items) {
    ?>
        <div class="card mt-2" style="width: 28rem; margin-left:5%">
            <div class="card-header bg-dark text-light">
               <b> Product Name : <?php echo $items['product_name'] ?></b>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Price : <?php echo $items['price'] ?></li>
                <li class="list-group-item">qty :   <?php echo $items['qty'] ?></li>
                <li class="list-group-item">paid_amt :   <?php echo $items['paid_amt'] ?></li>
                <li class="list-group-item">pending_amt :   <?php echo $items['pending_amt'] ?></li>
                <li class="list-group-item">total_amt :   <?php echo $items['total_amt'] ?></li>
                <li class="list-group-item">Date :   <?php echo $items['date'] ?></li>
            </ul>
        </div>
        <hr>
    <?php
    }
    ?> -->
    <div>
        <table class="table">
                <thead>
                    <tr>
                    <div class="card-header bg-dark text-light">
                        <b> Date : <?php echo $items['date'] ?></b>
                    </div>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($list as $items) {
                    ?>
                        <tr>
                            <th><?php echo $items['product_name'] ?></th>
                            <td>₹<?php echo $items['price'] ?></td>
                            <td><?php echo $items['qty'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="container mt-2">
                <div class="row">
                <div class="col-4">
                        <h6>Total</h6>
                        <input class="w-50" type="number" id="paid_amt" style="border: none; text-align:center;" onkeyup="calc_pending_amt()" value="<?php echo $items['total_amt'] ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Paid</h6>
                        <input class="w-50 text-success" type="number" id="paid_amt" style="border: none; text-align:center;" onkeyup="calc_pending_amt()" value="<?php echo $items['paid_amt'] ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Pending</h6>
                        <input class="w-50 text-danger" type="number" id="pending_amt" style="border: none; text-align:center;" onkeyup="calc_paid_amt()" value="<?php echo $items['pending_amt'] ?>" readonly>
                    </div>
                </div>
            </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>