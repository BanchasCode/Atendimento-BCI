<?php
ob_start();
include 'header.php';
include 'customer_profile_header.php';

if ($_SESSION['customer_login'] != true) {
    header('location:customer_login.php');
    return 0;
}
?>

<html>
<head>
    <title>Transferência Bancária</title>
    <link rel="stylesheet" type="text/css" href="css/fund_transfer.css"/>
    <style>
        #customer_profile .link4 {
            background-color: rgba(5, 21, 71, 0.4);
        }
    </style>
</head>
<body>

<div class="fundtransfer_conainer">
    <br>
    <span>IMPS (Pagamento Instantâneo 24x7)</span><br><br>

    <div class="fund_transfer">
        <div class="beneficiary_btn">
            <form id="form1" method="post">
                <a href="add_beneficiary.php"><input class="beneficiary" type="submit" name="add_beneficiary" value="Adicionar Beneficiário"></a>
                <input class="beneficiary" type="submit" name="delete_beneficiary" value="Excluir Beneficiário">
                <input class="beneficiary" type="submit" name="view_beneficiary" value="Visualizar Beneficiários">
            </form>
        </div>

        <br>

        <form id="form2" method="post">
            <select name="beneficiary" required>
                <option class="default" value="" disabled selected>Selecione o Beneficiário</option>

                <?php
                    include 'db_connect.php';
                    $cust_id = $_SESSION['customer_Id'];
                    $sql = "SELECT * FROM beneficiary_$cust_id";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['Beneficiary_ac_no'] . '">' . $row['Beneficiary_name'] . ' - ' . $row['Beneficiary_ac_no'] . '</option>';
                    }
                ?>
            </select><br>

            <input type="text" name="trnsf_amount" placeholder="Valor" required><br>
            <input type="text" name="trnsf_remark" placeholder="Observação"><br>
            <input type="submit" name="fnd_trns_btn" value="Enviar"><br>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php

if (isset($_POST['add_beneficiary'])) {
    header("location:add_beneficiary.php");
}

if (isset($_POST['delete_beneficiary'])) {
    header("location:delete_beneficiary.php");
}

if (isset($_POST['view_beneficiary'])) {
    header("location:view_beneficiary.php");
}

?>

<?php 

if (isset($_POST['fnd_trns_btn'])) {

    $_SESSION['trnsf_remark'] = $_POST['trnsf_remark'];

    if (!is_numeric($_POST['trnsf_amount'])) {
        echo '<script>alert("Valor inválido")</script>';
    } else {

        $sender_ac_no = $_SESSION['Account_No']; // Conta do remetente
        $_SESSION['trnsf_amount'] = $trnsf_amount = $_POST['trnsf_amount'];
        
        include 'db_connect.php';

        // Número da conta do beneficiário
        $_SESSION['beneficiary_ac_no'] = $beneficiary_ac_no = $_POST['beneficiary'];

        // Verifica o saldo atual do remetente
        $sql = "SELECT * FROM bank_customers WHERE Account_no = '$sender_ac_no'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['sender_mob'] = $sender_mob = $row['Mobile_no'];
        $sender_name = $row['Username'];

        if ($row['Current_Balance'] < $trnsf_amount) {
            echo '<script>alert("Saldo insuficiente")
                   location="fund_transfer.php";</script>';
        } else {

            // Gera um OTP para confirmação da transferência
            $_SESSION['fund_trnsfer_otp'] = $otp_fund_trnsfer = mt_rand(100,999).mt_rand(100,999);
            $_SESSION['ref_no'] = $ref_no = mt_rand(1000,9999);

            // Integração com SMS para envio do OTP (comentada)
            //-----------------------------------------------------------------------------------
            /*  
            require_once('textlocal.class.php');
            $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
            $textlocal = new Textlocal(false, false, $apikey);
            $numbers = array($sender_mob);
            $sender = 'TXTLCL';
            $message = 'Olá '.$sender_name.', seu código OTP com ref. nº '.$ref_no.' para concluir a transferência é: '.$otp_fund_trnsfer.'';
            
            try {
                $result = $textlocal->sendSms($numbers, $message, $sender);
                print_r($result);
            } catch (Exception $e) {
                die('Erro: ' . $e->getMessage());
            }
            */

            //-----------------------------------------------------------------------------------  

            // Redireciona para página de verificação do OTP
            header("Location:fund_transfer_otp.php");
        }
    }
}

?>