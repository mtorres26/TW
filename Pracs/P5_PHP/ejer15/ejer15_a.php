<?php
require_once 'conexionbbdd.php';
require_once 'funcionesbbdd.php';

session_start();

function acabarSesion()
{
    // La sesión debe estar iniciada
    if (session_status() == PHP_SESSION_NONE)
        session_start();
    // Borrar variables de sesión
    session_unset();
    // Obtener parámetros de cookie de sesión ...
    // $param = session_get_cookie_params();
    // ... y borrar cookie de sesión
    // setcookie(
    //      session_name(),
    //      $_COOKIE[session_name()],
    //      time() - 2592000,
    //      $param['path'],
    //      $param['domain'],
    //      $param['secure'],
    //      $param['httponly']
    // );
    // Destruir sesión
    session_destroy();
}

# Función que comprueba los datos del formulario pasandole por parametro el método usado
function comprobarDatos($p)
{
    if ((!isset($p['nombre']) || !preg_match("/^[A-Z][a-z]+$/", $p['nombre'])) && isset($p['envio'])) {
        $res['nombre'] = "El nombre no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['nombre'] = $p['nombre'];
        $res['nombre'] = "";
    } else {
        $res['nombre'] = "";
    }
    if (isset($p['ape'])) {
        $_SESSION['ape'] = $p['ape'];
    }
    if ((!isset($p['dni']) || !preg_match("/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]$/i", $p['dni'])) && isset($p['envio'])) {
        $res['dni'] = "El DNI no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['dni'] = $p['dni'];
        $res['dni'] = "";
    } else {
        $res['dni'] = "";
    }
    if ((!isset($p['nacim']) || !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $p['nacim']) || date($p['nacim']) > date("2006-05-12")) && isset($p['envio'])) {
        $res['nacim'] = "La fecha de nacimiento no es válida";
    } else if (isset($p['envio'])) {
        $_SESSION['nacim'] = $p['nacim'];
        $res['nacim'] = "";
    } else {
        $res['nacim'] = "";
    }
    if (isset($p['nacion'])) {
        $_SESSION['nacion'] = $p['nacion'];
    }
    if ((!isset($p['sexo']) || !preg_match("/^(Masculino|Femenino|No deseo responder)$/", $p['sexo'])) && isset($p['envio'])) {
        $res['sexo'] = "El sexo no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['sexo'] = $p['sexo'];
        $res['sexo'] = "";
    } else {
        $res['sexo'] = "";
    }
    if ((!isset($p['email']) || !filter_var($p['email'], FILTER_VALIDATE_EMAIL)) && isset($p['envio'])) {
        $res['email'] = "El email no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['email'] = $p['email'];
        $res['email'] = "";
    } else {
        $res['email'] = "";
    }
    if ((!isset($p['clave1']) || ($p['clave1'] != $p['clave2'])) && isset($p['envio'])) {
        $res['clave1'] = "La clave no es válida";
    } else if (isset($p['envio'])) {
        $_SESSION['clave1'] = $p['clave1'];
        $res['clave1'] = "";
    } else {
        $res['clave1'] = "";
    }
    if ((!isset($p['clave2']) || ($p['clave2'] != $p['clave1'])) && isset($p['envio'])) {
        $res['clave1'] = "La clave no es válida";
    } else if (isset($p['envio'])) {
        $_SESSION['clave2'] = $p['clave2'];
        $res['clave1'] = "";
    } else {
        $res['clave1'] = "";
    }
    if ((!isset($p['idioma']) || !preg_match("/^(Español|Inglés|Francés)$/", $p['idioma'])) && isset($p['envio'])) {
        $res['idioma'] = "El idioma no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['idioma'] = $p['idioma'];
        $res['idioma'] = "";
    } else {
        $res['idioma'] = "";
    }

    if (isset($p['preferencias[]']) && preg_match("/^(smoking|pets|views|carpet)$/", $p['preferencias[]'])) {
        $_SESSION['preferencias'] = $p['preferencias[]'];
    }

    if (!isset($p['consent']) && isset($p['envio'])) {
        $res['consent'] = "El consentimiento no es válido";
    } else if (isset($p['envio'])) {
        $_SESSION['consent'] = $p['consent'];
        $res['consent'] = "";
    } else {
        $res['consent'] = "";
    }

    if (isset($res)) {
        return $res;
    }

}

