<?php
session_start();
include("connect.php");

if (isset($_POST['verify'])) {
    $code = trim($_POST['code']);
    $email = $_SESSION['verify_email'];

    $stmt = $con->prepare(
        "SELECT verification_expires 
         FROM users 
         WHERE email=? AND verification_code=?"
    );
    $stmt->execute([$email, $code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if (strtotime($user['verification_expires']) >= time()) {

            $update = $con->prepare(
                "UPDATE users 
                 SET is_verified=1, verification_code=NULL, verification_expires=NULL 
                 WHERE email=?"
            );
            $update->execute([$email]);

            unset($_SESSION['verify_email']);
            header("Location: Login.php?verified=1");
            exit();

        } else {
            $error = "Code expired. Please resend.";
        }

    } else {
        $error = "Invalid verification code.";
    }
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Email Verification</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
               url('images/bg.jpg') no-repeat center center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.verify-box{
    background:rgba(0,0,0,0.85);
    padding:40px;
    width:350px;
    border-radius:8px;
    color:white;
    text-align:center;
}

.verify-box input{
    width:100%;
    padding:10px;
    margin:15px 0;
    border:none;
    border-radius:4px;
    box-sizing:border-box;
}

.verify-box button{
    width:100%;
    padding:10px;
    background:#c19b76;
    border:none;
    color:white;
    cursor:pointer;
    margin-top:10px;
}

.verify-box button:hover{
    opacity:0.9;
}

.resend-btn{
    background:transparent;
    border:1px solid #c19b76;
    color:#c19b76;
    margin-top:10px;
}

.error{
    color:#ff6b6b;
    margin-top:10px;
}

.note{
    font-size:14px;
    color:#ccc;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="verify-box">

<h2>Email Verification</h2>

<p class="note">
Enter the 6-digit code sent to your email.<br>
<b>This code will expire in 5 minutes.</b>
</p>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="code" placeholder="Verification Code" required>
    <button name="verify">Verify</button>
</form>

<form action="resend.php" method="POST">
    <button class="resend-btn">Resend Code</button>
</form>

</div>

</body>
</html>