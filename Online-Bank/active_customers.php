<html>
<head>
    <title>Clientes Ativos</title>
</head>
<link rel="stylesheet" type="text/css" href="css/active_customers.css"/>
<body>

<?php  
    include 'header.php';
    include 'staff_profile_header.php';
    include 'db_connect.php';
?>

<div class="active_customers_container">

<table border="1px" cellpadding="10">
    <tr>
        <th>#</th>
        <th>Nome do Usuário</th>
        <th>ID do Cliente</th>
        <th>Número da Conta</th>
        <th>Número de Celular</th>
        <th>E-mail</th>
        <th>Data de Nascimento</th>
        <th>Saldo Atual</th>
        <th>Cidadania</th>
        <th>Número do Cartão de Débito</th>
        <th>CVV</th>
        <th>Último Login</th>
        <th>Última Transação</th>
        <th>Status da Conta</th>
    </tr>

<?php

    $sql = "SELECT * from bank_customers";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {	   
        $Sl_no = 1; 
        
        // Exibir dados de cada linha
        while($row = $result->fetch_assoc()) {
            
            echo '
                <tr>
                    <td>'.$Sl_no++.'</td>
                    <td>'.$row['Username'].'</td>
                    <td>'.$row['Customer_ID'].'</td>
                    <td>'.$row['Account_no'].'</td>
                    <td>'.$row['Mobile_no'].'</td>
                    <td>'.$row['Email_ID'].'</td>
                    <td>'.$row['DOB'].'</td>
                    <td>R$ '.$row['Current_Balance'].'</td>
                    <td>'.$row['PAN'].'</td>
                    <td>'.$row['CITIZENSHIP'].'</td>
                    <td>'.$row['Debit_Card_No'].'</td>
                    <td>'.$row['CVV'].'</td>
                    <td>'.$row['Last_Login'].'</td>
                    <td>R$ '.$row['LastTransaction'].'</td>
                    <td>'.$row['Account_Status'].'</td>
                </tr>';
        }
    }

?>

</table>
</div>

<?php include 'footer.php'; ?> 
</body>
</html>