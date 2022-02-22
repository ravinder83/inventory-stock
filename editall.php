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
    <!-- <form class="d-flex col-lg-2" action="search.php" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search Items" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form> -->
    <?php if($row['role'] == 1){ ?>
    <form class="d-flex col-lg-2" action="searchedit.php" method="GET">
        <input class="form-control mx-2" type="search" id="search" name="search" placeholder="Search Items" aria-label="Search" autocomplete="off">
        <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
    </form>
    <form id="idform">
      <?php
            foreach ($res as $items)
            { 
              ?>
              <div class="row my-3 mx-2 align-items-center">
                <div class="col-4">
                    <label class="form-label" style="text-transform: capitalize;"><?php echo $items['name'] ?></label></br>
                    <div class="d-flex">
                    <p>Qty -</p>
                    <p id="initial_qty<?php echo $items['id']  ?>"class="all_initial_qty"><?php echo $items['qty'] ?></p>
                    </div>
                </div>

                <div class="col-5 d-flex">
                    <!-- <button type="button" class="btn btn-dark" onclick="inc('id<?php echo $items['id']?>')">+</button> -->
                    <input type="number" class="form-control w-75 h-50 alldata" id="id<?php echo $items['id']  ?>" autocomplete="off">
                    <!-- <button type="button" class="btn btn-dark" onclick="dec('id<?php echo $items['id']?>')">-</button> -->
                </div>

                <div class="col-3">
                    <button type="button" onclick="getSingleData(<?php echo $items['id']  ?>,<?php echo $items['qty']  ?>,'id<?php  echo $items['id']  ?>','initial_qty<?php echo $items['id']  ?>', )" class="btn btn-primary" id="singleUpdate">Update</button>
                </div>

              </div>
              <?php
            }
        ?>
        <?php 
         
            $ar['id']=[];
            foreach($res as $item)
            {
              array_push($ar['id'],$item['id']);
            }
            $encoded_data = json_encode($ar['id']);
            echo '<button type="button" onclick=\'getAllData('.$encoded_data.')\' class="btn btn-primary m-3" style="">Update All</button>';
        ?>

    </form>
    <?php } else{
      echo '<div class="alert alert-danger" role="alert">
            You are Not allowed to update stock
          </div>'; 
    }?>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<script>

function getSingleData(Item_id,qty,current,initial_qty){
  console.log(current);
  var Id=Item_id;
  var QTY=qty;
  var Crt_qty= document.getElementById(current).value;
  var initial_qty = initial_qty;
  //alert(initial_qty)  
  $.ajax({
    type: "POST",
    url: "updatedata.php",
    data: {ItemId:Id,qty:QTY,current_qty:Crt_qty},
    success: function(data)
    {
      if(data ==='true'){
        var old = document.getElementById(initial_qty);
        old.innerHTML = (+QTY) + (+Crt_qty);
        // console.log('Qty - ', (+QTY) + (+Crt_qty));
        document.getElementById(current).value="";
      }
    }
});

}

function getAllData(itemid)
{
  // with jquery
  // var inputs = $(".alldata");
  // var arr = [];     
  //     for(var i = 0; i < inputs.length; i++){
  //       arr.push($(inputs[i]).val());
        
  //   }
    var qty = document.getElementsByClassName('all_initial_qty');
    var prev_qty_arr = [];     
        for(var i = 0; i < qty.length; i++)
        {
          prev_qty_arr.push(qty[i].innerText);       
        }
      //console.log(prev_qty_arr);
    
    var inputs = document.getElementsByClassName('alldata');
    var cur_qty_arr = [];     
        for(var i = 0; i < inputs.length; i++)
        {
          cur_qty_arr.push(inputs[i].value);       
        }
     // console.log(cur_qty_arr);

    $.ajax({
    type: "POST",
    url: "updateAllData.php",
    data: {all_ids:itemid,prev_qty:prev_qty_arr,cur_qty:cur_qty_arr},
    success: function(data)
    {
      var response = JSON.parse(data);
      //console.log(response);
        // console.log(prev_qty_arr);
        // console.log(cur_qty_arr);
        var sum = prev_qty_arr.map((num,ind)=>{
          return (+num) + (+cur_qty_arr[ind]);
        });
        console.log(sum);
      
           var data = document.getElementsByClassName('all_initial_qty');
          for(var i=0;i<data.length;i++)
          {
            //console.log(data[i].innerHTML);
            data[i].innerHTML = sum[i];
            inputs[i].value = "";
            
          }      
    }
  });

}

function inc(ids){
  var val = document.getElementById(ids).value;
  console.log(val);
  if(val === ""){
    val = 0;
  }
  document.getElementById(ids).value=parseInt(val) + 1;
}

function dec(ids){
  var val = document.getElementById(ids).value;
  console.log(val);
  if(val<=0){
         val=1;  
    }
  document.getElementById(ids).value=parseInt(val) - 1;
}

</script>


<!-- jquery/ajax script for search -->
<script>
    $(document).ready(function(){
    // Live search
    $('#search').on('keyup',function(){
      var search_term = $(this).val();
      console.log(search_term);
      $.ajax({
        type: "POST",
        url: "searchedit.php",
        data: {search : search_term},
        success: function(data)
        {
          $('#idform').html(data);
        }
    });
    })

  })
</script>