# Funcion que comprueba si hay errores
function hayErrores($arrayErrores)
{
    if (isset($arrayErrores)) {
        foreach ($arrayErrores as $error) {
            if ($error != "") {
                return true;
            }
        }
    }
    return false;
}

# Funcion que genera el formulario
function HTMLForm($variables, $arrayErrores, $readonly, $cabeceraCorrecto)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario PHP</title>
        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                font-size: large;
            }
    
            form {
                width: 100%;
            }
    
            h1 {
                color: white;
                padding: 8px;
                background-color: steelblue;
                margin: 10px;
                font-size: 26px;
            }
    
            label {
                display: block;
                margin: 10px;
            }
    
            fieldset {
                background-color: lightcyan;
                padding: 10px;
                margin: 10px;
                border: 1px solid blue;
            }
    
            fieldset:hover {
                border: 8px solid steelblue;
            }
    
            fieldset:hover .oculto {
                display: block;
                margin: 3px;
                color: steelblue;
            }
    
            fieldset legend {
                font-weight: bold;
                font-size: 18px;
                background-color: mediumturquoise;
                padding: 5px;
                border: 1px solid blue;
                width: 160px;
                margin-left: 25px;
            }
    
            .subapartado {
                width: 100%;
                background-color: paleturquoise;
                margin: 5px;
                box-sizing: border-box;
                display: inline-block;
                padding-left: 3%;
            }
    
            .subsub_conborde {
                display: inline-block;
                border-left: 5px solid mediumturquoise;
                padding: 20px;
            }
    
            .subsub_aux {
                text-align: center;
                display: inline-block;
                margin-right: 20%;
            }
    
            .tratamiento {
                margin: 15px;
            }
    
            .oculto {
                display: none;
            }
    
            input[type=submit] {
                margin-left: auto;
                margin-right: auto;
                margin-top: 20px;
                margin-bottom: 20px;
                background-color: mediumturquoise;
                display: block;
                padding-right: 40px;
                padding-left: 40px;
                padding-top: 5px;
                padding-bottom: 5px;
                font-size: 18px;
                border: 1px solid black;
                font-weight: bold;
            }
    
            input[type=text] {
                width: 50%;
            }
    
            input[type=email] {
                width: 30%;
            }
    
            input[type=password] {
                width: 60%;
            }
    
            .error {
                color: red;
                display: inline-block;
                margin: 2px;
            }
    
            .cabCorrect {
                width: 100%;
                color: mediumaquamarine;
                background-color: blue;
                padding: 10px;
                margin: 5px;
                font-size: 20px;
                display: inline-block;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
    
            th {
                background-color: steelblue;
                color: white;
                padding: 8px;
            }
    
            td {
                border: 1px solid black;
                padding: 8px;
            }
    
            tr:nth-child(even) {
                background-color: lightcyan;
            }
    
            tr:nth-child(odd) {
                background-color: paleturquoise;
            }
        </style>
    </head>
    HTML;


    echo "<body>
        $cabeceraCorrecto
        <h1>Registro de usuarios</h1>";
    echo "<form action={$_SERVER['SCRIPT_NAME']} method=\"GET\" novalidate>
            <fieldset>
                <legend>Datos personales</legend>
                <div class=\"subapartado\">
                    <div class=\"subsub_aux\">
                        <label>Nombre:
                            <input type=\"text\" name=\"nombre\" placeholder=\"Obligatorio\" $readonly value=\"{$variables['nombre']}\" >
                        </label>
                        <p class=\"error\">{$arrayErrores['nombre']}<p>
    
                        <label>Apellidos:
                            <input type=\"text\" name=\"ape\" placeholder=\"Opcional...\" $readonly value=\"{$variables['ape']}\" >
                        </label>
                    </div>
                    <div class=\"subsub_conborde\">
                        <label for=\"idfoto\">Fotografía:</label>
                        <input type=\"file\" name=\"foto\" id=\"idfoto\" accept=\".jpg\" />
                    </div>
                </div>";

    echo "<div class=\"subapartado\">
                    <div class=\"subsub_aux\">
                        <label>DNI:
                            <input type=\"text\" name=\"dni\" $readonly value=\"{$variables['dni']}\">
                        </label>
                        <p class=\"error\">{$arrayErrores['dni']}</p>
    
                        <label>Fecha de nacimiento:
                            <input type=\"date\" name=\"nacim\" $readonly value=\"{$variables['nacim']}\" >
                        </label>
                        <p class=\"error\">{$arrayErrores['nacim']}</p>
                    </div>
                    <div class=\"subsub_aux\">
                        <label>Nacionalidad:
                            <input type=\"text\" name=\"nacion\" $readonly value=\"{$variables['nacion']}\" >
                        </label>
    
                        <label>Sexo:
                            <select name=\"sexo\" value=\"{$variables['sexo']}\" >
                                <option>Masculino</option>
                                <option>Femenino</option>
                                <option>No deseo responder</option>
                            </select>
                        </label>
                        <p class=\"error\">{$arrayErrores['sexo']}</p>
                    </div>
                </div>
                <div class=\"oculto\">
                    <p>En cumplimiento del Real Decreto 933/2021, de 26 de octubre, estos datos serán comunicados al centro
                        de datos de la Dirección General de la Policía.</p>
                </div>
            </fieldset>
            </div>";

    echo "<fieldset>
                <legend>Datos de acceso</legend>
                <div class=\"subapartado\">
                    <label>Email:
                        <input type=\"email\" name=\"email\" $readonly value=\"{$variables['email']}\" >
                    </label>
                    <p class=\"error\">{$arrayErrores['email']}</p>
                </div>
                <div class=\"subapartado\">
                    <div class=\"subsub_aux\">
                        <label>Clave:
                            <input type=\"password\" name=\"clave1\" placeholder=\"Introduzca una clave...\"
                                $readonly value=\"{$variables['clave1']}\" >
                        </label>
                        <p class=\"error\">{$arrayErrores['clave1']}</p>
                    </div>
                    <div class=\"subsub_aux\">
                        <label>Repita la clave:
                            <input type=\"password\" name=\"clave2\" id=\"idclave\" placeholder=\"Introduzca la misma clave...\"
                                $readonly value=\"{$variables['clave2']}\" >
                        </label>
                    </div>
                </div>
                <div class=\"oculto\">
                    <p>Usted podrá acceder al sistema en cualquier momento mediante estos datos. Asegúrese de escribir una
                        clave que pueda recordar con posterioridad. Si la olvida siempre podrá recuperarla a través de su
                        correo electrónico.</p>
                </div>
            </fieldset>";

    echo "<fieldset>
                <legend>Preferencias</legend>
                <div class=\"subsub_aux\">
                    <label>Idioma para comunicaciones:</label>
                    <label>
                        <input type=\"radio\" name=\"idioma\" value=\"Español\">Español
                    </label>
                    <label>
                        <input type=\"radio\" name=\"idioma\" value=\"Inglés\">Inglés
                    </label>
                    <label>
                        <input type=\"radio\" name=\"idioma\" value=\"Francés\">Francés
                    </label>
                    <p class=\"error\">{$arrayErrores['idioma']}</p>
                </div>
                <div class=\"subsub_conborde\">
                    <label>Preferencias de habitación:</label>
                    <label>
                        <input type=\"checkbox\" name=\"preferencias[]\" value=\"smoking\" />Para fumadores
                    </label>
                    <label>
                        <input type=\"checkbox\" name=\"preferencias[]\" value=\"pets\" />Que permita mascotas
                    </label>
                    <label>
                        <input type=\"checkbox\" name=\"preferencias[]\" value=\"views\" />Con vistas
                    </label>
                    <label>
                        <input type=\"checkbox\" name=\"preferencias[]\" value=\"carpet\" />Con moqueta
                    </label>
                </div>
                <div class=\"oculto\">
                    <p>Marque el idioma con el que tenga más facilidad de comunicación y una o varias preferencias sobre el
                        tipo de habitación que desea.</p>
                </div>
            </fieldset>";


    echo "<div class=\"tratamiento\">
                <label>Tratado de datos y envío a terceros:
                    <select name=\"consent\" value=\"{$variables['consent']}\">
                        <option value=\"TOTAL\">Acepta el almacenamiento de mis datos y el envío a terceros</option>
                        <option value=\"PARCIAL\">Acepta el almacenamiento de mis datos pero no el envío a terceros</option>
                        <option value=\"NINGUNO\">No acepta el almacenamiento ni el envío de datos a terceros</option>
                    </select>
                </label>
                <p class=\"error\">{$arrayErrores['consent']}</p>
            </div>
    
            <label>
                <input type=\"submit\" name=\"envio\" value=\"Enviar datos\" />
            </label>
        </form>
    </body>
    
    </html>
";
}

