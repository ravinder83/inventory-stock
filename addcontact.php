<?php
include 'dbcon.php';
include 'userAuth.php';
// define variables to empty values  
$nameErr = $mobileErr = "";
$customer = $mobile = "";

// insert data into customer with validation
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //product name Validation  
  if (empty($_POST["cname"])) {
    $nameErr = "Name is required";
  } else {
    $customer = ($_POST["cname"]);  
    if (!preg_match("/^[a-zA-Z ]*$/", $customer)) {
      $nameErr = "Only alphabets and white space are allowed";
    }
  }
  //selling price Validation  
  if (empty($_POST["mobile"])) {
    $mobileErr = "Mobile Number is required";
  } else {
    $mobile = ($_POST["mobile"]); 
  }

  if (empty($nameErr) && empty($mobileErr)) 
  {

    $insertdata = "INSERT INTO `customer` (`name`, `mobile`) VALUES ('$customer','$mobile')";
    $sqlQuery = mysqli_query($con, $insertdata) or die("Query failed");

        if ($sqlQuery)
        {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Customer Added !</strong>
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
    <h1>Add Customer</h1>
    <form action="addcontact.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Customer name</label>
        <input class="form-control w-75" type="text" id="cname" name="cname" placeholder="Enter Customer Name" autocomplete="off">
        <span class="error text-danger"><?php echo $nameErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Mobile</label>
        <input class="form-control w-75" type="number" id="mobile" name="mobile" placeholder="Enter Mobile" autocomplete="off">
        <span class="error text-danger"><?php echo $mobileErr; ?> </span>
      </div>
      <button type="submit" class="btn btn-primary">Add Customer</button>
    </form>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>