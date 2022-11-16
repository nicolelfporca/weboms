<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inventory</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.1.min"></script>

</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top flex-md-nowrap shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Joohlibeh <span class="text-muted">(Inventory)</span></a>
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
                        <a class="nav-link fs-5 mb-2 text-danger fw-bold active" aria-current="page" href="adminInventory.php">Inventory</a>
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
                <h1 class="h2 mt-3">Inventory</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="adminInventory.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="adminInventoryUpdate.php">Update</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <button id="addButton" type="button" class="btn btn-success col-12 mb-3" data-bs-toggle="modal" data-bs-target="#loginModal">Add New Dish</button>
                    <div class="table-responsive col-lg-12">
			            <table class="table table-bordered border-dark table-striped">
			                <thead class="table-dark">
			                    <tr>	
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">DISH</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">COST</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
			                    </tr>
			                </thead>
			                <tbody>
			  	                <?php 
                                    include('dishesClass.php');
                                    $dish = new dish();
                                    $result = $dish -> getAllDishes();
                                    if($result != null)
                                        foreach($result as $rows){
                                ?>
			                    <tr>	   
                                    <td><?php $pic = $rows['picName']; echo "<img src='dishesPic/$pic' style=width:100px;height:100px>";?></td>
                                    <td><?=$rows['dish']?></td>
                                    <td><?php echo '₱'.$rows['price']; ?></td>
                                    <td><?php echo '₱'.$rows['cost']; ?></td>
                                    <td><?php echo $rows['stock']; ?></td>
                                    <td><a href="?idAndPicnameDelete=<?php echo $rows['orderType']." ".$rows['picName'] ?>">Delete</a></td>
                                    <td><a href="adminInventoryUpdate.php?idAndPicnameUpdate=<?php echo $rows['orderType']." ".$rows['dish']." ".$rows['price']." ".$rows['picName']." ". $rows['cost']." ".$rows['stock'] ?>"  >Update</a></td>
			                    </tr>
			                    <?php } ?>
			                </tbody>
			            </table>
		            </div>
                </div>
            </div>

            <div class="modal fade" role="dialog" id="loginModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <form method="post" class="form-group" enctype="multipart/form-data">
                                <input type="text" class="form-control mb-3" name="dishes" placeholder="Enter Dish Name" required>
                                <input type="number" class="form-control mb-3" name="price" placeholder="Enter Price" required>
                                <input type="number" class="form-control mb-3" name="cost" placeholder="Enter Cost" required>
                                <input type="number" class="form-control mb-3" name="stock" placeholder="Enter Number of Stock" required>
                                <input type="file" class="form-control mb-3" name="fileInput" required>
                                <button type="submit" class="btn btn-success col-12" name="insert">Insert</button>
                            </form>
                            <?php
                                //delete 
                                if (isset($_GET['idAndPicnameDelete'])){
                                    $arr = explode(' ',$_GET['idAndPicnameDelete']);
                                    $id = $arr[0];
                                    $pic = $arr[1];
                                    $dish = new dish($id, $pic);
                                    $dish ->deleteDishOnDatabase();
                                }

                                //insert
                                if(isset($_POST['insert'])){
                                    $dishes = $_POST['dishes'];
                                    $price = $_POST['price'];
                                    $cost = $_POST['cost'];
                                    $file = $_FILES['fileInput'];
                                    $stock = $_POST['stock'];
                                    if($price < $cost){
                                    echo "<script>alert('Cost should be less than price!'); window.location.replace('adminInventory.php');</script>";
                                    return;
                                    }
                                    $fileName = $_FILES['fileInput']['name'];
                                    $fileTmpName = $_FILES['fileInput']['tmp_name'];
                                    $fileSize = $_FILES['fileInput']['size'];
                                    $fileError = $_FILES['fileInput']['error'];
                                    $fileType = $_FILES['fileInput']['type'];
                                    $fileExt = explode('.',$fileName);
                                    $fileActualExt = strtolower(end($fileExt));
                                    $allowed = array('jpg','jpeg','png');

                                    if(in_array($fileActualExt,$allowed)){
                                        if($fileError === 0){
                                            if($fileSize < 10000000){
                                                $fileNameNew = uniqid('',true).".".$fileActualExt;
                                                $fileDestination = 'dishesPic/'.$fileNameNew;
                                                move_uploaded_file($fileTmpName,$fileDestination);         
                                                $dish = new dish($dishes, $price, $fileNameNew, $cost, $stock);
                                                $dish->insertNewDishToDatabase();        
                                                echo "<script>window.location.replace('adminInventory.php')</script>";                                
                                            }
                                            else
                                                echo "your file is too big!";
                                        }
                                        else
                                            echo "there was an error uploading your file!";
                                    }
                                    else
                                        echo "you cannot upload files of this type";     
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
    
</body>
</html>