# Funcion para generar la tabla de tuplas
function HTMLTuplas($usuarios)
{
    echo "<html>";
    echo "<body>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Apellidos</th>";
    echo "<th>DNI</th>";
    echo "<th>Fecha Nacimiento</th>";
    echo "<th>Nacionalidad</th>";
    echo "<th>Sexo</th>";
    echo "<th>Email</th>";
    echo "<th>Idioma</th>";
    echo "<th>Preferencias</th>";
    echo "<th>Consentimiento</th>";
    echo "</tr>";
    foreach ($usuarios as $usuario):
        echo "<tr>";
        echo "<td>{$usuario['nombre']} </td>";
        echo "<td>{$usuario['apellidos']} </td>";
        echo "<td>{$usuario['dni']}</td>";
        echo "<td>{$usuario['fechanac']}</td>";
        echo "<td>{$usuario['nacionalidad']}</td>";
        echo "<td>{$usuario['sexo']}</td>";
        echo "<td>{$usuario['email']}</td>";
        echo "<td>{$usuario['idioma']}</td>";
        echo "<td>{$usuario['preferencias']}</td>";
        echo "<td>{$usuario['tratamiento']}</td>";
        echo "</tr>";
    endforeach;

    echo "</table>";
    echo "</body>";
    echo "</html>";
}

