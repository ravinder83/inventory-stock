<?php
include 'dbcon.php';
// $sql = "SELECT orderitems.order_id,orderitems.product_name,orders.customer_name,orders.total_amt FROM `orderitems` LEFT JOIN `orders` ON orderitems.order_id = orders.id WHERE MONTH(orders.date) = MONTH(CURRENT_DATE()) AND YEAR(orders.date) = YEAR(CURRENT_DATE())";
$sql = "SELECT * from orders WHERE MONTH(orders.date) = MONTH(CURRENT_DATE()) AND YEAR(orders.date) = YEAR(CURRENT_DATE())";
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

  <title>Order detail</title>
</head>

<body style="background-color: #f0f2f7;">
  <?php include 'header.php' ?>
  <h2 class="text-center mt-4">Order Details</h2>
  <div class="container-fluid">
    <h2>Search Order</h2>
    <form method="POST">
      <div class="row">
        <div class="col-6">
          <p>Start Date</p>
          <input type="date" name="start_date" id="start_date">
        </div>
        <div class="col-6">
          <p>End Date</p>
          <input type="date" name="end_date" id="end_date">
        </div>
      </div>
      <input type="button" onclick="searchData()" name="search" value="Search Order" class="btn btn-outline-success mt-4">
    </form>
  </div>
  <div class="container-fluid mt-4">

    <h2 class="text-center mt-4">Order's List</h2>
    <div class="container" id="search-item">
      <?php
      foreach ($res as $items) {
      ?><a style="text-decoration: none; text-transform:capitalize; color:black;" href="orderItemDetail.php?order_id=<?php echo $items['id'] ?>&cust_name=<?php echo $items['customer_name']; ?>">
          <div class="m-4 bg-light p-4">
            <div class="row">
              <div class="col-2">
                <h6><?php echo $items['id']; ?></h6>
              </div>
              <div class="col-4">
                <h6><?php echo $items['customer_name']; ?></h6>
              </div>
              <div class="col-6">
                <h6 class="float-end">₹ <?php echo $items['total_amt']; ?></h6>
              </div>
              <!-- <p class="text-center"><?php echo $items['date']; ?></p> -->
            </div>
          </div>
        </a>
      <?php }
      ?>
    </div>
  </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<script>
  function searchData() {
    var start_date = document.getElementById("start_date").value;
    var end_date = document.getElementById("end_date").value;
    console.log(start_date, end_date);

    $.ajax({
      type: "POST",
      url: "searchOrder.php",
      data: {
        start_date: start_date,
        end_date: end_date
      },
      success: function(data) {
        $('#search-item').html(data);
        console.log(data);
      }
    });
  }
</script>