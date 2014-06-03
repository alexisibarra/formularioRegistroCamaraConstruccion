<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html lang="es">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Viajanet Venezuela</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
  </script>
</head>
<body>
<div id="wrapper">
<?php
	require 'Model/dbFunctions.php';

  $model = new Model('local');

	$carpetaControladores = "./Controller/";
	$controladorPredefinido = "registro";
	$accionPredefinida = "_defaultAction";
	 
	if(! empty($_GET['controlador']))
		$controlador = $_GET['controlador'];
	else
		$controlador = $controladorPredefinido;
	 
	if(! empty($_GET['accion']))
		$accion = $_GET['accion'] . 'Action';
	else
		$accion = $accionPredefinida;

	$controlador = preg_replace('/[^a-zA-Z0-9]/', '', $controlador);
	$accion = '_' . preg_replace('/[^a-zA-Z0-9]/', '', $accion);
	$controlador = $carpetaControladores . $controlador . '.php';

	if(is_file($controlador))
		require_once $controlador;
	else
		die('El controlador no existe - 404 not found');

	if(is_callable($accion))
		$accion();
	else
		die('La accion no existe - 404 not found');
?>
</body>
</html>
