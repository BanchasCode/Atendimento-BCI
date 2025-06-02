<?php ob_start() ?>

<html>
<head>
    <title>Formulário de Registro</title>
    <link rel="stylesheet" type="text/css" href="css/customer_reg_form.css"/>
    <?php include 'header.php'; ?>
</head>
<body>

<div class="container_regfrm_container_parent">
    <h3>Formulário de Abertura de Conta Online</h3>
    <div class="container_regfrm_container_parent_child">
        <form method="post">
            <input type="text" name="name" placeholder="Nome" required />
            
            <select name="gender" required>
                <option class="default" value="" disabled selected>Gênero</option>
                <option value="Male">Masculino</option>
                <option value="Female">Feminino</option>
                <option value="Others">Outros</option>
            </select>
            
            <input type="text" name="mobile" placeholder="Número de Celular" required />
            <input type="text" name="email" placeholder="E-mail" />
            <input type="text" name="dob" placeholder="Data de Nascimento" onfocus="(this.type='date')" required />
            <input type="text" name="citizenship" placeholder="Bilhete de identidade" required />
            <input class="address" type="text" name="homeaddrs" placeholder="Endereço Residencial" required />
            <input class="address" type="text" name="officeaddrs" placeholder="Endereço Comercial" />
            <input type="text" name="country" placeholder="País" value="Mocambique" readonly="readonly" />

            <select name="state" required>
                <option class="default" value="" disabled selected>Provincia</option>
                <option value="São Paulo">Maputo</option>
                <option value="Rio de Janeiro">Gaza</option>
                <option value="Minas Gerais">Nampula</option>
                <option value="Bahia">Tete</option>
                <option value="Paraná">Sofala</option>
                <option value="Rio Grande do Sul">Maputo-cidade</option>
                <option value="Pernambuco">Pemba</option>
    
            </select>

    

          
            
            <select name="acctype" required>
                <option class="default" value="" disabled selected>Tipo de Conta</option>
                <option value="Saving">Poupança</option>
                <option value="Current">Corrente</option>
            </select>

            <input type="submit" name="submit" value="Enviar">
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php 

if (isset($_POST['submit'])) {

    session_start();
    $_SESSION['$cust_acopening'] = TRUE;
    $_SESSION['cust_name'] = $_POST['name'];
    $_SESSION['cust_gender'] = $_POST['gender'];
    $_SESSION['cust_mobile'] = $_POST['mobile'];
    $_SESSION['cust_email'] = $_POST['email'];
    $_SESSION['cust_landline'] = $_POST['landline'];
    $_SESSION['cust_dob'] = $_POST['dob'];
    $_SESSION['cust_pan='] = $_POST['pan_no'];
    $_SESSION['cust_citizenship'] = $_POST['citizenship'];
    $_SESSION['cust_homeaddrs'] = $_POST['homeaddrs'];
    $_SESSION['cust_officeaddrs'] = $_POST['officeaddrs'];
    $_SESSION['cust_country'] = $_POST['country'];
    $_SESSION['cust_state'] = $_POST['state'];
    $_SESSION['cust_city'] = $_POST['city'];
    $_SESSION['cust_pin'] = $_POST['pin'];
    $_SESSION['arealoc'] = $_POST['arealoc'];
    $_SESSION['nominee_name'] = $_POST['nominee_name'];
    $_SESSION['nominee_ac_no'] = $_POST['nominee_ac_no'];
    $_SESSION['cust_acctype'] = $_POST['acctype'];

    header('location:cust_regfrm_confirm.php');
}

?>