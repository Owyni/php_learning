<!DOCTYPE html>
<html lang="es"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| OWYNN |</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        .card-hover {
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0,0,0,.12);
        }
        .card-link { display: block; height: 100%; }

    </style>
</head>
<body class="bg-dark">
    <div class="container mt-4">
        <h1 class="mb-4 text-primary" style="text-align: center;">PROYECTOS AMBIENTES WEB</h1>

        <?php
        $htdocsPath = __DIR__;
        $projects = [];

        $items = scandir($htdocsPath);
        foreach ($items as $item) {
            if ($item != "." && $item != ".." && is_dir($htdocsPath . '/' . $item)) {
                $projects[] = [
                    'title' => $item
                ];
            }
        }
        ?>

        <div class="row" style="text-align: center;">
            <?php foreach ($projects as $project): 
                // Construir enlace relativo al directorio del proyecto (codificando espacios/caracteres)
                $href = rawurlencode($project['title']) . '/';
            ?>
                <div class="col-md-4 mb-4">
                    <a href="<?php echo htmlspecialchars($href); ?>" class="card-link text-decoration-none text-reset">
                        <div class="card shadow-sm border-primary card-hover h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><?php echo htmlspecialchars($project['title']); ?></h5>
                            </div>
                            <p style="font-size:48px; line-height:1; margin: 15px;">📁</p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
