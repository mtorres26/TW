<?php
require_once 'datosbbdd.php';

function conectar_bd(){
    # Creamos la conexión con las credenciales que hemos establecido en el otro fichero.
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_DATABASE);
    if (!$db) {
        echo "No se pudo establecer la conexión a la base de datos";
        echo "<p>Código del error</p>". mysqli_connect_errno();
        echo "<p>Mensaje del error</p>". mysqli_connect_error();
    }else{
        mysqli_set_charset($db, "utf8");
    }

    return $db;
}

function desconectar_bd($db){
    # Cerramos la conexión
    mysqli_close($db);
}

?>