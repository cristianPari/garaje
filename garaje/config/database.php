<?php
    require_once __DIR__.'/../vendor/autoload.php';
    $mongoClient = new MongoDB\Client("mongodb+srv://cristian:dvWncE4mougR6KAw@cluster0.nn6qt.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
    $database = $mongoClient->selectDataBase('garaje');
    $tasksCollection = $database->vehiculo;
?>