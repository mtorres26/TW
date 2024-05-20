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
    $param = session_get_cookie_params();
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
    if (!isset($p['nombre']) || !preg_match("/^[A-Z][a-z]+$/", $p['nombre'])) {
        $res['nombre'] = "El nombre no es válido";
    } else {
        $_SESSION['nombre'] = $p['nombre'];
        $res['nombre'] = "";
    }
    if(isset($p['ape'])){
        $_SESSION['ape'] = $p['ape'];
    }
    if (!isset($p['dni']) || !preg_match("/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]$/i", $p['dni'])) {
        $res['dni'] = "El DNI no es válido";
    } else {
        $_SESSION['dni'] = $p['dni'];
        $res['dni'] = "";
    }
    if (!isset($p['nacim']) || !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $p['nacim']) || date($p['nacim']) > date("2006-05-12")) {
        $res['nacim'] = "La fecha de nacimiento no es válida";
    } else {
        $_SESSION['nacim'] = $p['nacim'];
        $res['nacim'] = "";
    }
    if(isset($p['nacion'])){
        $_SESSION['nacion'] = $p['nacion'];
    }
    if (!isset($p['sexo']) || !preg_match("/^(Masculino|Femenino|No deseo responder)$/", $p['sexo'])) {
        $res['sexo'] = "El sexo no es válido";
    } else {
        $_SESSION['sexo'] = $p['sexo'];
        $res['sexo'] = "";
    }
    if (!isset($p['email']) || !filter_var($p['email'], FILTER_VALIDATE_EMAIL)) {
        $res['email'] = "El email no es válido";
    } else {
        $_SESSION['email'] = $p['email'];
        $res['email'] = "";
    }
    if (!isset($p['clave1']) || ($p['clave1'] != $p['clave2'])) {
        $res['clave1'] = "La clave no es válida";
    } else {
        $_SESSION['clave1'] = $p['clave1'];
        $res['clave1'] = "";
    }
    if (!isset($p['clave2']) || ($p['clave2'] != $p['clave1'])) {
        $res['clave1'] = "La clave no es válida";
    } else {
        $_SESSION['clave2'] = $p['clave2'];
        $res['clave1'] = "";
    }
    if (!isset($p['idioma']) || !preg_match("/^(Español|Inglés|Francés)$/", $p['idioma'])) {
        $res['idioma'] = "El idioma no es válido";
    } else {
        $_SESSION['idioma'] = $p['idioma'];
        $res['idioma'] = "";
    }
    
    if (isset($p['preferencias[]']) && preg_match("/^(smoking|pets|views|carpet)$/", $p['preferencias[]'])) {
        $_SESSION['preferencias'] = $p['preferencias[]'];
    }

    if (!isset($p['consent'])) {
        $res['consent'] = "El consentimiento no es válido";
    } else {
        $_SESSION['consent'] = $p['consent'];
        $res['consent'] = "";
    }

    return $res;
    
}

# Funcion que comprueba si hay errores
function hayErrores($arrayErrores){
    foreach($arrayErrores as $error){
        if($error != ""){
            return true;
        }
    }
    return false;
}

# Funcion que genera el formulario
function HTMLForm($variables, $arrayErrores){
echo<<<HTML
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
        </style>
    </head>
    HTML;


echo   "<body>
        <h1>Registro de usuarios</h1>";
echo   "<form action={$_SERVER['SCRIPT_NAME']} method=\"GET\" novalidate>
            <fieldset>
                <legend>Datos personales</legend>
                <div class=\"subapartado\">
                    <div class=\"subsub_aux\">
                        <label>Nombre:
                            <input type=\"text\" name=\"nombre\" placeholder=\"Obligatorio\" $readonly value=\"$nombre\" >
                        </label>
                        <p class=\"error\"><?php (isset($_GET['envio']) && isset($arrayErrores['nombre'])) ? print $arrayErrores['nombre'] : print " "; ?><p>
    
                        <label>Apellidos:
                            <input type="text" name="ape" placeholder="Opcional..." <?php echo $readonly ?> value=<?php isset($_SESSION['ape']) ? print $_SESSION['ape'] : print " "; ?> >
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['ape'])) ? print $arrayErrores['ape'] : print " "; ?></p>
                    </div>
                    <div class="subsub_conborde">
                        <label for="idfoto">Fotografía:</label>
                        <input type="file" name="foto" id="idfoto" accept=".jpg" />
                    </div>
                </div>";

