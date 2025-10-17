<?php

$api_key = "e66da4a07420273cb1800d6a7cf2fda0";
$ciudad = $_GET['city'] ?? 'madrid';

$timezones = [
    'madrid' => 'Europe/Madrid',
    'mexico' => 'America/Mexico_City',
    'tokio'  => 'Asia/Tokyo'
];

$selectedCity = $ciudad;
$tz = $timezones[$selectedCity] ?? 'UTC';
$dt = new DateTime('now', new DateTimeZone($tz));
$hora = $dt->format('H:i');
$year = $dt->format('Y');

$units = "metric";
$lang = "es";

$url = "https://api.openweathermap.org/data/2.5/weather?q={$ciudad}&appid={$api_key}&units={$units}&lang={$lang}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data["cod"]) && $data["cod"] == 200) {

    $nombre = $data["name"];
    $ciudades = [
        'madrid' => 'Madrid',
        'mexico' => 'Mexico',
        'tokio' => 'Tokio'
    ];

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
    <script src="myscript.js" defer></script>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima en <?php echo $nombre; ?> </title>
</head>

<body style="margin: auto; background-color: gray;">

    <div class="card" style="display: flex; margin: 15px; justify-content: space-between;">
        <p>🕒 Hora actual: <?php echo htmlspecialchars($hora); ?></p>
        <h1><?php echo "$nombre" ?></h1>
        <div style="">
            <img src="https://cdn-icons-png.flaticon.com/512/2640/2640490.png" style="width: 100px;">
            <p><strong><?php echo $descripcion; ?></strong></p>
            <p>🌡️ Temperatura: <?php echo $temp; ?> °C</p>
            <p>🧊 sensación térmica: <?php echo $sensacion ?> °C</p>
            <p>💧 Humedad: <?php echo $humedad; ?> %</p>
        </div>
    </div>

    <?php
    echo '<form method="get" style="margin: 15px; text-align: center; margin-top: 200px;">
            <label for="city">Ciudad:</label>
            <select id="city" name="city" required>';
    foreach ($ciudades as $valor => $ciudad) {
        $selected = (strtolower($nombre) == strtolower($ciudad)) ? 'selected' : '';
        echo "<option value=\"$valor\" $selected>$ciudad</option>";
    }
    echo '  </select>
            <button type="submit">Buscar</button>
          </form>';
    ?>

<div class="audio-player">
  <audio id="miAudio">
    <source src="audio/music.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>
  </audio>

    <h2 style="display: flex; justify-content: center; margin-top: 100px;">PLAY</h2>
    <button id="botonReproducir" style="display: block; margin: auto;">▶</button>


</body>

<footer style="justify-content: center; display: flex; margin-top: 200px;">
    <p>Derechos reservados © <?php echo $year; ?> UVAQ</p>
</footer>

</html>