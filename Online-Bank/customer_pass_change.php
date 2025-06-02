<html>
<head>
    <title>Alterar Senha</title>
    <link rel="stylesheet" type="text/css" href="css/customer_pass_change.css"/>
    <style>
        #customer_profile .link3 {
            background-color: rgba(5, 21, 71, 0.4);
        }
    </style>
</head>
<body>

<?php 
include 'header.php';
include 'customer_profile_header.php';

if ($_SESSION['customer_login'] != true) {
    header('location:customer_login.php');
}
?>

<div class="cust_passchng_container">
    <form method="post">
        <br><br>
        <input type="password" name="oldpass" placeholder="Senha Antiga" required><br>
        <input type="password" name="cnfrm" placeholder="Confirme a Senha Antiga" required><br>
        <input type="password" name="newpass" placeholder="Nova Senha" required><br>
        <input type="submit" name="change_pass" value="Alterar Senha"><br><br>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php  
if (isset($_POST['change_pass'])) {

    $oldpass = $_POST['oldpass'];
    $cnfrm = $_POST['cnfrm'];
    $newpass = $_POST['newpass'];

    include 'db_connect.php';
    $customer_id = $_SESSION['customer_Id'];

    $sql = "SELECT Password FROM bank_customers WHERE Customer_ID='$customer_id'";

    if (!$result = $conn->query($sql)) {
        echo "Erro: 1 " . $sql . "<br>" . $conn->error;
    }

    $row = $result->fetch_assoc();

    if ($oldpass == $cnfrm) {

        if ($row['Password'] == $oldpass) {

            $sql2 = "UPDATE bank_customers SET Password='$newpass' WHERE Customer_ID=$customer_id";
            if ($conn->query($sql2) === TRUE) {
                echo '<script>alert("Senha alterada com sucesso!")</script>';
            }

        } else {
            echo '<script>alert("Por favor, digite a senha antiga correta")</script>';
        }

    } else {

        if ($oldpass != $cnfrm) {
            echo '<script>alert("Dois erros\\n1. A senha antiga e a confirmação são diferentes!\\n2. A senha antiga está errada")</script>';
        } else {
            echo '<script>alert("A senha antiga e a confirmação são diferentes!")</script>';
        }

    }
}
?>