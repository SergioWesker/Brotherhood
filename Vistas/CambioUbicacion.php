<?php
echo "<form id=\"formulario_registro\" action=\"index.php?controlador=vehiculos&accion=modificarubicacion\" method=\"POST\">";


	echo "Id Vehiculo: ";
	echo "<input type=\"text\" name=\"VIN\" value=\"\"]><br>";
	echo "Nombre empleado: ";
	echo "<input type=\"text\" name=\"Nombre\" value=\"\"]><br>";
	echo "Causa o razon: ";
	echo "<input type=\"text\" name=\"Causa\" value=\"\"]><br>";
	echo "Nueva ubicacion: ";
	echo "<select id=\"NUbicacion\" name=\"NUbicacion\">
			<option value=\"0\" disabled selected>Selecciona Ubicacion</option>
			<option selected>-</option>
			<option value =\"A1\">A1</option>
			<option value =\"A2\">A2</option>
			<option value =\"A3\">A3</option>
			<option value =\"B1\">B1</option>
			<option value =\"B2\">B2</option>
			<option value =\"B3\">B3</option>
			<option value =\"C1\">C1</option>
			<option value =\"C2\">C2</option>
			<option value =\"C3\">C3</option>
		</select><br><br>";
	
	
	echo "<input type=\"submit\" name=\"submit\" value=\"Modificar\">";
	echo "</form>";
?>