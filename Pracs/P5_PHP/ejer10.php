<?php
session_start();

# Cuando enviemos el formulario, guardamos el nombre en la sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['numbers'] = array();
    }
    if (isset($_POST['reset'])) {
        session_unset();
        session_destroy();
        session_start();
    }
}

# Cuando ya tenemos el nombre, mostramos el saludo y añadimos al array un nuevo numero aleatorio
if (isset($_SESSION['name'])) {
    $random = rand(1, 10000000);
    $name = $_SESSION['name'];

    echo "<p>Bienvenido, $name</p>";
    if (count($_SESSION['numbers']) > 0) {
        $contador = 1;
        foreach ($_SESSION['numbers'] as $number) {
            echo "<p>$contador. $number</p>";
            $contador++;
        }
    }
    if (isset($random)) {
        echo "El nuevo numero es: $random <br>";
    }
    $_SESSION['numbers'][] = $random;
}

# Mostramos siempre el formulario para que el usuario pueda introducir su nombre
echo "<form method=\"post\">";
echo "Dígame su nombre para comenzar: <input type='text' name='name' required>";
echo "<input type='submit' value='Enviar'>";
echo "</form>";

# Hay que crear otro formulario para reset, para que no pida obligatoriamente nombre
echo "<form method='post'>";
echo "<input type='submit' name='reset' value='Borrar sesión'>";
echo "<p><a href='ejer10.php'>Cargar de nuevo</a></p>";
echo "</form>";

?>