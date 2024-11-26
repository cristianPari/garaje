<?php
require_once __DIR__ . '/../config/database.php';

function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

function formatDate($date)
{
    return $date->toDateTime()->format('Y-m-d');
}

function crearVehiculo($placa, $tipo, $color, $f_entrada, $h_entrada, $f_salida, $h_salida)
{
    global $tasksCollection;

    // Combina las fechas y horas
    $entrada = DateTime::createFromFormat('Y-m-d H:i', "$f_entrada $h_entrada") ?: null;
    $salida = DateTime::createFromFormat('Y-m-d H:i', "$f_salida $h_salida") ?: null;

    // Valida que las fechas y horas sean válidas
    if (!$entrada || !$salida) {
        throw new Exception("Las fechas y horas no tienen un formato válido.");
    }

    // Inserta los datos
    $resultado = $tasksCollection->insertOne([
        'placa' => sanitizeInput($placa),
        'tipo' => sanitizeInput($tipo),
        'color' => sanitizeInput($color),
        'f_entrada' => $entrada->format('Y-m-d'),
        'h_entrada' => $entrada->format('H:i:s'),
        'f_salida' => $salida->format('Y-m-d'),
        'h_salida' => $salida->format('H:i:s'),
        'completada' => false
    ]);

    return $resultado->getInsertedId();
}

function obtenerVehiculo()
{
    global $tasksCollection;
    return $tasksCollection->find();
}

function obtenerVehiculoPorId($id)
{
    global $tasksCollection;
    return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarVehiculo($id, $placa, $tipo, $color, $f_entrada, $h_entrada, $f_salida, $h_salida, $completada)
{
    global $tasksCollection;

    $entrada = DateTime::createFromFormat('Y-m-d H:i', "$f_entrada $h_entrada") ?: null;
    $salida = DateTime::createFromFormat('Y-m-d H:i', "$f_salida $h_salida") ?: null;

    if (!$entrada || !$salida) {
        throw new Exception("Las fechas y horas no tienen un formato válido.");
    }

    $resultado = $tasksCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'placa' => sanitizeInput($placa),
            'tipo' => sanitizeInput($tipo),
            'color' => sanitizeInput($color),
            'f_entrada' => $entrada->format('Y-m-d'),
            'h_entrada' => $entrada->format('H:i:s'),
            'f_salida' => $salida->format('Y-m-d'),
            'h_salida' => $salida->format('H:i:s'),
            'completada' => (bool)$completada
        ]]
    );

    return $resultado->getModifiedCount();
}


function eliminarVehiculo($id) {
    global $tasksCollection;
    $resultado = $tasksCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $resultado->getDeletedCount();
}

function toggleVehiculoCompletado($id) {
    global $tasksCollection;
    $vehiculo = $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    if ($vehiculo) {
        $nuevoEstado = !$vehiculo['completada'];
        $resultado = $tasksCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['completada' => $nuevoEstado]]
        );
        return $resultado->getModifiedCount() > 0 ? $nuevoEstado : null;
    }
    return null;
}
