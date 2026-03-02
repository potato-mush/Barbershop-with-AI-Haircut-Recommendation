<?php
session_start();
include("connect.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // PDO prepared statement
    $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row){

        if(password_verify($password, $row['password'])){

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            header("Location: index.php");
            exit();

        } else {
            $error = "Invalid password!";
        }

    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Barber Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                        url('images/bg.jpg') no-repeat center center/cover;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .login-box form{
            width: 100%;
        }
        .login-box input,
        .login-box button{
            width: 100%;
            box-sizing: border-box;
        }
        
       .login-box{
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
        .login-box h2{
            margin:10px 0 20px 0;
            letter-spacing:3px;
            font-weight:600;
        }

.login-box input{
    width:100%;
    padding:12px;
    margin:8px 0;
    border:1px solid rgba(255,255,255,0.1);
    border-radius:6px;
    background:rgba(255,255,255,0.05);
    color:white;
    outline:none;
    transition:0.3s;
}

.login-box input:focus{
    border:1px solid #c19b76;
    box-shadow:0 0 8px rgba(193,155,118,0.5);
} 
        .login-box button{
    width:100%;
    padding:14px; /* mas makapal */
    margin-top:10px;
    background:#c19b76;
    border:none;
    color:white;
    cursor:pointer;
    border-radius:8px;
    font-weight:600;
    letter-spacing:1px;
    font-size:15px; /* para same sa signup */
    transition:0.3s;
}

.login-box button:hover{
    background:#a37b55;
    box-shadow:0 5px 15px rgba(193,155,118,0.4);
    transform:translateY(-2px);
}

.login-box a{
    color:#c19b76;
    text-decoration:none;
    transition:0.3s;
}

.login-box a:hover{
    color:white;
}

        .error{
            color:red;
            text-align:center;
        }
        .login-btn {
    padding: 10px 20px;
    border: 1px solid #c19b76;
    color: #c19b76;
    text-decoration: none;
    transition: 0.3s;
}

.login-btn:hover {
    background: #c19b76;
    color: #fff;
}
.login-box img{
    width:95px;
    height:auto;
    margin-bottom:8px;
    filter: drop-shadow(0 0 8px rgba(193,155,118,0.6));
}


.back-btn{
    position: absolute;
    top: 20px;
    left: 20px;
    color: #c19b76;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.back-btn:hover{
    color: #fff;
}




    </style>
</head>

<body>

<div class="login-box">
    <a href="index.php" class="back-btn">← Back</a>
    <img src="Design/images/sana.png" alt="Barbershop Logo">
    <h2>LOGIN</h2>
    

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <p style="text-align:center;margin-top:15px;">
        Don’t have an account? <a href="Signup.php">Sign Up</a>
    </p>
</div>

</body>
</html>
