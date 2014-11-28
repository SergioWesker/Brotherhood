<?php
	class UsuarioCtl{
public $Correo;
public $NCorreo;
public $Nombre;
public $Apellido;
public $password;
public $Categoria;

		public function __construct()
		{
			//Incluye el modelo
			include('modelo/usuarioMdl.php');
			include("controlador/sesionCtl.php");
			//Creo el objeto del modelo
			$this->modelo = new UsuarioMdl();
			$this->controlador = new sesionCtl();
		}
		
	public function ejecutar()
		{	
			$regex = "/[\d\w\s]+/";
			$regexn = "/^(\w+)\s(\w+)/";
			
			switch($_GET['accion'])
			{
				case 'altausuario':
				
					if(empty($_POST)){
						$vista = file_get_contents("Vistas/ModificarEliminar.html");
						$header = file_get_contents("Vistas/cabecera.html");
					echo $header;
					echo $vista;
						require("Vistas/usuario.html");
						$footer = file_get_contents("Vistas/pie.html");
						echo $footer;

					}
					else{
								$Correo	= $_POST["email"];		
						
							if(isset($_POST["Nombre"]) && preg_match($regex, $_POST["Nombre"]))
								$Nombre 	= $_POST["Nombre"];
							else{
								$Nombre = "";
								echo "No es un Nombre<br>";
							}

							if(isset($_POST["Apellido"]) && preg_match($regex, $_POST["Apellido"]))
								$Apellido = $_POST["Apellido"];
							else{
							$Apellido = "";
							echo "No es un apellido<br>";
							}

							if(isset($_POST["password"]) && preg_match($regex, $_POST["password"]))
								$password 	= $_POST["password"];
							else{
								$password = "";
								echo "Password<br>";
							}

							if(isset($_POST["Categoria"]) && preg_match($regex, $_POST["Categoria"]))
							{
								$Categoria = $_POST["Categoria"];
								
							}
							else{
								$Categoria = "";
								echo "<br>";
							}
							
								$usuario = $this->modelo->alta($Correo,$Nombre,$Apellido,$password,$Categoria);
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Usuario registrado</div>';
						}
					
						break;
						
				case 'modificarusuario':
					$validar = $this->controlador->isAdmin();
					if ($validar==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador</div>';
						}
				else{
				if(empty($_POST)) {
					$vista = file_get_contents("Vistas/ModificarEliminar.html");
					$header = file_get_contents("Vistas/cabecera.html");
					echo $header;
					echo $vista;
					require("Vistas/modificarusuario.html");
					$footer = file_get_contents("Vistas/pie.html");
					echo $footer;

				}
					else{
								$Correo	= $_POST["email"];	
								$NCorreo	= $_POST["Nemail"];	
						
							if(isset($_POST["NNombre"]) && preg_match($regex, $_POST["NNombre"]))
								$Nombre 	= $_POST["NNombre"];
							else{
								$Nombre = "";
								echo "No es un Nombre<br>";
							}

							if(isset($_POST["NApellido"]) && preg_match($regex, $_POST["NApellido"]))
								$Apellido = $_POST["NApellido"];
							else{
							$Apellido = "";
							echo "No es un apellido<br>";
							}

							if(isset($_POST["Npassword"]) && preg_match($regex, $_POST["Npassword"]))
								$password 	= $_POST["Npassword"];
							else{
								$password = "";
								echo "Password<br>";
							}

							if(isset($_POST["NCategoria"]) && preg_match($regex, $_POST["NCategoria"]))
							{
								$Categoria = $_POST["NCategoria"];
								
							}
							else{
								$Categoria = "";
								echo "<br>";
							}
							
								$usuario = $this->modelo->modificar($Correo,$NCorreo,$Nombre,$Apellido,$password,$Categoria);
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Usuario modificado</div>';
						}
					}
					break;
						
						case "listausuarios":
					$validar = $this->controlador->isAdmin();
					
					if ($validar==false) {
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Debes ser administrador</div>';
					}
					else{
						$listar = $this ->modelo -> lista();
						$vista = file_get_contents("Vistas/tablausuarios.html");
						$header = file_get_contents("Vistas/cabecera.html");
						$footer = file_get_contents("Vistas/pie.html");
						//Obtengo la fila de la tabla
						$inicio_fila = strrpos($vista,'<tr>');
						$final_fila = strrpos($vista,'</tr>') + 5;
						$fila = substr($vista,$inicio_fila,$final_fila-$inicio_fila);

						$filas = null;
						foreach ($listar as $dato){
							$new_fila = $fila;
							//Reemplazo con un diccionario
							$diccionario = array(
							'{Correo}' => $dato["Correo"],
							'{Nombre}' => $dato["Nombre"],
							'{Apellido}' => $dato["Apellido"],
							'{Categoria}' => $dato["Categoria"],
							'{password}' => $dato["password"]);
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
						
						
					case 'login':
						require("Vistas/iniciar.html");
						break;


			}		
		}
		}
			
?>
