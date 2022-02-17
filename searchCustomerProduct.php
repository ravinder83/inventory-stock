<?php
include 'dbcon.php';
// search for customer
if(isset($_POST['search']))
{
  $search_value = $_POST['search'];
  $sql = "select * FROM customer WHERE name LIKE '%$search_value%' OR mobile LIKE '%$search_value%'";
  $sqlquery = mysqli_query($con,$sql);
  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '<a onclick="fun('.$row['id'].')" style="text-decoration: none; text-transform:capitalize; cursor:pointer"><div class="alert alert-dark text-center" role="alert">
      '.$row['name'].'&nbsp; &nbsp'.$row['mobile'].'
    </div></a>';
    } 
    echo $output;    
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

if(isset($_POST['id']))
{
  $cust_id = $_POST['id'];

  // fetching customer record
  $customer_detail = "Select * from customer where id = '$cust_id'";
  $sqlqueryCustomer = mysqli_query($con,$customer_detail);
  $customer_data = mysqli_fetch_array($sqlqueryCustomer);

  // getting cart count value
  $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$cust_id'";
  $sql_cart_count = mysqli_query($con,$cart_count);
  $cart_data = mysqli_fetch_array($sql_cart_count);

  // fetching products record
  $sql = "select * FROM product";
  $sqlquery = mysqli_query($con,$sql);
  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
    
      $output.= '<input class="form-control" type="search" id="searchProduct" onkeyup="search_prod('.$cust_id.')" name="search" placeholder="Search Product" aria-label="Search" autocomplete="off">
      <a href="cart.php?customerId='.$cust_id.'" style="text-decoration:none;color:black;"><i class="fas fa-cart-arrow-down" id="cartVal">('.$cart_data['count'].')</i></a>
      ';
      
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '
      <div class="mt-4 bg-light">
      <div class="row">
          <div class="col-1">
          <h6>'.$row['qty'].'</h6>
        </div>
        <div class="col-3">
        <h6>'.$row['name'].'</h6>
        </div>
        <div class="col-2">
        <h6 class="float-end">₹ '.$row['selling_price'].'</h6>
        </div>

        <div class="col-6 d-flex">
          <input type="number"  min="0" class="text-center qty" style="height:60px; width:70px;" id="qty'.$row['id'].'" name="qty" placeholder="Qty" value="1">
          <button type="button" class="btn btn-primary" style="height:60px; width:100px; margin-left:20px;"
          onclick="addToCart('.$row['id'].','.$cust_id.',qty'.$row['id'].')">Add</button>
        </div>
    </div>
    </div>
    ';
    } 
    echo $customer_data['name'];
    echo $output;
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

// Add to cart / Insert record into cart

if(isset($_POST['product_id']) && isset($_POST['cust_id']) && isset($_POST['qty_id']))
{
  $product_id = $_POST['product_id'];
  $cust_id = $_POST['cust_id'];
  $qty_id = $_POST['qty_id'];
  $output = "";
  if(!empty($qty_id)){

    $checkCart = "Select * from temp_cart where c_id = '$cust_id' AND p_id = '$product_id'";
    $sql_checkCart = mysqli_query($con,$checkCart);
    if(mysqli_num_rows($sql_checkCart))
    {
      $output .= '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Already In Cart!</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
      // getting cart count value
      $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$cust_id'";
      $sql_cart_count = mysqli_query($con,$cart_count);
      $cart_data = mysqli_fetch_array($sql_cart_count);

      $response = [$output , $cart_data['count']];
      echo json_encode($response);
    }else{
      $getProduct = "Select name,selling_price from product where id = '$product_id'";
      $exec_getProduct = mysqli_query($con,$getProduct);
      $row = mysqli_fetch_array($exec_getProduct);
      $productName = $row['name'];
      $price = $row['selling_price'];
      $sql = "Insert Into temp_cart (c_id,p_id,qty,product_name,product_price) Values ('$cust_id','$product_id','$qty_id','$productName','$price')";
      $sqlquery = mysqli_query($con,$sql);
      if($sqlquery){
        $output .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Added to cart!</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          // getting cart count value
          $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$cust_id'";
          $sql_cart_count = mysqli_query($con,$cart_count);
          $cart_data = mysqli_fetch_array($sql_cart_count);
  
          $response = [$output , $cart_data['count']];
          echo json_encode($response);
          //echo $output;
      }
      else{
        $output .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error Occured !</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        //echo json_encode($output);
      }
    }
    
  }
  else{
    $output .= '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Please select qty !</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
      //echo json_encode($output);
  }
}


// search for product
if(isset($_POST['searchProductData']))
{
  $cust_id = $_POST['cust_id'];
  $search_value = $_POST['searchProductData'];
  $sql = "select * FROM product WHERE name LIKE '%$search_value%'";
  $sqlquery = mysqli_query($con,$sql);

    // getting cart count value
    $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$cust_id'";
    $sql_cart_count = mysqli_query($con,$cart_count);
    $cart_data = mysqli_fetch_array($sql_cart_count);

  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
      $output.= '<input class="form-control my-4" type="search" id="searchProduct" onkeyup="search_prod('.$cust_id.')" name="search" placeholder="Search Product" aria-label="Search" autocomplete="off">
      <i class="fas fa-cart-arrow-down"></i><h3 id="cartVal">('.$cart_data['count'].')</h3>
      ';
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '
      <div class="row">
        <div class="col-6">
          <div class="alert alert-light" role="alert">
          '.$row['name'].'
          </div>
        </div>

        <div class="col-6 d-flex">
          <input type="number"  min="0" class="text-center" style="height:60px; width:70px;" id="qty'.$row['id'].'" name="qty" placeholder="Qty">
          <button type="button" class="btn btn-primary" style="height:60px; width:100px; margin-left:20px;"
          onclick="addToCart('.$row['id'].','.$cust_id.',qty'.$row['id'].')">Add to cart </button>
        </div>
    </div>';
    } 
    //echo $customer_data['name'];
    echo $output;
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

?>


