<?php
class Numero
{
    private $valor;

    public function __construct($valor)
    {
        $this->valor = $valor;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function esEntero()
    {
        return is_numeric($this->valor) && intval($this->valor) == $this->valor;
    }

    public function esPositivo()
    {
        return $this->esEntero() && $this->valor > 0;
    }
}

class Divisible
{
    private $a;
    private $b;

    public function __construct(Numero $a, Numero $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function comprobar()
    {
        $aVal = $this->a->getValor();
        $bVal = $this->b->getValor();

        // Verificaciones
        if (!$this->a->esEntero() && !$this->b->esEntero()) {
            return "Los números $aVal y $bVal no son enteros.";
        }
        if (!$this->a->esEntero()) {
            return "El número $aVal no es entero";
        }
        if (!$this->b->esEntero()) {
            return "El número $bVal no es entero";
        }

        if (!$this->a->esPositivo() && !$this->b->esPositivo()) {
            return "Los números $aVal y $bVal no son enteros positivos.";
        }
        if (!$this->a->esPositivo()) {
            return "El número $aVal no es entero positivo";
        }
        if (!$this->b->esPositivo()) {
            return "El número $bVal no es entero positivo";
        }

        if ($aVal % $bVal == 0) {
            return "El número $aVal es divisible entre el número $bVal";
        } else {
            return "El número $aVal no es divisible entre el número $bVal";
        }
    }
}

$a = $_POST['a'] ?? null;
$b = $_POST['b'] ?? null;

$numA = new Numero($a);
$numB = new Numero($b);

$divisible = new Divisible($numA, $numB);
$resultado = $divisible->comprobar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/index.css">
    <title>Resultado divisibilidad</title>
</head>

<body>
    <div class="container">
        <h2>Resultado:</h2>
        <p class="resultado"><?= $resultado ?></p>
        <a href="index.html">Volver</a>
    </div>

</body>

</html>