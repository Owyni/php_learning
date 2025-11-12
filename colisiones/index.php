<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Canvas - Detectar flechas izquierda/derecha</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #111;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        canvas {
            background: #222;
            border: 2px solid #444;
            display: block;
        }

        .info {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(0, 0, 0, 0.4);
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="info">Usa las flechas ← y → para mover el cuadro azul</div>
    <canvas id="game"></canvas>

    <script>
        // Setup canvas
        const canvas = document.getElementById('game');
        const ctx = canvas.getContext('2d');

        // Tamaño deseado en CSS píxeles
        const WIDTH = 600;
        const HEIGHT = 300;

        function resizeCanvas() {
            // Para que se vea nítido en pantallas retina
            const dpr = window.devicePixelRatio || 1;
            canvas.width = WIDTH * dpr;
            canvas.height = HEIGHT * dpr;
            canvas.style.width = WIDTH + 'px';
            canvas.style.height = HEIGHT + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0); // Normalizar el contexto
        }
        resizeCanvas();
        window.addEventListener('resize', () => {/* opcional: mantener fijo */ });

        // Estado del cuadro
        const box = {
            x: 50,            // posición x
            y: HEIGHT / 2 - 25, // posición y
            w: 50,            // ancho
            h: 50,            // alto
            speed: 200        // px por segundo
        };

        const boxred = {
            x: 300,            // posición x
            y: HEIGHT / 2 - 25, // posición y
            w: 50,            // ancho
            h: 50,            // alto
            speed: 200        // px por segundo
        };

        // Teclas presionadas
        const keys = { left: false, right: false };
        const keys2 = { up: false, down: false };

        // Manejadores de teclado
        window.addEventListener('keydown', (e) => {
            // Evitar scroll al presionar flechas
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') e.preventDefault();
            if (e.key === 'ArrowLeft') keys.left = true;
            if (e.key === 'ArrowRight') keys.right = true;
            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') e.preventDefault();
            if (e.key === 'ArrowUp') keys2.up = true;
            if (e.key === 'ArrowDown') keys2.down = true;
        });

        window.addEventListener('keyup', (e) => {
            if (e.key === 'ArrowLeft') keys.left = false;
            if (e.key === 'ArrowRight') keys.right = false;
            if (e.key === 'ArrowUp') keys2.up = false;
            if (e.key === 'ArrowDown') keys2.down = false;
        });

        // Lógica de actualización y dibujado usando requestAnimationFrame
        let lastTime = performance.now();
        function loop(now) {
            const dt = (now - lastTime) / 1000; // delta time en segundos
            lastTime = now;

            update(dt);
            draw();

            requestAnimationFrame(loop);
        }

        function update(dt) {
            // Mover cuadro según teclas
            if (keys.left && !keys.right) {
                box.x -= box.speed * dt;
            } else if (keys.right && !keys.left) {
                box.x += box.speed * dt;
            }
            if (keys2.up && !keys2.down) {
                boxred.y -= boxred.speed * dt;
            } else if (keys2.down && !keys2.up) {
                boxred.y += boxred.speed * dt;
            }

            // Limitar dentro del canvas
            if (box.x < 0) box.x = 0;
            if (box.x + box.w > WIDTH) box.x = WIDTH - box.w;

            if (boxred.y < 0) boxred.y = 0;
            if (boxred.y + boxred.h > HEIGHT) boxred.y = HEIGHT - boxred.h;
        }

        function draw() {
            // Limpiar
            ctx.clearRect(0, 0, WIDTH, HEIGHT);

            // Dibujo del cuadro
            ctx.fillStyle = '#29b6f6';
            ctx.fillRect(box.x, box.y, box.w, box.h);

            ctx.fillStyle = '#ff0000ff';
            ctx.fillRect(boxred.x, boxred.y, boxred.w, boxred.h);

            // Contorno
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#0288d1';
            ctx.strokeRect(box.x, box.y, box.w, box.h);

            ctx.lineWidth = 2;
            ctx.strokeStyle = '#ff0000ff';
            ctx.strokeRect(boxred.x, boxred.y, boxred.w, boxred.h);


            // Texto de instrucciones dentro del canvas
            ctx.fillStyle = '#ddd';
            ctx.font = '14px Arial';
            ctx.fillText('Posición: ' + Math.round(box.x) + ' px', 10, 20);
        }

        // Iniciar loop
        requestAnimationFrame(loop);
    </script>
</body>

</html>