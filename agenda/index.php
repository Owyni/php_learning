<?php
$contactos = [
    ['nombre'=>'Ana','apellido_paterno'=>'García','apellido_materno'=>'López','fecha_nacimiento'=>'1995-05-15','telefono'=>'5512345678','correo'=>'ana.garcia@ejemplo.com'],
    ['nombre'=>'Luis','apellido_paterno'=>'Martínez','apellido_materno'=>'Pérez','fecha_nacimiento'=>'1988-11-30','telefono'=>'5523456789','correo'=>'luis.martinez@ejemplo.com'],
    ['nombre'=>'Sofía','apellido_paterno'=>'Rodríguez','apellido_materno'=>'Sánchez','fecha_nacimiento'=>'2001-03-22','telefono'=>'5534567890','correo'=>'sofia.rodriguez@ejemplo.com'],
    ['nombre'=>'Javier','apellido_paterno'=>'Fernández','apellido_materno'=>'Gómez','fecha_nacimiento'=>'1975-07-04','telefono'=>'5545678901','correo'=>'javier.fernandez@ejemplo.com'],
    ['nombre'=>'Elena','apellido_paterno'=>'Díaz','apellido_materno'=>'Ruiz','fecha_nacimiento'=>'1990-01-10','telefono'=>'5556789012','correo'=>'elena.diaz@ejemplo.com'],
    ['nombre'=>'Carlos','apellido_paterno'=>'Hernández','apellido_materno'=>'Torres','fecha_nacimiento'=>'1985-09-25','telefono'=>'5567890123','correo'=>'carlos.hernandez@ejemplo.com'],
    ['nombre'=>'María','apellido_paterno'=>'Vázquez','apellido_materno'=>'Castro','fecha_nacimiento'=>'1998-04-01','telefono'=>'5578901234','correo'=>'maria.vazquez@ejemplo.com'],
    ['nombre'=>'Pedro','apellido_paterno'=>'Jiménez','apellido_materno'=>'Molina','fecha_nacimiento'=>'1970-12-18','telefono'=>'5589012345','correo'=>'pedro.jimenez@ejemplo.com'],
    ['nombre'=>'Laura','apellido_paterno'=>'Ortega','apellido_materno'=>'Ramos','fecha_nacimiento'=>'1992-06-07','telefono'=>'5590123456','correo'=>'laura.ortega@ejemplo.com'],
    ['nombre'=>'Miguel','apellido_paterno'=>'Herrera','apellido_materno'=>'Núñez','fecha_nacimiento'=>'1980-02-14','telefono'=>'5501234567','correo'=>'miguel.herrera@ejemplo.com'],
];

$nombre_buscado = $_POST['nombre_buscar'] ?? '';
$contactos_a_mostrar = $contactos;
$mensaje = "Contactos.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_buscado = trim($nombre_buscado);
    if ($nombre_buscado !== '') {
        $contactos_a_mostrar = array_filter($contactos, function($c) use ($nombre_buscado) {
            return stripos($c['nombre'], $nombre_buscado) !== false;
        });
        $mensaje = count($contactos_a_mostrar)
            ? "Resultados de la búsqueda para: <b>" . htmlspecialchars($nombre_buscado) . "</b>"
            : "No se encontraron contactos con el nombre: <b>" . htmlspecialchars($nombre_buscado) . "</b>";
    } else {
        $mensaje = "Campo de búsqueda vacío. Se muestra la lista completa.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contactos PHP</title>
    <style>
        body { font-family: Arial; background: #f4f4f9; margin: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        form { margin-bottom: 20px; display: flex; gap: 10px; }
        input[type="text"] { flex: 1; padding: 8px; }
        input[type="submit"] { padding: 8px 15px; background: #007bff; color: #fff; border: none; border-radius: 4px; }
        .mensaje { background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #e9ecef; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
<div class="container">
    <h1>📝 Directorio de Contactos</h1>
    <form method="POST">
        <input type="text" name="nombre_buscar" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($nombre_buscado); ?>">
        <input type="submit" value="Buscar">
    </form>
    <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php if ($contactos_a_mostrar): ?>
    <table>
        <tr>
            <th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th>
            <th>Fecha Nacimiento</th><th>Teléfono</th><th>Correo</th>
        </tr>
        <?php foreach ($contactos_a_mostrar as $c): ?>
        <tr>
            <td><?php echo htmlspecialchars($c['nombre']); ?></td>
            <td><?php echo htmlspecialchars($c['apellido_paterno']); ?></td>
            <td><?php echo htmlspecialchars($c['apellido_materno']); ?></td>
            <td><?php echo htmlspecialchars($c['fecha_nacimiento']); ?></td>
            <td><?php echo htmlspecialchars($c['telefono']); ?></td>
            <td><?php echo htmlspecialchars($c['correo']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No hay contactos para mostrar.</p>
    <?php endif; ?>
</div>
</body>
</html>
