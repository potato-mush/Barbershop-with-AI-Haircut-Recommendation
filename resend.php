<?php
session_start();
include("connect.php");

use PHPMailer\PHPMailer\PHPMailer;
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if (!isset($_SESSION['verify_email'])) {
    header("Location: Signup.php");
    exit();
}

$email = $_SESSION['verify_email'];

$code = rand(100000, 999999);
$expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

$stmt = $con->prepare(
    "UPDATE users 
     SET verification_code=?, verification_expires=? 
     WHERE email=?"
);
$stmt->execute([$code, $expires, $email]);

$mail = new PHPMailer(true);
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
$mail->Subject = 'Resent Verification Code';
$mail->Body = "
    <h2>New Verification Code</h2>
    <h1>$code</h1>
    <p><b>This code will expire in 5 minutes.</b></p>
";

$mail->send();

header("Location: verify.php");
exit();
