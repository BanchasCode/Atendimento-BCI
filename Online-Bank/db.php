
<?php include 'header.php';
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = new mysqli("localhost", "root", "", "bnkms");
    if ($con->connect_error) die("Erro de conexão");

    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $stmt = $con->prepare("INSERT INTO agendamento (nome_cliente, data_agendamento, hora_agendamento) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $data, $hora);
    $stmt->execute();
    $mensagem = "Agendamento realizado com sucesso!";
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Agendar Atendimento</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <h2>Agendar Atendimento no Banco</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Seu nome" required>
        <input type="date" name="data" required>
        <input type="time" name="hora" required>
        <button type="submit">Agendar</button>
    </form>

    <?php if (!empty($mensagem)): ?>
    <script>
        alert("<?= $mensagem ?>");
    </script>
    <br>
    <br>
    <br>
    <?php endif;
    include 'footer.php'; ?>
</body>
</html>
