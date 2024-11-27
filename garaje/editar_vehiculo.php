<?php
require_once __DIR__ . '/includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$vehiculo = obtenerVehiculoPorId($_GET['id']);

if (!$vehiculo) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['f_entrada']) || empty($_POST['h_entrada']) || empty($_POST['f_salida']) || empty($_POST['h_salida'])) {
        $error = "Las fechas y horas son obligatorias.";
    } else {
        try {
            $count = actualizarVehiculo($_GET['id'], $_POST['placa'], $_POST['tipo'], $_POST['color'], $_POST['f_entrada'], $_POST['h_entrada'], $_POST['f_salida'], $_POST['h_salida'], isset($_POST['completada']));
            if ($count > 0) {
                header("Location: index.php");
                exit;
            } else {
                $error = "No se pudo actualizar la tarea.";
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar el registro del vehiculo</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Editar el registro del vehiculo</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Placa: <input type="text" name="placa" value="<?php echo htmlspecialchars($vehiculo['placa']); ?>" required></label><br>
        <label>Tipo de vehiculo: <input type="text" name="tipo" value="<?php echo htmlspecialchars($vehiculo['tipo']); ?>" required></label><br>
        <label>Color: <input type="text" name="color" value="<?php echo htmlspecialchars($vehiculo['color']); ?>" required></label><br>

        <label>
            Fecha de entrada:
            <input type="date" name="f_entrada"
                value="<?php echo isset($vehiculo['f_entrada']) ? date('Y-m-d', strtotime($vehiculo['f_entrada'])) : ''; ?>">
        </label><br>


        <label>
            Hora de entrada:
            <input type="time" name="h_entrada"
                value="<?php echo isset($vehiculo['h_entrada']) ? date('H:i', strtotime($vehiculo['h_entrada'])) : ''; ?>">
        </label><br>

        <label>
            Fecha de salida:
            <input type="date" name="f_salida"
                value="<?php echo isset($vehiculo['f_salida']) ? date('Y-m-d', strtotime($vehiculo['f_salida'])) : ''; ?>">
        </label><br>


        <label>
            Hora de salida:
            <input type="time" name="h_salida"
                value="<?php echo isset($vehiculo['h_salida']) ? date('H:i', strtotime($vehiculo['h_salida'])) : ''; ?>">
        </label><br>

        <label>Completada: <input type="checkbox" name="completada" <?php echo $vehiculo['completada'] ? 'checked' : ''; ?>></label><br>

        <button type="submit" class="button">Actualizar Registro</button>
    </form>


    <a href="index.php">Volver a la lista de vehiculos</a>
</body>
</html>

