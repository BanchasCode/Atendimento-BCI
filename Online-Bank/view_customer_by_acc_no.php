<html>
<head>
    <title>Detalhes do Cliente</title>
    <link rel="stylesheet" type="text/css" href="css/view_customer_by_acc_no.css" />
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'staff_profile_header.php'; ?>

<div class="view_cust_byac_container_outer">
    <form method="POST">
        <input name="account_no" placeholder="Número da Conta do Cliente"><br>
        <input type="submit" name="submit_view" value="Enviar">
    </form>
</div>

<?php 

if (isset($_POST['submit_view'])) {
    $cust_ac = $_POST['account_no'];
    include 'db_connect.php';

    $sql = "SELECT * FROM bank_customers WHERE Account_no = '$cust_ac'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo '
        <div class="view_cust_byac_container_inner">
            <div class="cust_details">
                <span class="heading">Detalhes do Cliente</span><br>
                <label>ID do Cliente: '.$row['Customer_ID'].'</label>
                <label>Número da Conta: '.$row['Account_no'].'</label>
                <label>Nome do Cliente: '.$row['Username'].'</label>
                <label>Tipo de Conta: '.$row['Account_type'].'</label>
                <label>Código IFSC: '.$row['IFSC_Code'].'</label>
                <label>Agência: '.$row['Branch'].'</label>
                <label>Saldo Disponível: R$'.$row['Current_Balance'].'</label>
                <label>Número de Celular: '.$row['Mobile_no'].'</label>
                <label>Número do Cartão de Débito: '.$row['Debit_Card_No'].'</label>
                <label>Nome do Beneficiário: '.$row['Nominee_name'].'</label>
                <label>Número da Conta do Beneficiário: '.$row['Nominee_ac_no'].'</label>
                <label>E-mail: '.$row['Email_ID'].'</label>
            </div>
        </div>';
    
    } else {
        echo '<script>alert("Cliente não encontrado")</script>';
    }
}

?>

</body>
<?php include 'footer.php'; ?>
</html>