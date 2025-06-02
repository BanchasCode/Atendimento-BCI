<html>
<head>
    <title>Minha Conta</title>
    <link rel="stylesheet" type="text/css" href="css/customer_profile_myacc.css" />
    <style>
        #customer_profile .link1 {
            background-color: rgba(5, 21, 71, 0.4);
        }
    </style>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'customer_profile_header.php'; ?>

<?php 
if ($_SESSION['customer_login'] == true) {
    // Usuário logado, continuar normalmente
} else {
    header('location:customer_login.php');
}
?>

<?php 
$cust_id = $_SESSION['customer_Id'];
include 'db_connect.php'; 

$sql = "SELECT * FROM bank_customers WHERE Customer_ID = '$cust_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$current_bal = $row['Current_Balance'];
?>

<div class="cust_myacc_container">
    <br><br>
    <div class="accdet">
        <span class="heading">Detalhes da Conta</span><br>
        
        <label>ID do Cliente: <?php echo $_SESSION['customer_Id']; ?></label>
        <label>Número da Conta: <?php echo $_SESSION['Account_No']; ?></label>
        <label>Nome da Conta: <?php echo $_SESSION['Username']; ?></label>
        <label>Tipo de Conta: <?php echo $_SESSION['Account_type']; ?></label>
        <label>Código IFSC: <?php echo $_SESSION['IFSC_Code']; ?></label>
        <label>Agência: <?php echo $_SESSION['Branch']; ?></label>
        <label>Cheque: <?php echo $_SESSION['Cheque']; ?></label>
        <label>Saldo Disponível: R$<?php echo $current_bal; ?></label>
        <label>Número de Celular: <?php echo $_SESSION['Mobile_no']; ?></label>
        <label>Número do Cartão de Débito: <?php echo $_SESSION['Debit_Card_No']; ?></label>
        <label>Nome do Beneficiário: <?php echo $_SESSION['Nominee_name']; ?></label>
        <label>Número da Conta do Beneficiário: <?php echo $_SESSION['Nominee_ac_no']; ?></label>
        <label>E-mail: <?php echo $_SESSION['Email_ID']; ?></label><br><br><br><br>
        
        <a href="customer_pass_change.php"><input type="button" name="pass-chng" value="Alterar Senha"></a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>