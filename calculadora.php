<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

function factorial($n)
{
    return $n <= 1 ? 1 : $n * factorial($n - 1);
}

if (isset($_POST['calculate'])) {
    $num1 = isset($_POST['num1']) ? $_POST['num1'] : 0;
    $num2 = isset($_POST['num2']) ? $_POST['num2'] : 0;
    $operator = isset($_POST['operator']) ? $_POST['operator'] : '';

    if (!is_numeric($num1) || !is_numeric($num2)) {
        $result = "Erro: Números inválidos";
        $operation = "Erro: Números inválidos";
    } else {
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                $operation = "$num1 + $num2 = $result";
                break;
            case '-':
                $result = $num1 - $num2;
                $operation = "$num1 - $num2 = $result";
                break;
            case '*':
                $result = $num1 * $num2;
                $operation = "$num1 * $num2 = $result";
                break;
            case '/':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                    $operation = "$num1 / $num2 = $result";
                } else {
                    $result = "Erro: Divisão por zero";
                    $operation = "$num1 / $num2 = Erro: Divisão por zero";
                }
                break;
            case 'pow':
                $result = pow($num1, $num2);
                $operation = "$num1 ^ $num2 = $result";
                break;
            case 'fact':
                $result = factorial($num1);
                $operation = "$num1! = $result";
                break;
            default:
                $result = "Operação inválida";
                $operation = "Operação inválida";
        }
    }

    $_SESSION['history'][] = htmlspecialchars($operation);
}

if (isset($_POST['memory'])) {
    if (isset($_SESSION['memory'])) {
        $_POST['num1'] = $_SESSION['memory']['num1'];
        $_POST['num2'] = $_SESSION['memory']['num2'];
        $_POST['operator'] = $_SESSION['memory']['operator'];
        unset($_SESSION['memory']);
    } else {
        $_SESSION['memory'] = [
            'num1' => isset($_POST['num1']) ? $_POST['num1'] : 0,
            'num2' => isset($_POST['num2']) ? $_POST['num2'] : 0,
            'operator' => isset($_POST['operator']) ? $_POST['operator'] : ''
        ];
    }
}

if (isset($_POST['clear_history'])) {
    $_SESSION['history'] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Calculadora</title>
</head>
<body>
    <div class="calculator">
        <h2>Calculadora PHP</h2>
        <form action="" method="post">
            
        <label for="num2">Número 1
            <input type="number" name="num1" placeholder="Número 1" value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : ''; ?>" required> 
            </label>
            <select class="select" name="operator" required>
    <option value="+" <?php echo isset($_POST['operator']) && $_POST['operator'] === '+' ? 'selected' : ''; ?>>+</option>
    <option value="-" <?php echo isset($_POST['operator']) && $_POST['operator'] === '-' ? 'selected' : ''; ?>>-</option>
    <option value="*" <?php echo isset($_POST['operator']) && $_POST['operator'] === '*' ? 'selected' : ''; ?>>*</option>
    <option value="/" <?php echo isset($_POST['operator']) && $_POST['operator'] === '/' ? 'selected' : ''; ?>>/</option>
    <option value="pow" <?php echo isset($_POST['operator']) && $_POST['operator'] === 'pow' ? 'selected' : ''; ?>>Potência (x^y)</option>
    <option value="fact" <?php echo isset($_POST['operator']) && $_POST['operator'] === 'fact' ? 'selected' : ''; ?>>Fatoração (n!)</option>
</select>

        	
            <label for="num2">Número 2
            <input type="number" name="num2" placeholder="Número 2" value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : ''; ?>" required>
            </label>
            <button class="calcularbotao" type="submit" name="calculate">Calcular</button>
        <div class="current-operation">
            <?php if (isset($operation)): ?>
                <p style="
    justify-content: center;
    display: flex;" >Conta atual: <?php echo htmlspecialchars($operation); ?></p>
            <?php endif; ?>
        </div>
        <div class="botoes"> 
            <button class="memoriabotao" type="submit" name="memory">Memória (M)</button>
            <button class="limparbotao" type="submit" name="clear_history">Limpar Histórico</button>
        </div>
        </form>

            <h3>Histórico de Operações</h3>
    <div class="historico">
    <ul>
        <?php
        foreach ($_SESSION['history'] as $op) {
            echo "<li>" . htmlspecialchars($op) . "</li>";
        }
        ?>
    </ul>
    </div> 

    <div>
    <?php
    if (isset($_SESSION['memory'])) {
        $memory_num1 = $_SESSION['memory']['num1'];
        $memory_num2 = $_SESSION['memory']['num2'];
        $memory_operator = $_SESSION['memory']['operator'];
        echo "<p>Valor na memória: " . htmlspecialchars("$memory_num1 $memory_operator $memory_num2") . "</p>";
    }
    ?>
    </div>


</body>
</html>


