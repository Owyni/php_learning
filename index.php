<?php
session_start();


// Manejar envío de nombre (form) y recordar en sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    // limpiar entradas básicas
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    if ($name !== '') {
        $_SESSION['visitor_name'] = $name;
    } else {
        unset($_SESSION['visitor_name']);
    }
    // redirigir para evitar reenvío de formulario
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener nombre desde sesión o query (por ejemplo: welcome.php?name=Owynn)
if (!empty($_GET['name'])) {
    $qname = htmlspecialchars(trim($_GET['name']), ENT_QUOTES, 'UTF-8');
    if ($qname !== '') {
        $_SESSION['visitor_name'] = $qname;
    }
}

$name = $_SESSION['visitor_name'] ?? null;

// Determina saludo según la hora local del servidor
$hour = (int)date('G'); // 0-23
if ($hour >= 5 && $hour < 12) {
    $greeting = '¡Buenos días';
} elseif ($hour >= 12 && $hour < 19) {
    $greeting = '¡Buenas tardes';
} else {
    $greeting = '¡Buenas noches';
}

// Fecha y hora formateada
setlocale(LC_TIME, 'es_ES.UTF-8'); // intenta español; en algunos servidores puede no estar disponible
$now = strftime('%A, %e de %B de %Y - %R');

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Página de bienvenida</title>
    <style>
        :root{--bg:#0f172a;--card:#0b1220;--accent:#7c3aed;--muted:#94a3b8;--glass: rgba(255,255,255,0.04)}
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;color:#e6eef8;background:linear-gradient(180deg,var(--bg),#071025);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
        .card{width:100%;max-width:880px;background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));border:1px solid rgba(255,255,255,0.04);backdrop-filter: blur(6px);padding:28px;border-radius:14px;box-shadow:0 10px 30px rgba(2,6,23,0.6);display:grid;grid-template-columns:1fr 340px;gap:20px}
        @media(max-width:900px){.card{grid-template-columns:1fr}}
        h1{margin:0;font-size:28px}
        p.lead{color:var(--muted);margin-top:8px}
        .welcome{margin-top:18px;padding:18px;border-radius:10px;background:var(--glass);border:1px solid rgba(255,255,255,0.02)}
        .name{font-size:22px;font-weight:700;color:#fff}
        .meta{color:var(--muted);font-size:13px;margin-top:6px}
        form{display:flex;gap:8px;margin-top:14px}
        input[type=text]{flex:1;padding:10px 12px;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:#e6eef8}
        button{padding:10px 14px;border-radius:8px;border:0;background:linear-gradient(90deg,var(--accent),#5b21b6);color:white;font-weight:600;cursor:pointer}
        .small{font-size:13px;color:var(--muted)}
        .aside{padding:16px;border-radius:10px;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border:1px solid rgba(255,255,255,0.03)}
        .btn-ghost{background:transparent;border:1px solid rgba(255,255,255,0.06);padding:8px 10px;border-radius:8px;color:var(--muted);cursor:pointer}
        .clear{margin-top:12px}
        .logo{display:flex;align-items:center;gap:10px}
        .spark{width:42px;height:42px;border-radius:10px;background:linear-gradient(90deg,#7c3aed,#ff8b8b);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-family:monospace}
        footer{margin-top:18px;color:var(--muted);font-size:13px}
        .pulse{animation:pulse 3s infinite}
        @keyframes pulse{0%{transform:scale(1)}50%{transform:scale(1.03)}100%{transform:scale(1)}}
    </style>
</head>
<body>
    <div class="card">
        <div>
            <div class="logo">
                <div class="spark pulse">:v</div>
                <div>
                    <h1>Bienvenidos a la Papucueva</h1>
                </div>
            </div>

            <div class="welcome">
                <div class="meta"><?= $now ?: date('d/m/Y H:i') ?></div>

                <?php if ($name): ?>
                    <div style="margin-top:12px">
                        <div class="name"><?= $greeting ?>, <?= $name ?>!</div>
                    </div>
                <?php else: ?>
                    <div style="margin-top:12px">
                        <div class="name"><?= $greeting ?>!</div>
                        <div class="meta">Dime cómo te llamas para personalizar esta página.</div>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <input type="text" name="name" placeholder="Tu nombre" aria-label="Tu nombre" value="<?= $name ? $name : '' ?>">
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <aside class="aside">
            <h3 style="margin-top:0">Opciones</h3>
            <a  href="calculadora/index.php" class="small">Calculadora</a> <br>
            <a  href="carros/index.php" class="small">Carros</a> <br>
            <a  href="horas/index.php" class="small">Horas</a> <br>
            <a  href="tabla/index.php" class="small">Tabla</a> <br>


            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" style="margin-top:10px">
                <input type="hidden" name="name" value="">
                <button type="submit" class="btn-ghost">Borrar nombre guardado</button>
            </form>

            <div style="margin-top:12px">
                <div class="small"><strong>Hora del servidor:</strong></div>
                <div class="small"><?= date('d/m/Y H:i:s') ?></div>
            </div>

            <div style="margin-top:12px">
                <div class="small"><strong>Dirección IP (cliente):</strong></div>
                <div class="small"><?php
                    // Obtener IP sencilla (no 100% fiable detrás de proxies)
                    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
                    echo htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');
                ?></div>
            </div>
        </aside>
    </div>
</body>
</html>
