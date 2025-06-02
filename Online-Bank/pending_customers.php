<html>
<head>
    <title>Clientes Pendentes</title>
</head>
<link rel="stylesheet" type="text/css" href="css/pending_customers.css"/>
<body>

<?php  
include 'header.php';
include 'staff_profile_header.php';
include 'db_connect.php';
?>

<div class="application_search">
    <form method="post">
        <input type="text" name="application_no" placeholder="Número da Solicitação" required>
        <input type="submit" name="search_application" value="Buscar">
    </form>
</div>

<div class="pending_customers_container">
    <table border="1px" cellpadding="10">
        <tr>
            <th>#</th>
            <th>Número da Solicitação</th>
            <th>Nome</th>
            <th>Gênero</th>
            <th>Celular</th>
            <th>E-mail</th>
            <th>Telefone Fixo</th>
            <th>Data de Nascimento</th>

            <th>Cidadania</th>
            <th>Endereço Residencial</th>
            <th>Endereço Comercial</th>
            <th>País</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Bairro/Localidade</th>
            <th>Nome do Beneficiário</th>
            <th>Número da Conta do Beneficiário</th>
            <th>Tipo de Conta</th>
            <th>Data da Solicitação</th>
        </tr>

        <?php

        if(isset($_POST['search_application'])){
            if(empty($_POST['application_no'])){
                echo '<script>alert("Por favor, digite o número da solicitação")</script>';
            } else {
                $application_no = $_SESSION['application_no'] = $_POST['application_no'];
                $sql = "SELECT * FROM pending_accounts WHERE Application_no = '$application_no'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {   
                    $Sl_no = 1; 
                    while($row = $result->fetch_assoc()) {
                        echo '
                            <tr>
                                <td>'.$Sl_no++.'</td>
                                <td>'.$row['Application_no'].'</td>
                                <td>'.$row['Name'].'</td>
                                <td>'.$row['Gender'].'</td>
                                <td>'.$row['Mobile_no'].'</td>
                                <td>'.$row['Email_id'].'</td>
                                <td>'.$row['Landline_no'].'</td>
                                <td>'.$row['DOB'].'</td>
                                <td>'.$row['PAN'].'</td>
                                <td>'.$row['CITIZENSHIP'].'</td>
                                <td>'.$row['Home_Addr'].'</td>
                                <td>'.$row['Office_Addr'].'</td>
                                <td>'.$row['Country'].'</td>
                                <td>'.$row['State'].'</td>
                                <td>'.$row['City'].'</td>
                                <td>'.$row['Pin'].'</td>
                                <td>'.$row['Area_Loc'].'</td>
                                <td>'.$row['Nominee_name'].'</td>
                                <td>'.$row['Nominee_ac_no'].'</td>
                                <td>'.$row['Account_type'].'</td>
                                <td>'.$row['Application_Date'].'</td>
                            </tr>';
                    }
                } else {
                    echo '<script>alert("Solicitação não encontrada")</script>';
                }
            }
        }

        ?>
    </table>
</div>

<form method="post">
    <div class="approve">
        <input type="submit" name="approve_cust" value="Aprovar">
    </div>
</form>

<?php	
include 'account_approve_process.php';
include 'footer.php'; 
?> 

</body>
</html>