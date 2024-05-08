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



