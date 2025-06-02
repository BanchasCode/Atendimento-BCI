<html>
<head>
    <title>Adicionar Funcionário</title>
</head>
<body>

<?php 
include 'header.php';
include 'admin_profile_header.php';
?>

<div class="add_staff_container">
<br>
<form method="post">
    <input type="text" name="Staff_name" placeholder="Nome do Funcionário" required><br>
    <input type="text" name="Mobile_no" placeholder="Número de Celular (10 Dígitos)" required><br>
    <input type="text" name="email" placeholder="E-mail" required><br>
    
    <select name="gender" required>
        <option value="" disabled selected>Gênero</option>
        <option value="Male">Masculino</option>
        <option value="Female">Feminino</option>
    </select><br>

    <input type="text" name="pan_no" placeholder="Número do PAN" required><br>
    <input type="text" name="citizenship" placeholder="Número da Cidadania" required><br>
    <input type="date" name="dob" required><br>

    <select name="dept" required>
        <option value="" disabled selected>Departamento</option>
        <option value="Revenue">Receita</option>
        <option value="Cash Deposit">Depósito em Dinheiro</option>
    </select><br>

    <input type="text" name="address" placeholder="Endereço"><br>
    <input type="submit" name="submit" value="Adicionar Funcionário"><br>
</form><br>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php
if(isset($_POST['submit'])){

    include 'db_connect.php';

    $staff_name = $_POST['Staff_name'];
    $staff_id = '1011'.mt_rand(100,999);
    $staff_password = mt_rand(100000,999999);
    $staff_mobile_no = $_POST['Mobile_no'];
    $staff_email = $_POST['email'];
    $staff_gender = $_POST['gender'];
    $staff_department = $_POST['dept'];
    $staff_dob = $_POST['dob'];
    $staff_pan_no = $_POST['pan_no'];
    $staff_citizenship = $_POST['citizenship'];
    $staff_address = $_POST['address'];

    $sql = "INSERT INTO bank_staff (Staff_name, Staff_id, Password, Mobile_no, Email_id, Gender,
    Department, DOB, CITIZENSHIP, PAN, Home_addr)
    VALUES ('$staff_name', '$staff_id', '$staff_password', '$staff_mobile_no', '$staff_email', '$staff_gender',
    '$staff_department', '$staff_dob', '$staff_citizenship', '$staff_pan_no', '$staff_address') ";

    if($conn->query($sql) === TRUE){
        echo '<script>alert("Novo funcionário adicionado com sucesso\\n\\nID do funcionário: '.$staff_id.'\\n\\nSenha: '.$staff_password.'")</script>';
    } else {
        echo "<br>Erro: " . $sql . "<br>" . $conn->error;
    }

}
?>