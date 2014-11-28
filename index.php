<?php
	session_start();
	$controlador = null;
	if (empty($_GET) || empty($_REQUEST['controlador'])) {
		require("Vistas/iniciar.html");
	}
	else {
		switch($_REQUEST['controlador'])
		{
			case 'vehiculos':
				//Carga el controlador
				require('controlador/vehiculoCtl.php');
				$controlador = new VehiculoCtl();

				//Ejecuta el controlador
				$controlador->ejecutar();
				break;

			case 'usuarios':
				require('controlador/sesionCtl.php');
				$controlador = new SesionCtl();
				$controlador->isLogged();
				break;

			case 'registro':
				require('controlador/usuarioCtl.php');
				$controlador = new UsuarioCtl();
				$controlador->ejecutar();
				break;
		}
	}
?>
