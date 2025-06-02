<html>
<head>
    <title>Imagem de Perfil</title>
    <link rel="stylesheet" type="text/css" href="css/cust_photo_upload.css"/>
</head>
<body>

<?php 
ob_start();
include 'header.php';
include 'customer_profile_header.php';

if ($_SESSION['customer_login'] != true) {
    header('location:customer_login.php');
}
?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="file_upload">
        <input type="file" name="image" required><br><br>
        <input type="submit" name="submit" value="Enviar">
    </div>
</form>
<br>

<?php

if (isset($_POST['submit'])) {

    $file = $_FILES['image']['tmp_name'];
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = getimagesize($_FILES['image']['tmp_name']);

    if ($image_size == FALSE) {
        echo '<script>alert("O arquivo selecionado não é uma imagem.\\nPor favor, selecione um arquivo de imagem.")</script>';
    } else {
        include 'db_connect.php';
        $customer_id = $_SESSION['customer_Id'];

        // Atualiza a foto do cliente
        $sql = "UPDATE bank_customers SET Customer_Photo='$image' WHERE Customer_ID=$customer_id";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Foto enviada com sucesso!")</script>';
            header('location:customer_profile.php');
        } else {
            echo '<script>alert("Erro ao atualizar foto.\\nTente novamente.")</script>';
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

} else {
    echo '<script>alert("Por favor, selecione um arquivo de imagem para enviar.")</script>';
}

include 'footer.php';
?>

</body>
</html>