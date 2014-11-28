<?php
	class UsuarioMdl
	{
		public $bd_driver;
		
		function __construct(){
			require("database_config.inc");
			$this->bd_driver = new mysqli($host, $user, $pass, $bd);
		
			if($this -> bd_driver->connect_errno)
				die("<br>Error en la conexión");
		}
		
		

		function alta($Correo,$Nombre,$Apellido,$password,$Categoria){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query ="INSERT INTO usuario(Correo, Nombre,Apellido,password,Categoria)VALUES (\"$Correo\",\"$Nombre\",\"$Apellido\",\"$password\",\"$Categoria\")";
			
			$U = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($U === FALSE) 
				return FALSE;
		}
					

		function modificar($Correo,$NCorreo,$Nombre,$Apellido,$password,$Categoria){
			require("database_config.inc");
			$enlace =  mysql_connect($host, $user, $pass);
			mysql_select_db($bd,$enlace);
			if (!$enlace){
			    die('No pudo conectarse: ' . mysql_error());
			}
			
			$consulta = "UPDATE usuario SET Correo='{$_POST['Nemail']}', Nombre='{$_POST['NNombre']}', Apellido='{$_POST['NApellido']}', Categoria='{$_POST['NCategoria']}', password='{$_POST['Npassword']}' WHERE Correo='{$_POST['email']}'";

			// Ejecutar la consulta
			$resultado = mysql_query($consulta);

			if (!$resultado){
				$mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
				$mensaje .= 'Consulta completa: ' . $consulta;
				die($mensaje);
			}
			mysql_close($enlace);
		}

		public function lista(){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query = 'SELECT * FROM usuario';
			$r = $this -> bd_driver -> query($query);
			while($row = $r -> fetch_assoc())
			$rows[] = $row;
			return $rows;
		}


	}
?>
