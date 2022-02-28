<?php
include 'dbcon.php';
// for fetching number of items
$sql = "Select * from product";
$sqlquery = mysqli_query($con,$sql);
$res = [];
while ($row = mysqli_fetch_array($sqlquery)){
    array_push($res, $row);
}

// for fetching number of customer
$sql2 = "Select * from customer";
$sqlquery2 = mysqli_query($con,$sql2);
$res2 = [];
while ($row2 = mysqli_fetch_array($sqlquery2)){
    array_push($res2, $row2);
}
// for fetching details from orders table.
$order = "Select * from orders";
$exec_order = mysqli_query($con,$order);
$orders = [];
while ($row3 = mysqli_fetch_array($exec_order)){
    array_push($orders, $row3);
}

$total_earning = "select sum(total_amt) as 'tot_amt' from orders";
$exec_total = mysqli_query($con,$total_earning);
$tot_amount = mysqli_fetch_array($exec_total);

$total_qty = "select sum(qty) as 'qty' from orderitems";
$exec_qty = mysqli_query($con,$total_qty);
$tot_qty = mysqli_fetch_array($exec_qty);
// echo $tot_amount['tot_amt'];
// echo "<pre>";
// echo $orders;
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

  <title>Dashboard</title>
</head>

<body style="background-color: #f0f2f7;">
<?php include 'header.php' ?>


  <div class="container-fluid bg-primary text-light">

    <div class="row py-2">
      <div class="col-4">
        <p class="text-center mb-2">Sold</p>
        <h6 class="text-center mb-0"><?php echo $tot_qty['qty'] ?></h6>
      </div>
      <div class="col-4">
        <p class="text-center mb-2">Total</p>
        <h6 class="text-center mb-0"><?php echo count($orders); ?></h6>
      </div>
      <div class="col-4">
        <p class="text-center mb-2">Earning</p>
        <h6 class="text-center mb-0">₹ <?php echo $tot_amount['tot_amt'] ?></h6>
      </div>
    </div>
  </div>


  <section>
    <div class="row my-3 mx-2">
    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-right:3px;
    width: calc(50% - 3px);">
        <a href="items.php" style="text-decoration: none; color:#000;">
        <div class="row align-items-center">
          <div class="col-4">
            <p class="text-center  mb-0" style="color: #174482; "><i class="fas fa-shopping-basket" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Items</p>(<?php echo count($res) ?>)
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-left: 3px;
    width: calc(50% - 3px);">
    <a href="contacts.php" style="text-decoration: none; color:#000;">
    <div class="row">
          <div class="col-4">
            <p class="text-center mb-0" style="color: #942615; "><i class="fas fa-id-card" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Contacts</p> (<?php echo count($res2) ?>)
            
          </div>
        </div></a>
    </div>
    </div>
  </section>

  <section>
    <div class="row my-3 mx-2">
    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-right:3px;
    width: calc(50% - 3px);">
        <a href="editall.php" style="text-decoration: none; color:#000;">
        <div class="row align-items-center">
          <div class="col-4">
            <p class="text-center  mb-0" style="color: #174482; "><i class="fas fa-edit" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Update Stock</p>
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-left: 3px;
    width: calc(50% - 3px);">
    <a href="order.php" style="text-decoration: none; color:#000;">
    <div class="row">
          <div class="col-4">
            <p class="text-center mb-0" style="color: #942615; "><i class="fas fa-shopping-cart" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Place Order</p>
            
          </div>
        </div></a>
    </div>
    </div>
  </section>

  <section>
    <div class="row my-3 mx-2">
    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-right:3px;
    width: calc(50% - 3px);">
        <a href="outstanding2.php" style="text-decoration: none; color:#000;">
        <div class="row align-items-center">
          <div class="col-4">
            <p class="text-center  mb-0" style="color: #174482; "><i class="fas fa-money-bill-alt" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Pendings</p>
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 py-3" style="background-color:#fff; margin-left: 3px;
    width: calc(50% - 3px);">
    <a href="orderdetail.php" style="text-decoration: none; color:#000;">
    <div class="row">
          <div class="col-4">
            <p class="text-center mb-0" style="color: #942615; "><i class="fas fa-info-circle" style="font-size:22px;"></i></p>
          </div>
          <div class="col-8 d-flex">
            <p class="mb-0">Order Details</p>
            
          </div>
        </div></a>
    </div>
    </div>
  </section>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>