<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calculadora de promedio, mediana y moda</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h1>Calculadora de promedio, mediana y moda</h1>
    <form method="post" action="">
        <label for="numeros">Ingrese los números separados por coma:</label>
        <input
            type="text"
            id="numeros"
            name="numeros"
            placeholder="Ejemplo: 2.5, 3, 4.1, 2.5, 6"
            required />
        <button type="submit">Calcular</button>
    </form>

    <?php
    class EstadisticaNumeros
    {
        private $numeros = [];
        private $errores = [];

        public function __construct(string $entrada)
        {
            $this->procesarEntrada($entrada);
        }

        private function procesarEntrada(string $entrada): void
        {
            $tokens = explode(",", $entrada);
            foreach ($tokens as $valor) {
                $valor = trim($valor);
                if ($valor === "") continue;

                if ($this->esNumeroReal($valor)) {

                    $this->numeros[] = (float)$valor;
                } else {
                    $this->errores[] = $valor;
                }
            }
        }

        private function esNumeroReal(string $valor): bool
        {

            return is_numeric($valor);
        }

        public function calcularPromedio(): ?float
        {
            if (count($this->numeros) === 0) return null;
            return array_sum($this->numeros) / count($this->numeros);
        }

        public function calcularMediana(): ?float
        {
            $n = count($this->numeros);
            if ($n === 0) return null;

            $nums = $this->numeros;
            sort($nums);

            $mitad = (int)($n / 2);
            if ($n % 2 === 1) {

                return $nums[$mitad];
            } else {

                return ($nums[$mitad - 1] + $nums[$mitad]) / 2;
            }
        }


        public function calcularModa(): array
        {
            if (count($this->numeros) === 0) return [];

            if (empty($frecuencias)) {
                return [];
            }
            $maxFrecuencia = max($frecuencias);
            $redondeados = array_map(fn($num) => round($num, 4), $this->numeros);
            $frecuencias = array_count_values($redondeados);
            $maxFrecuencia = max($frecuencias);
            if ($maxFrecuencia === 1) {
                return [];
            }

            $modas = [];
            foreach ($frecuencias as $num => $freq) {
                if ($freq === $maxFrecuencia) {
                    $modas[] = $num;
                }
            }
            return $modas;
        }

        public function obtenerNumeros(): array
        {
            return $this->numeros;
        }

        public function obtenerErrores(): array
        {
            return $this->errores;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $entrada = trim($_POST["numeros"]);
        if ($entrada !== "") {
            $estadistica = new EstadisticaNumeros($entrada);

            $errores = $estadistica->obtenerErrores();
            if (count($errores) > 0) {
                echo "<h2>Valores no válidos:</h2><ul>";
                foreach ($errores as $err) {
                    echo "<li>" . htmlspecialchars($err) . " no es un número válido</li>";
                }
                echo "</ul>";
            }

            $numeros = $estadistica->obtenerNumeros();
            if (count($numeros) > 0) {
                $promedio = $estadistica->calcularPromedio();
                $mediana = $estadistica->calcularMediana();
                $moda = $estadistica->calcularModa();

                echo "<h2>Resultados:</h2>";
                echo "<ul>";
                echo "<li>Promedio: " . number_format($promedio, 4) . "</li>";
                echo "<li>Mediana: " . number_format($mediana, 4) . "</li>";

                if (count($moda) === 0) {
                    echo "<li>Moda: No hay moda (todos los valores son únicos)</li>";
                } else {

                    $modas_formateadas = array_map(fn($m) => number_format($m, 4), $moda);
                    echo "<li>Moda: " . implode(", ", $modas_formateadas) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No se ingresaron números válidos para calcular.</p>";
            }
        }
    }
    ?>
</body>

</html>