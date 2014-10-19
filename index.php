<?php
	session_start();
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
	}
?>
