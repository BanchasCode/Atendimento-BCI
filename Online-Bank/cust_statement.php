<html>
<head>
    <title>Extrato</title>
    <link rel="stylesheet" type="text/css" href="css/cust_statement.css" />
    <style>
        #customer_profile .link5 {
            background-color: rgba(5, 21, 71, 0.4);
        }
    </style>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'customer_profile_header.php' ?>

<?php 
if ($_SESSION['customer_login'] == true) {
    // Usuário logado, continuar normalmente
} else {
    header('location:customer_login.php');
}
?>

<div class="cust_statement_container_head">
    <label class="heading">Extrato Bancário</label>
</div>

<div class="cust_statement_container">
    <div class="cust_statement">
        <table>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>ID da Transação</th>
                <th>Descrição</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
            </tr>

            <?php
            $cust_id = $_SESSION['customer_Id'];
            $sql = "SELECT * FROM passbook_$cust_id ORDER BY Id DESC";
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
                            <td>R$ ' . $row['Net_Balance'] . '</td>
                        </tr>';
                }
            } else {
                echo "<tr><td colspan='7'>Nenhuma transação encontrada.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<br>

<?php include 'footer.php'; ?>
</body>
</html>