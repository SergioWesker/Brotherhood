<?php
	echo "<form id=\"formulario_registro\" action=\"index.php?controlador=usuarios&accion=iniciar\" method=\"POST\">";
		echo "usuario: ";
		echo "<input type=\"text\" name=\"user\" value=\"\"]><br>";
		echo "tipo de usuario: ";
		echo "	<select id=\"type\" name=\"type\">
				<option value=\"0\" disabled selected></option>
				<option selected></option>
				<option value =\"administrador\">administrador</option>
				<option value =\"usuario\">usuario</option>
				</select><br>";
		echo "<input type=\"submit\" name=\"submit\" value=\"Iniciar sesion\">";
		echo "</form>";
?>
