<?php
require 'conexionbbdd.php';

function insertar_usuario($nombre, $apellidos, $email, $password)
{
    $conexion = conectar_bd();
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES ('$nombre', '$apellidos', '$email', '$password')";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        echo "Usuario insertado correctamente";
    } else {
        echo "Error al insertar el usuario";
    }
    desconectar_bd($conexion);
}

function obtener_usuarios()
{
    $conexion = conectar_bd();
    $sql = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexion, $sql);
    $usuarios = [];
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
    }
    desconectar_bd($conexion);
    return $usuarios;
}

?>