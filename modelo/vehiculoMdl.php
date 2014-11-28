<?php
	class vehiculoMdl
	{
		
		public $bd_driver;
		
		function __construct(){
			require("database_config.inc");
			$this->bd_driver = new mysqli($host, $user, $pass, $bd);
		
			if($this -> bd_driver->connect_errno)
				die("<br>Error en la conexión");
		}
		
		
		public function lista(){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query = 'SELECT * FROM vehiculo';
			$r = $this -> bd_driver -> query($query);
			while($row = $r -> fetch_assoc())
			$rows[] = $row;
			return $rows;
		}
		
		
		public function listaU($usuario){
			$query = "SELECT * FROM vehiculo WHERE Id_usuario = '$usuario'";
			$r = $this -> bd_driver -> query($query);
			if($r==null)
			{return $r;}
			else {
				while ($row = $r->fetch_assoc())
					$rows[] = $row;
				return $rows;
			}
		}

		function alta($VIN,$Marca,$Modelo,$Color,$Caracteristicas){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query ="INSERT INTO vehiculo(VIN, marca,modelo,color,caracteristicas)VALUES (\"$VIN\",\"$Marca\",\"$Modelo\",\"$Color\",\"$Caracteristicas\")";
			
			$V = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($V === FALSE) 
				return FALSE;
		}
					
		function inventario($VIN,$Kilometraje,$Combustible,$Golpes){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query ="INSERT INTO inventario(VIN, kilometraje,combustible,golpes)VALUES (\"$VIN\",\"$Kilometraje\",\"$Combustible\",\"$Golpes\")";
			
			$I = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($I === FALSE) 
				return FALSE;
		}


		function ubicacion($VIN,$ubicacion){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			$query ="INSERT INTO ubicacion (VIN, ubicacion_inicial)VALUES (\"$VIN\",\"$ubicacion\")";
			
			$U = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($U === FALSE) 
				return FALSE;
		}

		function modificarubicacion($VIN,$Nombre,$Causa,$NUbicacion){
			require("database_config.inc");
			$enlace =  mysql_connect($host, $user, $pass);
			mysql_select_db($bd,$enlace);
			if (!$enlace){
			    die('No pudo conectarse: ' . mysql_error());
			}
			
			echo "Ubicación modificada";
			$consulta = "UPDATE ubicacion SET ubicacion_inicial='{$_POST['NUbicacion']}' WHERE VIN='{$_POST['VIN']}'";

			// Ejecutar la consulta
			$resultado = mysql_query($consulta);

			if (!$resultado){
				$mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
				$mensaje .= 'Consulta completa: ' . $consulta;
				die($mensaje);
			}
			mysql_close($enlace);
			//Mysql> UPDATE refranero SET fecha="2003-06-01" WHERE ID=1; 
			
			//$Fechayhora =$hoy[year]."-".$hoy[mon]."-".$hoy[mday]." ".$hoy[hours].":".$hoy[minutes].":".$hoy[seconds];
			//echo $Fechayhora;
			$query ="INSERT INTO cambio_ubicacion (VIN, nombre_empleado, razon_de_cambio, nueva_ubicacion)VALUES (\"$VIN\",\"$Nombre\",\"$Causa\",\"$NUbicacion\")";
			
			$M = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($M === FALSE) 
				return FALSE;
		}

		function baja($VIN,$Estado){
			//echo "<br>debug: Entro a la alta del alumno en el modelo";
			require("database_config.inc");
			$enlace =  mysql_connect($host, $user, $pass);
			mysql_select_db($bd,$enlace);
			if (!$enlace) {
			    die('No pudo conectarse: ' . mysql_error());
			}
			
			echo 'Vehiculo listo';
			$consulta = "UPDATE ubicacion SET ubicacion_inicial='Fuera' WHERE VIN='{$_POST['VIN']}'";

			// Ejecutar la consulta
			$resultado = mysql_query($consulta);

			if (!$resultado) {
			    $mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
			    $mensaje .= 'Consulta completa: ' . $consulta;
				die($mensaje);
			}
			mysql_close($enlace);
			//Mysql> UPDATE refranero SET fecha="2003-06-01" WHERE ID=1; 
			
			//$Fechayhora =$hoy[year]."-".$hoy[mon]."-".$hoy[mday]." ".$hoy[hours].":".$hoy[minutes].":".$hoy[seconds];
			//echo $Fechayhora;
			$query ="INSERT INTO baja_vehiculo (VIN, estado_salida)VALUES (\"$VIN\",\"$Estado\")";
			
			$M = $this->bd_driver->query($query);
			if($this->bd_driver->insert_id){
				return $this->bd_driver->insert_id;
			}
			elseif($M === FALSE) 
				return FALSE;
		}
		function modificarinventario($VIN,$Kilometraje,$Combustible,$Golpes){
			//echo "<br>debug: Entro a la alta del alumno en el modelo"
			require("database_config.inc");
			$enlace =  mysql_connect($host, $user, $pass);
			mysql_select_db($bd,$enlace);
			if (!$enlace){
				die('No pudo conectarse: ' . mysql_error());
			}

			$consulta = "UPDATE inventario SET VIN='{$_POST['VIN']}', kilometraje='{$_POST['kilometraje']}', combustible='{$_POST['combustible']}', golpes='{$_POST['golpes']}' WHERE VIN='{$_POST['VIN']}'";

			// Ejecutar la consulta
			$resultado = mysql_query($consulta);

			if (!$resultado){
				$mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
				$mensaje .= 'Consulta completa: ' . $consulta;
				die($mensaje);
			}
			mysql_close($enlace);
		}
		function eliminarinventario($VIN){
			//echo "<br>debug: Entro a la alta del alumno en el modelo"
			require("database_config.inc");
			$enlace =  mysql_connect($host, $user, $pass);
			mysql_select_db($bd,$enlace);
			if (!$enlace){
				die('No pudo conectarse: ' . mysql_error());
			}

			$consulta = "DELETE  FROM inventario WHERE VIN='{$_POST['VIN']}'";

			// Ejecutar la consulta
			$resultado = mysql_query($consulta);

			if (!$resultado){
				$mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
				$mensaje .= 'Consulta completa: ' . $consulta;
				die($mensaje);
			}
			mysql_close($enlace);
		}
	}
?>
