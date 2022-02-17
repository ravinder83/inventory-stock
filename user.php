<?php
include 'dbcon.php';
// define variables to empty values  
$nameErr = $passErr = $mobilenoErr = $roleErr = $activeErr = "";
$username = $password = $mobile = $role = $isactive = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

  //String Validation  
  if (empty($_POST["uname"])) {
    $nameErr = "Name is required";
  } else {
    $username = ($_POST["uname"]);  
    if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
      $nameErr = "Only alphabets and white space are allowed";
    }
  }

  //password Validation  
  if (empty($_POST["pass"])) {
    $passErr = "Password is required";
  } else {
    $password = ($_POST["pass"]); 
    if (!preg_match("/^[0-9]*$/", $password)) {
      $passErr = "Only numeric value is allowed.";
    }  
    if (strlen($password) != 6) {
      $passErr = "Mobile no must contain 6 digits.";
    }
  }

  //Mobile Validation  
  if (empty($_POST["mobile"])) {
    $mobilenoErr = "Mobile no is required";
  } else {
    $mobile = ($_POST["mobile"]); 
    if (!preg_match("/^[0-9]*$/", $mobile)) {
      $mobilenoErr = "Only numeric value is allowed.";
    }  
    if (strlen($mobile) != 10) {
      $mobilenoErr = "Mobile no must contain 10 digits.";
    }
  }

  if (empty($nameErr) && empty($passErr) && empty($mobilenoErr)) {

    $nameCheck = "select * from user where username='$username'";
		$execName = mysqli_query($con,$nameCheck);
		$nameCount = mysqli_num_rows($execName);

		if($nameCount>0)
		{
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>User Already Added !</strong>Please Try With Diffrent UserName
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
		}
		else
		{	
      $role = $_POST['role'];
      $isactive = $_POST['isactive'];
      $pass = password_hash($password, PASSWORD_BCRYPT);
      $insertdata = "INSERT INTO `user` (`username`, `password`, `mobile`, `role`, `isActive`) VALUES ('$username', '$pass', '$mobile', '$role', '$isactive')";

      $sqlQuery = mysqli_query($con, $insertdata) or die("Query failed");
      if ($sqlQuery) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>User Added !</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      } else {
        echo "Error Occured";
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

  <title>User Page</title>
</head>

<body>
  <div class="container mt-4">
    <h1>Add User</h1>
    <form action="user.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">User name</label>
        <input class="form-control w-75" type="text" id="uname" name="uname" placeholder="Enter Username" autocomplete="off">
        <span class="error text-danger">* <?php echo $nameErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Password</label>
        <input class="form-control w-75" type="password" id="pass" name="pass" placeholder="Enter Password" autocomplete="off">
        <span class="error text-danger">* <?php echo $passErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Mobile</label>
        <input class="form-control w-75" type="text" id="mobile" name="mobile" placeholder="Enter Mobile" autocomplete="off">
        <span class="error text-danger">* <?php echo $mobilenoErr; ?> </span>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Role</label>
        <select class="form-select w-75" aria-label="Default select example" name="role">
          <option selected value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Is Active</label>
        <select class="form-select w-75" aria-label="Default select example" name="isactive">
          <option selected value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>