<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Ejemplo</title>
</head>

<body>
    <?php
    echo '<p>Si has llegado aquí es porque la URL que has puesto es incorrecta</p>';
    echo '<pre>' . var_export($_SERVER, true) . '</pre>';
    ?>
</body>

</html>

<!--   'SCRIPT_FILENAME' => '/home/alumnos/2324/mtorres262324/public_html/practicaPHP/procesarerror.php',
       'REQUEST_URI' => '/~mtorres262324/practicaPHP/unadireccion.php',
       'SCRIPT_NAME' => '/~mtorres262324/practicaPHP/procesarerror.php',
       'PHP_SELF' => '/~mtorres262324/practicaPHP/procesarerror.php',
       'REDIRECT_URL' => '/~mtorres262324/practicaPHP/unadireccion.php',
-->
