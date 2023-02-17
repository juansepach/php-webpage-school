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
            gap: 10px;
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
    <title>Agregar asignatura</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h3>Añadir asignaturas</h3>
        <input type="number" name="codasig" id="codasig" placeholder="Código asignatura" required autofocus>
        <input type="text" name="nombre" id="nombre" placeholder="Asignatura" required>
        <input type="number" name="horas" id="horas" placeholder="Horas de duración" required>       
        <input type="submit" name="submit" value="Enviar valores">
	<a class="fcc-btn" href="index.php">Cursos</a>
	<a class="fcc-btn" href="alumno.php">Alumnos</a>
	<a class="fcc-btn" href="listado.php">Resumen</a>
	<a class="fcc-btn" href="nota.php">Notas</a>
    </form>
    <footer>
        <p>Test Website</p>
    </footer>


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
    is_numeric($_POST['codasig'])  &&
    is_numeric($_POST['horas']);
// Si no pasa la validación, termina.
if (!$es_valido) {
    die('<h3>Sin datos de entrada</h3>');
}
// Almacenamos los datos escapando los caracteres especiales
// por seguridad
$codasig = $enlace->real_escape_string($_POST['codasig']);
$nombre = $enlace->real_escape_string($_POST['nombre']);
$horas = $enlace->real_escape_string($_POST['horas']);
/* Definición de la consulta y ejecución*/
$sql = sprintf(
    "insert into asignaturas values (%d, '%s', %d)",
   $codasig,
   $nombre,
   $horas,
);

// Asignamos código HTML a una variable
// para mostrar los datos agregados a la BD
$tabla_resultado = "
<h3>Datos registrados:</h3>
<table>
<thead>
    <th>Código de asignatura</th>
    <th>Nombre</th>
    <th>Duración (horas)</th>
</thead>
<tbody>
    <tr>
        <td>$codasig</td>
        <td>$nombre</td>
        <td>$horas</td>
    </tr>
</tbody>
</table>";
 
if ($enlace->query($sql) === TRUE) {
    echo $tabla_resultado;
} else {
    echo "<h3>Error agregando los datos</h3>";
}

// Cierro la conexión con la base de datos
$enlace->close();
?>

</body>

</html>
