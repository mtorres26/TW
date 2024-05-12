<?php
session_start();
if (isset($_GET['borrar']))
    unset($_SESSION['total']);
if (!isset($_SESSION['total']) or !isset($_SESSION['numero'])) {
    $_SESSION['numero'] = 0;
    $_SESSION['total'] = 0;
}
if (isset($_GET['enviar']) and is_numeric($_GET['donacion'])) {
    $_SESSION['numero']++;
    $_SESSION['total'] += $_GET['donacion'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Ejemplo</title>
</head>

<body>
    <?php
    echo "<p>Hasta ahora hay un total de {$_SESSION['numero']} donaciones.</p>";
    echo "<p>El importe acumulado es de {$_SESSION['total']} euros.</p>";
    if (isset($_GET['donacion']) and is_numeric($_GET['donacion']))
        echo "<p>La última donación fue de {$_GET['donacion']} euros</p>";
    echo form();
    ?>
</body>

</html>
<?php
function form()
{
    return <<<HTML
 <form action="{$_SERVER['SCRIPT_NAME']}" method="get">
 <label>Realizar una nueva donación: <input type="text" name="donacion" size="10"></label>
 <p><input type="submit" name="enviar" value="Enviar">
 <input type="submit" name="borrar" value="Borrar sesión"></p>
 </form>\n
 HTML;
}
?>