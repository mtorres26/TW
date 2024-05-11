<!-- Esto hecho por el profesor, se pretende hacer todos los cálculos aqui al principio en PHP y luego mostrar $variables en el html -->
<?php

// Esto para no escribir tanto luego en el value del dato1 del html (objetivo=que no se borre el dato introducido en caso de error del formulario)
$dato1 = "";
$dato2 = "";
$error = "";

// En php hay que comprobar si las variables existen antes de operar con ellas
if (isset($_GET['numero1']) && isset($_GET['numero2'])) {
    $dato1 = $_GET['numero1'];
    $dato2 = $_GET['numero2'];
    if (is_numeric($dato1)) {
        if (is_numeric($dato2)) {
            if (array_key_exists('producto', $_GET)) {
                $resultado = $dato1 * $dato2;
                $operacion = 'Producto';
            } else if (array_key_exists('suma', $_GET)) {
                $resultado = $dato1 + $dato2;
                $operacion = 'Suma';
            } else if (array_key_exists('resta', $_GET)) {
                $resultado = $dato1 - $dato2;
                $operacion = 'Resta';
            } else if (array_key_exists('division', $_GET)) {
                if ($dato2 != 0) {
                    $resultado = $dato1 / $dato2;
                    $operacion = 'Division';
                } else {
                    $resultado = "No se puede operar.";
                    $operacion = "Sin operación.";
                    $error = "No se puede dividir por 0.";
                }
            }
        } else {
            $resultado = "No se puede operar.";
            $operacion = "Sin operación.";
            $error = "El segundo valor debe ser un número.";
        }
    } else {
        $resultado = "No se puede operar.";
        $operacion = "Sin operación.";
        $error = "El primer valor debe ser un número.";
    }
} else {
    $resultado = "No se puede operar.";
    $operacion = "Sin operación.";
    $error = "";
}
?>


<?php
echo <<<HTML
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <style>
        main {
            font-family: Arial;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            border: 2px solid lightgray;
            padding: 5px;
            display: inline-flex;
            align-items: center;
            background-color: lightblue;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px;
            display: flex;
            flex-direction: column;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <main>
        <h1>Calculadora</h1>
        <form action="{$_SERVER['SCRIPT_NAME']}" method="GET">      
            <!-- value="dato1..." (definido arriba) es para que el valor se quede guardado si al enviar el formulario hay error -->
            <label><span>Dato 1</span><input type="text" name="numero1" placeholder="Introduce un número" value="$dato1"/></label>
            <fieldset>
                <legend>Operación</legend>
                <input type="submit" name="suma" value="+">
                <input type="submit" name="resta" value="-">
                <input type="submit" name="producto" value="*">
                <input type="submit" name="division" value="/">
                <p class="error">$error</p>
            </fieldset>
            <label><span>Dato 2</span><input type="text" name="numero2" placeholder="Introduce un número" value="$dato2" /></label>
        </form>

        <section>
            <p>Resultado: $resultado</p>
            <p>Operación: $operacion</p>
        </section>

    </main>
</body>

</html>
HTML;
?>