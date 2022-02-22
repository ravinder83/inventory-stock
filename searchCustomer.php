<?php
include 'dbcon.php';
// search for products
if(isset($_POST['search'])){
  $search_value = $_POST['search'];
  $sql = "select * FROM customer WHERE name LIKE '%$search_value%' OR mobile LIKE '%$search_value%'";
  $sqlquery = mysqli_query($con,$sql);
  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '<a href="contactDetail.php?cid='.$row['id'].'" style="text-decoration: none; text-transform:capitalize"><div class="alert alert-dark text-center" role="alert">
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

if(isset($_POST['search_item'])){
  $search_item = $_POST['search_item'];
  $sql = "select * FROM product WHERE name LIKE '%$search_item%'";
  $sqlquery = mysqli_query($con,$sql);
  $output = "";
  if(mysqli_num_rows($sqlquery) > 0){
    while ($row = mysqli_fetch_array($sqlquery)){
      $output .= '<div class="my-2 bg-light p-3"><a class="text-dark" href="itemdetail.php?itemid='.$row['id'].'" style="text-decoration: none; text-transform:capitalize">
      <div class="row">
              <div class="col-6">
                <h6>'.$row['name'].'</h6>
              </div>
              <div class="col-3">
              <h6>'.$row['qty'].'</h6>
              </div>
              <div class="col-3">
              <h6 class="float-end">₹ '.$row['selling_price'].'</h6>
              </div>
            </div>
            </a></div>';
    } 
    echo $output;    
  }else{
    $output = '<div class="alert alert-danger" role="alert">
                No Data Found
              </div>';
    echo $output;
  }
}

?>


