<html>
<head>
    <title>Meu Perfil</title>
    <link rel="stylesheet" type="text/css" href="css/customer_profile_myprofile.css">
    <style>
        #customer_profile .link2 {
            background-color: rgba(5, 21, 71, 0.4);
        }
    </style>
</head>
<body>

<?php 
include 'header.php';
include 'customer_profile_header.php';

$cust_id = $_SESSION['customer_Id'];
include 'db_connect.php'; 

$sql = "SELECT * FROM bank_customers WHERE Customer_ID = '$cust_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="myprofile_container">
    <div class="customer_profile_photo">
        <!-- Imagem do perfil comentada por enquanto -->
        <!-- <?php echo '<img class="custmr_img" src="data:image/jpeg;base64,'.base64_encode($row['Customer_Photo']).'"'; ?> onerror="this.src='img/customers/No_image.jpg'" height="130" width="120"/><br> -->
    </div>

    <div class="customer_profile_details">
        <label>Nome: <?php echo $row['Username']; ?></label><br>
        <label>Gênero: <?php echo $row['Gender']; ?></label><br>
        <label>Número de Celular: <?php echo $row['Mobile_no']; ?></label><br>
        <label>Telefone Fixo: <?php echo $row['Landline_no']; ?></label><br>
        <label>Endereço: <?php echo $row['Home_Addr']; ?></label><br>
        <label>Moeda: <?php echo 'INR'; ?></label><br>
        <label>País: <?php echo $row['Country']; ?></label><br>
        <label>Estado: <?php echo $row['State']; ?></label><br>
        <label>Cidade: <?php echo $row['City']; ?></label><br>
        <label>Data de Abertura da Conta: <?php echo $row['Ac_Opening_Date']; ?></label><br>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>