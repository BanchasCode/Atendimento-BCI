<?php 
include 'header.php';
include 'customer_profile_header.php';

if ($_SESSION['customer_login'] == FALSE) {
    header('location:customer_login.php');
}
?>

<html>
<head>
    <title>Meu Perfil</title>
    <link rel="stylesheet" type="text/css" href="css/customer_profile.css" />
</head>
<body>

<?php 
$cust_id = $_SESSION['customer_Id'];
include 'db_connect.php'; 

$sql = "SELECT * FROM bank_customers WHERE Customer_ID = '$cust_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$current_bal = $row['Current_Balance'];
?>

<div class="cust_profile_container">
    <div class="acc_details">
        <span class="heading">Detalhes da Conta</span><br>
        <label>ID do Cliente: <?php echo $_SESSION['customer_Id']; ?></label>
        <label>Número da Conta: <?php echo $_SESSION['Account_No']; ?></label>
        <label>Nome da Conta: <?php echo $_SESSION['Username']; ?></label>
        <label>Tipo de Conta: <?php echo $_SESSION['Account_type']; ?></label>
        <label>Saldo Disponível: R$<?php echo $current_bal; ?></label>
    </div>

    <div class="statement">
        <label class="heading">Extrato Bancário</label>
        <table>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Data</th>
                <th width="15%">ID Trans.</th>
                <th width="31%">Descrição</th>
                <th width="10%">Crédito</th>
                <th width="10%">Débito</th>
                <th width="20%">Saldo</th>
            </tr>

            <?php
            $cust_id = $_SESSION['customer_Id'];
            $sql = "SELECT * FROM passbook_$cust_id ORDER BY Id DESC LIMIT 10";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $Sl_no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <tr>
                            <td>' . $Sl_no++ . '</td>
                            <td>' . $row['Transaction_date'] . '</td>
                            <td>' . $row['Transaction_id'] . '</td>
                            <td>' . $row['Description'] . '</td>
                            <td>' . $row['Cr_amount'] . '</td>
                            <td>' . $row['Dr_amount'] . '</td>
                            <td>R$' . $row['Net_Balance'] . '</td>
                        </tr>';
                }
            } else {
                echo "<tr><td colspan='7'>Nenhuma transação encontrada.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>