<?php
include 'dbcon.php';
include 'userAuth.php';
// define variables to empty values  
$productErr = $spriceErr = "";
$productName = $qty = $sellingPrice = $costPrice = $category = "";

// fetching data from category table

// $res['category_name']=[];
// $selectquery = "select * from category";
// $sqlquery = mysqli_query($con,$selectquery);
// while($row = mysqli_fetch_array($sqlquery))
// {
//     array_push($res['category_name'], $row);
// }
$res = [];
$selectquery = "select * from category";
$sqlquery = mysqli_query($con,$selectquery);
while($row = mysqli_fetch_array($sqlquery))
{
    array_push($res, $row);
}

// fetching data from store table
$storeData = [];
$sqlStore = "select * from store";
$sqlqueryStore = mysqli_query($con,$sqlStore);
while($rows = mysqli_fetch_array($sqlqueryStore))
{
    array_push($storeData, $rows);
}

// insert data into product with validation
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //product name Validation  
  if (empty($_POST["pname"])) {
    $productErr = "Name is required";
  } else {
    $productName = ($_POST["pname"]);  
    // if (!preg_match("/^[a-zA-Z ]*$/", $productName)) {
    //   $productErr = "Only alphabets and white space are allowed";
    // }
  }
  //selling price Validation  
  if (empty($_POST["sprice"])) {
    $spriceErr = "Selling Price is required";
  } else {
    $sellingPrice = ($_POST["sprice"]); 
  }

  if (empty($productErr) && empty($spriceErr)) 
  {
      $qty = $_POST['qty'];
      $costPrice = $_POST['cprice'];
      $category = $_POST['cat'];
      $store = $_POST['store'];

    $insertdata = "INSERT INTO `product` (`name`, `qty`, `selling_price`, `cost_price`, `cat_id`,`store`) VALUES ('$productName', '$qty', '$sellingPrice', '$costPrice', '$category','$store')";
    $sqlQuery = mysqli_query($con, $insertdata) or die("Query failed");

        if ($sqlQuery)
        {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Product Added !</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        header('location:dashboard.php');
        } 
        else 
        {
        echo "Error Occured";
        }
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

  <title>Product Page</title>
</head>
<?php include'header.php';  ?>
<body style="background-color: #f0f2f7;";>
  <div class="container mt-4">
    <h1>Add Product</h1>
    <form action="product.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product name</label>
        <input class="form-control w-75" type="text" id="pname" name="pname" placeholder="Enter Product Name" autocomplete="off">
        <span class="error text-danger"><?php echo $productErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Qty</label>
        <input class="form-control w-75" type="number" min="0" id="qty" name="qty" placeholder="Enter Quantity" autocomplete="off">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Selling Price</label>
        <input class="form-control w-75" type="number" id="sprice" name="sprice" placeholder="Enter Selling Price" autocomplete="off">
        <span class="error text-danger"><?php echo $spriceErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Cost Price</label>
        <input class="form-control w-75" type="number" id="cprice" name="cprice" placeholder="Enter Cost Price" autocomplete="off">
      </div>
      <div class="mb-3" style="display: none;">
        <label for="exampleInputEmail1" class="form-label">Category</label>
        <select class="form-select w-75" aria-label="Default select example" name="cat">
        <option>Select Category</option>
            <?php 
            foreach ($res as $value) {
                ?><option value=<?php echo $value['id']; ?>><?php echo $value['category_name']; ?></option><?php
            }
            ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Store</label>
        <select class="form-select w-75" aria-label="Default select example" name="store">
        <option value="">Select Store</option>
            <?php 
            foreach ($storeData as $item) {
                ?><option value=<?php echo $item['value']; ?>><?php echo $item['value']; ?></option><?php
            }
            ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>