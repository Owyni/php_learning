<?php   

//Array bidimensional
$carros = array(
  array("Marca" => "Ford", "Modelo" => "Ka", "Year" => 2018),
  array("Marca" => "Chevrolet", "Modelo" => "Onix", "Year" => 2020),
  array("Marca" => "Ford", "Modelo" => "Ranger", "Year" => 2025),

);

foreach ($carros as $carro)
{
    echo "Marca: " . $carro["Marca"] . ", Modelo: " . $carro["Modelo"] . ", Year: " . $carro["Year"] . "\n <br>";
}

?>

