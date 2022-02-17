<?php
include 'dbcon.php';
// $sql = "SELECT id,customer_id,customer_name,sum(pending_amt) as 'total_pending' FROM `orders` where pending_amt != 0 GROUP BY customer_id ORDER BY total_pending";
$sql = "SELECT id,customer_id,customer_name,pending_amt,DATE_FORMAT(date,'%M %e, %Y') as 'date' FROM `orders` where pending_amt != 0";
$sqlquery = mysqli_query($con,$sql);
$res = [];
while ($row = mysqli_fetch_array($sqlquery)){
    array_push($res, $row);
}
// echo "<pre>";
// echo $res[0]['customer_name'];
// die;
$sql2 = "SELECT DISTINCT orderitems.order_id from orderitems INNER JOIN orders ON orderitems.order_id = orders.id where orders.pending_amt != 0 AND orders.customer_id = 1";
$sqlquery2 = mysqli_query($con,$sql2);
$res2 = [];
while ($row2 = mysqli_fetch_array($sqlquery2)){
    array_push($res2, $row2);
}
// echo "<pre>";
// print_r($res2);
// echo "</pre>";
$idd = [];
foreach($res2 as $arr)
{
  array_push($idd,$arr['order_id']);
}
$encoded_data = json_encode($idd);
// echo $encoded_data;
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

  <title>Outstanding</title>
</head>

<body style="background-color: #f0f2f7;">
<?php include 'header.php' ?>
<h2 class="text-center mt-4">Outstanding Customer List</h2>
<div class="container" id="search-item">
    <?php 
        foreach($res as $items){
            ?><a style="text-decoration: none; text-transform:capitalize; color:black;" href="outstandingCustomerDetail.php?order_id=<?php echo urlencode($encoded_data) ?>&cust_name=<?php echo $items['customer_name']; ?>"><div class="m-4 bg-light p-4">
            <div class="row">
              <div class="col-4">
                <h6><?php echo $items['customer_name']; ?></h6>
              </div>
              <div class="col-6">
              <h6 class="float-end">₹ <?php echo $items['pending_amt']; ?></h6>
              </div>
              <p><?php echo $items['date']; ?></p>
            </div>
          </div></a>
        <?php }
    ?>
</div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>
