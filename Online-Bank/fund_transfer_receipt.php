<?php
// Verificação de login (exemplo — descomente conforme necessário)
/*
if ($_SESSION['Customer_login'] == FALSE) {
    header("location:customer_login.php");
}
*/
?>

<html>
<head>
    <title>Recibo</title>

    <style>
        .receipt_container {
            color: #2C4E86;
            width: 40%;
            margin: 5% auto;
            background-color: #d9f7f4;
            padding: 20px;
            border: 1px solid rgba(44, 78, 134, 0.5);
            font-family: Arial, sans-serif;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .receipt_container label {
            display: block;
            margin: 10px 5%;
            font-size: 16px;
        }

        .receipt_container h2 {
            text-align: center;
            color: #1a3b69;
        }
    </style>
</head>
<body>

<?php 
include 'header.php';
include 'customer_profile_header.php'; 
?>

<div class="receipt_container">
    <h2>Comprovante de Transferência</h2>
    
    <label>Para: <?php echo "Nome do Beneficiário"; ?></label>
    <label>De: <?php echo $_SESSION['Username'] ?? "Nome do Cliente"; ?></label>
    <label>Valor: R$ <?php echo $_POST['amount'] ?? "0.00"; ?></label>
    <label>ID da Transação: <?php echo mt_rand(100000, 999999); ?></label>
    <label>Data: <?php echo date("d/m/Y"); ?></label>
    <label>Hora: <?php echo date("H:i:s"); ?></label>
</div>

<?php include 'footer.php'; ?>

</body>
</html>