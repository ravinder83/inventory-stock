<?php
include 'dbcon.php';
// print_r($_POST);
// die();
// $item_id[] = $_POST['all_ids'];
$item_id = [];
foreach($_POST['all_ids'] as $value) {
    //echo $value;
    array_push($item_id,$value);
}
//print_r($item_id);
$prev_qty = $_POST['prev_qty'];
$current_qty = $_POST['cur_qty'];

$updated_qty = array_map(function () {
    return array_sum(func_get_args());
}, $prev_qty, $current_qty);

//print_r($updated_qty);

$rowCount = count($updated_qty);
for($i=0;$i<$rowCount;$i++) 
    {
        //echo $updated_qty[$i].'<br>';
        //echo $item_id[$i].'<br>';
        $sql = "Update product Set qty = '$updated_qty[$i]' Where id='$item_id[$i]'";
        mysqli_query($con,$sql);
    }

    // $sql2 = "Select * from product";
    // $sqlquery2 = mysqli_query($con,$sql2);
    // $res = [];
    // while ($row = mysqli_fetch_array($sqlquery2))
    // {
    //     array_push($res, $row);
    // }
    // print_r($res);

    $sql2 = "select * from product";
    $result2 = mysqli_query($con,$sql2);
    if(mysqli_num_rows($result2) > 0){
        $data =array();
        while($row = mysqli_fetch_assoc($result2))
        {
            $data[] = $row;
        }
    }
    // retutning JSON format data as response to ajax call
    echo json_encode($data);
?>