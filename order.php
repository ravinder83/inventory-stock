<?php
include 'dbcon.php';
$sql = "select * FROM customer";
$sqlquery = mysqli_query($con,$sql);
$customer = [];
while ($row = mysqli_fetch_array($sqlquery)){
    array_push($customer,$row);
} 
    
$sql2 = "select * FROM product";
$sqlquery2 = mysqli_query($con,$sql2);
$product = [];
while ($row = mysqli_fetch_array($sqlquery2)){
    array_push($product,$row);
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

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>Order</title>
</head>

<body style="background-color: #f0f2f7;">
<?php include 'header.php'
 ?>
<?php if($row['role'] == 1){ ?>
<div class="container" id="cart-result">

</div>
<div class="container">
<input class="form-control" type="search" id="search" name="search" placeholder="Search Customer" aria-label="Search" autocomplete="off">
</div>
<?php 
  // if(isset($_SESSION['customer_name']))
  // {
  //   $user = $_SESSION['customer_name'];
  //   echo "Selected user $user ";
  // }
  // else{
  //   echo '';
  // }
?>

<div class="search my-4 mx-2" id="search-data"></div>
<?php } else{
  echo '<div class="alert alert-danger" role="alert">
          You are Not allowed to placed Order
        </div>'; 
} ?>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<script>
  $(document).ready(function(){
    // Live search for customer
    $('#search').on('keyup',function(){
      var search_term = $(this).val();
      console.log(search_term);
      $.ajax({
        type: "POST",
        url: "searchCustomerProduct.php",
        data: {search : search_term},
        success: function(data)
        {
        $('#search-data').html(data);
        }
    });
    })
  })
</script>

<script>
  // for search customer record
    function fun(id){
        //alert(id);
        $.ajax({
        type: "POST",
        url: "searchCustomerProduct.php",
        data: {id : id},
        success: function(data)
        {
            $('#search-data').html(data);
            document.getElementById('search').value="";
        }
    });
    }
</script>

<script>
  // define function to add product in cart
  function addToCart(product_id,cust_id,qty_id,store)
  {
    var qty = document.getElementById(qty_id.id).value;
    if(qty == ""){
      alert("please select qty");
    }
    $.ajax({
        type: "POST",
        url: "searchCustomerProduct.php",
        data: {product_id : product_id , cust_id : cust_id , qty_id : qty , store:store},
        success: function(data)
        {
          // $('#cart-result').html(data);
          var cartVal = document.getElementById('cartVal').innerHTML;
          //console.log("addddd----",cartVal);
          var mydata = JSON.parse(data);
          //console.log(mydata);
            
            document.getElementById('cartVal').innerHTML = mydata[1];
            $('#cart-result').html(mydata[0]);
            //console.log(mydata[1]);
        }
    });
  }
</script>

<script>
    function search_prod(c_id){
      // console.log("customer",c_id);
      var search_term = document.getElementById('searchProduct').value;
      console.log(search_term);
      $.ajax({
        type: "POST",
        url: "searchCustomerProduct.php",
        data: {searchProductData : search_term , cust_id : c_id},
        success: function(data)
        {
          //var mydata = JSON.parse(data);
          //console.log("fdfdfd-----",mydata);
          $('#search-data').html(data);
          //document.getElementsByClassName('qty').value="";
        }
    });
    }
</script>