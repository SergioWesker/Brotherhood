<?php
foreach ($listar as $dato)
{

	echo "Id Vehiculo: ".$dato["VIN"];
	echo "<br>";
	echo "Marca: ".$dato["marca"];	
	echo "<br>";
	echo "Modelo: ".$dato["modelo"];	
	echo "<br>";
	echo "Color: ".$dato["color"];	
	echo "<br>";
	echo "Caracteristicas: ".$dato["caracteristicas"];
	echo "<br><br>";
}
?>
