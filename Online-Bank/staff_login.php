<?php
session_start();
if (isset($_SESSION['staff_login'])) {
    header('location:staff_profile.php');
}
?>

<html>
<head>
    <title>Página do Funcionário</title>
    <link rel="stylesheet" type="text/css" href="css/staff_login.css" />
</head>
<body>

<?php include 'header.php'; ?>

<div class="staff_login_container">
    <form method="post">
        <br>
        <div class="formspace">
            <p class="formspace2">
                <div class="form">
                    <label class="login">Funcionário</label>
                    <div class="input_field">
                        <label class="userdetail">ID do Funcionário</label><br>
                        <input class="customer_id" type="text" name="staff_id" required /><br>
                        <label class="userdetail">Senha</label><br>
                        <input class="password" type="password" name="password" required /><br>
                        <input class="login-btn" type="submit" name="staff_login-btn" value="ENTRAR"/><br>
                        <a class="help"><label class="label_help">ESQUECI A SENHA?</label></a>
                        <img class="userloginimg" src="img/home-logo-hi.png" height="90px" width="90px">
                    </div>
                </div>
            </p>
        </div>
    </form>
</div>

<br>

<?php include 'footer.php'; ?>
</body>
</html>

<?php include 'staff_login_process.php'; ?>