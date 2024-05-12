<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uso de cookies</title>
</head>

<body>
    <?php
    # Si ya hemos usado el formulario, guardamos la cookie con el idioma seleccionado
    if (isset($_POST['idioma'])) {
        $idioma = $_POST['idioma'];
        setcookie('idioma', $_POST['idioma']);
        header("Location: {$_SERVER['SCRIPT_NAME']}");
    }

    # Si ya hemos guardado la cookie, la leemos
    if (isset($_COOKIE['idioma'])) {
        $idioma = $_COOKIE['idioma'];
    } else {
        $idioma = 'es';
    }

    $mensajes = json_decode(file_get_contents('mensajes.json'), true);

    $mensaje_elegir = $mensajes[$idioma]['ElegirIdioma'];
    $mensaje_bienvenida = $mensajes[$idioma]['Bienvenida'];
    $mensaje_cambio = $mensajes[$idioma]['Cambio'];
    $mensaje_aplicar = $mensajes[$idioma]['Aplicar'];
    $mensaje_enlace = $mensajes[$idioma]['Enlace'];

    echo '<p>' . $mensaje_bienvenida . '</p>';
    echo '<p>' . $mensaje_cambio . '</p>';
    ?>

    <form method="POST">
        <label for="idioma"><?php echo $mensaje_elegir; ?>:</label>
        <select name="idioma" id="idioma">
            <option value="es" <?php if ($idioma == "es")
                echo 'selected'; ?>><?php echo $mensajes[$idioma]['Espanol']; ?>
            </option>
            <option value="en" <?php if ($idioma == "en")
                echo 'selected'; ?>><?php echo $mensajes[$idioma]['Ingles']; ?>
            </option>
            <option value="fr" <?php if ($idioma == "fr")
                echo 'selected'; ?>><?php echo $mensajes[$idioma]['Frances']; ?>
            </option>
        </select>
        <button type="submit"><?php echo $mensaje_aplicar; ?></button>
    </form>
    <p><a href="usoCookies.php"><?php echo $mensaje_enlace; ?></a></p>
</body>

</html>