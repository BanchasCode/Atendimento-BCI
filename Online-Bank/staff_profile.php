<?php ob_start(); ?>

<html>
<head>
    <title>Home do Funcionário</title>
    <link rel="stylesheet" type="text/css" href="css/staff_profile.css" />
</head>
<body>

<?php
include 'header.php';
include 'staff_profile_header.php';
?>

<form method="post">
    <div class="staff_options">
        <input type="submit" name="viewdet" value="Visualizar Clientes Ativos"/>
        <input type="submit" name="view_cust_by_ac" value="Visualizar Cliente por Número da Conta"/>
        <input type="submit" name="apprvac" value="Aprovar Conta Pendente"/>
        <!-- <input type="submit" name="view_trans" value="Visualizar Transação"/> -->
        <input type="submit" name="del_cust" value="Excluir Conta de Cliente"/>
        <input type="submit" name="credit_cust_ac" value="Creditar Conta de Cliente"/>
        <input type="submit" name="dbf" value="Confirmar agendamento"/>
    </div>
</form>

<?php include 'footer.php'; ?>
</body>
</html>

<?php

if (isset($_POST['viewdet'])) {
    header('location:active_customers.php');
}

if (isset($_POST['view_cust_by_ac'])) {
    header('location:view_customer_by_acc_no.php');
}

if (isset($_POST['apprvac'])) {
    header('location:pending_customers.php');
}

if (isset($_POST['view_trans'])) {
    echo '<script>alert("Visualizar Transação")</script>';
}

if (isset($_POST['del_cust'])) {
    header('location:delete_customer.php');
}

if (isset($_POST['credit_cust_ac'])) {
    header('location:credit_customer_ac.php');
}
if (isset($_POST['dbf'])) {
    header('location:dbf.php');
}

?>