<?php
session_start();

$pokemon = isset($_GET['pokemon']) ? strtolower(trim($_GET['pokemon'])) : '';

if (!isset($_SESSION['searched'])) {
    $_SESSION['searched'] = [];
}

if ($pokemon && !in_array($pokemon, $_SESSION['searched'])) {
    $_SESSION['searched'][] = $pokemon;
}

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokémon Buscador</title>
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P|Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #00869B;
            font-family: "Roboto", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #22223b;
            color: #f2e9e4;
            padding: 32px 0 20px 0;
            text-align: center;
            font-family: "Press Start 2P", cursive;
            font-size: 2.5em;
            letter-spacing: 3px;
            box-shadow: 0 6px 24px rgba(34,34,59,0.18);
            position: relative;
        }
        .header img {
            vertical-align: middle;
            width: 72px;
            margin-right: 20px;
            filter: drop-shadow(0 2px 8px #4ea8de);
        }
        .container {
            max-width: 1100px;
            margin: 48px auto;
            background: rgba(242,233,228,0.98);
            border-radius: 32px;
            box-shadow: 0 10px 40px rgba(34,34,59,0.15);
            padding: 48px;
            display: flex;
            gap: 48px;
        }
        .main {
            flex: 2;
        }
        .sidebar {
            flex: 1;
            margin-left: 0;
        }
        form {
            margin-bottom: 36px;
            background: #f2e9e4;
            padding: 22px 28px;
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(34,34,59,0.10);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        label {
            font-weight: 700;
            font-family: "Press Start 2P", cursive;
            color: #4ea8de;
            font-size: 1.1em;
        }
        input[type="text"] {
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #4ea8de;
            margin-right: 10px;
            font-size: 20px;
            background: #e9ecef;
            font-family: "Roboto", Arial, sans-serif;
        }
        button {
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            background: #4ea8de;
            color: #f2e9e4;
            font-weight: 700;
            cursor: pointer;
            font-size: 20px;
            font-family: "Press Start 2P", cursive;
            box-shadow: 0 3px 12px rgba(34,34,59,0.12);
            transition: background 0.2s, transform 0.2s;
        }
        button:hover {
            background: #22223b;
            transform: scale(1.07);
        }
        h1, h2, h3, h4 {
            margin-top: 0;
            font-family: "Press Start 2P", cursive;
            color: #22223b;
        }
        .poke-card {
            border:2px solid #4ea8de;
            padding:22px;
            margin-bottom:22px;
            background: #e9ecef;
            border-radius: 20px;
            box-shadow: 0 6px 24px rgba(34,34,59,0.10);
            transition: box-shadow 0.2s, transform 0.2s;
            text-align: center;
            position: relative;
        }
        .poke-card:hover {
            box-shadow: 0 12px 48px rgba(34,34,59,0.18);
            transform: scale(1.15);
        }
        .poke-card img {
            width:110px;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 8px #4ea8de);
        }
        .types img {
            width: 40px;
            vertical-align: middle;
            margin-right: 10px;
            filter: drop-shadow(0 2px 4px #22223b);
        }
        .types span {
            font-family: "Roboto", Arial, sans-serif;
            font-size: 1.2em;
            color: #185a9d;
            font-weight: bold;
        }
        .evolutions {
            font-weight: 700;
            color: #185a9d;
            font-family: "Roboto", Arial, sans-serif;
            font-size: 1.2em;
            margin-bottom: 14px;
        }
        .not-found {
            color: #b22234;
            font-weight: bold;
            font-family: "Press Start 2P", cursive;
            background: #f2e9e4;
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(34,34,59,0.10);
        }
        .poke-info {
            background: #e9ecef;
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(34,34,59,0.08);
            font-family: "Roboto", Arial, sans-serif;
            font-size: 1.2em;
        }
        .sidebar h2 {
            color: #4ea8de;
            font-size: 1.4em;
            margin-bottom: 22px;
        }
        .sidebar {
            background: #e9ecef;
            border-radius: 20px;
            padding: 28px 22px;
            box-shadow: 0 3px 12px rgba(34,34,59,0.08);
        }
        .sidebar::-webkit-scrollbar {
            width: 8px;
            background: #a9def9;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #4ea8de;
            border-radius: 10px;
        }
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                padding: 18px;
            }
            .sidebar {
                margin-top: 28px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="main">';

echo '<form method="get">
    <label for="pokemon">Pokémon:</label>
    <input type="text" id="pokemon" name="pokemon" autocomplete="off" value="'. htmlspecialchars($pokemon) .'">
    <button type="submit">Buscar</button>
</form>';

if ($pokemon) {
    $url = "https://pokeapi.co/api/v2/pokemon/" . $pokemon;
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "<p class='not-found'>NO EXISTEEEE, ESO NO ES UN POKEMON</p>";
    } else {
        $data = json_decode($response, true);

        echo "<h1>". ucfirst($data["name"])."</h1>";
        echo "<div class='poke-info'>";
        echo "<img src='". $data["sprites"]["other"]["official-artwork"]["front_default"]."' style='width:180px;'><br>";
        echo "<div>Altura: <b>". $data["height"]. "<br></b> Peso: <b>". $data["weight"]. "</b></div>";
        echo "</div>";

        echo "<h3>Evoluciones:</h3>";
        $speciesUrl = $data["species"]["url"];
        $speciesResponse = @file_get_contents($speciesUrl);
        if ($speciesResponse !== FALSE) {
            $speciesData = json_decode($speciesResponse, true);
            $evolutionChainUrl = $speciesData["evolution_chain"]["url"];
            $evolutionResponse = @file_get_contents($evolutionChainUrl);
            if ($evolutionResponse !== FALSE) {
                $evolutionData = json_decode($evolutionResponse, true);
                $evolutions = [];
                $sprites = [];
                $current = $evolutionData["chain"];
                do {
                    $name = $current["species"]["name"];
                    $evolutions[] = ucfirst($name);

                    $speciesUrl = $current["species"]["url"];
                    $speciesResp = @file_get_contents($speciesUrl);
                    if ($speciesResp !== FALSE) {
                        $speciesData = json_decode($speciesResp, true);
                        $pokeUrl = "https://pokeapi.co/api/v2/pokemon/" . $name;
                        $pokeResp = @file_get_contents($pokeUrl);
                        if ($pokeResp !== FALSE) {
                            $pokeData = json_decode($pokeResp, true);
                            $sprites[] = $pokeData["sprites"]["other"]["official-artwork"]["front_default"];
                        } else {
                            $sprites[] = null;
                        }
                    } else {
                        $sprites[] = null;
                    }

                    $current = isset($current["evolves_to"][0]) ? $current["evolves_to"][0] : null;
                } while ($current);

                echo "<div class='evolutions'>" . implode("       |       ", $evolutions) . "</div>";
                echo "<style>
                .evo-img {
                    width: 120px;
                    height: 120px;
                    object-fit: contain;
                    vertical-align: middle;
                    margin-right: 14px;
                    margin-bottom: 6px;
                    border-radius: 12px;
                    background: #fffbe7;
                    border: 2px solid #00869B;
                    transition: transform 0.18s, box-shadow 0.18s;
                }
                .evo-img:hover {
                    transform: scale(1.12);
                }
                </style>";
                foreach ($sprites as $i => $sprite) {
                    if ($sprite) {
                        echo "<img src='" . htmlspecialchars($sprite) . "' class='evo-img' alt='" . htmlspecialchars($evolutions[$i]) . "'>";
                    }
                }
            }
        }
        echo "</div>";
    }
}

echo '</div>';

echo '</div>
</body>
</html>';
?>