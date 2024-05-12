<?php
session_start();

if (isset($_POST['limpiar'])) {
    session_unset();
    session_destroy();
    session_start();
}

if (!isset($_SESSION['tablero'])) {
    $_SESSION['tablero'] = [
        ['libre', 'libre', 'libre'],
        ['libre', 'libre', 'libre'],
        ['libre', 'libre', 'libre']
    ];
    $_SESSION['turno'] = 'rojo';
}

if (isset($_POST['poner00'])) {
    $_SESSION['tablero'][0][0] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner01'])) {
    $_SESSION['tablero'][0][1] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner02'])) {
    $_SESSION['tablero'][0][2] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner10'])) {
    $_SESSION['tablero'][1][0] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner11'])) {
    $_SESSION['tablero'][1][1] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner12'])) {
    $_SESSION['tablero'][1][2] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner20'])) {
    $_SESSION['tablero'][2][0] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner21'])) {
    $_SESSION['tablero'][2][1] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}
if (isset($_POST['poner22'])) {
    $_SESSION['tablero'][2][2] = $_SESSION['turno'];
    $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'amarillo' : 'rojo';
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>3 en raya</title>
    <style>
        body {
            font-family: helvetica;
        }

        .juego {
            width: 200px;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .juego>h1 {
            width: 100%;
            background-color: lightgreen;
            text-align: center;
        }

        .juego>.informacion {
            width: 100%;
            background-color: lightgreen;
        }

        .informacion {
            margin: 5px 0;
            padding: 5px;
        }

        .informacion img {
            vertical-align: middle;
        }

        .informacion p {
            text-align: center;
            margin: auto;
        }

        .libre {
            transition: transform .5s ease-in-out;
        }

        .libre:hover {
            transform: scale(1.5);
            cursor: pointer;
        }

        .ganador {
            animation: anim 0.5s infinite linear alternate;
        }

        @keyframes anim {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.5);
            }
        }
    </style>
</head>

<body>
    <section class="juego">
        <h1>3 en raya</h1>
        <section class="tablero">
            <form method="post" action=<?php echo $_SERVER['SCRIPT_NAME'] ?>>
                <table>
                    <tr>
                        <td><input type="image" class=<?php if(isset($_SESSION['tablero'][0][0]) && $_SESSION['tablero'][0][0] == 'libre') echo 'libre'; ?> 
                        src=<?php if(isset($_SESSION['tablero'][0][0]) && $_SESSION['tablero'][0][0] == 'rojo') print "brojo.png" : print "bazul.png"; ?> width="50px" formmethod="post"
                                name="poner00" /></td>
                        <td><input type="image" class="libre" src="bamarillo.png" width="50px" formmethod="post"
                                name="poner01" /></td>
                        <td><input type="image" src="bazul.png" width="50px" formmethod="post" name="poner02" /></td>
                    </tr>
                    <tr>
                        <td><input type="image" src="brojo.png" width="50px" formmethod="post" name="poner10" /></td>
                        <td><input type="image" src="brojo.png" width="50px" formmethod="post" name="poner11" /></td>
                        <td><input type="image" class="libre" src="bamarillo.png" width="50px" formmethod="post"
                                name="poner12" /></td>
                    </tr>
                    <tr>
                        <td><input type="image" class="libre" src="bamarillo.png" width="50px" formmethod="post"
                                name="poner20" /></td>
                        <td><input type="image" src="bazul.png" width="50px" formmethod="post" name="poner21" /></td>
                        <td><input type="image" class="libre" src="bamarillo.png" width="50px" formmethod="post"
                                name="poner22" /></td>
                    </tr>
                </table>
            </form>
        </section>
        <section class="informacion">
            <p>Turno: <img src="brojo.png" width="25px" /></p>
        </section>
        <section class="botones">
            <form method="post" action="">
                <input type="submit" name="limpiar" value="Limpiar" />
            </form>
        </section>
    </section>
</body>

</html>