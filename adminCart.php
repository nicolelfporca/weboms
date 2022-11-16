<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin POS</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.6.1.min"></script>

</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top flex-md-nowrap shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Joohlibeh <span class="text-muted">(POS)</span></a>
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</header>

<div class="container-fluid mt-5">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse vh-100 shadow">
            <div class="position-sticky pt-3 sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link fs-2 mb-2 mt-1 text-black fw-bold" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-danger fw-bold active" arie-current="page" href="adminPos.php">Point of Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="adminOrdersList.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="adminInventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="adminSalesReport.php">Sale Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="home.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 mt-3">Point of Sales <span class="text-muted">- View Cart</span></h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminPos.php">POS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminCart.php">View Cart</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-lg-12">
                        <table class="table table-bordered border-dark table-striped mb-3">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">DISH</th>
                                    <th scope="col">COST</th>
                                </tr>
                            </thead>
                            <?php
                                $dishesArr = array();
                                $priceArr = array();
                                $dishesQuantity = array();

                                for($i=0; $i<count($_SESSION['dishes']); $i++){
                                    if(in_array( $_SESSION['dishes'][$i],$dishesArr)){
                                        $index = array_search($_SESSION['dishes'][$i], $dishesArr);
                                        $newCost = $priceArr[$index] + $_SESSION['price'][$i];
                                        $priceArr[$index] = $newCost;
                                    }
                                    else{
                                        array_push($dishesArr,$_SESSION['dishes'][$i]);
                                        array_push($priceArr,$_SESSION['price'][$i]);
                                    }
                                }

                                foreach(array_count_values($_SESSION['dishes']) as $count){
                                    array_push($dishesQuantity,$count);
                                }

                                $total = 0;
                                // getting total price
                                for($i=0; $i<count($priceArr); $i++){
                                    $total += $priceArr[$i];
                                }

                                for($i=0; $i<count($dishesArr); $i++){
                            ?>
                            <tr>
                                <td><?php echo $dishesQuantity[$i];?></td>
                                <td><?php echo $dishesArr[$i];?></td>
                                <td><?php echo '₱ '.$priceArr[$i];?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td colspan="2" class="text-end"><b>TOTAL AMOUNT:</b></td>
                                <td><b>₱ <?php echo $total;?></b></td>
                            </tr>
                        </table>

                        <form method="post">
                            <input class="form-control mb-3" name="cash" type="number" placeholder="Cash Amount"></input>
                            <button class="btn btn-danger col-12 mb-3" id="clear">Clear Order</button>
                            <button class="btn btn-success col-12 mb-3" name="order">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>

<script>
    document.getElementById("pos").onclick = function () {window.location.replace('adminPos.php'); }

    $(document).ready(function () {
        $("#clear").click(function () {
            $.post(
                "method/clearMethod.php", {
                }
            );
            window.location.replace('adminCart.php');
        });
    });
</script>

<script>
    document.getElementById("admin").onclick = function () {window.location.replace('admin.php'); };
    document.getElementById("pos").onclick = function () {window.location.replace('adminPos.php'); };
    document.getElementById("orders").onclick = function () {window.location.replace('adminOrdersList.php'); };
    document.getElementById("ordersQueue").onclick = function () {window.location.replace('adminOrdersQueue.php'); };
    document.getElementById("inventory").onclick = function () {window.location.replace('adminInventory.php'); };
    document.getElementById("salesReport").onclick = function () {window.location.replace('adminSalesReport.php'); };

    document.getElementById("Logout").onclick = function () {window.location.replace('Login.php'); 
    $.post(
        "method/clearSessionMethod.php", {
        }
    );};
  </script>

<?php
    if(isset($_POST['order'])){
        $cash = $_POST['cash'];
        if(empty($cash)){
            echo "<script>alert('Please Enter Your Cash Amount');</script>";
            return;
        }
        if($cash<$total){
            echo "<script>alert('Your Cash Is Less Than Your Total Payment Amount');</script>";
            return;
        }
        include_once('orderClass.php');
        $order = new order($dishesQuantity,$dishesArr,$priceArr,$cash,$total);
        $order-> displayReceipt();
    }
?>
