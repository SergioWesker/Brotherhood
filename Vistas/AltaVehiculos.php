<?php
echo "<form id=\"formulario_registro\" action=\"index.php?controlador=vehiculos&accion=altavehiculo\" method=\"POST\">";


	echo "Id Vehiculo: ";
	echo "<input type=\"text\" name=\"VIN\" value=\"\"]><br>";
	echo "Marca: ";
	echo "<input type=\"text\" name=\"Marca\" value=\"\"]><br>";
	echo "Modelo: ";
	echo "<input type=\"text\" name=\"Modelo\" value=\"\"]><br>";
	echo "Color: ";
	echo "<input type=\"text\" name=\"Color\" value=\"\"]><br>";
	echo "Caracteristicas: ";
	echo "<input type=\"text\" name=\"Caracteristicas\" value=\"\"]><br>";
	echo "Kilometraje: ";
	echo "<input type=\"text\" name=\"Kilometraje\" value=\"\"]><br>";
	echo "Cantidad de combustible: ";
	echo "<select id=\"Combustible\" name=\"Combustible\">
			<option value=\"0\" disabled selected>Selecciona Cantidad</option>
			<option selected>-</option>
			<option value =\"1.5\">1.5</option>
			<option value =\"2.4\">2.4</option>
			<option value =\"6.5\">6.5</option>
			<option value =\"20.0\">20.0</option>
		</select><br>";
	echo "Estado del vehiculo: ";
	echo "	<select id=\"Golpes\" name=\"Golpes\">
			<option value=\"0\" disabled selected>\"Selecciona Estado\"</option>
			<option selected>-</option>
			<option value =\"Sin daños\">Sin daños</option>
			<option value =\"Defensa golpeada\">Defensa golpeada</option>
			<option value =\"Cofre golpeado\">Cofre golpeado</option>
			<option value =\"Vidrio roto\">Vidrio roto</option>
			<option value =\"Rayado\">Rayado</option>
			<option value =\"Abolladura\">Abolladura</option>
			<option value =\"PDD\">Puerta delantera derecha golpeada</option>
			<option value =\"PDI\">Puerta delantera izquierda golpeada</option>
			<option value =\"PTD\">Puerta tracera derecha golpeada</option>
			<option value =\"PTI\">Puerta tracera izquierda golpeada</option>
			</select><br>";
	echo "Ubicacion del vehiculo: ";
	echo "<select id=\"Ubicacion\" name=\"Ubicacion\">
			<option value=\"0\" disabled selected>Selecciona Ubicacion</option>
			<option selected>-</option>
			<option value =\"A1\">A1 Patio</option>
			<option value =\"A2\">A2 Patio</option>
			<option value =\"A3\">A3 Patio</option>
			<option value =\"B1\">B1 Horno</option>
			<option value =\"B2\">B2 Horno</option>
			<option value =\"B3\">B3 Horno</option>
			<option value =\"C1\">C1 Taller</option>
			<option value =\"C2\">C2 Taller</option>
			<option value =\"C3\">C3 Taller</option>
		</select><br><br>";
	
	echo "<input type=\"submit\" name=\"submit\" value=\"Dar alta\">";
	echo "</form>";
?>
