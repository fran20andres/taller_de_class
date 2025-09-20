<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>pares e impares</title>
   <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Bienvenido al identificador de pares e impares usando HTML, PHP y CSS</h1>
    <form method="post" action="">
        <label for="numeros">Lista de números:</label>
        <input
            type="text"
            id="numeros"
            name="numeros"
            placeholder="20, 10, 2, 11, 3"
            required
        />
        <button type="submit">Procesar</button>
    </form>

<?php

class IdentificadorNumeros {
    private $entrada;
    private $resultados = [];

    public function __construct(string $entrada) {
        $this->entrada = $entrada;
    }


    public function procesar(): void {
        $tokens = explode(",", $this->entrada);

        foreach ($tokens as $valor) {
            $valor = trim($valor);
            if ($valor === "") continue;

            if ($this->esEntero($valor)) {
                $num = (int)$valor;
                if ($num % 2 === 0) {
                    $this->resultados[] = ["valor" => $valor, "tipo" => "par"];
                } else {
                    $this->resultados[] = ["valor" => $valor, "tipo" => "impar"];
                }
            } else {
                $this->resultados[] = ["valor" => $valor, "tipo" => "no-entero"];
            }
        }
    }

   
    private function esEntero(string $valor): bool {
        return preg_match('/^[+-]?\d+$/', $valor) === 1;
    }

  
    public function obtenerResultados(): array {
        return $this->resultados;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrada = trim($_POST["numeros"]);
    if ($entrada !== "") {
        $identificador = new IdentificadorNumeros($entrada);
        $identificador->procesar();
        $resultados = $identificador->obtenerResultados();

        echo "<h2>Resultados:</h2>";
        echo "<ul>";
        foreach ($resultados as $res) {
            if ($res["tipo"] === "par") {
                echo "<li>{$res['valor']} es número par</li>";
            } elseif ($res["tipo"] === "impar") {
                echo "<li>{$res['valor']} es número impar</li>";
            } else {
                echo "<li>{$res['valor']} no es un número entero</li>";
            }
        }
        echo "</ul>";
    }
}
?>
</body>
</html>
