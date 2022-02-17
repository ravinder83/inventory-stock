<?php
include 'dbcon.php';
// define variables to empty values  
$catErr = "";
$category ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

  //String Validation  
  if (empty($_POST["category"])) {
    $catErr = "Category Name is required";
  } else {
    $category = ($_POST["category"]);  
    if (!preg_match("/^[a-zA-Z ]*$/", $category)) {
      $catErr = "Only alphabets and white space are allowed";
    }
  }

  if (empty($catErr)) {

        $nameCheck = "select * from category where category_name='$category'";
		$execName = mysqli_query($con,$nameCheck);
		$nameCount = mysqli_num_rows($execName);

		if($nameCount>0)
		{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Category Already Exists !</strong>Please Try With Diffrent Category Name
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
		}
        else{
            $insertdata = "INSERT INTO `category` (`category_name`) VALUES ('$category')";
            $sqlQuery = mysqli_query($con, $insertdata) or die("Query failed");

            if ($sqlQuery)
            {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Category Added !</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            } 
            else
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Something Went Wrong !</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
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

  <title>Category Page</title>
</head>

<body>
  <div class="container mt-4">
    <h1>Add Category</h1>
    <form action="category.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Category Name</label>
        <input class="form-control w-75" type="text" id="category" name="category" placeholder="Enter Category Name" autocomplete="off">
        <span class="error text-danger"><?php echo $catErr; ?> </span>
      </div>
      <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>