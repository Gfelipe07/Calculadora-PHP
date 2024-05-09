<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a84b8;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #63b9db;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: black;
        }
        form {
            text-align: center;
        }
        input[type="text"], select, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid black;
            border-radius: 3px;
            font-size: 16px;
        }
        button {
            background-color: #8aeed5;
            color: black;
            cursor: pointer;
        }
        button:hover {
            background-color: #1a84b8;
        }
        .history {
            margin-top: 20px;
        }
        .history p {
            border-bottom: 1px solid #ccc;
            padding: 5px 0;
        }
        .history p:last-child {
            border: none;
        }
        .btn-group {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Calculadora PHP</h2>

    <form action="" method="post">
        <input type="text" name="num1" placeholder="Digite o primeiro número" value="<?php echo isset($_POST['lastCalculation']) ? explode(' ', $_POST['lastCalculation'])[0] : ''; ?>" required>
        <select name="operation">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="text" name="num2" placeholder="Digite o segundo número" value="<?php echo isset($_POST['lastCalculation']) ? explode(' ', $_POST['lastCalculation'])[2] : ''; ?>" required>
        <button type="submit" name="calculate"><Strong>Calcular</Strong></button>
    </form>

    <?php
        session_start();
        function calculate($num1, $num2, $operation) {
            switch ($operation) {
                case '+':
                    return $num1 + $num2;
                case '-':
                    return $num1 - $num2;
                case '*':
                    return $num1 * $num2;
                case '/':
                    if ($num2 == 0) {
                        return "Erro: Divisão por zero";
                    } else {
                        return $num1 / $num2;
                    }
            }
        }

        if (isset($_POST['calculate'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operation = $_POST['operation'];
            $result = calculate($num1, $num2, $operation);
            
            echo "<p><Strong> O resultado de $num1 $operation $num2 é: $result</p> </Strong> ";

            if (!isset($_SESSION['history'])) {
                $_SESSION['history'] = array();
            }
            array_push($_SESSION['history'], "$num1 $operation $num2 = $result");
        }

        if (isset($_POST['clear'])) {
            unset($_SESSION['history']);
        }

        if (isset($_SESSION['history']) && !empty($_SESSION['history'])) {
            $lastCalculation = end($_SESSION['history']);
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="lastCalculation" value="' . htmlspecialchars($lastCalculation) . '">';
           echo '<button type="submit" name="retrieve"><Strong>Recuperar Último Cálculo</Strong></button>';
            echo '</form>';
        }
    ?>

    <div class="btn-group">
        <form action="" method="post">
            <button type="submit" name="clear"><Strong>Limpar Histórico</Strong></button>
        </form>
    </div>

    <div class="history">
        <?php
            if (isset($_SESSION['history'])) {
                echo "<h3>Histórico de Cálculos:</h3>";
                foreach ($_SESSION['history'] as $calculation) {
                    echo "<p>$calculation</p>";
                }
            }
        ?>
    </div>
</div>

</body>
</html>
