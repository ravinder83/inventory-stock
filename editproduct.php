<?php
    include 'dbcon.php';
    $itemid =  $_GET['edit'];
    $sql = "Select * from product where id = '$itemid'";
    $sqlquery = mysqli_query($con,$sql);
    $data = mysqli_fetch_array($sqlquery);
    // echo "<pre>";
    // echo $data['name'];
    // die();

    if(isset($_POST['submit']))
		{
				//$id = $_GET['edit'];
				$name = $_POST['iname'];
				$qty = $_POST['qty'];
				$sellingPrice = $_POST['sellingPrice'];    
				$costPrice = $_POST['costPrice'];

				$update = "update product SET name='$name',qty='$qty',selling_price='$sellingPrice',cost_price='$costPrice' where id='$itemid'";
				$runupdate = mysqli_query($con,$update);
				if($runupdate)
				{
					header('location:items.php');
				}
				else
				{
					echo "failed";
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

  <title>Dashboard</title>
</head>

<body style="background-color: #f0f2f7;">
  <?php include 'header.php' ?>
  <h1 class="text-center">Update Item</h1>

  <div class="container-fluid" style="height: 100%;display: flex;justify-content: center;align-items: center;">
      <div class="card" style="width: 18rem;">
      <div class="card-body">
  <form method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" id="iname" name="iname" value="<?php echo $data['name'] ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Qty</label>
        <input type="text" class="form-control" id="qty" name="qty" value=<?php echo $data['qty'] ?>>
      </div>
      <div class="mb-3">
        <label class="form-label">Selling Price</label>
        <input type="text" class="form-control" id="sellingPrice" name="sellingPrice" value=<?php echo $data['selling_price'] ?>>
      </div>
      <div class="mb-3">
        <label class="form-label">Cost Price</label>
        <input type="text" class="form-control" id="costPrice" name="costPrice" value=<?php echo $data['cost_price'] ?>>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Update</button> 
  </form>
      </div>
      </div>
  </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>