<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso inválido. El formulario debe enviarse por POST.");
}

$tarea = $_POST['tarea'] ?? null;
$hora_limite = $_POST['hora'] ?? null;

if (empty($tarea) || empty($hora_limite)) {
    die("Error: Faltan datos obligatorios del formulario.");
}

$nuevos_datos = [
    'tarea' => $tarea,
    'hora_limite' => $hora_limite
];

$file_path = 'registros_tareas.json';
$registros = [];

if (file_exists($file_path) && filesize($file_path) > 0) {
    $json_content = file_get_contents($file_path);
    $registros = json_decode($json_content, true);

    if (!is_array($registros)) {
        $registros = [];
    }
}

$registros[] = $nuevos_datos;

$json_actualizado = json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if ($json_actualizado !== false) {
    if (file_put_contents($file_path, $json_actualizado) !== false) {
        header("Location: index.php?status=success");
        exit;
    } else {
        die("Error: No se pudo escribir en el archivo JSON. Verifique los permisos.");
    }
} else {
    die("Error: No se pudo codificar el array a JSON.");
}
?>
