<?php
include 'dbcon.php';
// search for products
$search = $_POST['search'];
$sql = "select * FROM product WHERE name LIKE '%$search%'";
$sqlquery = mysqli_query($con,$sql);
$output = "";
$ar['id']=[];
if(mysqli_num_rows($sqlquery) > 0){
  while ($row = mysqli_fetch_array($sqlquery)){
    array_push($ar['id'],$row['id']);
    $output .= '<div class="row my-3 mx-2 align-items-center">
    <div class="col-4">
        <label class="form-label" style="text-transform: capitalize;">'.$row['name'].'</label></br>
        <div class="d-flex">
        <p>Qty -</p>
        <p id="initial_qty'.$row['id'].'"class="all_initial_qty">'.$row['qty'].'</p>
        </div>
    </div>

    <div class="col-5 d-flex">
        <input type="number" class="form-control w-75 h-50 alldata" id="id'.$row['id'].'" autocomplete="off">
    </div>

    <div class="col-3">
        <button type="button" onclick="getSingleData('.$row['id'].','.$row['qty'].',\'id'.$row['id'].'\',\'initial_qty'.$row['id'].'\')" class="btn btn-primary" id="singleUpdate">Update</button>
    </div>

  </div>';
  } 
    
      $encoded_data = json_encode($ar['id']);
      $output .= '<button type="button" style="margin-left:20%;" onclick=\'getAllData('.$encoded_data.')\' class="btn btn-primary">Update All</button>';
      echo $output;    
}else{
  $output = '<div class="alert alert-danger" role="alert">
              No Data Found
            </div>';
  echo $output;
}
?>
