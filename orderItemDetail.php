<?php
include 'dbcon.php';
$id = $_GET['order_id'];
$customer_name = $_GET['cust_name'];
$sql = "SELECT * FROM `orderitems` INNER JOIN `orders` ON orders.id = orderitems.order_id where orderitems.order_id = $id";
$sqlquery = mysqli_query($con, $sql);
$res = [];
while ($row = mysqli_fetch_array($sqlquery)) {
    array_push($res, $row);
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

    <title>Order Item detail</title>
</head>

<body style="background-color: #f0f2f7;">
    <?php include 'header.php' ?>
    <h3 class="text-primary m-2"><a href="orderdetail.php"><i class="fas fa-backward"></i></a></h3>
    <h5 class="container m-4">Order item List</h5>
    <p class="text-danger" style="text-transform: capitalize;margin-left:5%;"><b><?php echo $customer_name; ?></b></p>
    <!-- <div class="card-header bg-dark text-light">
               <b> Date : demo</b>
            </div>   -->
    <!-- <?php
    foreach ($res as $items) {
    ?>
        <div class="card mt-2" style="width: 28rem; margin-left:5%">     
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Price : <?php echo $items['price'] ?></li>
                <li class="list-group-item">qty :   <?php echo $items['qty'] ?></li>
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
                        <div class="row">
                        <div class="col-5">
                        <p style="font-size: 13px;"><b> Date : <?php echo $items['date'] ?></b></p>
                        </div>
                        <div class="col-7">
                        <p style="font-size: 13px;"><b> Payment Mode : <?php echo $items['payment_mode'] ?></b></p>
                        </div>
                        </div>                  
                    </div> 
                        <th scope="col">Product Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($res as $items) {
                    ?>
                        <tr>
                            <th><?php echo $items['product_name'] ?></th>
                            <td>₹<?php echo $items['qty'] ?></td>
                            <td><?php echo $items['price'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="container mt-2">
                <div class="row">
                <div class="col-4">
                        <h6>Total</h6>
                        <input class="w-50" type="number" style="border: none; text-align:center;" value="<?php echo $items['total_amt'] ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Paid</h6>
                        <input class="w-50 text-success" type="number" style="border: none; text-align:center;" value="<?php echo $items['paid_amt'] ?>" readonly>
                    </div>
                    <div class="col-4">
                        <h6>Pending</h6>
                        <input class="w-50 text-danger" type="number" style="border: none; text-align:center;" value="<?php echo $items['pending_amt'] ?>" readonly>
                    </div>
                </div>
            </div>
    </div>

</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>