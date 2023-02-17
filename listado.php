<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #ebfaff;
        }

        h3 {
            text-align: center;
            margin-bottom: 0;
        }

        form {
            padding: 20px;
            background: #78ceeb;
            border: 1px solid black;
            border-radius: 10%;
            margin: 10px auto 20px;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type=submit] {
            padding: 10px;
        }

        .grupo {
            margin: 10px
        }

        .opcion {
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-bottom: 10px;
        }

        caption, footer {
            font-size: 0.8rem;
            padding: 5px;
            text-align: center;
        }

        th {
            background: #e9e9ca;
        }

        table,
        th,
        td {
            text-align: center;
            margin: 10px auto;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
    <title>Test Website</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h3>Tablas disponibles</h3>
        <div class="grupo">
            <div class="opcion">
                <input type="radio" id="alumnos" name="resultado" value="0" />
                <label for="alumnos">Alumnos</label>
            </div>
            <div class="opcion">
                <input type="radio" id="cursos" name="resultado" value="1" />
                <label for="cursos">Cursos</label>
            </div>
            <div class="opcion">
                <input type="radio" id="asignaturas" name="resultado" value="2" />
                <label for="asignaturas">Asignaturas</label>
            </div>
            <div class="opcion">
                <input type="radio" id="notas" name="resultado" value="3" />
                <label for="notas">Notas</label>
            </div>
        </div>
        <input type="submit" value="Mostrar">
	<a class="fcc-btn" href="index.php">Cursos</a>
	<a class="fcc-btn" href="alumno.php">Alumnos</a>
	<a class="fcc-btn" href="asignatura.php">Asignaturas</a>
	<a class="fcc-btn" href="nota.php">Notas</a>

    </form>


    <?php
    /* Obtención de datos y validación */
    $es_valido = isset($_POST['resultado']);
    if (!$es_valido) {
        die('<h3>Debes seleccionar una tabla</h3>');
    }
    // Se preparan dos arrays con los encabezados
    // y los nombres de las tablas
    $lista_titulo_tabla = [
        'alumnos',
        'cursos',
        'asignaturas',
        'notas',
    ];
    $lista_encabezados = [
        ['Código de alumno', 'Nombre', 'Dirección', 'Curso'],
        ['Código de curso', 'Título', 'Alumnos inscritos'],
        ['Código de asignatura', 'Denominación', 'Duración (horas)'],
        ['Alumno', 'Asignatura', 'Evaluación', 'Nota']
    ];
    $tabla = $_POST['resultado'];
    $titulo_tabla = $lista_titulo_tabla[$tabla];
    $encabezados = $lista_encabezados[$tabla];

    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $user = 'lector';
    $pwd = 'otrosecreto';
    $database = 'instituto';
    $enlace = new mysqli($host, $user, $pwd, $database)
        or die('<h3>Fallo en la conexion</h3>');

    /* Consulta a la base de datos */
    $sql = sprintf("select * from %s", $enlace->real_escape_string($titulo_tabla));
    $res = $enlace->query($sql);
    ?>

    <table>        
        <thead>
            <?php
            foreach ($encabezados as $encabezado) {
                echo "<th>$encabezado</th>";
            }
            ?>
        </thead>
        <tbody>           
            <?php
                echo "<h3>Tabla de $titulo_tabla </h3>";
                if($res === FALSE or $res->num_rows == 0) {
                    echo "<td colspan='100%'><h3>SIN DATOS</h3></td>";
                    die();                    
                }
                while($fila = $res->fetch_array(MYSQLI_NUM)){
                    echo "<tr>";
                    foreach($fila as $valor) {
                        echo "<td>$valor</td>";
                    }
                    echo "</tr>";
                }
            ?>            
        </tbody>
    </table>
    <footer>Test Website</footer>
</body>

</html>
