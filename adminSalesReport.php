<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sales Report</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.6.1.min"></script>

</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top flex-md-nowrap shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Joohlibeh <span class="text-muted">(Sales Report)</span></a>
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
                        <a class="nav-link fs-5 mb-2 text-black" href="adminOrdersList.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="adminInventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-danger fw-bold active" aria-current="page" href="adminSalesReport.php">Sale Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 mb-2 text-black" href="home.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 mt-3">Sales Report</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminSalesReport.php">SR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminGraph.php">View Graph</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="datetime-local" name="dateFetch1" class="form-control mb-3 text-center" value="<?php echo(isset($_POST['dateFetch1'])?  $_POST['dateFetch1']: " ") ?>" >
                        <input type="datetime-local" name="dateFetch2" class="form-control mb-3 text-center" value="<?php echo(isset($_POST['dateFetch1'])?  $_POST['dateFetch2']: " ") ?>" >
                        <button type="submit" name="fetch" class="btn btn-success col-12 mb-3">Fetch</button>
                    </form>
                    
                    <form method="POST"><button type="submit" name="showAll" class="btn btn-success col-12 mb-3">Show All</button></form>
                        <div class="col-lg-12">
                            <?php
                                include_once('orderClass.php');

                                if(isset($_POST['fetch']) && !isset($_POST['showAll'])){
                                    $dateFetch1 = $_POST['dateFetch1'];
                                    $dateFetch2 = $_POST['dateFetch2'];
                                    $order = new orderList($dateFetch1,$dateFetch2);
                                    $orderlist =  $order -> getOrderListByDates(); 
                                }
                                else{
                                    $order = new orderList();
                                    $orderlist =  $order -> getApprovedOrderList(); 
                                }
                            ?>
                            <table class="table table-striped" border="10">
                                <thead>
                                    <tr>	
                                        <th scope="col">name</th>
                                        <th scope="col">status</th>
                                        <th scope="col"></th>
                                        <th scope="col">date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($orderlist))
                                        foreach($orderlist as $rows){ ?>
                                        <tr>	   
                                            <td><?php echo $rows['name']; ?></td>
                                            <td><?php echo ($rows['status'] == 1 ? "Approved": "Pending"); ?></td>
                                            <td><a href="adminOrders.php?idAndPic=<?php echo $rows['ordersLinkId'].','.$rows['proofOfPayment']?>">View Order</a></td>
                                            <td><?php echo date('m/d/Y h:i:s a ', strtotime($rows['date'])); ?></td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
    
</body>
</html>