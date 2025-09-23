<?php
class Calculadora {
    private $numero;

    public function __construct($numero) {
        $this->numero = $numero;
    }

    public function calcularFibonacci() {
        $fibonacci = [0, 1];
        for ($i = 2; $i < $this->numero; $i++) {
            $fibonacci[] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
        }
        return array_slice($fibonacci, 0, $this->numero);
    }

    public function calcularFactorial() {
        if ($this->numero == 0) {
            return '1';
        }

        $resultado = 1;
        $secuencia = [];
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado *= $i;
            $secuencia[] = $i;
        }
        $secuencia_str = implode(' x ', $secuencia);
        return $secuencia_str . ' = ' . $resultado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora PHP</title>
    <link rel="stylesheet" href="css/fibonacci.css">
</head>
<body>
    <div class="container">
        <div class="resultado">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $numero = $_POST['numero'];
                $operacion = $_POST['operacion'];

                if ($numero >= 0 && $numero <= 100) {
                    $calculadora = new Calculadora($numero);
                    $resultado = '';

                    if ($operacion == 'fibonacci') {
                        $resultado = $calculadora->calcularFibonacci();
                    } elseif ($operacion == 'factorial') {
                        $resultado = $calculadora->calcularFactorial();
                    }

                    echo "<h3>Resultado:</h3>";
                    if (is_array($resultado)) {
                        echo "<p>Sucesión de Fibonacci: " . implode(', ', $resultado) . "</p>";
                    } else {
                        echo "<p>Factorial de {$numero}: " . $resultado . "</p>";
                    }
                } else {
                    echo "<h3>Error:</h3>";
                    echo "<p>El número ingresado debe estar entre 0 y 100.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
