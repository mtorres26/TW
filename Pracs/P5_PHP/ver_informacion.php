<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver información del servidor</title>
    <style>
        span {
            color: red;
            font-weight: normal;
        }

        li {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    echo "<h1>Información del servidor.</h1>";
    showVar($_SERVER, 'Variables de $_SERVER');
    function showVar($var, $msg)
    {
        echo "<h2>$msg</h2>";
        echo "<ul>";
        foreach ($var as $c => $v) {
            if (is_array($v)) {
                echo "<li>$c = <span>";
                print_r($v);
                echo "</span></li>";
            } else
                echo "<li>$c = <span>$v</span></li>";
        }
        echo "</ul>";
    }
    ?>
</body>

</html>