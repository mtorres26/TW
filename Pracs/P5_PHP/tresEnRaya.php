<?php
session_start();

if (isset($_POST['limpiar']) || (isset($ganada) && $ganada)) {
    session_unset();
    session_destroy();
    session_start();
}

if (!isset($_SESSION['tablero'])) {
    $_SESSION['tablero'] = array(
        array('libre', 'libre', 'libre'),
        array('libre', 'libre', 'libre'),
        array('libre', 'libre', 'libre')
    );
    $_SESSION['turno'] = 'rojo';
}

# Si se pulsan los botones...
if (isset($_POST['poner00_x'])) {
    if($_SESSION['tablero'][0][0] == 'libre'){
        $_SESSION['tablero'][0][0] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner01_x'])) {
    if($_SESSION['tablero'][0][1] == 'libre'){
        $_SESSION['tablero'][0][1] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner02_x'])) {
    if($_SESSION['tablero'][0][2] == 'libre'){
        $_SESSION['tablero'][0][2] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner10_x'])) {
    if($_SESSION['tablero'][1][0] == 'libre'){
        $_SESSION['tablero'][1][0] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner11_x'])) {
    if($_SESSION['tablero'][1][1] == 'libre'){
        $_SESSION['tablero'][1][1] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner12_x'])) {
    if($_SESSION['tablero'][1][2] == 'libre'){
        $_SESSION['tablero'][1][2] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner20_x'])) {
    if($_SESSION['tablero'][2][0] == 'libre'){
        $_SESSION['tablero'][2][0] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner21_x'])) {
    if($_SESSION['tablero'][2][1] == 'libre'){
        $_SESSION['tablero'][2][1] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
} else if (isset($_POST['poner22_x'])) {
    if($_SESSION['tablero'][2][2] == 'libre'){
        $_SESSION['tablero'][2][2] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == 'rojo' ? 'azul' : 'rojo';
    }
}

function ganar($color, $fil, $col)
{
    # Cuando las rayas sean horizontales o verticales
    if ($_SESSION['tablero'][$fil][$col] == $color && $_SESSION['tablero'][$fil][($col + 1) % 3] == $color && $_SESSION['tablero'][$fil][($col + 2) % 3] == $color) {
        return true;
    } else if ($_SESSION['tablero'][$fil][$col] == $color && $_SESSION['tablero'][($fil + 1) % 3][$col] == $color && $_SESSION['tablero'][($fil + 2) % 3][$col] == $color) {
        return true;
    }
    # Cuando las rayas son diagonales
    else if ($fil == $col && $_SESSION['tablero'][($fil + 1) % 3][($col + 1) % 3] == $color && $_SESSION['tablero'][($fil + 2) % 3][($col + 2) % 3] == $color) {
        return true;
    } else if (($fil == 1 && $col == 1) || ($fil - $col == 2) || ($col - $fil == 2)) {
        if ($_SESSION['tablero'][($fil + 1) % 3][($col +2) % 3] == $color && $_SESSION['tablero'][($fil +2) % 3][($col + 1) % 3] == $color) {
            return true;
        }
    } else {
        return false;
    }
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
            <form method="post" action=<?php echo $_SERVER['SCRIPT_NAME']; ?>>
                <table>
                    <tr>
                        <td><input type="image" <?php if ($_SESSION['tablero'][0][0] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][0][0],0,0)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][0][0] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][0][0] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][0][0] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner00" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][0][1] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][0][1],0,1)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][0][1] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][0][1] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][0][1] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner01" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][0][2] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][0][2],0,2)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][0][2] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][0][2] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][0][2] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner02" /></td>
                    </tr>
                    <tr>
                        <td><input type="image" <?php if ($_SESSION['tablero'][1][0] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][1][0],1,0)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][1][0] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][1][0] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][1][0] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner10" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][1][1] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][1][1],1,1)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][1][1] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][1][1] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][1][1] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner11" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][1][2] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][1][2],1,2)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][1][2] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][1][2] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][1][2] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner12" /></td>
                    </tr>
                    <tr>
                        <td><input type="image" <?php if ($_SESSION['tablero'][2][0] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][2][0],2,0)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][2][0] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][2][0] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][2][0] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner20" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][2][1] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][2][1],2,1)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][2][1] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][2][1] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][2][1] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner21" /></td>

                        <td><input type="image" <?php if ($_SESSION['tablero'][2][2] == 'libre')
                            echo 'class="libre"'; else if(ganar($_SESSION['tablero'][2][2],2,2)) echo 'class="ganador"'; ?>
                                src=<?php if ($_SESSION['tablero'][2][2] == 'rojo') {
                                    echo "brojo.png";
                                } else if ($_SESSION['tablero'][2][2] == 'azul') {
                                    echo "bazul.png";
                                } else if ($_SESSION['tablero'][2][2] == 'libre') {
                                    echo "bamarillo.png";
                                } ?> width="50px"
                                formmethod="post" name="poner22" /></td>
                    </tr>
                </table>
            </form>
        </section>
        <section class="informacion">
            <p>Turno: <img src=<?php if (isset($_SESSION['turno'])) {
                if ($_SESSION['turno'] == 'rojo')
                    echo "brojo.png";
                else
                    echo "bazul.png";
            } ?> width="25px" /></p>
        </section>
        <section class="botones">
            <form method="post" action=<?php echo $_SERVER['SCRIPT_NAME'] ?>>
                <input type="submit" name="limpiar" value="Limpiar" />
            </form>
        </section>
    </section>
</body>

</html>