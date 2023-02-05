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
        }

        form {
            padding: 20px;
            background: #78ceeb;
            border: 1px solid black;
            border-radius: 10%;
            margin: 50px auto 20px;
            width: 300px;
            gap: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        footer {
            font-size: 0.8em;
            text-align: center;
        }

        caption {
            font-size: 0.8em;
            padding: 5px;
        }

        th {
            background: #78ceeb;
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
    <title>Agregar curso</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h3>Formulario de entrada de cursos</h3>
        <input type="number" name="curso" id="curso" placeholder="Número de curso" required autofocus>
        <input type="text" name="nomcurso" id="nomcurso" placeholder="Nombre del curso" required>
        <input type="number" name="numalum" id="numalum" placeholder="Número de alumnos" required>
        <input type="submit" name="submit" value="Enviar valores">
        <a class="fcc-btn" href="alumno.php">Alumnos</a>
	<a class="fcc-btn" href="asignatura.php">Asignaturas</a>
	<a class="fcc-btn" href="listado.php">Resumen</a>
	<a class="fcc-btn" href="nota.php">Notas</a>
    </form>
    <footer>
        <p>Test Website</p>
    </footer>
</body>

</html>

<?php

// Desactivar toda notificación de error
error_reporting(0);

// Configuración de la conexión a la base de datos
$host = 'localhost';
$user = 'admin';
$pwd = 'secreto';
$database = 'instituto';
$enlace = new mysqli($host, $user, $pwd, $database)
    or die('<h3>Fallo en la conexion</h3>');

/* Validación de los datos */
// Creo una variable booleana de validación
$es_valido = isset($_POST['submit']) &&
    is_numeric($_POST['curso'])  &&
    is_numeric($_POST['numalum']);
// Si no pasa la validación, termina.
if (!$es_valido) {
    die('<h3>Sin datos de entrada</h3>');
}
// Almacenamos los datos escapando los caracteres especiales
// por seguridad
$curso = $enlace->real_escape_string($_POST['curso']);
$nomcurso = $enlace->real_escape_string($_POST['nomcurso']);
$numalum = $enlace->real_escape_string($_POST['numalum']);

/* Definición de la consulta y ejecución*/
$sql = sprintf(
    "insert into cursos (curso, nomcurso, numalum) values (%d, '%s', %d)",
    $curso,
    $nomcurso,
    $numalum
);
// Asignamos código HTML a una variable
$tabla_resultado = "
<h3>Datos registrados:</h3>
<table>
<thead>
    <th>Número de curso</th>
    <th>Nombre del curso</th>
    <th>Número de alumnos</th>
</thead>
<tbody>
    <tr>
        <td>$curso</td>
        <td>$nomcurso</td>
        <td>$numalum</td>
    </tr>
</tbody>
</table>";

// Si hay éxito se devuelven los datos del registro
if ($enlace->query($sql) === TRUE) {
    echo $tabla_resultado;
} else {
    // Si no, se imprime un mensaje de error
    echo "<h3>Error agregando los datos</h3>";
}

// Cierro la conexión con la base de datos
$enlace->close();
?>
