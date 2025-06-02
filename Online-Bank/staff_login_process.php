<?php ob_start(); ?>
<?php
include 'db_connect.php';

if (isset($_POST['staff_login-btn'])) {

    if (isset($_POST['staff_id'])) {
        $staff_id = $_POST['staff_id'];
        $password = $_POST['password'];
    }

    $sql = "SELECT * FROM bank_staff WHERE staff_id='$staff_id' AND Password='$password'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($staff_id != $row['staff_id'] && $password != $row['Password']) {
        echo '<script>alert("ID ou senha incorretos.")</script>';
    } else {
        // Inicia sessão do funcionário
        $_SESSION['staff_login'] = true;
        $_SESSION['staff_name'] = $row['staff_name'];
        $_SESSION['staff_id'] = $row['staff_id'];

        // Define data e hora do último login
        date_default_timezone_set('Asia/Kolkata');
        $_SESSION['staff_last_login'] = date("d/m/y h:i:s A");

        // Redireciona para página do perfil do funcionário
        header('location:staff_profile.php');
    }
}
?>