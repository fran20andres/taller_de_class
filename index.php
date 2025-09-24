<?php
class Nodo {
    public $valor;
    public $izquierdo;
    public $derecho;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->izquierdo = null;
        $this->derecho = null;
    }
}

class ArbolBinario {
    public $raiz = null;

    // Construir desde Preorden + Inorden
    public function construirDesdePreIn($preorden, $inorden) {
        if (empty($preorden) || empty($inorden)) return null;

        $valorRaiz = array_shift($preorden);
        $raiz = new Nodo($valorRaiz);

        $indice = array_search($valorRaiz, $inorden);
        $inIzq = array_slice($inorden, 0, $indice);
        $inDer = array_slice($inorden, $indice + 1);

        $preIzq = array_slice($preorden, 0, count($inIzq));
        $preDer = array_slice($preorden, count($inIzq));

        $raiz->izquierdo = $this->construirDesdePreIn($preIzq, $inIzq);
        $raiz->derecho   = $this->construirDesdePreIn($preDer, $inDer);

        return $raiz;
    }

    // Construir desde Postorden + Inorden
    public function construirDesdePostIn($postorden, $inorden) {
        if (empty($postorden) || empty($inorden)) return null;

        $valorRaiz = array_pop($postorden);
        $raiz = new Nodo($valorRaiz);

        $indice = array_search($valorRaiz, $inorden);
        $inIzq = array_slice($inorden, 0, $indice);
        $inDer = array_slice($inorden, $indice + 1);

        $postIzq = array_slice($postorden, 0, count($inIzq));
        $postDer = array_slice($postorden, count($inIzq));

        $raiz->izquierdo = $this->construirDesdePostIn($postIzq, $inIzq);
        $raiz->derecho   = $this->construirDesdePostIn($postDer, $inDer);

        return $raiz;
    }

    // Recorridos
    public function preorden($nodo, &$res) {
        if ($nodo == null) return;
        $res[] = $nodo->valor;
        $this->preorden($nodo->izquierdo, $res);
        $this->preorden($nodo->derecho, $res);
    }

    public function inorden($nodo, &$res) {
        if ($nodo == null) return;
        $this->inorden($nodo->izquierdo, $res);
        $res[] = $nodo->valor;
        $this->inorden($nodo->derecho, $res);
    }

    public function postorden($nodo, &$res) {
        if ($nodo == null) return;
        $this->postorden($nodo->izquierdo, $res);
        $this->postorden($nodo->derecho, $res);
        $res[] = $nodo->valor;
    }

    // Dibujo en HTML
    public function dibujar($nodo) {
        if ($nodo == null) return "";
        $html = "<ul><li><div class='nodo'>{$nodo->valor}</div>";
        if ($nodo->izquierdo || $nodo->derecho) {
            $html .= "<ul>";
            $html .= "<li>" . ($nodo->izquierdo ? $this->dibujar($nodo->izquierdo) : "") . "</li>";
            $html .= "<li>" . ($nodo->derecho ? $this->dibujar($nodo->derecho) : "") . "</li>";
            $html .= "</ul>";
        }
        $html .= "</li></ul>";
        return $html;
    }
}

// ================== Lógica principal ==================
$preorden = $inorden = $postorden = [];
$arbol = new ArbolBinario();
$raiz = null;
$resultados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["preorden"])) $preorden = explode(",", str_replace(" ", "", $_POST["preorden"]));
    if (!empty($_POST["inorden"])) $inorden = explode(",", str_replace(" ", "", $_POST["inorden"]));
    if (!empty($_POST["postorden"])) $postorden = explode(",", str_replace(" ", "", $_POST["postorden"]));

    // Reconstrucción según entradas
    if (!empty($preorden) && !empty($inorden)) {
        $raiz = $arbol->construirDesdePreIn($preorden, $inorden);
    } elseif (!empty($postorden) && !empty($inorden)) {
        $raiz = $arbol->construirDesdePostIn($postorden, $inorden);
    }

    // Generar recorridos
    if ($raiz) {
        $resPre = $resIn = $resPost = [];
        $arbol->preorden($raiz, $resPre);
        $arbol->inorden($raiz, $resIn);
        $arbol->postorden($raiz, $resPost);
        $resultados = [
            "Preorden" => implode(" → ", $resPre),
            "Inorden"  => implode(" → ", $resIn),
            "Postorden"=> implode(" → ", $resPost),
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Construcción de Árbol Binario</h1>
    <form method="POST">
        <label>Preorden:</label>
        <input type="text" name="preorden" placeholder="Ej: A,B,D,E,C"><br>
        <label>Inorden:</label>
        <input type="text" name="inorden" placeholder="Ej: D,B,E,A,C"><br>
        <label>Postorden:</label>
        <input type="text" name="postorden" placeholder="Ej: D,E,B,C,A"><br>
        <button type="submit">Construir Árbol</button>
    </form>

    <?php if ($raiz): ?>
        <h2>Recorridos resultantes:</h2>
        <ul>
            <?php foreach ($resultados as $tipo => $recorrido): ?>
                <li><strong><?= $tipo ?>:</strong> <?= $recorrido ?></li>
            <?php endforeach; ?>
        </ul>
        <h2>Árbol:</h2>
        <div class="arbol">
            <?= $arbol->dibujar($raiz); ?>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p style="color:red;">Debes ingresar al menos Inorden + (Preorden o Postorden)</p>
    <?php endif; ?>
</body>
</html>
