<?php
include 'dbcon.php';
// session_start();
if(isset($_COOKIE['username']))  
  {
    header('location:dashboard.php');
  }
$nameErr = $passErr = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

  //Name Validation  
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
  }

  if (empty($nameErr) && empty($passErr)) {
        $userNameCheck = "Select * from user where username='$username'";
        $check = mysqli_query($con,$userNameCheck);
        $userCount = mysqli_num_rows($check);
        if($userCount)
        {
            //echo "Login Success";
            $passwordCheck = mysqli_fetch_assoc($check);
            $dbPass = $passwordCheck['password'];
            //$_SESSION['username'] = $passwordCheck['username'];
            setcookie('loginid', $passwordCheck['id'], time() + ( 365 * 24 * 60 * 60));  // (86400 * 30)
            // $idn =  $_COOKIE['loginid'];
            // echo $idn;
            // die();
            $passDecode = password_verify($password,$dbPass);
            if($passDecode)
				{
					echo "login successfully..";
					?>
						<script type="text/javascript">
							location.replace("dashboard.php");
						</script>
					<?php
				}
				else
				{
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Invalid Password </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
				}
			}
			else
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> Invalid UserName </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
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

  <title>Login</title>
</head>

<body style="background-color: #f0f2f7;";>
  <div class="container mt-4">
    <h1>Login</h1>
    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">User name</label>
        <input class="form-control w-75" type="text" id="uname" name="uname" placeholder="Enter Username" autocomplete="off">
      </div>
      <span class="error text-danger"><?php echo $nameErr; ?> </span>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Password</label>
        <input class="form-control w-75" type="password" id="pass" name="pass" placeholder="Enter Password" autocomplete="off">
      </div>
      <span class="error text-danger"><?php echo $passErr; ?> </span><br/>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>