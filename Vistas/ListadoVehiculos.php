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
	/*echo "Kilometraje: ".$dato["Kilometraje"];	
	echo "<br>";
	echo "Combustible: ".$dato["Combustible"];
	echo "<br>";
	echo "Golpes: ".$dato["Golpes"];
	echo "<br>";
	echo "Ubicacion: ".$dato["Ubicacion"];
	echo "<br>";
	echo "<br>";
	*/
}
?>
