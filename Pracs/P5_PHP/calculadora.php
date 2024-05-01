<!-- Esto hecho por el profesor, se pretende hacer todos los cálculos aqui al principio en PHP y luego mostrar $variables en el html -->
<?php
// En php hay que comprobar si las variables existen antes de operar con ellas
if (
    isset($_GET['numero1']) && isset($_GET['numero2']) &&
    is_numeric($_GET['numero1']) && is_numeric($_GET['numero2']) &&
    array_key_exists('producto', $_GET)
)
    $resultado = $_GET['numero1'] * $_GET['numero2'];
else {
    $resultado = "No se puede operar.";
}

// Esto para no escribir tanto luego en el value del dato1 del html (objetivo=que no se borre el dato introducido en caso de error del formulario)
$def1 = $_GET['numero1'];
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
        <!-- Esto justo de abajo hecho por profesor -->
        <form action="{$_SERVER['SCRIPT_NAME']}" method="GET">      
            <!-- value="$def1..." (definido arriba) es para que el valor se quede guardado si al enviar el formulario hay error -->
            <label><span>Dato 1</span><input type="text" name="numero1" placeholder="Introduce un número" value="$def1"/></label>
            <!-- Aqui se puede hacer un if(hay error){<p>$error1</p>} -->
            <fieldset>
                <legend>Operación</legend>
                <input type="submit" name="suma" value="+">
                <input type="submit" name="resta" value="-">
                <input type="submit" name="producto" value="*">
                <input type="submit" name="division" value="/">
            </fieldset>
            <label><span>Dato 2</span><input type="text" name="numero2" placeholder="Introduce un
número" /></label>
        </form>


        <!-- Esto hecho por el profesor -->
        <section>
            <p>Resultado: $resultado</p>
        </section>


        <section>
            <p>Operación: <span>Sin operación</span></p>
            <p>Resultado: <span>Sin resultado</span></p>
        </section>
    </main>
</body>

</html>
HTML;
?>