<?php
session_start();

function acabarSesion()
{
    // La sesión debe estar iniciada
    if (session_status() == PHP_SESSION_NONE)
        session_start();
    // Borrar variables de sesión
    session_unset();
    // Obtener parámetros de cookie de sesión ...
    $param = session_get_cookie_params();
    // ... y borrar cookie de sesión
    setcookie(
        session_name(),
        $_COOKIE[session_name()],
        time() - 2592000,
        $param['path'],
        $param['domain'],
        $param['secure'],
        $param['httponly']
    );
    // Destruir sesión
    session_destroy();
}

# Función que comprueba los datos del formulario pasandole por parametro el método usado
function comprobarDatos($p)
{
    $res = [];
    if (!isset($p['nombre']) || !preg_match("/^[A-Z][a-z]+$/", $p['nombre'])) {
        $_SESSION['error']['nombre'] = "El nombre no es válido";
    } else {
        $_SESSION['nombre'] = $p['nombre'];
        #$res['error']['nombre'] = "";
    }
    if (!isset($p['ape']) || !preg_match("/^[A-Z][a-z]+$/", $p['ape'])) {
        $res['error']['ape'] = "Los apellidos no son válidos";
    } else {
        $_SESSION['ape'] = $p['ape'];
        #$res['error']['ape'] = "";
    }
    if (!isset($p['dni']) || !preg_match("/^[0-9]{8}[A-Z]$/", $p['dni'])) {
        $res['error']['dni'] = "El DNI no es válido";
    } else {
        $_SESSION['dni'] = $p['dni'];
        #$res['error']['dni'] = "";
    }
    if (!isset($p['nacim']) || !preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $p['nacim'])) {
        $res['error']['nacim'] = "La fecha de nacimiento no es válida";
    } else {
        $_SESSION['nacim'] = $p['nacim'];
        #$res['error']['nacim'] = "";
    }
    if (!isset($p['nacion']) || !preg_match("/^[A-Z][a-z]+$/", $p['nacion'])) {
        $res['error']['nacion'] = "La nacionalidad no es válida";
    } else {
        $_SESSION['nacion'] = $p['nacion'];
        #$res['error']['nacion'] = "";
    }
    if (!isset($p['sexo']) || !preg_match("/^(Masculino|Femenino|No deseo responder)$/", $p['sexo'])) {
        $res['error']['sexo'] = "El sexo no es válido";
    } else {
        $_SESSION['sexo'] = $p['sexo'];
        # $res['error']['sexo'] = "";
    }
    if (!isset($p['email']) || !preg_match("/^[a-zA-Z0-9.!#$%&'*+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $p['email'])) {
        $res['error']['email'] = "El email no es válido";
    } else {
        $_SESSION['email'] = $p['email'];
        #$res['error']['email'] = "";
    }
    if (!isset($p['clave']) || !preg_match("/^[A-Za-z0-9]{8,}$/", $p['clave'])) {
        $res['error']['clave'] = "La clave no es válida";
    } else {
        $_SESSION['clave'] = $p['clave'];
        #$res['error']['clave'] = "";
    }
    if (!isset($p['idioma']) || !preg_match("/^(Español|Inglés|Francés)$/", $p['idioma'])) {
        $res['error']['idioma'] = "El idioma no es válido";
    } else {
        $_SESSION['idioma'] = $p['idioma'];
        #$res['error']['idioma'] = "";
    }
    if (!isset($p['preferencias']) || !preg_match("/^(smoking|pets|views|carpet)$/", $p['preferencias'])) {
        $res['error']['preferencias'] = "Las preferencias no son válidas";
    } else {
        $_SESSION['preferencias'] = $p['preferencias'];
        #$res['error']['preferencias'] = "";
    }
    if (!isset($p['consent']) || !preg_match("/^(TOTAL|PARCIAL|NINGUNO)$/", $p['consent'])) {
        $res['error']['consent'] = "El consentimiento no es válido";
    } else {
        $_SESSION['consent'] = $p['consent'];
        #$res['error']['consent'] = "";
    }
    return $res;
}

