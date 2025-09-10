<?php

date_default_timezone_set("America/Mexico_City");
$horaMexico = date("H");

if ($horaMexico > 0 && $horaMexico < 12) {
  echo "Buenos dias!";
}

if ($horaMexico >= 12 && $horaMexico < 19) {
    echo "Buenas tardes!";
}

if ($horaMexico >= 19 && $horaMexico <= 24) {
    echo "Buenas noches!";
}

$zonas = [
  "America/Mexico_City" => "México",
  "Europe/Madrid" => "Madrid",
  "Asia/Tokyo" => "Tokio"
];

foreach ($zonas as $zona => $nombre) {
    date_default_timezone_set($zona);
    echo "La hora en $nombre es: " . date("H:i:s") . "<br>";
}

?>