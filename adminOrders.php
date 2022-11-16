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
                <h1 class="h2 mt-3">Orders <span class="text-muted">- View Order</span></h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminOrdersList.php">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminOrders.php">View Order</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-lg-12">
                        <?php
                            $arr = explode(',',$_GET['idAndPic']);
                            $id = $arr[0];
                            $pic = $arr[1];
                            include_once('orderClass.php');
                            $order = orderList::withID( $id );
                            $arr =  $order -> getAllOrderById();
                        ?>
                        <table class="table table-bordered border-dark table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <!-- <th scope="col">price</th> -->
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total = 0;
                                    if($arr != null)
                                    foreach($arr as $rows){ ?>
                                <tr>
                                    <?php $price = ($rows['price']*$rows['quantity']);  $total += $price;?>
                                    <td><?php echo $rows['quantity']; ?></td>
                                    <td><?php echo $rows['dish']; ?></td>
                                    <td><?php echo '₱' .$price?></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td colspan="2" class="text-end"><b>TOTAL AMOUNT:</b></td>
                                    <td><b>₱ <?php echo $total?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        <h3>PROOF OF PAYMENT:</h3>
                        <?php echo "<img src='payment/$pic' style=width:300px;height:500px>";?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
