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

<?php
    include_once('connection.php');
    $sold = 0;
    $initialCost = 0;
    $stock = 0;
    $profit = 0;
    $sql = mysqli_query($conn,"select * from dishes_tb");  
            
    if (mysqli_num_rows($sql)) { 
        while($rows = mysqli_fetch_assoc($sql)){
            $initialCost += $rows['cost'];
            $stock = $rows['stock'];  
            // $stock += $rows['stock'];
        }
        $initialCost = ($initialCost * $stock);
        // print_r($initialCost);
    }

    $sql = mysqli_query($conn,"select dishes_tb.*, order_tb.* from dishes_tb inner join order_tb where dishes_tb.orderType = order_tb.orderType");  
    if (mysqli_num_rows($sql)) { 
        while($rows = mysqli_fetch_assoc($sql)){
            $sold += ($rows['price']*$rows['quantity']);
            // $stock += $rows['stock'];
        }
    }
?>

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
                            <a class="nav-link text-black" href="adminSalesReport.php">SR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminGraph.php" id="viewGraph">View Graph</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-lg-12">
                        <table class="table table-bordered border-dark">
                            <tr>
                                <td><b>TOTAL INITIAL COST</b></td>
                                <td><?php echo '₱'.$initialCost?></td>
                            </tr>
                            <tr>
                                <td><b>TOTAL AMOUNT SOLD</b></td>
                                <td><?php echo '₱'.$sold?></td>
                            </tr>
                            <tr>
                                <td><b>TOTAL PROFIT</b></td>
                                <td><?php echo (($sold-$initialCost)<0 ? 'no profit': '₱'.($sold-$initialCost))?></td>
                            </tr>
                            <tr>
                                <td><b>LOSS</b></td>
                                <td><?php echo ($initialCost-$sold)<0 ? 'no loss': '₱'.($initialCost-$sold)?></td>
                            </tr>
                        </table>
                        <div class="col-lg-12" id="piechart" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
    
</body>
</html>

<script>
    document.getElementById("viewSalesReport").onclick = function () {window.location.replace('adminSalesReport.php'); };

    //graphs
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartPie);
    
    //pie
    function drawChartPie() {
        var data = google.visualization.arrayToDataTable([
            ['name', 'cost'],
            ['sold',<?php echo $sold?>],
            ['initial cost',<?php echo $initialCost?>]
        ]);

        var options = {
            title: '',
            backgroundColor: 'transparent',
            is3D: true,
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    
    }
</script>