<?php
	class SesionCtl{
		public $user;
		public $type;
		public $password;

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
		
		function isWorker(){
			if( isset($_SESSION['user']) && $_SESSION['type'] == 'trabajador' )
				return true;
			return false;
		}

		function isLogged(){
			switch($_GET['accion'])
			{
				case "iniciar":
					if( isset($_SESSION['user'])){
						echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Ya iniciaste sesión</div>';
						require("Vistas/header.html");
					}
					else{
							$user	= $_POST["email"];
							$password   = $_POST["password"];
							$resultado = $this->modelo->validar($user,$password);
							$cat = $this->modelo->categoria($user);
							$_SESSION['type'] = implode($cat);
							if($resultado == true)
							{
								$_SESSION['user'] = $user;
								echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Sesión iniciada</div>';
								require("Vistas/header.html");
							}
							else{
								echo '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Sus datos son incorrectos</div>';
							require("Vistas/iniciar.html");
							}
						}
					break;


				case "cerrar":
					session_unset();
					session_destroy();	
					setcookie(session_name(),'', time()-3600);
					echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   Sesión cerrada</div>';
					require("Vistas/iniciar.html");
					break;

				case 'recuperar':
					if(empty($_POST["email"])) {
						require("Vistas/correo.html");
					}
					else {
						$useremail = $_POST["email"];
						$lexy = $this->modelo->recuperarcorreo($useremail);

					}
					break;
			}
		}
	}
?>