# Funcion que inicializa las variables del formulario a vacío o las iguala al array de sesion
function actualizaVariables()
{
    if (isset($_SESSION['nombre'])) {
        $variables['nombre'] = $_SESSION['nombre'];
    } else {
        $variables['nombre'] = "";
    }
    if (isset($_SESSION['ape'])) {
        $variables['ape'] = $_SESSION['ape'];
    } else {
        $variables['ape'] = "";
    }
    if (isset($_SESSION['dni'])) {
        $variables['dni'] = $_SESSION['dni'];
    } else {
        $variables['dni'] = "";
    }
    if (isset($_SESSION['nacim'])) {
        $variables['nacim'] = $_SESSION['nacim'];
    } else {
        $variables['nacim'] = "";
    }
    if (isset($_SESSION['nacion'])) {
        $variables['nacion'] = $_SESSION['nacion'];
    } else {
        $variables['nacion'] = "";
    }
    if (isset($_SESSION['sexo'])) {
        $variables['sexo'] = $_SESSION['sexo'];
    } else {
        $variables['sexo'] = "";
    }
    if (isset($_SESSION['email'])) {
        $variables['email'] = $_SESSION['email'];
    } else {
        $variables['email'] = "";
    }
    if (isset($_SESSION['clave1'])) {
        $variables['clave1'] = $_SESSION['clave1'];
    } else {
        $variables['clave1'] = "";
    }
    if (isset($_SESSION['clave2'])) {
        $variables['clave2'] = $_SESSION['clave2'];
    } else {
        $variables['clave2'] = "";
    }
    if (isset($_SESSION['idioma'])) {
        $variables['idioma'] = $_SESSION['idioma'];
    } else {
        $variables['idioma'] = "";
    }
    if (isset($_SESSION['preferencias'])) {
        $variables['preferencias'] = $_SESSION['preferencias'];
    } else {
        $variables['preferencias'] = "";
    }
    if (isset($_SESSION['consent'])) {
        $variables['consent'] = $_SESSION['consent'];
    } else {
        $variables['consent'] = "";
    }
    
    return $variables;
}

$bd = conectar_bd();

$arrayErrores = comprobarDatos($_GET);

$readonly = "";

$cabeceraCorrecto = "";

# Si no hay errores, se deshabilita el formulario
if (!hayErrores($arrayErrores) && isset($_GET['envio'])) {
    # Cabecera para cuando se introduzcan los valores correctos
    $cabeceraCorrecto = "<h2 class=\"cabCorrect\">Los datos se han recibido correctamente</h2>";
    $readonly = "readonly";
}

$variables = actualizaVariables();

HTMLForm($variables, $arrayErrores, $readonly, $cabeceraCorrecto);
HTMLTuplas(obtener_usuarios($bd));

if (!hayErrores($arrayErrores) && isset($_GET['envio'])) {
    insertar_usuario($bd, $variables['nombre'], $variables['ape'], $variables['dni'], $variables['nacim'], $variables['nacion'], $variables['sexo'], $variables['email'], $variables['clave1'], $variables['idioma'], $variables['preferencias'], $variables['consent']);
}

desconectar_bd($bd);

# Se finaliza la sesion si todo esta correcto
if (!hayErrores($arrayErrores) && isset($_GET['envio'])) {
    acabarSesion();
} ?>