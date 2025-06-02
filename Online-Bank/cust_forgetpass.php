<html>
<head>
    <title>Esqueci a Senha</title>
    <link rel="stylesheet" type="text/css" href="css/cust_forgetpass.css"/>
</head>
<body>

<?php include 'header.php'; ?>

<div class="forgetpass_container">
    <p>Esqueci a Senha</p>
    <form method="post">
        <input type="text" name="cust_id" placeholder="ID do Cliente" required /><br>
        <input type="text" name="dbt_crd" placeholder="Número do Cartão de Débito" required /><br>
        <input type="text" name="dbt_crdpin" placeholder="PIN do Cartão de Débito" required /><br>
        <input type="text" name="mobile_no" placeholder="Número de Celular Cadastrado" required /><br>
        <input type="submit" name="sendotp" value="Enviar"><br>
    </form><br>
</div>

</body>
</html>

<?php 
include 'footer.php';

if(isset($_POST['sendotp'])){
    session_start();
    include 'cust_forgetpass_validate.php';
}
?>