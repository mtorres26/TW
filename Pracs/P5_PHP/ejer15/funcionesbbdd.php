<?php
require_once 'conexionbbdd.php';

function insertar_usuario($conexion, $nombre, $apellidos, $dni, $nacim, $nacion, $sexo, $email, $clave, $idioma, $preferencias, $consentimiento)
{
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, apellidos, dni, fechanac, nacionalidad, sexo, email, clave, idioma, preferencias, tratamiento) VALUES ('$nombre', '$apellidos', '$dni', '$nacim', '$nacion', '$sexo', '$email', '$claveHash', '$idioma', '$preferencias', '$consentimiento')";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        echo "Usuario insertado correctamente";
    } else {
        echo "Error al insertar el usuario";
    }
}

function obtener_usuarios($conexion)
{
    $sql = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexion, $sql);
    $usuarios = [];
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
    }
    return $usuarios;
}

?>