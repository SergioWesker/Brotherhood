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
					if ($validar==false){
						echo "Debes ser administrador para poder ingresar un vehiculo";
						require("Vistas/menu.php");
					}
					else{
						if(empty($_POST))
							require("Vistas/AltaVehiculos.php");
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
								echo "Vehiculo registrado";
							}
						
						}
					}
					break;
				case "vista":
					$validar = $this->controlador->isAdmin();
					$validarU = $this->controlador->isUser();
					
					if ($validar==false&&$validarU==false) {
						echo "Necesitas ser usuario o administrador para ver los vehiculos registrados";
						require("Vistas/menu.php");
					}
					else{
						$listar = $this ->modelo -> lista();
						require("Vistas/ListadoVehiculos.php");
					}
					break;
					
				case 'modificarubicacion':
					$validar = $this->controlador->isAdmin();
					if ($validar==false) {
						echo "Debes ser administrador para poder modificar la ubicacion de un vehiculo";
						require("Vistas/menu.php");
					}
					else{
						if(empty($_POST))
							require("Vistas/CambioUbicacion.php");
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
							}

						}	
					}
					break;
							
				case 'darbaja':
					$validar = $this->controlador->isAdmin();
					if ($validar==false) {
						echo "Debes ser administrador para poder dar de baja un vehiculo";
						require("Vistas/menu.php");
					}
					else{
						if(empty($_POST))
							require("Vistas/BajaVehiculos.php");
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
							else {
								$darbaja = $this->modelo->baja($VIN,$Estado);
							}
						}
					}
					break;
			}
		}
	}
?>
