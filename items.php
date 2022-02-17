<?php
include 'dbcon.php';
$sql = "Select * from product";
$sqlquery = mysqli_query($con,$sql);
$res = [];
while ($row = mysqli_fetch_array($sqlquery)){
    array_push($res, $row);
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>Dashboard</title>
</head>

<body style="background-color: #f0f2f7;">
<?php include 'header.php' ?>
    <form class="d-flex col-lg-2" action="search.php" method="GET">
        <input class="form-control me-2" type="search" id="search" name="search" placeholder="Search Items" aria-label="Search" autocomplete="off">
        <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
    </form>
<h2 class="text-center mt-4">Item List</h2>
<div class="container" id="search-item">
    <?php 
        foreach($res as $items){
            ?><div class="m-4 bg-light p-4"><a class="text-dark" href="itemdetail.php?itemid=<?php echo $items['id']; ?>" style="text-decoration: none; text-transform:capitalize;">
            <div class="row">
              <div class="col-4">
                <h6><?php echo $items['name']; ?></h6>
              </div>
              <div class="col-2">
              <h6><?php echo $items['qty']; ?></h6>
              </div>
              <div class="col-4">
              <h6 class="float-end">₹ <?php echo $items['selling_price']; ?></h6>
              </div>
              <!-- <div class="col-2">
                <i class="fas fa-times" style="border: 1px solid black; padding:4px; border-radius:50%"></i>
              </div> -->
            </div>
          </a></div>
        <?php }
    ?>
</div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<script>
  $(document).ready(function(){
    // Live search
    $('#search').on('keyup',function(){
      var search_term = $(this).val();
      console.log(search_term);
      $.ajax({
        type: "POST",
        url: "searchCustomer.php",
        data: {search_item : search_term},
        success: function(data)
        {
        $('#search-item').html(data);
        }
    });
    })

  })
</script>