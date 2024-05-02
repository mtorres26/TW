<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operar</title>
</head>

<body>
    <?php
    preg_match('#([^/]*php)/(.*)$#', $_SERVER['PHP_SELF'], $coincidencias);
    $chunks = (count($coincidencias) > 0) ? explode('/', $coincidencias[2]) : [];
    if (count($chunks) > 0)
        echo '<pre>' . var_export($chunks, true) . '</pre>';
    else
        echo '<p>No hay trailing path</p>';

    # Ahora hacemos lo mismo pero para el query string, para saber con qué numeros operar
    if (isset($_SERVER['QUERY_STRING'])) {
        $asignaciones = $_SERVER['QUERY_STRING'];
        $asignaciones = explode('&', $asignaciones);
    } else {
        $asignaciones = [];
    }
    if (count($asignaciones) > 0)
        echo '<pre>' . var_export($asignaciones, true) . '</pre>';
    else
        echo '<p>No hay operandos</p>';

    # Ahora sacamos los operandos (numeros) que hay las asignaciones
    $operandos = [];
    # Expresion regular para sacar uno o varios numeros de las asignaciones
    if (count($asignaciones) == 2) {
        preg_match('#[0-9]+#', $asignaciones[0], $operandos[0]);
        preg_match('#[0-9]+#', $asignaciones[1], $operandos[1]);
    }

    # Hacemos las comprobaciones necesarias para operar
    if (count($chunks) == 0 || count($operandos) == 0) {
        echo '<p>No se puede operar debido a la falta de trailing path u operandos.</p>';
    } else if ($chunks[0] == 'multiplica') {
        $result = $operandos[0][0] * $operandos[1][0];
        echo '<p>La multiplicación da como resultado: ' . $result . '</p>';
    } else if ($chunks[0] == 'suma') {
        $result = $operandos[0][0] + $operandos[1][0];
        echo '<p>La suma da como resultado: ' . $result . '</p>';
    } else if ($chunks[0] == 'divide' && $operandos[1] != 0) {
        $result = $operandos[0][0] / $operandos[1][0];
        echo '<p>La división da como resultado: ' . $result . '</p>';
    } else if ($chunks[0] == 'resta') {
        $result = $operandos[0][0] - $operandos[1][0];
        echo '<p>La resta da como resultado: ' . $result . '</p>';
    }
    ?>

</body>

</html>