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

    <div class="row">
      <div class="col-4">
        <p class="text-center">Sold</p>
        <h6 class="text-center"><?php echo $tot_qty['qty'] ?></h6>
      </div>
      <div class="col-4">
        <p class="text-center">Total</p>
        <h6 class="text-center"><?php echo count($orders); ?></h6>
      </div>
      <div class="col-4">
        <p class="text-center">Earning</p>
        <h6 class="text-center">₹ <?php echo $tot_amount['tot_amt'] ?></h6>
      </div>
    </div>
  </div>


  <section>
    <div class="row">
    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff;">
        <a href="items.php" style="text-decoration: none; color:#000;"><div class="row" style="margin-left:10px;">
          <div class="col-4 mt-2">
            <p class="text-center display-2" style="color: #174482; "><i class="fas fa-shopping-basket" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
            <p>Items</p>(<?php echo count($res) ?>)
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff; position: relative; left:30px;">
    <a href="contacts.php" style="text-decoration: none; color:#000;"><div class="row">
          <div class="col-4 mt-2">
            <p class="text-center display-2" style="color: #942615; "><i class="fas fa-id-card" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
            <p>Contacts</p> (<?php echo count($res2) ?>)
            
          </div>
        </div></a>
    </div>
    </div>
  </section>

  <section>
    <div class="row">
    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff;">
        <a href="editall.php" style="text-decoration: none; color:#000;"><div class="row" style="margin-left:10px;">
          <div class="col-4 mt-2">
            <p class="text-center display-2" style="color: #174482; "><i class="far fa-edit" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
            <p class="mt-4">Update Stock</p>
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff; position: relative; left:30px;">
    <a href="order.php" style="text-decoration: none; color:#000;"><div class="row">
          <div class="col-4 mt-2">
            <p class="text-center display-2" style="color: #942615;"><i class="fas fa-shopping-cart" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
          <p class="mt-4">Place Order</p>
          </div>
        </div></a>
    </div>
    </div>
  </section>

  <section>
    <div class="row">
    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff;">
        <a href="outstanding2.php" style="text-decoration: none; color:#000;"><div class="row" style="margin-left:10px;">
          <div class="col-4 mt-2">
            <p class="text-center display-2" style="color: #174482; "><i class="fas fa-money-bill-alt" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
            <p class="mt-4">Pendings</p>
          </div>
        </div></a>
    </div>

    <div class="col-xl-6 col-sm-6 col-6 mt-3" style="width:40%;background-color: #fff; position: relative; left:30px;">
    <a href="orderdetail.php" style="text-decoration: none; color:#000;"><div class="row">
          <div class="col-4">
            <p class="text-center display-2" style="color: #942615;"><i class="fas fa-info-circle" style="font-size: 30px;"></i></p>
          </div>
          <div class="col-8">
          <p class="mt-4">Order Details</p>
          </div>
        </div></a>
    </div>
    </div>
  </section>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>