# Comprobamos los datos del formulario
// $r = comprobarDatos($_GET);

# Si hay errores
// if (!empty($r)) {
//     # Mostramos el formulario con los errores
//     HTMLform($r, "");
// } else {
//     # Mostramos el formulario deshabilitado
//     HTMLform([], "readonly");
// }

# Función que genera el formulario
function HTMLform($readonly = ""){
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
    </style>
</head>

<body>
    <h1>Registro de usuarios</h1>
    <form action="{$_SERVER['SCRIPT_NAME']}" method="GET" novalidate>
        <fieldset>
            <legend>Datos personales</legend>
            <div class="subapartado">
                <div class="subsub_aux">
                    <label>Nombre:
                        <input type="text" name="nombre" placeholder="Obligatorio" required $readonly value="{<?php if (isset({$_SESSION['nombre']}))
                            echo {$_SESSION['nombre']};
                        ?>}" />
                    </label>
                    <p class="error">{<?php if (isset({$_SESSION['error']['nombre']})) {
                        echo {$_SESSION['error']['nombre']};
                    } ?>}</p>

                    <label>Apellidos:
                        <input type="text" name="ape" placeholder="Opcional..." $readonly value=<?php if (isset($_SESSION['ape']))
                            echo $_SESSION['ape'];
                        else
                            echo ""; ?> />
                    </label>
                    <p class="error"><?php if (isset($r['error']['ape'])) {
                        echo $r['error']['ape'];
                    } ?></p>
                </div>
                <div class="subsub_conborde">
                    <label for="idfoto">Fotografía:</label>
                    <input type="file" name="foto" id="idfoto" accept=".jpg" />
                </div>
            </div>
            <div class="subapartado">
                <div class="subsub_aux">
                    <label>DNI:
                        <input type="number" name="dni" $readonly value=<?php if (isset($_SESSION['dni']))
                            echo $_SESSION['dni'];
                        else
                            echo ""; ?> />
                    </label>
                    <p class="error"><?php if (isset($r['error']['dni'])) {
                        echo $r['error']['dni'];
                    } ?></p>

                    <label>Fecha de nacimiento:
                        <input type="date" name="nacim" $readonly value=<?php if (isset($_SESSION['nacim']))
                            echo $_SESSION['nacim'];
                        else
                            echo ""; ?> />
                    </label>
                    <p class="error"><?php if (isset($r['error']['nacim'])) {
                        echo $r['error']['nacim'];
                    } ?></p>
                </div>
                <div class="subsub_aux">
                    <label>Nacionalidad:
                        <input type="text" name="nacion" $readonly value=<?php if (isset($_SESSION['nacion']))
                            echo $_SESSION['nacion'];
                        else
                            echo ""; ?> />
                    </label>
                    <p class="error"><?php if (isset($r['error']['nacion'])) {
                        echo $r['error']['nacion'];
                    } ?></p>

                    <!-- selected para valores por defecto -->
                    <label>Sexo:
                        <select name="sexo" $readonly value=<?php if (isset($_SESSION['nacion']))
                            echo $_SESSION['nacion'];
                        else
                            echo ""; ?>>
                            <option>Masculino</option>
                            <option>Femenino</option>
                            <option selected>No deseo responder</option>
                        </select>
                    </label>
                    <p class="error"><?php if (isset($r['error']['sexo'])) {
                        echo $r['error']['sexo'];
                    } ?></p>
                </div>
            </div>
            <div class="oculto">
                <p>En cumplimiento del Real Decreto 933/2021, de 26 de octubre, estos datos serán comunicados al centro
                    de datos de la Dirección General de la Policía.</p>
            </div>
        </fieldset>
        </div>

        <fieldset>
            <legend>Datos de acceso</legend>
            <div class="subapartado">
                <label>Email:
                    <!-- pattern con expresion regular de email segun W3-->
                    <input type="email" name="email" $readonly value=<?php if (isset($_SESSION['email']))
                            echo $_SESSION['email'];
                        else
                            echo ""; ?>/>
                </label>
                <p class="error"><?php if (isset($r['error']['email'])) {
                        echo $r['error']['email'];
                    } ?></p>
            </div>
            <div class="subapartado">
                <div class="subsub_aux">
                    <label>Clave:
                        <input type="password" name="clave" placeholder="Introduzca una clave..."
                            $readonly value=<?php if (isset($_SESSION['clave'])){
                            echo $_SESSION['clave'];}
                        else
                            {echo "";} ?> />
                    </label>
                    <p class="error"><?php if (isset($r['error']['clave'])) {
                        echo $r['error']['clave'];
                    } ?></p>
                </div>
                <div class="subsub_aux">
                    <label>Repita la clave:
                        <input type="password" name="clave" id="idclave" placeholder="Introduzca la misma clave..."
                            $readonly value=<?php if (isset($_SESSION['clave'])){
                            echo $_SESSION['clave'];}
                        else
                            {echo "";} ?> />
                    </label>
                </div>
            </div>
            <div class="oculto">
                <p>Usted podrá acceder al sistema en cualquier momento mediante estos datos. Asegúrese de escribir una
                    clave que pueda recordar con posterioridad. Si la olvida siempre podrá recuperarla a través de su
                    correo electrónico.</p>
            </div>
        </fieldset>

        <fieldset>
            <legend>Preferencias</legend>
            <div class="subsub_aux">
                <!-- checked para valores por defecto -->
                <label>Idioma para comunicaciones:</label>
                <label>
                    <input type="radio" name="idioma" value="Español" />Español
                </label>
                <label>
                    <input type="radio" name="idioma" value="Inglés" checked />Inglés
                </label>
                <label>
                    <input type="radio" name="idioma" value="Francés" />Francés
                </label>
                <p class="error"><?php if (isset($r['error']['idioma'])) {
                        echo $r['error']['idioma'];
                    } ?></p>
            </div>
            <div class="subsub_conborde">
                <!-- name = preferencias[] en formato array para seleccionar varios sin errores-->
                <label>Preferencias de habitación:</label>
                <label>
                    <input type="checkbox" name="preferencias[]" value="smoking" />Para fumadores
                </label>
                <label>
                    <input type="checkbox" name="preferencias[]" value="pets" />Que permita mascotas
                </label>
                <label>
                    <input type="checkbox" name="preferencias[]" value="views" />Con vistas
                </label>
                <label>
                    <input type="checkbox" name="preferencias[]" value="carpet" />Con moqueta
                </label>
                <p class="error"><?php if (isset($r['error']['preferencias'])) {
                        echo $r['error']['preferencias'];
                    } ?></p>
            </div>
            <div class="oculto">
                <p>Marque el idioma con el que tenga más facilidad de comunicación y una o varias preferencias sobre el
                    tipo de habitación que desea.</p>
            </div>
        </fieldset>

        <!-- selected para valores por defecto y value=... para enviar al server lo justo -->
        <div class="tratamiento">
            <label>Tratado de datos y envío a terceros:
                <select name="consent" $readonly value=<?php if (isset($_SESSION['consent'])){
                            echo $_SESSION['consent'];}
                        else
                            {echo "";} ?>>
                    <option selected value="TOTAL">Acepta el almacenamiento de mis datos y el envío a terceros</option>
                    <option value="PARCIAL">Acepta el almacenamiento de mis datos pero no el envío a terceros</option>
                    <option value="NINGUNO">No acepta el almacenamiento ni el envío de datos a terceros</option>
                </select>
            </label>
            <p class="error"><?php if (isset($r['error']['consent'])) {
                        echo $r['error']['consent'];
                    } ?></p>
        </div>

        <label>
            <input type="submit" value="Enviar datos" />
        </label>
    </form>
</body>

</html>
HTML;
}

# Comprobamos los datos del formulario
$r = comprobarDatos($_GET); 

HTMLform();

acabarSesion(); 

?>