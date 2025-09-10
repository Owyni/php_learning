<?php

$alumnos = [
    ["nombre" => "Owynn",    "edad" => 20, "calificacion" => 9],
    ["nombre" => "Emilio",   "edad" => 22, "calificacion" => 8],
    ["nombre" => "Nicolai",  "edad" => 19, "calificacion" => 9],
    ["nombre" => "Garon",    "edad" => 21, "calificacion" => 7],
];

foreach ($alumnos as $alumno) {
    if ($alumno["calificacion"] > 7) {
        echo "Nombre: " . $alumno["nombre"] . 
             " | Edad: " . $alumno["edad"] . 
             " | Calificación: " . $alumno["calificacion"] . "<br>";
    }
}

?>
