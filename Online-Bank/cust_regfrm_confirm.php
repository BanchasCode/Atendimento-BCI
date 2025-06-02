<?php 
session_start();
if (!isset($_SESSION['$cust_acopening'])) {
    header('location:customer_reg_form.php');
}
?>

<html>
<head>
    <title>Confirmar</title>
    <link rel="stylesheet" type="text/css" href="css/cust_regfrm_confirm.css" />
    <?php include 'header.php'; ?>
</head>
<body>

<div class="cust_regfrm_cnfrm_container">
    <div class="cnfrm_info">
        <span><?php echo "Nome : ".$_SESSION['cust_name']."<br>"; ?></span>
        <span><?php echo "Gênero : ".$_SESSION['cust_gender']."<br>"; ?></span>
        <span><?php echo "Número de Celular : ".$_SESSION['cust_mobile']."<br>"; ?></span>
        <span><?php echo "E-mail : ".$_SESSION['cust_email']."<br>"; ?></span>
        <span><?php echo "Telefone Fixo : ".$_SESSION['cust_landline']."<br>"; ?></span>
        <span><?php echo "Data de Nascimento : ".$_SESSION['cust_dob']."<br>"; ?></span>
        <span><?php echo "Número do PAN : ".$_SESSION['cust_pan=']."<br>"; ?></span>
        <span><?php echo "Número da Cidadania : ".$_SESSION['cust_citizenship']."<br>"; ?></span>
        <span><?php echo "Endereço Residencial : ".$_SESSION['cust_homeaddrs']."<br>"; ?></span>
        <span><?php echo "Endereço Comercial : ".$_SESSION['cust_officeaddrs']."<br>"; ?></span>
        <span><?php echo "País : ".$_SESSION['cust_country']."<br>"; ?></span>
        <span><?php echo "Estado : ".$_SESSION['cust_state']."<br>"; ?></span>
        <span><?php echo "Cidade : ".$_SESSION['cust_city']."<br>"; ?></span>
        <span><?php echo "CEP : ".$_SESSION['cust_pin']."<br>"; ?></span>
        <span><?php echo "Bairro/localidade : ".$_SESSION['arealoc']."<br>"; ?></span>
        <span><?php echo "Nome do Beneficiário : ".$_SESSION['nominee_name']."<br>"; ?></span>
        <span><?php echo "Número da Conta do Beneficiário : ".$_SESSION['nominee_ac_no']."<br>"; ?></span>
        <span><?php echo "Tipo de Conta : ".$_SESSION['cust_acctype']."<br>"; ?></span><br>

        <form method="post">
            <div class="cnfrm-btn">
                <div class="btn_innerdiv">
                    <input class="cnfrm-submit-btn" type="submit" name="cnfrm-submit" value="Confirmar" />
                    <input class="cnfrm-submit-btn" type="button" value="Voltar" onclick="history.back()" />
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php' ?>
</body>
</html>

<?php

if (isset($_POST['cnfrm-submit'])) {

    include 'db_connect.php';
    $application_no = rand(1000, 9999) . mt_rand(10000, 99999);
    $name = $_SESSION['cust_name'];
    $gender = $_SESSION['cust_gender'];
    $mobile = $_SESSION['cust_mobile'];
    $email = $_SESSION['cust_email'];
    $landline = $_SESSION['cust_landline'];
    $dob = $_SESSION['cust_dob'];
    $pan = $_SESSION['cust_pan='];
    $citizenship = $_SESSION['cust_citizenship'];
    $homeaddrs = $_SESSION['cust_homeaddrs'];
    $officeaddr = $_SESSION['cust_officeaddrs'];
    $country = $_SESSION['cust_country'];
    $state = $_SESSION['cust_state'];
    $city = $_SESSION['cust_city'];
    $pin = $_SESSION['cust_pin'];
    $arealoc = $_SESSION['arealoc'];
    $nominee_name = $_SESSION['nominee_name'];
    $nominee_ac_no = $_SESSION['nominee_ac_no'];
    $acctype = $_SESSION['cust_acctype'];

    date_default_timezone_set('Asia/Kolkata'); 
    $application_dt = date("d/m/y h:i:s A");

    $sql = "INSERT INTO pending_accounts (
        Application_no, Name, Gender, Mobile_no, Email_id, Landline_no, DOB, PAN, CITIZENSHIP,
        Home_Addr, Office_Addr, Country, State, City, Pin, Area_Loc, Nominee_name, Nominee_ac_no, Account_type, Application_Date
    ) VALUES (
        '$application_no', '$name', '$gender', '$mobile', '$email', '$landline', '$dob', '$pan', '$citizenship',
        '$homeaddrs', '$officeaddr', '$country', '$state', '$city', '$pin', '$arealoc', '$nominee_name', '$nominee_ac_no', '$acctype', '$application_dt'
    )";

    if ($conn->query($sql) === TRUE) {

        // Desativado por padrão — envio de SMS para confirmação da aplicação
        /*
        require('textlocal.class.php');
        $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
        $textlocal = new Textlocal(false, false, $apikey);
        $numbers = array($mobile);
        $sender = 'TXTLCL';
        $message = 'Olá '.$name.', seu número de solicitação para abertura de conta é '.$application_no.'. Por favor, visite a agência mais próxima para concluir o processo. Obrigado por escolher nosso banco. Boas transações.';
        
        try {
            $result = $textlocal->sendSms($numbers, $message, $sender);
            print_r($result);
        } catch (Exception $e) {
            die('Erro: ' . $e->getMessage());
        }
        */

        unset($_SESSION['$cust_acopening']);

        echo '<script>
            alert("Solicitação enviada com sucesso\\n\\nNúmero da solicitação: '.$application_no.'\\n\\nPor favor, visite a agência com o número da solicitação para aprovação da conta\\n\\nDica: Pelo login do funcionário, aprove a solicitação");
            location="index.php"
        </script>';

    } else {
        echo $sql;
    }

}
?>