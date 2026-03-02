<?php
session_start();
include("connect.php");
date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if(isset($_POST['signup'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1️⃣ check password match
    if($password != $confirm_password){
        $error = "Passwords do not match!";
    } else {

        // 2️⃣ check if email exists
        $stmt = $con->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){
            $error = "Email already registered!";
        } else {

            // 3️⃣ hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 4️⃣ generate verification code + expiry
            $code = rand(100000, 999999);
            $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            // 5️⃣ insert user (NOT verified yet)
            $stmt = $con->prepare(
                "INSERT INTO users 
                (name, email, password, verification_code, verification_expires) 
                VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$name, $email, $hashed_password, $code, $expires]);
                // 🔔 Get the newly inserted user ID
                $user_id = $con->lastInsertId();

                // 🔔 Insert welcome notification
                $notif_stmt = $con->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
                $notif_message = "Thank you for signing up!";
                $notif_stmt->execute([$user_id, $notif_message]);
            // 6️⃣ send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cuttrendz@gmail.com';
                $mail->Password = 'zkmj ervv ckhk hxkn'; // Gmail App Password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('cuttrendz@gmail.com', 'Barber Shop');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification Code';
                $mail->Body = "
                    <h2>Email Verification</h2>
                    <p>Your verification code is:</p>
                    <h1>$code</h1>
                    <p><b>This code will expire in 5 minutes.</b></p>
                ";

                $mail->send();

                $_SESSION['verify_email'] = $email;
                header("Location: verify.php");
                exit();

            } catch (Exception $e) {
                $error = "Email sending failed.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Sign Up - Barber Shop</title>

<style>

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
               url('images/bg.jpg') no-repeat center center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* BOX */
.signup-box{
    background: rgba(0,0,0,0.92);
    padding:30px 40px;
    width:360px;
    border-radius:12px;
    color:white;
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
    display:flex;
    flex-direction:column;
    align-items:center;
    position:relative;
    backdrop-filter: blur(6px);
}

.signup-box form{
    width:100%;
}

.signup-box input,
.signup-box button{
    width:100%;
    box-sizing:border-box;
}

/* LOGO */
.signup-box img{
    width:95px;
    height:auto;
    margin-bottom:8px;
    filter: drop-shadow(0 0 8px rgba(193,155,118,0.6));
}

/* TITLE */
.signup-box h2{
    margin:10px 0 20px 0;
    letter-spacing:3px;
    font-weight:600;
}

/* INPUTS */
.signup-box input{
    padding:12px;
    margin:8px 0;
    border:1px solid rgba(255,255,255,0.1);
    border-radius:6px;
    background:rgba(255,255,255,0.05);
    color:white;
    outline:none;
    transition:0.3s;
}

.signup-box input:focus{
    border:1px solid #c19b76;
    box-shadow:0 0 8px rgba(193,155,118,0.5);
}

/* BUTTON */
.signup-box button{
    padding:12px;
    margin-top:5px;
    background:#c19b76;
    border:none;
    color:white;
    cursor:pointer;
    border-radius:6px;
    font-weight:600;
    letter-spacing:1px;
    transition:0.3s;
}

.signup-box button:hover{
    background:#a37b55;
    box-shadow:0 5px 15px rgba(193,155,118,0.4);
    transform:translateY(-2px);
}

/* LINKS */
.signup-box a{
    color:#c19b76;
    text-decoration:none;
    transition:0.3s;
}

.signup-box a:hover{
    color:white;
}

/* ERROR */
.error{
    color:#ff4d4d;
    text-align:center;
    font-size:14px;
}

/* BACK BUTTON */
.back-btn{
    position:absolute;
    top:15px;
    left:20px;
    color:#c19b76;
    text-decoration:none;
    font-size:14px;
    transition:0.3s;
}

.back-btn:hover{
    color:white;
}

</style>
</head>

<body>

<div class="signup-box">
    <a href="Login.php" class="back-btn">← Back</a>
    <img src="Design/images/sana.png" alt="Barbershop Logo">

<h2 style="text-align:center;">Sign Up</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button type="submit" name="signup">Create Account</button>

</form>

<p style="text-align:center;margin-top:15px;">
Already have account? <a href="login.php">Login</a>
</p>

</div>

</body>
</html>
