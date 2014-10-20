<?php
	class SesionCtl{
		public $user;
		public $type;

		public function __construct()
		{
			//Incluye el modelo
			include('modelo/sesionMdl.php');
			//Creo el objeto del modelo
			$this->modelo = new SesionMdl();
		}
		
		
		function isAdmin(){
			if( isset($_SESSION['user']) && $_SESSION['type'] == 'administrador' )
				return true;
			return false;
		}

		function isUser(){
			if( isset($_SESSION['user']) && $_SESSION['type'] == 'usuario' )
				return true;
			return false;
		}

		function isLogged(){
			switch($_GET['accion'])
			{
				case "iniciar":
					if( isset($_SESSION['user'])){
						echo 'Ya iniciaste sesion <br>';
						require('Vistas/menu.php');
					}
					else{
						if(empty($_POST))
							require('Vistas/altausuario.php');
					    else{
							if(isset($_POST["user"]))
								$user	= $_POST["user"];
						    if(isset($_POST["type"]))
								$type   = $_POST["type"];
							
							$_SESSION['user'] = $user;
							$_SESSION['type'] = $type;
							echo 'A iniciado sesion';
							$usiario = $this->modelo->correo($_SESSION['type'],$_SESSION['user']);
								
							require('Vistas/menu.php');
							}
							
						}
					break;

				case "cerrar":
					session_unset();
					session_destroy();	
					setcookie(session_name(),'', time()-3600);
					echo 'Sesion cerrada';
					require('Vistas/altausuario.php');
					break;
			}
		}
	}
?>
