<?
  function _defaultAction(){
    require_once "View/Registro/default.php";
  }
	function _insertarAction(){
	global $model;
	$data = array(	
		"empresa_nombre" => $_GET["empresa_nombre"],
		"empresa_rif" => $_GET["empresa_rif"],
		"empresa_snc" => $_GET["empresa_snc"],
		"empresa_registro" => $_GET["empresa_registro"],
		"empresa_tomo" => $_GET["empresa_tomo"],
		"empresa_mercantil" => $_GET["empresa_mercantil"],
		"empresa_socios" => $_GET["empresa_socios"],
		"empresa_capital" => $_GET["empresa_capital"],
		"empresa_nivel" => $_GET["empresa_nivel"],
		"empresa_direccion" => $_GET["empresa_direccion"],
		"empresa_telefonos" => $_GET["empresa_telefonos"],
		"empresa_especialidad" => $_GET["empresa_especialidad"],
		"empresa_twitter" => $_GET["empresa_twitter"],
		"afiliado_nombre" => $_GET["afiliado_nombre"],
		"afiliado_ci" => $_GET["afiliado_ci"],
		"afiliado_edad" => $_GET["afiliado_edad"],
		"afiliado_nacionalidad" => $_GET["afiliado_nacionalidad"],
		"afiliado_edocivil" => $_GET["afiliado_edocivil"],
		"afiliado_profesion" => $_GET["afiliado_profesion"],
		"afiliado_direccion" => $_GET["afiliado_direccion"],
		"afiliado_telhab" => $_GET["afiliado_telhab"],
		"afiliado_telcel" => $_GET["afiliado_telcel"],
		"afiliado_email" => $_GET["afiliado_email"],
	);
	if ($model->insert("inscripcion", $data, "")){
		require_once "View/exito.php";
	} else {
		require_once "View/error.php";
	}
	}
?>
