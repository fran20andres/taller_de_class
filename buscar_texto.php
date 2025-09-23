<?php
// Clase base
class Texto {
    protected $contenido;

    public function __construct($contenido) {
        $this->contenido = $contenido;
    }

    public function getContenido() {
        return $this->contenido;
    }
}

// Clase hija que hereda de Texto
class Buscador extends Texto {
    private $busqueda;

    public function __construct($contenido, $busqueda) {
        parent::__construct($contenido);
        $this->busqueda = $busqueda;
    }

    // Método para resaltar coincidencias
    public function buscarCoincidencias() {
        if (empty($this->busqueda)) {
            return $this->contenido;
        }

        // Resaltar las coincidencias usando <span>
        $resultado = str_ireplace(
            $this->busqueda,
            "<span class='resaltado'>{$this->busqueda}</span>",
            $this->contenido
        );

        return $resultado;
    }
}

// Recibir variables del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $texto = $_POST['texto'] ?? '';
    $buscar = $_POST['buscar'] ?? '';

    $buscador = new Buscador($texto, $buscar);
    $resultado = $buscador->buscarCoincidencias();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Búsqueda</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <h1>Resultado de la búsqueda</h1>

    <div class="resultado">
        <?php if (!empty($resultado)) { ?>
            <p><?php echo $resultado; ?></p>
        <?php } else { ?>
            <p>No se ingresaron datos válidos.</p>
        <?php } ?>
    </div>

    <div style="text-align: center;">
        <a href="index.html"><button>Volver</button></a>
    </div>
</body>
</html>
