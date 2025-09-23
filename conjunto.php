<?php
class Conjunto
{
    protected $elementos;

    public function __construct($cadena)
    {
        $this->elementos = array_map('intval', explode(',', $cadena));
        $this->elementos = array_unique($this->elementos);
    }

    public function getElementos()
    {
        return $this->elementos;
    }
}

class OperacionesConjuntos extends Conjunto
{
    private $conjuntoB;

    public function __construct($conjuntoA, $conjuntoB)
    {
        parent::__construct($conjuntoA); // inicializa conjunto A
        $this->conjuntoB = array_unique(array_map('intval', explode(',', $conjuntoB)));
    }

    public function union()
    {
        return array_values(array_unique(array_merge($this->elementos, $this->conjuntoB)));
    }

    public function interseccion()
    {
        return array_values(array_intersect($this->elementos, $this->conjuntoB));
    }

    public function diferenciaAB()
    {
        return array_values(array_diff($this->elementos, $this->conjuntoB));
    }

    public function diferenciaBA()
    {
        return array_values(array_diff($this->conjuntoB, $this->elementos));
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conjuntoA = $_POST['conjuntoA'] ?? '';
    $conjuntoB = $_POST['conjuntoB'] ?? '';

    if (
        empty($conjuntoA) || empty($conjuntoB) ||
        !preg_match('/^\d+(,\d+)*$/', $conjuntoA) ||
        !preg_match('/^\d+(,\d+)*$/', $conjuntoB)
    ) {

        echo "<link rel='stylesheet' href='css/index.css'>";
        echo "<h1>Error</h1>";
        echo "<div class='error'>⚠️ Entrada inválida. Ingrese solo números separados por comas (ejemplo: 1,2,3).</div>";
        echo "<a href='index.html' class='volver'>Volver</a>";
        exit;
    }
    $operaciones = new OperacionesConjuntos($conjuntoA, $conjuntoB);

    echo "<link rel='stylesheet' href='css/index.css'>";
    echo "<h1>Resultados</h1>";
    echo "<div class='resultado'><strong>Unión:</strong> {" . implode(', ', $operaciones->union()) . "}</div>";
    echo "<div class='resultado'><strong>Intersección:</strong> {" . implode(', ', $operaciones->interseccion()) . "}</div>";
    echo "<div class='resultado'><strong>Diferencia A - B:</strong> {" . implode(', ', $operaciones->diferenciaAB()) . "}</div>";
    echo "<div class='resultado'><strong>Diferencia B - A:</strong> {" . implode(', ', $operaciones->diferenciaBA()) . "}</div>";
    echo "<a href='index.html' class='volver'>Volver</a>";
}
?>