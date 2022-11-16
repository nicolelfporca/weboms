<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.1.min"></script>

</head>
<body>

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

                <!-- register form -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card shadow">
                        <div class="card-body py-5 px-md-5">
                            <form method="post">
                                <h1 class="fw-normal text-center mb-5">Register an account</h1>
                                <input type="text" class="form-control form-control-lg" name="username" placeholder="Enter Username" required></br>
                                <input type="text" class="form-control form-control-lg" name="name" placeholder="Enter Name" required></br>
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Enter Email" required></br>
                                <input type="password" class="form-control form-control-lg mb-3" name="password" placeholder="Enter Password" required></br>
                                <button type="submit" class="btn btn-lg btn-danger col-12 mb-3 shadow" name="createAccount">Create Account</button><br>
                                <div class="text-muted text-center">
                                    Already have an account? <a href="#" class="login_link text-muted" id="back">Log in</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
</body>
</html>

<script>
    document.getElementById("back").addEventListener("click",function(){
        window.location.replace('login.php');
    });
</script>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    if(isset($_POST['createAccount'])){
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        include_once('connection.php');
        $otp = uniqid();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        //Load Composer's autoloader
        require 'vendor/autoload.php';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
          
        try {
            //Server settings
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'webBasedOrdering098@gmail.com'; //from //SMTP username
            $mail->Password   = 'cgzyificorxxdlau';                     //SMTP password
            $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption
            $mail->Port       =  465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      
            //Recipients
            $mail->setFrom('webBasedOrdering098@gmail.com', 'webBasedOrdering');
            $mail->addAddress("$email");                                //sent to
      
            //Content
            $mail->Subject = 'OTP';
            $mail->Body    = $otp;
      
            $mail->send();
              
        }catch (Exception $e) {
            echo "<script>window.location.replace('register.php'); alert('Error: $mail->ErrorInfo');</script>";
            return;
        }

        if($conn->query("insert into user_tb(username, name, email, otp, password) values('$username','$name','$email','$otp','$hash')"))
            echo "<script>window.location.replace('login.php'); alert('OTP sent please verify your account first!');</script>";
        else
            echo '<script type="text/javascript">alert("failed to save to database");window.location.replace("login.php");</script>';  
    }
?>