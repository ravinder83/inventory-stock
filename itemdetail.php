<?php
    include 'dbcon.php';
    $itemid =  $_GET['itemid'];
    $sql = "Select * from product where id = '$itemid'";
    $sqlquery = mysqli_query($con,$sql);
    $data = mysqli_fetch_array($sqlquery);
    // echo "<pre>";
    // print_r($data);
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
  <h1 class="text-center">Item Detail</h1>

  <div class="container-fluid" style="height: 100%;display: flex;justify-content: center;align-items: center;">
      <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title"><?php echo $data['name'] ?></h5>
        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Qty :- <?php echo $data['qty'] ?></li>
        <li class="list-group-item">Selling Price :-<?php echo $data['selling_price'] ?></li>
        <li class="list-group-item">Cost Price :-<?php echo $data['cost_price'] ?></li>
        <?php if($row['role'] == 1){
          ?><li class="list-group-item d-flex"><a href="editproduct.php?edit=<?php  echo $data['id'] ?>" class="btn btn-warning">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteproduct.php?delete=<?php  echo $data['id'] ?>" class="btn btn-danger">Delete</a></li><?php
        } ?>
        
      </ul>
      </div>
  </div>
</body>

<?php
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>