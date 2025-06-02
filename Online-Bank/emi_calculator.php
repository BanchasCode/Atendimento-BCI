<html>
<head>
    <title>Calculadora de EMI</title>
</head>
<body>

<div class="emi_calc_div">
    <form method="post">
        <input type="text" name="amount" placeholder="Valor do Empréstimo" required>
        <input type="text" name="rate" placeholder="Taxa de Juros" required>
        <input type="text" name="tenure" placeholder="Prazo do Empréstimo (Anos)" required>
        <input type="submit" name="submit" value="Calcular">
    </form>
</div>

<?php
if (isset($_POST['submit'])) {

    $amount = $_POST['amount'];
    $rate = $_POST['rate'];
    $tenure = $_POST['tenure'];

    // Convertendo taxa para porcentagem e prazo para meses, se necessário
    $rate_monthly = $rate / 100;
    $tenure_months = $tenure * 12;

    // Fórmula correta de cálculo de EMI:
    // EMI = P * r * (1 + r)^n / ((1 + r)^n - 1)
    $emi = ($amount * $rate_monthly) * pow((1 + $rate_monthly), $tenure_months) / (pow((1 + $rate_monthly), $tenure_months) - 1);

    echo "<h3>EMI Mensal: R$ " . number_format($emi, 2, ',', '.') . "</h3><br>";
    echo "<h3>Pagamento Total (Principal + Juros): R$ " . number_format($emi * $tenure_months, 2, ',', '.') . "</h3><br>";

}
?>

</body>
</html>