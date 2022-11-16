<?php
    session_start();

    if(!isset($_SESSION["dishes"]) && !isset($_SESSION["price"])){
        $_SESSION["dishes"] = array();
        $_SESSION["price"] = array();
    }
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
                <h1 class="h2 mt-3">Point of Sales</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminPos.php">POS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminCart.php">View Cart</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-lg-12">
                        <?php
                            include_once('dishesClass.php');
                            $dishes = new dish();
                            $dishes =  $dishes -> getAllDishes();
                        ?>
                        <table class="table table-bordered border-dark table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">DISH</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dishes as $rows){ ?>
                                <tr>
                                    <td><?=$rows['dish']?></td>
                                    <td><?php echo '₱'.$rows['price']; ?></td>
                                    <td><?php $pic = $rows['picName']; echo "<img src='dishesPic/$pic' style=width:100px;height:100px>";?></td>
                                    <td><a href="?order=<?php echo $rows['dish'].",".$rows['price']?>" >Add To Cart</a></td>
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
    if(isset($_GET['order'])){
      $order = explode(',',$_GET['order']);
      $dish = $order[0];
      $price = $order[1];
      array_push($_SESSION['dishes'], $dish);
      array_push($_SESSION['price'], $price);
    }
?>
