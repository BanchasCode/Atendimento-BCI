<?php
session_start();
if ($_SESSION['forgetpass_otp'] == FALSE) {
    header("location:customer_login.php");
}
?>

<html>
<head>
    <title>Verificação de OTP</title>
    <link rel="stylesheet" type="text/css" href="css/cust_forgetpassotpverify.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="cust_forgetpassotpverify">
    <form method="post">
        <input type="text" name="otpcode" placeholder="Código OTP">
        <input type="submit" name="verify-btn" value="Verificar">
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php

// Apenas para demonstração (remover em produção)
// $_SESSION['forgetpass_otp'] = 'SBI20060';

if (isset($_POST['verify-btn'])) {

    if (empty($_POST['otpcode'])) {
        echo '<script>alert("OTP é obrigatório")</script>';
    } else {

        if ($_POST['otpcode'] == $_SESSION['forgetpass_otp']) {

            include 'db_connect.php';
            $cust_id = $_SESSION['cust_id'];
            $sql = "SELECT Password, Username, Mobile_no FROM bank_customers WHERE Customer_ID = $cust_id";
            $result = $conn->query($sql);

            if ($result->num_rows < 0) {
                echo "Falha: " . $sql;
            } else {

                $row = $result->fetch_assoc();
                $pass = $row['Password'];
                $mob = $row['Mobile_no'];
                $cust_name = $row['Username'];
                $hidden_mob_no = substr($mob, 0, 3) . "XXXX" . substr($mob, 7, 10);

                //--------------------------------------------------------------------------------
                // Enviar senha do cliente para o número de celular cadastrado
                // Integração com SMS ------------------------------------

                require('textlocal.class.php');

                $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
                $textlocal = new Textlocal(false, false, $apikey);
                $numbers = array($mob);
                $sender = 'TXTLCL';
                $message = 'Olá '.$cust_name.', sua senha do Internet Banking é: '.$pass;

                try {
                    $result = $textlocal->sendSms($numbers, $message, $sender);
                    print_r($result);
                } catch (Exception $e) {
                    die('Erro: ' . $e->getMessage());
                }

                //-------------------------------------------------------------------------------- 

                unset($_SESSION['cust_id']);
                unset($_SESSION['forgetpass_otp']);

                echo '<script>alert("Senha enviada com sucesso para seu número de celular cadastrado: '.$hidden_mob_no.'\\nPor favor, não compartilhe com ninguém")
                location="customer_login.php";</script>';	

            }

        } else {
            echo '<script>alert("OTP incorreto")</script>';
        }
    }
}

?>