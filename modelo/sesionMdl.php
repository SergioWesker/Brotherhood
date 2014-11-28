<?php
	class sesionMdl
	{
	
		public $bd_driver;
		
		function __construct(){
			require("database_config.inc");
			$this->bd_driver = new mysqli($host, $user, $pass, $bd);
		
			if($this -> bd_driver->connect_errno)
				die("<br>Error en la conexión");
		}
		
		
		function correo($id_user, $pass){
			
			$para      = 'esdelevin@hotmail.com';
			$titulo    = 'El título';
			$mensaje   = 'Hola';
			$cabeceras = 'From: sergio06_20@sergiowesker.byethost22.com' . "\r\n" .
			    'Reply-To: sergio06_20@sergiowesker.byethost22.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
			    
			// Enviamos el mensaje
			if (mail($para, $titulo, $mensaje, $cabeceras)) {
				echo  "Su mensaje fue enviado.";
			} else {
				echo "Error de envío.";
			}    
		}
		
		function validar($user, $password){
			$sql = "SELECT * FROM usuario WHERE correo = '$user' and password = '$password'";
			 $rec = mysql_query($sql);
			$count = 0;
			$r = $this -> bd_driver -> query($sql);
			while($row = $r -> fetch_assoc())
			{
				$count++;
				$result = $row;
			}
			if($count == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		
		function categoria($user){
		$result = "SELECT Categoria FROM usuario WHERE correo = '$user'";
			if ($resultado = $this -> bd_driver -> query($result)) 
			 $tipo = $resultado->fetch_row();
			 
			return $tipo;
		}

		function recuperarcorreo($email){

			$result = "SELECT password FROM usuario WHERE correo = '$email'";
			$resultado = mysql_query($result);
			if (!$resultado){
				echo 'Su correo: ' . "<strong>" . $email . "</strong>" ." no ha sido registrado.";
				require("Vistas/iniciar.html");
			}
			else {
				if ($resultado = $this->bd_driver->query($result))
					$password = $resultado->fetch_row();
				$password = implode($password);


				$para = $email;
				$titulo = 'El título';
				$mensaje = 'Hola su cotraseña es: ' . $password;
				$cabeceras = 'From: sergio06_20@sergiowesker.byethost22.com' . "\r\n" .
					'Reply-To: sergio06_20@sergiowesker.byethost22.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				// Enviamos el mensaje
				if (mail($para, $titulo, $mensaje, $cabeceras)) {
					echo "Su mensaje fue enviado.";
					echo $password;
				} else {
					echo "Error de envío.";

				}
			}
		}
		
	}
?>
