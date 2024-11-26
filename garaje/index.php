<?php
    require_once __DIR__ .'/includes/functions.php';

    if (isset($_GET['accion']) && isset($_GET['id'])) {
        switch ($_GET['accion']) {
            case 'eliminar' :
                $count = eliminarVehiculo($_GET['id']);
                $mensaje = $count > 0 ? "Vehiculo eliminado con exito." : "No se pudo eliminar el vehiculo.";
                break;
            case 'toggleCompletada':
                $nuevoEstado = toggleVehiculoCompletado($_GET['id']);
                if ($nuevoEstado !== null) {
                    $mensaje = $nuevoEstado ? "Vehiculo marcado como completo." : "Vehiculo marcado como no completado.";
                } else {
                    $mensaje = "No se pudo cambiar el estado del vehiculo.";
                }
                break;
        }
    }

    $auto = obtenerVehiculo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Vehiculos</h1>

        <?php if (isset($mensaje)): ?>
            <div class="<?php echo $count > 0 ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <a href="agregar_vehiculo.php" class="button">Agregar un nuevo Vehiculo</a>

        <h2>Lista de los vehiculos</h2>
        <table>
            <tr>
                <th>Placa</th>
                <th>Tipo de vehiculo</th>
                <th>Color</th>
                <th>Fecha de entrada</th>
                <th>Hora de entrada</th>
                <th>Fecha de salida</th>
                <th>Hora de salida</th>
                <th>Completado</th>
            </tr>
            <?php foreach ($auto as $Vehiculo): ?>
            <tr>
                <td><?php echo htmlspecialchars($Vehiculo['placa']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['tipo']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['color']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['f_entrada']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['h_entrada']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['f_salida']); ?></td>
                <td><?php echo htmlspecialchars($Vehiculo['h_salida']); ?></td>
                <td><?php echo $Vehiculo['completada'] ? 'Sí' : 'No'; ?></td>
                <td class="actions">
                    <a href="editar_vehiculo.php?id=<?php echo $Vehiculo['_id']; ?>" class="button">Editar</a>
                    <a href="index.php?accion=eliminar&id=<?php echo $Vehiculo['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>