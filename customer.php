<?php 
    session_start();
    $_SESSION['query'] = null
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <!-- <script src="js/jquery-3.6.1.min"></script> -->

</head>
<body class="bg-light">

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top shadow">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">JoohLibeh <span class="text-muted">(Home)</span></a>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white me-2" href="#">Orders</a>
                </li>
            </ul>
      
            <form class="d-flex">
                <a class="btn btn-outline-light col-12" href="home.php" id="logout" type="button">Logout</a>
            </form>
        </div>
    </div>
    <hr>
</nav>

<!-- content page -->
<section id="home">
    <div class="container mt-5 pt-5 mb-5 text-center">
        <h1 class="fw-normal mb-3">HI COSTUMER!</h1>
        <p class="mb-4">
            This is your email: @email <br>
            This is your username: @username <br>
            This is your password: @password (lagyan ng show if ever kaya) <br>
        </p>
        <img src="https://assets3.thrillist.com/v1/image/2809418/1200x600/scale;" alt="Jollibee" class="mb-5" style="width: 100%; height: 100%;">
    </div>
</section>

<!-- section #contact -->
<section id="contact">
    <footer class="text-center text-lg-start bg-danger">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div class="me-5 d-none d-lg-block">
                <span class="text-white">Get connected with us on social networks:</span>
            </div>
            <div>
                <a href="" class="me-4 text-white link">Facebook</a>
                <a href="" class="me-4 text-white link">Twitter</a>
                <a href="" class="me-4 text-white link">Google</a>
                <a href="" class="me-4 text-white link">Instagram</a>
                <a href="" class="me-4 text-white link">LinkedIn</a>
                <a href="" class="me-4 text-white link">GitHub</a>
            </div>
        </section>

        <section>
            <div class="container mt-3 mb-3">
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100" style="background: none;">
                            <div class="card-body shadow">
                            <input type="text" class="form-control mb-3" placeholder="Your Email">
                                <input type="number" class="form-control mb-3" placeholder="Your Phone Number">
                                <input type="text" class="form-control mb-3" placeholder="Subject">
                                <textarea type="text" class="form-control mb-3" placeholder="Message" rows="5"></textarea>
                                <button type="submit" class="btn btn-light col-12">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-8">
                        <div class="card h-100 shadow">
                            <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 390px">
                                <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center p-4 text-white" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021 Copyright:
            <a class="text-white fw-bold link" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
    </footer>
</section>
    
</body>
</html>

<script>
	document.getElementById("logout").addEventListener("click",function(){
		$.post(
        "method/clearMethod.php");
        window.location.replace('home.php');
    });
    
	// document.getElementById("home").onclick = function () {window.location.replace('customer.php'); };
	// document.getElementById("menu").onclick = function () {window.location.replace('customerMenu.php'); };
	// document.getElementById("customerOrders").onclick = function () {window.location.replace('customerOrdersList.php'); };
</script>