echo            "<div class="subapartado">
                    <div class="subsub_aux">
                        <label>DNI:
                            <input type="text" name="dni" <?php echo $readonly ?> value=<?php isset($_SESSION['dni']) ? print $_SESSION['dni'] : print ""; ?>>
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['dni'])) ? print $arrayErrores['dni'] : print ""; ?></p>
    
                        <label>Fecha de nacimiento:
                            <input type="date" name="nacim" <?php echo $readonly ?> value=<?php isset($_SESSION['nacim']) ? print $_SESSION['nacim'] : print ""; ?> >
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['nacim'])) ? print $arrayErrores['nacim'] : print ""; ?></p>
                    </div>
                    <div class="subsub_aux">
                        <label>Nacionalidad:
                            <input type="text" name="nacion" <?php echo $readonly ?> value=<?php isset($_SESSION['nacion']) ? print $_SESSION['nacion'] : print ""; ?> >
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['nacion'])) ? print $arrayErrores['nacion'] : print ""; ?></p>
    
                        
                        <label>Sexo:
                            <select name="sexo" value=<?php isset($_SESSION['sexo']) ? print $_SESSION['sexo'] : print ""; ?> >
                                <option <?php if(isset($_SESSION['sexo'])) {
                                    if($_SESSION['sexo'] == "Masculino") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>Masculino</option>
                                <option <?php if(isset($_SESSION['sexo'])) {
                                    if($_SESSION['sexo'] == "Femenino") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>Femenino</option>
                                <option <?php if(isset($_SESSION['sexo'])) {
                                    if($_SESSION['sexo'] == "No deseo responder") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>No deseo responder</option>
                            </select>
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['sexo'])) ? print $arrayErrores['sexo'] : print ""; ?></p>
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
                        <input type="email" name="email" <?php echo $readonly ?> value=<?php isset($_SESSION['email']) ? print $_SESSION['email'] : print ""; ?>>
                    </label>
                    <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['email'])) ? print $arrayErrores['email'] : print ""; ?></p>
                </div>
                <div class="subapartado">
                    <div class="subsub_aux">
                        <label>Clave:
                            <input type="password" name="clave1" placeholder="Introduzca una clave..."
                                <?php echo $readonly ?> value=<?php isset($_SESSION['clave1']) ? print $_SESSION['clave1'] : print ""; ?> >
                        </label>
                        <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['clave1'])) ? print $arrayErrores['clave1'] : print ""; ?></p>
                    </div>
                    <div class="subsub_aux">
                        <label>Repita la clave:
                            <input type="password" name="clave2" id="idclave" placeholder="Introduzca la misma clave..."
                                <?php echo $readonly ?> value=<?php isset($_SESSION['clave2']) ? print $_SESSION['clave2'] : print ""; ?> >
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
                        <input type="radio" name="idioma" value="Español" <?php if(isset($_SESSION['idioma']))
                        {if($_SESSION['idioma'] == "Español") {print "checked";}
                        else if($datosRec){print "disabled";}}  ?>/>Español
                    </label>
                    <label>
                        <input type="radio" name="idioma" value="Inglés" <?php if(isset($_SESSION['idioma']))
                        {if($_SESSION['idioma'] == "Inglés") {print "checked";}
                        else if($datosRec){print "disabled";}}  ?>/>Inglés
                    </label>
                    <label>
                        <input type="radio" name="idioma" value="Francés" <?php if(isset($_SESSION['idioma']))
                        {if($_SESSION['idioma'] == "Francés") {print "checked";}
                        else if($datosRec){print "disabled";}}  ?> />Francés
                    </label>
                    <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['idioma'])) ? print $arrayErrores['idioma'] : print ""; ?></p>
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
                    <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['preferencias[]'])) ? print $arrayErrores['preferencias[]'] : print ""; ?></p>
                </div>
                <div class="oculto">
                    <p>Marque el idioma con el que tenga más facilidad de comunicación y una o varias preferencias sobre el
                        tipo de habitación que desea.</p>
                </div>
            </fieldset>
    
            <!-- selected para valores por defecto y value=... para enviar al server lo justo -->
            <div class="tratamiento">
                <label>Tratado de datos y envío a terceros:
                    <select name="consent" value=<?php isset($_SESSION['consent']) ? print $_SESSION['consent'] : print ""; ?>>
                        <option value="TOTAL" <?php if(isset($_SESSION['consent'])) {
                                    if($_SESSION['consent'] == "TOTAL") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>Acepta el almacenamiento de mis datos y el envío a terceros</option>
                        <option value="PARCIAL" <?php if(isset($_SESSION['consent'])) {
                                    if($_SESSION['consent'] == "PARCIAL") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>Acepta el almacenamiento de mis datos pero no el envío a terceros</option>
                        <option value="NINGUNO" <?php if(isset($_SESSION['consent'])) {
                                    if($_SESSION['consent'] == "NINGUNO") {print "selected";}
                                    else if($datosRec){print "disabled";}}?>>No acepta el almacenamiento ni el envío de datos a terceros</option>
                    </select>
                </label>
                <p class="error"><?php (isset($_GET['envio']) && isset($arrayErrores['consent'])) ? print $arrayErrores['consent'] : print ""; ?></p>
            </div>
    
            <label>
                <input type="submit" name="envio" value="Enviar datos" />
            </label>
        </form>
    </body>
    
    </html>
"
}

# Funcion para generar la tabla de tuplas
function HTMLTuplas($usuarios){
    echo<<<HTML
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
    
            h1 {
                color: white;
                padding: 8px;
                background-color: steelblue;
                margin: 10px;
                font-size: 26px;
            }
        </style>
    </head>
    HTML;
    
    echo "<body>";
    echo "<h1>Usuarios registrados</h1>";
    echo    "<table>";
    echo    "<tr>";
    echo        "<th>Nombre</th>";
                "<th>Apellidos</th>";
                "<th>Email</th>";
            "</tr>";
            foreach ($usuarios as $usuario) : 
            echo   "<tr>";
            echo        "<td>{$usuario['nombre']} </td>";
            echo        "<td>$usuario['apellidos'] </td>";
            echo        "<td>$usuario['email']</td>";
            echo   "</tr>";
            endforeach; 
    echo <<< HTML 
    </table>
    </body>
    
    </html>
    HTML;
}

# Funcion que inicializa las variables del formulario a vacío o las iguala al array de sesion
function inicializaVariables(){
    if(isset($_SESSION['nombre'])){
        $variables['nombre'] = $_SESSION['nombre'];
    } else {
        $variables['nombre'] = "";
    } 
    if(isset($_SESSION['ape'])){
        $variables['ape'] = $_SESSION['ape'];
    } else{
        $variables['ape'] = "";
    }
    if(isset($_SESSION['dni'])){
        $dni = $_SESSION['dni'];
    } else{
        $dni = "";
    }
    if(isset($_SESSION['nacim'])){
        $nacim = $_SESSION['nacim'];
    } else {
        $nacim = "";
    }
    if(isset($_SESSION['nacion'])){
        $nacion = $_SESSION['nacion'];
    } else {
        $nacion = "";
    }
    if(isset($_SESSION['sexo'])){
        $sexo = $_SESSION['sexo'];
    } else {
        $sexo = "";
    }
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
    } else {
        $email = "";
    }
    if(isset($_SESSION['clave1'])){
        $clave = $_SESSION['clave1'];
    } else {
        $clave = "";
    }
    if(isset($_SESSION['idioma'])){
        $idioma = $_SESSION['idioma'];
    } else {
        $idioma = "";
    }
    if(isset($_SESSION['preferencias'])){
        $preferencias = $_SESSION['preferencias'];
    } else {
        $preferencias = "";
    }
    if(isset($_SESSION['consent'])){
        $consent = $_SESSION['consent'];
    } else {
        $consent = "";
    }
    return $variables;
}


$db = conectar_bd();

$arrayErrores = comprobarDatos($_GET);

# Si no hay errores, se deshabilita el formulario
if(hayErrores($arrayErrores)){
    $readonly = "";
} else if(isset($_GET['envio'])){
    $readonly = "readonly";
}

$variables = inicializaVariables();

HTMLForm($variables, $arrayErrores);
HTMLTuplas(obtener_usuarios());

desconectar_bd($db);

# Se finaliza la sesion si todo esta correcto
if(!hayErrores($arrayErrores) && isset($_GET['envio'])){
    acabarSesion();
}?>
