<html>
<head>
    <title>Home do Funcionário</title>
    <link rel="stylesheet" type="text/css" href="css/credit_customer_ac.css" />
</head>
<body>

<?php
include 'header.php';
include 'staff_profile_header.php';
?>

<div class="cust_credit_container">
    <form method="post">
        <input class="customer" type="text" name="customer_account_no" placeholder="Número da Conta do Cliente" required><br>
        <input class="customer" type="text" name="credit_amount" placeholder="Valor" required><br>
        <input class="customer" type="submit" name="credit_btn" value="Creditar">
    </form><br>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php 
if(isset($_POST['credit_btn'])){

    $cust_ac_no = $_POST['customer_account_no'];
    $credit_amount = $_POST['credit_amount'];

    if(!is_numeric($_POST['credit_amount'])){
        echo '<script>alert("Valor inválido")</script>';
    } else { 

        include 'db_connect.php';

        // Detalhes do cliente necessários para a transação
        $sql = "SELECT * FROM bank_customers WHERE Account_no = $cust_ac_no";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $customer_ac_no = $row['Account_no'];
            $customer_id = $row['Customer_ID'];
            $customer_name = $row['Username'];
            $customer_ifsc = $row['IFSC_Code'];
            $customer_mob = $row['Mobile_no'];
            $customer_netbal = $row['Current_Balance'] + $credit_amount;
            $customer_passbk = "passbook_".$customer_id;

            // Gera o ID da transação
            $transaction_id = mt_rand(100,999).mt_rand(1000,9999).mt_rand(10,99);
            
            // Data da transação
            date_default_timezone_set('Asia/Kolkata'); 
            $transaction_date = date("d/m/y h:i:s A");
            
            // Observação ou descrição
            $remark = "Depósito em Dinheiro";
                
            // Descrição da transação
            $Transac_description = "Depósito em Dinheiro/".$transaction_id;
            
            $date_time = date("d/m/y h:i:s A");

            // SMS de notificação da transação (comentado)
            //-------------------------------------------------------------------------------------
            //-------------------Para o cliente----------------------------------------------------
            
            /*
            require('textlocal.class.php');
            $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
            $textlocal = new Textlocal(false,false,$apikey);
            $numbers = array($customer_mob);
            $sender = 'TXTLCL';
            $hidden_ac_no  = "XXXXXXXX".substr($customer_ac_no ,8 , 13);
            $message = 'Sua conta nº '.$hidden_ac_no.' foi creditada com R$'.$credit_amount.' em '.$date_time.'. ID da transação: '.$transaction_id.'' ;
        
            try {
                $result = $textlocal->sendSms($numbers, $message, $sender);
                print_r($result);
            } catch (Exception $e) {
                die('Erro: ' . $e->getMessage());
            }
            */

            //-------------------------------------------------------------------------------------

            // Desativa o autocommit
            $conn->autocommit(FALSE);
        
            // Adiciona o valor ao saldo disponível do cliente
            $sql1 = "UPDATE bank_customers SET Current_Balance = '$customer_netbal' WHERE bank_customers.Account_no = '$customer_ac_no'";
                
            // Insere o registro no extrato do cliente
            $sql2 = "INSERT INTO $customer_passbk (Transaction_id, Transaction_date, Description, Cr_amount, Dr_amount, Net_Balance, Remark)
                     VALUES ('$transaction_id', '$transaction_date', '$Transac_description', '$credit_amount', '0', '$customer_netbal', '$remark')";
                
            if($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE ){
                $conn->commit();
                echo '<script>alert("Valor creditado com sucesso na conta do cliente")</script>';
            } else {
                echo '<script>alert("Transação falhou\\n\\nMotivo:\\n\\n'.$conn->error.'")</script>';
                $conn->rollback();
            }

        } else {
            echo '<script>alert("Número da conta incorreto")</script>';
        }

    }

}
?>