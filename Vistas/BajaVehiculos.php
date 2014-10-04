<?php
echo "<form id=\"formulario_registro\" action=\"index.php?controlador=vehiculos&accion=darbaja\" method=\"POST\">";


	echo "Id Vehiculo: ";
	echo "<input type=\"text\" name=\"VIN\" value=\"\"]><br>";
	echo "Estado salida: ";
	echo "<input type=\"text\" name=\"Estado\" value=\"\"]><br>";

	echo "<input type=\"submit\" name=\"submit\" value=\"Dar baja\">";
	echo "</form>";
?>
