<?php
include 'dbcon.php';

$customer_id = $_GET['customerId'];
// fetching cart data
$cartData = "Select * from temp_cart where c_id = '$customer_id'";
$exec_cartData = mysqli_query($con, $cartData);
$cart_details = [];
$totalprice = 0;
while ($row = mysqli_fetch_array($exec_cartData)) {
    array_push($cart_details, $row);
}
// fetching customer details
$getCustomerDetail = "Select * from customer where id = '$customer_id'";
$exec_getCustomerDetail = mysqli_query($con, $getCustomerDetail);
$customer = mysqli_fetch_array($exec_getCustomerDetail);

// fetching payment_mode
$payment_mode = "Select * from payment_mode";
$exec_payment_mode = mysqli_query($con, $payment_mode);
$mode_details = [];
while ($row = mysqli_fetch_array($exec_payment_mode)) {
    array_push($mode_details, $row);
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

    <title>Cart</title>
</head>

<body style="background-color: #f0f2f7;">
    <?php include 'header.php' ?>
    <div class="container">
        <h4>My Shopping Cart</h4>

        <?php
        if (!empty($cart_details)) {
        ?>
            <a href="deleteAllCart.php?cust_id=<?php echo $customer_id; ?>"><button type="button" class="btn-sm btn-danger">Empty Cart</button></a>
            <div class="table-responsive my-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                            <th scope="col">Remove Cart</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart_details as $items) {
                            $totalprice += ((int)$items['product_price'] * (int)$items['qty']);
                            // if (is_numeric($items['product_price']) && is_numeric($items['qty'])) {
                            //     $totalprice += ($items['product_price'] * $items['qty']);
                            //   } else {

                            //   }
                        ?>
                            <tr>
                                <th><?php echo $items['product_name'] ?></th>
                                <td>₹ <?php echo $items['product_price'] ?></td>
                                <td><?php echo $items['qty'] ?></td>
                                <td>₹ <?php echo $items['product_price'] * $items['qty'] ?></td>
                                <td class="text-center"><a class="text-danger" href="deleteCart.php?id=<?php echo $items['id'] ?>&customer_id=<?php echo $customer_id; ?>"><i class="fas fa-times" style="border: 1px solid red; margin-left:10px; padding:4px; border-radius:50%"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <input type="text" class="w-25 float-end" style="border: none; text-align:center;" id="grand_total" value="<?php echo $totalprice ?>" readonly></br>
      
                <div class="row w-100 my-3">
                    <div class="col-6">
                        <h5>Paid</h5>
                        <input type="number" style="max-width:100%;" id="paid_amt" onkeyup="calc_pending_amt()" placeholder="paid amount" value="<?php echo $totalprice ?>">
                    </div>
                    <div class="col-6">
                        <h5>Pending</h5>
                        <input type="number" style="max-width:100%;" id="pending_amt" onkeyup="calc_paid_amt()" placeholder="pending amount" value="0">
                    </div>
                </div>

            <div class="mt-2 paymentOptions">
                <h5>Payment Method</h5>
                <div class="row">
                    <?php
                    foreach ($mode_details as $payment) {
                    ?>
                        <div class="col pe-0">
                            <div class="form-check">
                                <input class="form-check-input radio" value="<?php echo $payment['payment_method'] ?>" type="radio" name="radio" checked id="<?php echo $payment['id'] ?>">
                                <label class="form-check-label" for="flexRadioDefault1" style="font-size:12px;">
                                    <?php echo $payment['payment_method'] ?>
                                </label>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class=" mt-2">
                <button type="button" class="btn btn-primary" onclick="getData('<?php echo $customer['name'] ?>','<?php echo $customer['mobile'] ?>',<?php echo $customer_id ?>)">Place Order</button>
            </div>
            <div id="message" class="alert-success" role="alert"></div>
        <?php
        } else {
            echo '<div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Oops !</h4>
            <p>Your Cart Is Empty</p>
            <hr>
            <p class="mb-0">Please Add Some Items In Your Cart</p>
          </div>';
        }
        ?>

    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<script>
    function calc_pending_amt() {
        var grand_total = document.getElementById("grand_total").value;
        console.log(grand_total);
        var paid_amt = document.getElementById("paid_amt").value;
        console.log(paid_amt);
        var pending_amt = document.getElementById("pending_amt").value = grand_total - paid_amt;
        console.log(pending_amt);
        //   $.ajax({
        //     type: "POST",
        //     url: "searchCustomerProduct.php",
        //     data: {search : search_term},
        //     success: function(data)
        //     {
        //     $('#search-data').html(data);
        //     }
        // });
    }

    function calc_paid_amt() {
        var grand_total = document.getElementById("grand_total").value;
        var pending_amt = document.getElementById("pending_amt").value;
        var paid_amt = document.getElementById("paid_amt").value = grand_total - pending_amt;
    }

    function getData(customer_name, mobile, customer_id) {
        console.log(customer_name, mobile);
        var grand_total = document.getElementById("grand_total").value;
        var paid_amt = document.getElementById("paid_amt").value;
        var pending_amt = document.getElementById("pending_amt").value;

        // getting selected radio button value using js
        var radios = document.querySelectorAll('input[type="radio"]:checked');
        var payment_mode = radios.length > 0 ? radios[0].value : null;

        // via jquery
        // $('input[type=radio]:checked', '.paymentOptions').val()

        // code for insert data
        $.ajax({
            type: "POST",
            url: "placeOrder.php",
            data: {
                customer_id: customer_id,
                customer_name: customer_name,
                mobile: mobile,
                grand_total: grand_total,
                paid_amt: paid_amt,
                pending_amt: pending_amt,
                payment_mode: payment_mode
            },
            success: function(data) {
                // console.log(data);
                document.getElementById('message').innerHTML = data;

                const myTimeout = setTimeout(myGreeting, 1000);

                function myGreeting() {
                    window.location = "dashboard.php";
                }
            }
        });
    }
</script>