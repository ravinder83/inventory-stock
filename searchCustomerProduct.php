<?php
include 'dbcon.php';
session_start();
// include 'style.css';
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


  $_SESSION['customer_name'] = $customer_data['name'];
  $_SESSION['customer_id'] = $customer_data['id'];

  $session_name =   $_SESSION['customer_name'] = $customer_data['name'];
  $session_id =     $_SESSION['customer_id'] = $customer_data['id'];

  // getting cart count value
  $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$session_id'";
  $sql_cart_count = mysqli_query($con,$cart_count);
  $cart_data = mysqli_fetch_array($sql_cart_count);

  // fetching products record
  $sql = "select * FROM product order by name";
  $sqlquery = mysqli_query($con,$sql);
  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
    
      $output.= '<input class="form-control my-2" type="search" id="searchProduct" onblur="search_prod('.$cust_id.')" name="search" placeholder="Search Product" aria-label="Search" autocomplete="off">
      ';
      
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '
      <div class="mt-4">
      <div class="row align-items-center px-2 py-2 bg-light">
          
        <div class="col-5">
        <h6 style="display: flex;align-items: center;justify-content: space-between;font-size:11px" class="mb-0">'.$row['name'].' <span>('.$row['qty'].')</span></h6>
        </div>

        <div class="col-2">
        <h6 class="float-end mb-0" style="font-size:11px">₹ '.$row['selling_price'].'</h6>
        </div>

        <div class="col-5 d-flex justify-content-end">
          <input type="number" min="0" class="text-center qty" style="height:40px; width:50px;" id="qty'.$row['id'].'" name="qty" placeholder="Qty" value="1">
          <input type="hidden" name="store" value="'.$row['store'].'"/>
          <button type="button" class="btn btn-primary" style="height:40px; width:50px; margin-left:20px;"
          onclick=\'addToCart('.$row['id'].','.$cust_id.',qty'.$row['id'].',"'.$row['store'].'")\'>Add</button>
        </div>
    </div>
    </div>
    ';
    } 
    echo '<p class="text-danger" style="text-transform: capitalize;margin-left:5%;"><b>'.$session_name.'</b></p>';
    echo $output;
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

// Add to cart / Insert record into cart

if(isset($_POST['product_id']) && isset($_POST['cust_id']) && isset($_POST['qty_id']) && isset($_POST['store']))
{
  $product_id = $_POST['product_id'];
  $cust_id = $_POST['cust_id'];
  $qty_id = $_POST['qty_id'];
  $store = $_POST['store'];
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
      $sql = "Insert Into temp_cart (c_id,p_id,qty,product_name,product_price,store) Values ('$cust_id','$product_id','$qty_id','$productName','$price','$store')";
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
  // fetching customer record
  $customer_detail = "Select * from customer where id = '$cust_id'";
  $sqlqueryCustomer = mysqli_query($con,$customer_detail);
  $customer_data = mysqli_fetch_array($sqlqueryCustomer);

  $search_value = $_POST['searchProductData'];
  $sql = "select * FROM product WHERE name LIKE '%$search_value%'";
  $sqlquery = mysqli_query($con,$sql);

    // getting cart count value
    $cart_count = "select count(id) as 'count' from temp_cart where c_id = '$cust_id'";
    $sql_cart_count = mysqli_query($con,$cart_count);
    $cart_data = mysqli_fetch_array($sql_cart_count);

  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
      $output.= '<input class="form-control my-2" type="search" id="searchProduct" onblur="search_prod('.$cust_id.')" name="search" placeholder="Search Product" aria-label="Search" autocomplete="off">
      ';
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '
    <div class="mt-4 ">
    <div class="row align-items-center px-2 py-2 bg-light">
        
      <div class="col-5">
      <h6 style="display: flex;align-items: center;justify-content: space-between;font-size:11px" class="mb-0">'.$row['name'].' <span>('.$row['qty'].')</span></h6>
      </div>

      <div class="col-2">
      <h6 class="float-end mb-0" style="font-size:11px">₹ '.$row['selling_price'].'</h6>
      </div>

      <div class="col-5 d-flex justify-content-end">
        <input type="number" min="0" class="text-center qty" style="height:40px; width:50px;" id="qty'.$row['id'].'" name="qty" placeholder="Qty" value="1">
        <button type="button" class="btn btn-primary" style="height:40px; width:50px; margin-left:20px;"
        onclick="addToCart('.$row['id'].','.$cust_id.',qty'.$row['id'].')">Add</button>
      </div>
  </div>
  </div>
    ';
    } 
    echo '<p class="text-danger" style="text-transform: capitalize;margin-left:5%;"><b>'.$customer_data['name'].'</b></p>';
    echo $output;
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

?>


