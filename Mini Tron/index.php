<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Mini Tron</title>
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
        background: #000;
        border: 2px solid #444;
        display: block;
    }

    .info {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.4);
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 14px;
    }

    .message {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        padding: 20px 30px;
        border-radius: 10px;
        font-size: 24px;
        display: none;
        text-align: center;
    }

    .start-screen {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #fff;
        font-size: 28px;
    }

    .start-screen small {
        font-size: 16px;
        color: #bbb;
        margin-top: 10px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="message" id="message"></div>
    <div class="start-screen" id="startScreen">
        <div>MINI TRON</div>
        <small>Presiona <b>Espacio</b> para comenzar</small>
        <small>J1: Use ⬆️⬅️⬇️➡️</small>
        <small>J2: Use W A S D</small>
    </div>
    <canvas id="game"></canvas>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const msgBox = document.getElementById('message');
const startScreen = document.getElementById('startScreen');

const WIDTH = 1300;
const HEIGHT = 700;
const PIXEL = 5;

function resizeCanvas() {
    const dpr = window.devicePixelRatio || 1;
    canvas.width = WIDTH * dpr;
    canvas.height = HEIGHT * dpr;
    canvas.style.width = WIDTH + 'px';
    canvas.style.height = HEIGHT + 'px';
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
}
resizeCanvas();

const grid = Array.from({ length: WIDTH / PIXEL }, () => Array(HEIGHT / PIXEL).fill(0));

let running = false; // inicia detenido

const player1 = {
    x: Math.floor(WIDTH / (2 * PIXEL)) + 80,
    y: Math.floor(HEIGHT / (2 * PIXEL)),
    dir: 'left',
    color: '#29B5F6',
    keymap: { left: 'ArrowLeft', right: 'ArrowRight', up: 'ArrowUp', down: 'ArrowDown' }
};

const player2 = {
    x: Math.floor(WIDTH / (2 * PIXEL)) - 80,
    y: Math.floor(HEIGHT / (2 * PIXEL)),
    dir: 'right',
    color: '#FF0000',
    keymap: { left: 'a', right: 'd', up: 'w', down: 's' }
};

function drawPixel(p, color) {
    ctx.fillStyle = color;
    ctx.fillRect(p.x * PIXEL, p.y * PIXEL, PIXEL, PIXEL);
}

function resetGame() {
    for (let x = 0; x < grid.length; x++) grid[x].fill(0);
    ctx.clearRect(0, 0, WIDTH, HEIGHT);

    player1.x = Math.floor(WIDTH / (2 * PIXEL)) + 79;
    player1.y = Math.floor(HEIGHT / (2 * PIXEL) + 1);
    player1.dir = 'left';

    player2.x = Math.floor(WIDTH / (2 * PIXEL)) - 80;
    player2.y = Math.floor(HEIGHT / (2 * PIXEL));
    player2.dir = 'right';

    running = true;
    msgBox.style.display = 'none';
}

window.addEventListener('keydown', (e) => {
    // Iniciar juego desde pantalla de inicio
    if (!running && startScreen.style.display !== 'none' && e.key === ' ') {
        startScreen.style.display = 'none';
        resetGame();
        requestAnimationFrame(loop);
        return;
    }

    // Reiniciar después de perder
    if (!running && e.key === ' ') {
        resetGame();
        requestAnimationFrame(loop);
        return;
    }

    // Controles
    if (running) {
        // Jugador 1
        if (e.key === player1.keymap.left && player1.dir !== 'right') player1.dir = 'left';
        if (e.key === player1.keymap.right && player1.dir !== 'left') player1.dir = 'right';
        if (e.key === player1.keymap.up && player1.dir !== 'down') player1.dir = 'up';
        if (e.key === player1.keymap.down && player1.dir !== 'up') player1.dir = 'down';

        // Jugador 2
        if (e.key === player2.keymap.left && player2.dir !== 'right') player2.dir = 'left';
        if (e.key === player2.keymap.right && player2.dir !== 'left') player2.dir = 'right';
        if (e.key === player2.keymap.up && player2.dir !== 'down') player2.dir = 'up';
        if (e.key === player2.keymap.down && player2.dir !== 'up') player2.dir = 'down';
    }
});

function movePlayer(p) {
    if (p.dir === 'left') p.x--;
    if (p.dir === 'right') p.x++;
    if (p.dir === 'up') p.y--;
    if (p.dir === 'down') p.y++;
}

function checkCollision(p, id) {
    if (p.x < 0 || p.x >= WIDTH / PIXEL || p.y < 0 || p.y >= HEIGHT / PIXEL) return true;
    if (grid[p.x][p.y] !== 0) return true;
    grid[p.x][p.y] = id;
    return false;
}

function gameOver(winner) {
    running = false;
    msgBox.textContent = winner ? `${winner} gana 🏆` : "Empate 💥";
    msgBox.style.display = 'block';
}

let lastTime = 0;
const speed = 20;

function loop(now) {
    if (!running) return;

    if (now - lastTime > speed) {
        movePlayer(player1);
        movePlayer(player2);

        const p1Crash = checkCollision(player1, 1);
        const p2Crash = checkCollision(player2, 2);

        drawPixel(player1, player1.color);
        drawPixel(player2, player2.color);

        if (p1Crash && p2Crash) gameOver(null);
        else if (p1Crash) gameOver("Jugador 2");
        else if (p2Crash) gameOver("Jugador 1");

        lastTime = now;
    }
    requestAnimationFrame(loop);
}
</script>
</body>
</html>
