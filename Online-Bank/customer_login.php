<?php
ob_start();
session_start();
if (isset($_SESSION['customer_login'])) {
    header('location:customer_profile.php');
}
?>

<html>
<head>
    <title>Página de Login</title>
    <link rel="stylesheet" type="text/css" href="css/customer_login.css" />
</head>
<body>

<?php include 'header.php' ?>

<div class="login_container">
    <form method="post">
        <br>
        <div class="formspace">
            <p class="formspace2">
                <div class="form">
                    <label class="login">LOGIN</label>
                    <div class="input_field">
                        <label class="userdetail">ID do Cliente</label><br>
                        <input class="customer_id" type="text" name="customer_id" required /><br>
                        <label class="userdetail">Senha</label><br>
                        <input class="password" type="password" name="password" required /><br>
                        <input class="login-btn" type="submit" name="login-btn" value="ENTRAR"/><br>
                        <a href="cust_forgetpass.php" class="help"><label class="label_help">ESQUECI A SENHA?</label></a>
                        <img class="userloginimg" src="img/home-logo-hi.png" height="90px" width="90px">
                    </div>
                </div>
            </p>
        </div>
    </form>
    <br>
</div>

<?php include 'footer.php' ?>
</body>
</html>

<?php include 'customer_login_process.php' ?>