<?php
    session_start();

    if (!isset($_SESSION['history'])) 
    {
        $_SESSION['history'] = array();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_POST['clear'])) 
        {
            $_SESSION['history'] = array();
        } else {
            $n1 = isset($_POST['n1']) ? $_POST['n1'] : null;
            $n2 = isset($_POST['n2']) ? $_POST['n2'] : null;
            $operation = $_POST['operation'];

            switch ($operation) {
                case 'somar':
                    $result = $n1 + $n2;
                    break;
                case 'subtrair':
                    $result = $n1 - $n2;
                    break;
                case 'multiplicar':
                    $result = $n1 * $n2;
                    break;
                case 'dividir':
                    if ($n2 != 0) 
                    {
                        $result = $n1 / $n2;
                    } else {
                        $result = "Error";
                    }
                    break;
                case 'fatoracao':
                    $result = 1;
                    for ($i = 1; $i <= $n1; $i++) {
                        $result *= $i;
                    }
                    break;
                case 'potencia':
                    $result = pow($n1, $n2);
                    break;
                default:
                    $result = "Operação inválida!";
                    break;
            }

            $_SESSION['history'][] = "$n1 $operation $n2 = $result";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora com Histórico</title>
    <style>
        body 
        {
            background-color: black;
            color: gold;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container 
        {
            width: 400px;
        }

        .btn-group button 
        {
            background-color: black;
            color: skyblue;
            border: 1px solid skyblue;
            border-radius: 5px;
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .btn-group button:focus 
        {
            outline: none;
        }

        .btn-group button:hover 
        {
            background-color: black;
        }

        form input[type="submit"] 
        {
            background-color: black;
            color: green;
            border: 1px solid green;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }

        form input[type="number"],
        form select,
        form input[type="text"] 
        {
            border-radius: 5px;
            border: 1px solid black;
            padding: 5px;
            margin-bottom: 10px;
            display: block;
            width: calc(100% - 12px); /* Adicionado para compensar a largura da borda */
        }

        .history 
        {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post">

            <label for="n1">N1</label>
            <input type="number" name="n1" id="n1" required>

            <label for="operation">Operação</label>
            <select name="operation" id="operation" required>
                <option value="somar">+</option>
                <option value="subtrair">-</option>
                <option value="multiplicar">*</option>
                <option value="dividir">/</option>
                <option value="fatoracao">n!</option>
                <option value="potencia">x^y</option>
            </select>

            <label for="n2">N2</label>
            <input type="number" name="n2" id="n2">

            <label for="result">Resultado</label>
            <input type="text" name="result" id="result" value="<?php if (isset($result)) echo $result; ?>" readonly>

            <input type="submit" value="Calcular">

        </form>

        <div class="btn-group">
            <button id="showHistory">Mostrar Histórico</button>
            <form action="" method="post">
                <button type="submit" name="clear">Limpar Histórico</button>
            </form>
        </div>

        <div class="history">
            <?php
                if (!empty($_SESSION['history'])) 
                {
                    echo "<h3>Histórico de Cálculos:</h3>";
                    foreach ($_SESSION['history'] as $calculo) 
                    {
                        echo "<p>$calculo</p>";
                    }
                } else {
                    echo "<p>Ainda não há cálculos no histórico.</p>";
                }
            ?>
        </div>
    </div>


    <!--JS apenas para mudar o display do historico no CSS-->
    <script>
        document.getElementById("showHistory").addEventListener("click", function() {
            document.querySelector(".history").style.display = "block";
        });
    </script>

</body>
</html>
