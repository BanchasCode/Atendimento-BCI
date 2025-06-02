<html>
<head>
    <title>Solicitar Cartão de Débito</title>
    <link rel="stylesheet" type="text/css" href="css/debit_card_form.css">
</head>
<body>

<?php include 'header.php' ?>

<div class="debit_card_form_container">
    <br>
    <form method="POST">
        <input type="text" name="holder_name" placeholder="Nome do Titular da Conta"><br>
        <input type="text" name="dob" placeholder="Data de Nascimento" onfocus="(this.type='date')"><br>
        <input type="text" name="mob" placeholder="Celular Cadastrado (10 Dígitos)"><br>
        <input type="text" name="acc_no" placeholder="Número da Conta"><br>
        <input type="submit" name="dbt_crd_submit" value="Enviar"><br>
    </form>
</div>

<?php include 'footer.php' ?>
</body>
</html>

<?php

if (isset($_POST['dbt_crd_submit'])) {
    $holder_name = $_POST['holder_name'];
    $dob = $_POST['dob'];
    $pan = $_POST['pan'];
    $mob = $_POST['mob'];
    $acc_no = $_POST['acc_no'];

    if (empty($_POST['holder_name']) || empty($_POST['dob']) || empty($_POST['pan']) || empty($_POST['mob']) || empty($_POST['acc_no'])) {
        echo '<script>alert("Nenhum campo deve ficar vazio")</script>';
    } else {

        include 'db_connect.php';
        $sql = "SELECT * FROM bank_customers WHERE Account_no = '$acc_no'";
        $result = $conn->query($sql);

        if ($result->num_rows <= 0) {
            echo '<script>alert("Nenhuma conta encontrada com os dados fornecidos")</script>';
        } else {

            $row = $result->fetch_assoc();

            if (!is_numeric($mob) || strlen($mob) != 10) {
                echo '<script>alert("Número de celular inválido\\nPor favor, digite um número de celular válido com 10 dígitos")</script>';
            } elseif ($mob != $row['Mobile_no']) {
                echo '<script>alert("Por favor, digite seu número de celular cadastrado")</script>';
            } elseif ($holder_name != $row['Username']) {
                echo '<script>alert("Nome do titular incorreto")</script>';
                echo $row['Username'];
            } elseif ($dob != $row['DOB']) {
                echo '<script>alert("Data de nascimento incorreta\\nDigite conforme consta no seu cartão PAN")</script>';
            } elseif ($pan != $row['PAN']) {
                echo '<script>alert("Número do PAN incorreto")</script>';
            } else {

                // Código para emitir o cartão de débito, pois todos os dados estão corretos
                $mob_no = $row['Mobile_no'];

                if ($row['Debit_Card_No'] === NULL) {

                    $debit_card = "4213" . mt_rand(1000,9999) . mt_rand(1000,9999);
                    $debit_card_pin = mt_rand(10,99) . mt_rand(10,99);

                    $sql = "UPDATE bank_customers SET Debit_Card_No = '".$debit_card."', Debit_Card_Pin = '".$debit_card_pin."' WHERE Account_no = '$acc_no'";

                    if ($conn->query($sql) === TRUE) {

                        // Integração com SMS para enviar detalhes do cartão de débito (comentado)
                        //--------------------------------------------------------------------------------------
                        /*  
                        require('textlocal.class.php');
                        $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
                        $textlocal = new Textlocal(false, false, $apikey);
                        $numbers = array($mob_no);
                        $sender = 'TXTLCL';
                        $message = 'Olá '.$row['Username'].' Seu número do Cartão de Débito é: '.$debit_card.' e o PIN gerado automaticamente é: '.$debit_card_pin.'. Por favor, mude o PIN assim que possível.';
                        
                        try {
                            $result = $textlocal->sendSms($numbers, $message, $sender);
                            print_r($result);
                        } catch (Exception $e) {
                            die('Erro: ' . $e->getMessage());
                        }
                        */
                        //--------------------------------------------------------------------------------------

                        echo '<script>alert("Cartão de débito emitido com sucesso.\\n\\nEle será entregue no seu endereço em breve.\\n\\nSeu número do cartão de débito é: '.$debit_card.' e o PIN é: '.$debit_card_pin.'\\n\\nPor favor, mude esse PIN assim que possível.")</script>';

                    }

                } else {
                    echo '<script>alert("Você já solicitou um cartão de débito\\n\\nSeu número do cartão é: '.$row['Debit_Card_No'].'")</script>';
                }

            }
        }
    }
}
?>