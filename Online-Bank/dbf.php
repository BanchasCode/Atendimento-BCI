<?php include 'header.php';
$con = new mysqli("localhost", "root", "", "bnkms");
if ($con->connect_error) die("Erro de conexão");

$mensagem = "";
if (isset($_GET['id']) && isset($_GET['acao'])) {
    $id = $_GET['id'];
    $acao = $_GET['acao'];
    if (in_array($acao, ['confirmado', 'negado'])) {
        $con->query("UPDATE agendamento SET estado='$acao' WHERE id=$id");
        $mensagem = "Agendamento foi " . ($acao == 'confirmado' ? "confirmado" : "negado") . " com sucesso!";
    }
}

$resultado = $con->query("SELECT * FROM agendamento");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Agendamentos</title>
     <link rel="stylesheet" type="text/css" href="css/index.css">
     <style>
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: center; }
        a { margin: 0 5px; }
    </style>

</head>
<body>
    <h2>Lista de Agendamentos</h2>
    <table>
        <tr>
            <th>Cliente</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
        <?php while($row = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nome_cliente'] ?></td>
            <td><?= $row['data_agendamento'] ?></td>
            <td><?= $row['hora_agendamento'] ?></td>
            <td><?= $row['estado'] ?></td>
            <td>
                <a href="?id=<?= $row['id'] ?>&acao=confirmado">Confirmar</a>
                <a href="?id=<?= $row['id'] ?>&acao=negado">Negar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (!empty($mensagem)): ?>
    <script>
        alert("<?= $mensagem ?>");
        window.location.href = "dbf.php";
    </script>
    <br>
    <br>
    <br>
    <?php endif; 
     include 'footer.php';?>
</body>
</html>
