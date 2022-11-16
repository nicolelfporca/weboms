<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.6.1.min"></script>

</head>
<body>
<?php include_once('connection.php');?>

<section class="">
    <div class="px-4 py-5 px-md-5 text-center text-lg-start bg-danger vh-100">
        <div class="container container2">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight text-light">
                        Welcome to <br />
                        JoohLibeh!
                    </h1>
                    <p class="text-light">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p>
                </div>

                <!-- login form -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card shadow">
                        <div class="card-body py-5 px-md-5">
                            <form method="post">
                                <div class="form-outline mb-4">
                                    <h1 class="fw-normal text-center mb-5">Log in to your account</h1>
                                    <input class="form-control form-control-lg mb-0" type="text" name="username" placeholder="Username" required></br>
                                    <input class="form-control form-control-lg mb-0" type="password" name="password" placeholder="Password" required></br>
                                    <div class="mt-0 mb-4">
                                        <a href="#" class="pass text-muted">Forgot Password?</a>
                                    </div>
                                    <button class="btn btn-lg btn-danger col-12 mb-3 shadow" type="submit" name="login" value="login">Login</button><br>
                                    <div class="text-center text-muted">
                                        Not a member? <a href="register.php" class="signup_link text-muted">Sign up</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal otp -->
<div class="modal fade" id="otpModal" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content container">
            <div class="modal-body">
                <form method="post" class="form-group">
                    <h3>Please Enter your OTP:</h3>
                    <input type="text" class="form-control" placeholder="otp" name="otp" >          
                    <input data-dismiss="modal" type="submit" value="Cancel" name="Cancel">
                    <input type="submit" value="Resend" name="Resend">
                    <input type="submit" value="Verify" name="Verify">
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
    if(isset($_POST['login'])){
        $_SESSION["username"]  = $_POST['username'];
        $username = $_POST['username'];
        $password = $_POST['password'];
            
        if(empty($username) || empty($password)){
            echo '<script type="text/javascript">alert("Please complete details!");</script>';
            echo "<script>window.location.replace('login.php')</script>";
            return;
        }
            
        // admin block
        if($_POST['username'] === 'admin'){
            $query = "select * from admin_tb";
            $resultSet = $conn->query($query);
                
            if($resultSet->num_rows  > 0){
                foreach($resultSet as $rows){
                    $valid = password_verify($password, $rows['password']);
                }
                if($valid)
                    echo "<SCRIPT> location.replace('admin.php');</SCRIPT>";
                else
                    echo "<SCRIPT>  window.location.replace('login.php'); alert('incorrect username or password!');</SCRIPT>";
            }
            else
                echo "<SCRIPT>  window.location.replace('login.php'); alert('$conn->error');</SCRIPT>";
        }
            
        else{ // user block
            $query = "select * from user_tb where username = '$username'";
            $resultSet = $conn->query($query);
                
            if($resultSet->num_rows  > 0){
                foreach($resultSet as $rows){
                    $valid = password_verify($password, $rows['password'])?true:false;
                    $otp = $rows['otp'];
                    $userlinkId = $rows['userlinkId'];
                }
                if($valid && $otp == ""){
                    $_SESSION['userlinkId'] = $userlinkId;
                    echo "<SCRIPT> window.location.replace('customer.php?username=$username');  </SCRIPT>";
                }
                else if($valid && $otp != ""){
                    echo "<script type='text/javascript'>$('#otpModal').modal('show');</script>";
                }
                else
                    echo "<SCRIPT>alert('incorrect username or password!');</SCRIPT>";
            }
            else
                echo "<SCRIPT>alert('incorrect username or password!');</SCRIPT>";
        }
    }

    if(isset($_POST['Verify'])){
        $username = $_SESSION["username"];
        $otp = $_POST['otp'];
        $readQuery = "select * from user_tb where username = '$username' && otp = '$otp' ";
        $result = mysqli_query($conn,$readQuery);
            
        if(mysqli_num_rows($result) === 1){
            while($rows = mysqli_fetch_assoc($result))
                $_SESSION['userlinkId'] = $rows['userlinkId'];
                $updateQuery = "UPDATE user_tb SET otp='' WHERE otp='$otp'";
                if(mysqli_query($conn, $updateQuery))
                    echo "<SCRIPT> window.location.replace('customer.php?username=$username'); </SCRIPT>";
        }
        else
            echo  '<script type="text/javascript">alert("Incorrect Otp!"); window.location.replace("login.php");</script>';
    }
?>