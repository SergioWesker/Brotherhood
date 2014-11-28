<?php
	class VehiculoCtl
	{
		public $modelo;
		public $VIN;
		public $KM;
		public $Combustible;
		public $Golpes;
		public $Ubicacion;
		public $cierra;
		public $abre;
		public $filas;
		
		public function __construct()
		{
			//Incluye el modelo
			include('modelo/vehiculoMdl.php');
			include("controlador/sesionCtl.php");
			//Creo el objeto del modelo
			$this->modelo = new VehiculoMdl();
			$this->controlador = new sesionCtl();
		}
		
		public function ejecutar()
		{	
			$regex = "/[\d\w\s]+/";
			$regexn = "/^(\w+)\s(\w+)/";
			
			switch($_GET['accion'])
			{
				case 'altavehiculo':
					$validar = $this->controlador->isAdmin();
					$validar2 = $this->controlador->isWorker();
					if ($validar==false&&$validar2==false){
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o trabajador</div>';
						require("Vistas/header.html");
					}
					else{
						if(empty($_POST))
						{
							$vista = file_get_contents("Vistas/ModificarEliminar.html");
							$header = file_get_contents("Vistas/cabecera.html");
							echo $header;
							echo $vista;
							require("Vistas/AltaVehiculos.php");
							$footer = file_get_contents("Vistas/pie.html");
							echo $footer;
						}
						else{
							//Se obtienen las variables para alta y se limpian
							if(isset($_POST["VIN"]) && is_numeric($_POST["VIN"]))
								$VIN	= $_POST["VIN"];		
							else{
								$VIN = "";
								echo "Identificador no válido<br>";
							}
						
							if(isset($_POST["Marca"]) && preg_match($regex, $_POST["Marca"]))
								$Marca 	= $_POST["Marca"];
							else{
								$Marca = "";
								echo "Marca desconocida<br>";
							}

							if(isset($_POST["Modelo"]) && preg_match($regex, $_POST["Modelo"]))
								$Modelo = $_POST["Modelo"];
							else{
							$Modelo = "";
							echo "Modelo no identificado<br>";
							}

							if(isset($_POST["Color"]) && preg_match($regex, $_POST["Color"]))
								$Color 	= $_POST["Color"];
							else{
								$Color = "";
								echo "Color inexistente<br>";
							}

							if(isset($_POST["Caracteristicas"]) && preg_match($regex, $_POST["Caracteristicas"]))
								$Caracteristicas = $_POST["Caracteristicas"];
							else{
								$Caracteristicas = "";
								echo "Caractéres no válidos<br>";
							}

							if(isset($_POST["Kilometraje"]) && is_numeric($_POST["Kilometraje"]))
								$Kilometraje = $_POST["Kilometraje"];
							else{
								$Kilometraje = "";
								echo "El kilometraje debe ser numérico<br>";
							}

							if(isset($_POST["Combustible"]) && is_float((float) $_POST["Combustible"]))
								$Combustible = $_POST["Combustible"];
							else{
								$Combustible = "";
								echo "Error la cantidad debe ser flotante<br>";
							}
		                    if(isset($_POST["Golpes"]) && preg_match($regex, $_POST["Golpes"]))
								$Golpes = $_POST["Golpes"];
							else{
								$Golpes = "";
								echo "Error<br>";
							}

		                    if(isset($_POST["Ubicacion"]) && preg_match($regex, $_POST["Ubicacion"]))
								$Ubicacion = $_POST["Ubicacion"];
							else{
								$Ubicacion = "";
								echo "Ubicación desconocida<br>";
							}
							

							if (($VIN=="")||($Marca=="")||($Modelo=="")||($Color=="")||($Caracteristicas=="")||($Kilometraje=="")||($Combustible=="")||($Golpes=="")||($Ubicacion==""))
								require("Vistas/error.html");
							else{
								$vehiculo = $this->modelo->alta($VIN,$Marca,$Modelo,$Color,$Caracteristicas);
								$inv = $this->modelo->inventario($VIN,$Kilometraje,$Combustible,$Golpes);
								$ubi = $this->modelo->ubicacion($VIN,$Ubicacion);
								echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Vehiculo registrado</div>';
							}
						
						}
					}
					break;
					
					
				case "listado":
					$validar = $this->controlador->isAdmin();
					
					if ($validar==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador</div>';
						require("Vistas/header.html");
					}
					else{
						$listar = $this ->modelo -> lista();
						$vista = file_get_contents("Vistas/Web/tabla.html");
						$header = file_get_contents("Vistas/cabecera.html");
						$footer = file_get_contents("Vistas/pie.html");
						//Obtengo la fila de la tabla
						$inicio_fila = strrpos($vista,'<tr>');
						$final_fila = strrpos($vista,'</tr>') + 5;
						$fila = substr($vista,$inicio_fila,$final_fila-$inicio_fila);

						$filas =null;

						foreach ($listar as $dato){
							$new_fila = $fila;
							//Reemplazo con un diccionario
							$diccionario = array(
							'{VIN}' => $dato["VIN"],
							'{Marca}' => $dato["marca"],
							'{Modelo}' => $dato["modelo"],
							'{Color}' => $dato["color"],
							'{Caracteristicas}' => $dato["caracteristicas"]);
							$new_fila = strtr($new_fila,$diccionario);

							$filas .= $new_fila;
						}
						$vista = str_replace($fila, $filas, $vista);
						$header = strtr($header,$diccionario);
						$vista = $header . $vista . $footer;
						//Mostrar la vista
					echo $vista;
					}
					break;
					
					
				case "vehiculosusuario":
				$validar = $this->controlador->isAdmin();
				$validarU = $this->controlador->isUser();

				if ($validar==false&&$validarU==false) {

					echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o usuario</div>';
					require("Vistas/header.html");
				}
				else{
					$usuario = $_SESSION['user'];
					$listar = $this ->modelo -> listaU($usuario);
					if($listar==null)
					{echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Este usuario no tiene vehiculos</div>';}
					else {
						$vista = file_get_contents("Vistas/ModificarEliminar.html");
						$header = file_get_contents("Vistas/cabecera.html");
						$footer = file_get_contents("Vistas/pie.html");
						//Obtengo la fila de la tabla
						$inicio_fila = strrpos($vista, '<tr>');
						$final_fila = strrpos($vista, '</tr>') + 5;
						$fila = substr($vista, $inicio_fila, $final_fila - $inicio_fila);


						foreach ($listar as $dato) {
							$new_fila = $fila;
							//Reemplazo con un diccionario
							$diccionario = array(
								'{VIN}' => $dato["VIN"],
								'{Marca}' => $dato["marca"],
								'{Modelo}' => $dato["modelo"],
								'{Color}' => $dato["color"],
								'{Caracteristicas}' => $dato["caracteristicas"]);
							$new_fila = strtr($new_fila, $diccionario);
							$filas .= $new_fila;
						}
						$vista = str_replace($fila, $filas, $vista);
						$header = strtr($header, $diccionario);
						$vista = $header . $vista . $footer;
						//Mostrar la vista
						echo $vista;
					}
				}
				break;

				case 'modificarubicacion':
					$validar = $this->controlador->isAdmin();
					$validar2 = $this->controlador->isWorker();
					if ($validar==false&&$validar2==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o trabajador</div>';
						require("Vistas/header.html");
					}
					else{
						if(empty($_POST)) {
							$vista = file_get_contents("Vistas/ModificarEliminar.html");
							$header = file_get_contents("Vistas/cabecera.html");
							echo $header;
							echo $vista;
							require("Vistas/Cambioubicacion.php");
							$footer = file_get_contents("Vistas/pie.html");
							echo $footer;
						}
						else{
							//Se obtienen las variables para alta y se limpian
							if(isset($_POST["VIN"]) && is_numeric($_POST["VIN"]))
								$VIN	= $_POST["VIN"];		
							else{
								$VIN = "";
								echo "Identificador no válido<br>";
							}
							
							if(isset($_POST["Nombre"]) && preg_match($regexn, $_POST["Nombre"]))
								$Nombre 	= $_POST["Nombre"];
							else{
								$Nombre = "";
								echo "Nombre no valido<br>";
							}
							
							if(isset($_POST["Causa"]) && preg_match($regex, $_POST["Causa"]))
								$Causa 	= $_POST["Causa"];
							else{
								$Causa = "";
								echo "Error<br>";
							}

							if(isset($_POST["NUbicacion"]) && preg_match($regex, $_POST["NUbicacion"]))
								$NUbicacion = $_POST["NUbicacion"];
							else{
								$NUbicacion = "";
								echo "Ubicación desconocida<br>";
							}
							

							if (($VIN=="")||($Nombre=="")||($Causa=="")||($NUbicacion==""))
								require("Vistas/error.html");
							else{
								$modificar = $this->modelo->modificarubicacion($VIN,$Nombre,$Causa,$NUbicacion);
								echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Ubicacion modificada</div>';
							}

						}	
					}
					break;
							
				case 'darbaja':
					$validar = $this->controlador->isAdmin();
					$validar2 = $this->controlador->isWorker();
					if ($validar==false&&$validar2==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o trabajador</div>';
						require("Vistas/header.html");
					}
					else{
						if(empty($_POST)) {
							$vista = file_get_contents("Vistas/ModificarEliminar.html");
							$header = file_get_contents("Vistas/cabecera.html");
							echo $header;
							echo $vista;
							require("Vistas/BajaVehiculos.php");
							$footer = file_get_contents("Vistas/pie.html");
							echo $footer;
						}
						else{
							if(isset($_POST["VIN"]) && is_numeric($_POST["VIN"]))
								$VIN	= $_POST["VIN"];		
							else {
								$VIN = "";
								echo "Identificador no válido<br>";
							}
							if(isset($_POST["Estado"]) && preg_match($regex, $_POST["Estado"]))
									$Estado = $_POST["Estado"];
							else{
								$Estado = "";
								echo "Estado desconocido<br>";
							}
							

							if (($VIN=="")||($Estado=="")) 
								require("Vistas/error.html");
							else 
								$darbaja = $this->modelo->baja($VIN,$Estado);
							echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Vehiculo terminado</div>';
						}
					}
					break;
				case 'modificarinventario':
					$validar = $this->controlador->isAdmin();
					if ($validar==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o trabajador</div>';
						require("Vistas/header.html");
					}
					else{
						if(empty($_POST)){
							$vista = file_get_contents("Vistas/ModificarEliminar.html");
							$header = file_get_contents("Vistas/cabecera.html");
							echo $header;
							echo $vista;
							require("Vistas/modificarinventario.php");
							$footer = file_get_contents("Vistas/pie.html");
							echo $footer;
						}
						else{
							//Se obtienen las variables para alta y se limpian
							if(isset($_POST["VIN"]) && is_numeric($_POST["VIN"]))
								$VIN	= $_POST["VIN"];
							else{
								$VIN = "";
								echo "Identificador no válido<br>";
							}

							if(isset($_POST["kilometraje"]) && is_numeric($_POST["kilometraje"]))
								$Kilometraje = $_POST["kilometraje"];
							else{
								$Kilometraje = "";
								echo "El kilometraje debe ser numérico<br>";
							}

							if(isset($_POST["combustible"]) && is_float((float) $_POST["combustible"]))
								$Combustible = $_POST["combustible"];
							else{
								$Combustible = "";
								echo "Error la cantidad debe ser flotante<br>";
							}
							if(isset($_POST["golpes"]) && preg_match($regex, $_POST["golpes"]))
								$Golpes = $_POST["golpes"];
							else{
								$Golpes = "";
								echo "Error<br>";
							}
							$inventario = $this->modelo->modificarinventario($VIN,$Kilometraje,$Combustible,$Golpes);
							echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Inventario modificado</div>';
						}
					}
					break;
				case 'eliminarinventario':
					$validar = $this->controlador->isAdmin();
					if ($validar==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador o trabajador</div>';
						require("Vistas/header.html");
					}
					else{
						if(empty($_POST)){
							$vista = file_get_contents("Vistas/ModificarEliminar.html");
							$header = file_get_contents("Vistas/cabecera.html");
							echo $header;
							echo $vista;
							require("Vistas/eliminarinventario.php");
							$footer = file_get_contents("Vistas/pie.html");
							echo $footer;
						}
						else{
							//Se obtienen las variables para alta y se limpian
							if(isset($_POST["VIN"]) && is_numeric($_POST["VIN"]))
								$VIN	= $_POST["VIN"];
							else{
								$VIN = "";
								echo "Identificador no válido<br>";
							}


							$eliminar_inv = $this->modelo->eliminarinventario($VIN);
							echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Inventario eliminado</div>';
						}
					}
					break;

			}
		}
	}
?>
