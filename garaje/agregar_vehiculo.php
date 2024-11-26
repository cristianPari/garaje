<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = crearVehiculo($_POST['placa'], $_POST['tipo'], $_POST['color'], $_POST['f_entrada'], $_POST['h_entrada'], $_POST['f_salida'], $_POST['h_salida']);

    if ($id) {
        header("Location: index.php");
        exit;
    } else{
        $error = "No se pudo crear el registro del vehiculo";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Agregar un nuevo vehiculo</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif ?>

    <form method="POST">
        <label>Placa: <input type="text" name="placa" required></label><br>
        <label>Tipo de vehiculo: <input type="text" name="tipo" required></label><br>
        <label>Color: <input type="text" name="color" required></label><br>
        <label>Fecha de Ingreso: <input type="date" name="f_entrada" required></label><br>
        <label>Hora de Ingreso: <input type="time" name="h_entrada" required></label><br>
        <label>Fecha de Salida: <input type="date" name="f_salida" required></label><br>
        <label>Hora de Salida: <input type="time" name="h_salida" required></label><br>
        <button type="submit" class="button">Registrar</button>
        <!-- <input type="submit" value="Registrar"> -->
    </form>

    <a href="index.php">Ver la lista de los Vehiculos</a>
</body>
</html>