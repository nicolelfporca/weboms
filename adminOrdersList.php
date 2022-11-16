<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.6.1.min"></script>

</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top flex-md-nowrap shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Joohlibeh <span class="text-muted">(Orders)</span></a>
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
                        <a class="nav-link fs-5 mb-2 text-black" href="adminPos.php">Point of Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-danger fw-bold active" aria-current="page" href="adminOrdersList.php">Orders</a>
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
                <h1 class="h2 mt-3">Orders</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminOrdersList.php">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminOrders.php">View Order</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-lg-12">
                        <table class="table table-bordered border-dark table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">NAME</th>
                                    <th scope="col">
                                        <form method="post">
                                            <button type="submit" name="showAll" class="btn btn-light">SHOW/HIDE ALL</button>
                                        </form>
                                        </br>
                                        ORDERS ID
                                        </th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col">APPROVAL STATUS:</th>
                                    <th scope="col">ORDER STATUS:</th>
                                    <th scope="col">DATE & TIME:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    session_start();
                                    include_once('orderClass.php');
                                    $orderlist = new orderList();
                                    if($_SESSION['query'] != 'all')
                                    $resultSet =  $orderlist -> getNotOrdersComplete();
                                    else
                                    $resultSet =  $orderlist -> getOrderList();
                                    if($resultSet != null)
                                    foreach($resultSet as $rows){ ?>
                                <tr>
                                    <td><?php echo $rows['name']; ?></td>
                                    <td><?php echo $rows['ordersLinkId'];?></td>
                                    <td><a href="adminOrders.php?idAndPic=<?php echo $rows['ordersLinkId'].','.$rows['proofOfPayment']?>">View Order</a></td>
                                    <td><?php
                                        if($rows['status'] == 1){
                                        echo "Already Approved";
                                        }
                                        else{
                                        ?><a href="?status=<?php echo $rows['ordersLinkId'].','.$rows['email']; ?>">Approve</a><?php
                                        }?>
                                        </td>
                                    <td><a href="?orderComplete=<?php echo $rows['ordersLinkId'] ?>">Order Complete</a></td>
                                    <td><a href="method/deleteOrderMethod.php?idAndPicnameDelete=<?php echo $rows['ID'].','.$rows['proofOfPayment'].','.$rows['ordersLinkId'] ?>">Delete</a></td>
                                    <td><?php echo ($rows['status'] == 1 ? "Approved": "Pending"); ?></td>
                                    <td><?php echo ($rows['isOrdersComplete'] == 1 ? "Order Complete": "Preparing"); ?></td>
                                    <td><?php echo date('m/d/Y h:i a ', strtotime($rows['date'])); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>

<?php
    if(isset($_GET['status'])){
        $arr = explode(',',$_GET['status']);
        $ordersLinkId = $arr[0];
        $email = $arr[1];
        $order = new order($ordersLinkId,$email);
        $order-> computeOrder();
        $order-> sendReceiptToEmail();
        $order-> approveOrder();
    }
    if(isset($_GET['orderComplete'])){
        $id = $_GET['orderComplete'];
        $orderlist =  orderList::withID($id);
        $orderlist -> setOrderComplete();
    }
    if(isset($_POST['showAll'])){
        if($_SESSION['query'] == 'all')
        $_SESSION['query'] = null;
        else
        $_SESSION['query'] = 'all';
        echo "<script>window.location.replace('adminOrdersList.php');</script>";
    }
?>
