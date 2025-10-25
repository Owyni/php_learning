<?php

$api_key = "e66da4a07420273cb1800d6a7cf2fda0";
$ciudad = $_GET['city'] ?? 'madrid';

$timezones = [
    'madrid' => 'Europe/Madrid',
    'mexico' => 'America/Mexico_City',
    'tokyo' => 'Asia/Tokyo'
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
        'tokyo' => 'Tokyo'
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima en <?php echo $nombre; ?> </title>
    <link rel="stylesheet" href="styles.css">
    <script src="myscript.js" defer></script>
</head>

<body>

    <div id="contenedor-principal">

        <aside class="lateral-izquierdo">
            <p class="hora">🕒 Hora actual: <?php echo htmlspecialchars($hora); ?></p>
        </aside>

        <main class="centro">
            <?php
            echo '<form method="get">
            <label for="city">Ciudad:</label>
            <select id="city" name="city" required>';
            foreach ($ciudades as $valor => $ciudad) {
                $selected = ($selectedCity === $valor) ? 'selected' : '';
                echo "<option value=\"$valor\" $selected>$ciudad</option>";
            }
            echo '  </select>
            <button type="submit">Buscar</button>
          </form>';
            ?>

            <form action="guardar.php" method="POST" class="user-form">
                <h2>Registro de Usuario</h2>
                <label>Nombre:</label><br>
                <input type="text" name="nombre" required><br><br>

                <label>Edad:</label><br>
                <input type="number" name="edad" required><br><br>

                <label>Profesión:</label><br>
                <input type="text" name="profesion" required><br><br>

                <button type="submit">Guardar en JSON</button>
            </form>

            <div class="audio-player">
                <audio id="myAudio">
                    <source src="sentimental.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                </audio>
            </div>

            <button id="botonReproducir" class="control-button"
                style="background-image: url('play.jpg'); border-radius: 40%;"></button>
            <button id="botonPausa" class="control-button hide"
                style="background-image: url('pause.jpg'); border-radius: 40%;"></button>

        </main>

        <aside class="lateral-derecho">
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/2640/2640490.png" style="width: 100px;">
                <p><strong><?php echo $descripcion; ?></strong></p>
                <p>🌡️ Temperatura: <?php echo $temp; ?> °C</p>
                <p>🧊 sensación térmica: <?php echo $sensacion ?> °C</p>
                <p>💧 Humedad: <?php echo $humedad; ?> %</p>
            </div>
        </aside>

    </div>

</body>

</html>