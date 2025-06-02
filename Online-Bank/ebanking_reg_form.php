<html>
<head>
    <title>Registro no Internet Banking</title>
    <link rel="stylesheet" type="text/css" href="css/ebanking_reg_form.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="ebanking_reg_form_container_parent">
    <h3>Registro no Internet Banking</h3>
    <div class="ebanking_reg_form_container_child">
        <form method="post">
            <input type="text" name="holder_name" placeholder="Nome do Titular da Conta" required />
            <input type="text" name="accnum" placeholder="Número da Conta" required />
            <input type="text" name="dbtcard" placeholder="Número do Cartão de Débito" required />
            <input type="text" name="dbtpin" placeholder="PIN do Cartão de Débito" required />
            <input type="text" name="mobile" placeholder="Celular Cadastrado (10 Dígitos)" required />
            <input type="text" name="dob" placeholder="Data de Nascimento" onfocus="(this.type='date')" required />
            <input type="text" name="last_trans" placeholder="Última Transação (R$)" required />
            <input type="password" name="password" placeholder="Senha" minlength="7" required />
            <input type="password" name="cnfrm_password" placeholder="Confirmar Senha" required />
            <input type="submit" name="submit" value="Enviar" />
        </form>
    </div>
</div>

<?php  

if (isset($_POST['submit'])) {

    if (
        empty($_POST['holder_name']) || empty($_POST['accnum']) ||
        empty($_POST['dbtcard']) || empty($_POST['dbtpin']) ||
        empty($_POST['mobile']) || empty($_POST['pan_no']) ||
        empty($_POST['dob']) || empty($_POST['password']) ||
        empty($_POST['cnfrm_password'])
    ) {
        echo '<script>alert("Nenhum campo deve ficar vazio")</script>';
    } else {

        include 'db_connect.php';

        $holder_name = $_POST['holder_name'];
        $account_no = $_POST['accnum'];
        $debitcard_no = $_POST['dbtcard'];
        $debitcrd_pin = $_POST['dbtpin'];
        $mobileno = $_POST['mobile'];
        $pan = $_POST['pan_no'];
        $dob = $_POST['dob'];
        $last_trans = $_POST['last_trans'];

        // Sem hash por enquanto
        $password = $_POST['password'];
        $cnfrm_password = $_POST['cnfrm_password'];

        // Obter ID do cliente
        $sql1 = "SELECT * FROM bank_customers WHERE Account_no = '$account_no'";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $custmr_id = $row1['Customer_ID'];

            // Obter última transação (Crédito)
            $sql2 = "SELECT Cr_amount FROM passbook_$custmr_id WHERE Id=(SELECT MAX(Id) FROM passbook_$custmr_id)";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
            $last_trans_cr = $row2['Cr_amount'];

            // Obter última transação (Débito)
            $sql3 = "SELECT Dr_amount FROM passbook_$custmr_id WHERE Id=(SELECT MAX(Id) FROM passbook_$custmr_id)";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();
            $last_trans_dr = $row3['Dr_amount'];

            if ($row1['Username'] != $holder_name) {
                echo '<script>alert("Nome do titular incorreto")</script>';
            } elseif ($row1['Debit_Card_No'] != $debitcard_no) {
                echo '<script>alert("Número do cartão de débito incorreto")</script>';
            } elseif ($row1['Debit_Card_Pin'] != $debitcrd_pin) {
                echo '<script>alert("PIN do cartão de débito incorreto")</script>';
            } elseif ($row1['Mobile_no'] != $mobileno) {
                echo '<script>alert("Número de celular incorreto")</script>';
            } elseif ($row1['PAN'] != $pan) {
                echo '<script>alert("Número do PAN incorreto")</script>';
            } elseif ($row1['DOB'] != $dob) {
                echo '<script>alert("Data de nascimento incorreta\\nDigite conforme consta no seu cartão PAN")</script>';
            } elseif ($row2['Cr_amount'] != $last_trans && $row3['Dr_amount'] != $last_trans) {
                echo '<script>alert("Detalhes da última transação incorretos")</script>';
            } elseif ($password != $cnfrm_password) {
                echo '<script>alert("Senha e confirmação devem ser iguais")</script>';
            } elseif (!empty($row1['Password'])) {
                echo '<script>alert("Você já se cadastrou no Internet Banking. Não é possível registrar novamente\\n\\nUse seu ID do cliente para acessar.")</script>';
            } else {

                // Atualizar senha do cliente
                $sql = "UPDATE bank_customers SET Password='$password' WHERE Customer_ID='$custmr_id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Cadastro realizado com sucesso\\n\\nID do Cliente: '.$custmr_id.' \\n\\nUse esse ID para fazer login")</script>';
                } else {
                    echo '<script>alert("Falha no cadastro")</script>';
                }
            }

        } else {
            echo '<script>alert("Número da conta não encontrado")</script>';
        }
    }
}

?>