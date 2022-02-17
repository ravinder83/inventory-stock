<?php
include 'dbcon.php';
// search for products
$search = $_GET['search'];
$sql = "select * FROM product WHERE name LIKE '%$search%'";
$sqlquery = mysqli_query($con,$sql);
$res = [];
while ($row = mysqli_fetch_array($sqlquery)){
    array_push($res, $row);
}
// echo "<pre>";
// print_r($res);
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
<h2 class="text-center mt-4">Search Result for <em>"<?php echo $_GET['search'] ?>"</em></h2>
<?php 
        if(!empty($res))
        {
            foreach($res as $items)
            {
                ?>
                <a href="itemdetail.php?itemid=<?php echo $items['id']; ?>" style="text-decoration: none; text-transform:capitalize"><div class="alert alert-dark text-center" role="alert">
                <?php echo $items['name']; ?> <span style="margin-left: 50%;">(<?php echo $items['qty'] ?>)</span>
                </div>
                </a>
            <?php 
            }
        }else{
            ?>
                <div class="alert alert-danger text-center" role="alert">
                No Data Found
                </div>
                
            <?php 
        }
        
    ?>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>