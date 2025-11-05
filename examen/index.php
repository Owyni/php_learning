<?php

date_default_timezone_set("America/Mexico_City");
$audio_source = 'audio.mp3';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="myscript.js" defer></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do list de tareas</title>
</head>

<body>
    <h1 style="text-align: center;">Mi Agenda</h1>
    <header class="header">
        <form action="guardar.php" method="POST"
            style="display: flex; justify-content: space-around; align-items: center;">
            <input type="text" id="tarea" name="tarea" placeholder="Tarea a ingresar">
            <input type="time" id="hora" name="hora" placeholder="Hora límite">
            <button type="submit" class="Agregar-tarea">
                Agregar tarea
            </button>
        </form>

    </header>

    <form class="lista_tareas" style="text-align: center; margin-top: 20px;">
        <h2>Lista de Tareas</h2>
        <div class="tareas">
            <?php
            $file_path = 'registros_tareas.json';
            if (file_exists($file_path) && filesize($file_path) > 0) {
                $json_content = file_get_contents($file_path);
                $registros = json_decode($json_content, true);

                if (is_array($registros)) {
                    foreach ($registros as $registro) {
                        echo '<li>' . htmlspecialchars($registro['hora_limite']) . ' Tarea :  ' . htmlspecialchars($registro['tarea']) . '</li>';
                    }
                } else {
                    echo '<li>No hay tareas registradas.</li>';
                }
            } else {
                echo '<li>No hay tareas registradas.</li>';
            }
            ?>

        </div>
        <ul id="lista-tareas">
        </ul>
    </form>

    <?php 
    $horaMexico = date('H:i');
    
    foreach ($registros as $registro) {
        if ($horaMexico == $registro['hora_limite']) {
                echo '<div class="audio-player">
                <audio autoplay  id="myAudio">
                    <source src="audio.mp3" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                </audio>
            </div>';
        }
        else {
            echo "";
        }
    }
    
    ?>
    <h2>Es hora de: <?php foreach ($registro as $registros)
        if ($horaMexico == $registro['hora_limite']) {
            echo $registro['tarea'];
        }?></h2>
</body>

</html>