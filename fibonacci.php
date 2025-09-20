<?php

class Calculadora {
    // Atributo privado para almacenar el número
    private $numero;

    // Constructor para inicializar el número
    public function __construct($numero) {
        $this->numero = $numero;
    }

    // Método público para calcular la sucesión de Fibonacci
    public function calcularFibonacci() {
        $fibonacci = [0, 1];

        // Generamos la secuencia de Fibonacci hasta el número especificado
        for ($i = 2; $i < $this->numero; $i++) {
            $fibonacci[] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
        }

        return array_slice($fibonacci, 0, $this->numero); // Devolvemos solo los primeros N números
    }

    // Método público para calcular el factorial y mostrar la secuencia multiplicativa
    public function calcularFactorial() {
        if ($this->numero == 0) {
            return '1';  // El factorial de 0 es 1, pero lo mostramos como una cadena
        }

        $resultado = 1;
        $secuencia = [];

        // Calculamos el factorial y formamos la secuencia multiplicativa
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado *= $i;
            $secuencia[] = $i;  // Agregamos cada número a la secuencia
        }

        // Convertimos la secuencia a una cadena con "x" entre los números
        $secuencia_str = implode(' x ', $secuencia);

        return $secuencia_str . ' = ' . $resultado; // Mostramos la secuencia seguida del resultado final
    }
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST['numero'];
    $operacion = $_POST['operacion'];

    // Crear una instancia de la clase Calculadora
    $calculadora = new Calculadora($numero);

    // Variable para almacenar el resultado
    $resultado = '';

    // Según la operación seleccionada, realizamos el cálculo correspondiente
    if ($operacion == 'fibonacci') {
        $resultado = $calculadora->calcularFibonacci();  // Calculamos la sucesión de Fibonacci
    } elseif ($operacion == 'factorial') {
        $resultado = $calculadora->calcularFactorial();  // Calculamos el factorial
    }

    // Mostrar el resultado
    echo "<h3>Resultado:</h3>";
    if (is_array($resultado)) {
        echo "Sucesión de Fibonacci: " . implode(', ', $resultado);
    } else {
        echo "Factorial de {$numero}: " . $resultado;
    }
}

?>
