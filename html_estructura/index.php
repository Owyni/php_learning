<?php
$hora_actual = date("H:i:s");
$anio_actual = date("Y");

$api_key="e66da4a07420273cb1800d6a7cf2fda0";
$ciudad=$_GET['city']  ?? 'madrid';

$units="metric";
$lang="es";

$url="https://api.openweathermap.org/data/2.5/weather?q={$ciudad}&appid={$api_key}&units={$units}&lang={$lang}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response,true);

if(isset($data["cod"]) && $data["cod"] == 200) {
    $nombre = $data["name"];
    $pais = $data["sys"]["country"];
    $temp = $data["main"]["temp"];
    $sensacion = $data["main"]["feels_like"];
    $humedad = $data["main"]["humidity"];
    $descripcion = ucfirst($data["weather"][0]["description"]);
    $icono = $data["weather"][0]["icon"];
} else {
    die("No se encontró ciudad: " . htmlspecialchars($ciudad));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima en <?php echo $nombre; ?> </title>
    </head>
<body>

    <div class="card" style="width: 300px;">
        <h1><?php echo "$nombre, $pais"?></h1>
        <img src="https://cdn-icons-png.flaticon.com/512/2640/2640490.png" style="width: 100px;" <?php echo$icono; ?>@2x.png" alt="icono">
        <p><strong><?php echo $descripcion; ?></strong></p>
        <p>🌡️ Temperatura: <?php echo $temp;?> °C</p>
        <p>🧊 sensación térmica: <?php echo $sensacion?> °C</p>
        <p>💧 Humedad: <?php echo $humedad; ?> %</p>
    </div>

    <footer style="justify-content: center; display: flex;">
        <p>Derechos reservados © <?php echo $anio_actual; ?> UVAQ</p>
    </footer>

</body>
</html>