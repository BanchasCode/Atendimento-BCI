<?php
$customer_id = $_POST['cust_id'];
$debitcard = $_POST['dbt_crd'];
$dbt_pin = $_POST['dbt_crdpin'];
$mob_no = $_POST['mobile_no'];

include 'db_connect.php';

$sql = "SELECT Username,Password,Customer_ID, Mobile_no,Debit_Card_No,Debit_Card_Pin FROM bank_customers WHERE Customer_ID = '$customer_id'";
$result = $conn->query($sql);

if (!is_numeric($customer_id) || !is_numeric($debitcard) || !is_numeric($dbt_pin) || !is_numeric($mob_no)) {
    echo '<script>alert("Formato incorreto")</script>';
} else {

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($mob_no == $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']) {

            $otp = "SBI" . mt_rand(10000, 99999);
            $_SESSION['cust_id'] = $row['Customer_ID'];
            $_SESSION['forgetpass_otp'] = $otp;

            $hidden_mob_no = substr($mob_no, 0, 3) . "XXXX" . substr($mob_no, 7, 10);

            //--------------------------------------------------------------------------------------	
            // Integração com SMS para envio do OTP -------------------------------------------------
            require('textlocal.class.php');
            $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
            $textlocal = new Textlocal(false, false, $apikey);
            $numbers = array($mob_no);
            $sender = 'TXTLCL';
            $message = 'Olá '.$row['Username'].', seu OTP é: '.$otp;

            try {
                $result = $textlocal->sendSms($numbers, $message, $sender);
                print_r($result);
            } catch (Exception $e) {
                die('Erro: ' . $e->getMessage());
            }

            //--------------------------------------------------------------------------------------				
            //--------------------------------------------------------------------------------------		

            echo '<script>alert("OTP enviado para seu número de celular cadastrado: '.$hidden_mob_no.'\\nPor favor, verifique para recuperar sua senha")
            location="cust_forgetpassotpverify.php"</script>';

        } else {

            if ($mob_no != $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']) {
                echo '<script>alert("Número de celular incorreto.\\nDigite o número cadastrado.")</script>';
            } else {
                if ($mob_no == $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']) {
                    echo '<script>alert("Número do Cartão de Débito incorreto")</script>';
                } else {
                    if ($mob_no == $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']) {
                        echo '<script>alert("PIN do Cartão de Débito incorreto")</script>';
                    } else {
                        if ($mob_no != $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']) {
                            echo '<script>alert("Todos os campos estão incorretos.")</script>';
                        } else {
                            if ($mob_no == $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']) {
                                echo '<script>alert("Detalhes do Cartão de Débito incorretos.")</script>';
                            } else {
                                if ($mob_no != $row['Mobile_no'] && $debitcard != $row['Debit_Card_No']) {
                                    echo '<script>alert("Número do celular e número do cartão de débito não coincidem")</script>';
                                }
                            }
                        }
                    }
                }
            }

        }

    } else {
        echo '<script>alert("Cliente não encontrado!")</script>';
    }

}
?>