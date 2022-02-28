<?php
include 'dbcon.php';
session_start();
$id;
if(isset($_SESSION['customer_id']))
{
  $id =  $_SESSION['customer_id'];
}
else{
  $id = "";
}
  // getting cart count value
  $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$id'";
  $sql_cart_count = mysqli_query($con,$cart_count);
  $cart_data = mysqli_fetch_array($sql_cart_count);

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Product Page</title>
</head>

<body style="background-color: #f0f2f7;";>
<div class="container-fluid" style="box-shadow: 20px 20px 50px #8aaae6 inset;">
  <div class="row align-items-center py-2">
    <div class="col-6 d-flex">
      <a class="nav-link text-dark p-0" style="font-size: 24px;" href="dashboard.php">Home</a>
      <?php 
          if(isset($_SESSION['customer_id']))
          {
            ?>
            <a href="cart.php?customerId=<?php echo $id ?>" style="text-decoration:none;color:black;"><i class="fas fa-cart-arrow-down mx-2 my-2" style="font-size:22px" id="cartVal">(<?php echo $cart_data['count'] ?>)</i></a>    
            <?php
          }else{
            echo "";
          }
      ?>
    </div>
    <div class="col-6 text-end">
    <p class="mb-0">Hello <?php if(isset($_COOKIE['loginid'])){ echo $row['username'];}else{echo "";}  ?></p>
    </div>
  </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>