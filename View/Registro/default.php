<?
  function campo($tamXS, $tamMD, $texto, $id, $tipo, $clase){
    echo '
    <div class="form-group col-xs-'.$tamXS.' col-md-'.$tamMD.' ">
      <label for="'.$id.'">'.$texto.'</label>
      <input type="'.$tipo.'" class="form-control input-sm '.$clase.'" 
        id="'.$id.'" required>
    </div>';      
  }
?>
<div class="container">
  <h1> Planilla de solicitud de inscripcion </h1>
  <form role="form">
    <div class="row">
      
      <!-- Datos de la empresa -->
      <h2> Datos de la empresa</h2>
      
      <!-- Nombre -->
      <? campo(12,12, "Nombre de la empresa", "empresa_nombre", "text", "" )?>
      <!-- RIF -->
      <? campo(3,3, "RIF", "empresa_rif", "text", "" )?>
      <!-- SNC -->
      <? campo(3,3, "SNC", "empresa_snc", "text", "" )?>
      <!-- Registro -->
      <? campo(3,3, "Registro No.", "empresa_registro", "text", "" )?>
      <!-- Tomo -->
      <? campo(3,3, "Tomo", "empresa_tomo", "text", "" )?>
      <!-- Registro Mercantil -->
      <? campo(4,4, "Registro Mercantil", "empresa_mercantil", "text", "" )?>
      <!-- No de Socios -->
      <? campo(4,4, "No. de socios", "empresa_socios", "text", "" )?>
      <!-- Capital Suscrito -->
      <? campo(4,4, "Capital Suscrito", "empresa_capital", "text", "" )?>
      <!-- Nivel de contratación -->
      <? campo(12,12, "Nivel de contratación", "empresa_nivel", "text", "" )?>
      <!-- Dirección -->
      <? campo(12,12, "Dirección", "empresa_direccion", "text", "" )?>
      <!-- Teléfonos -->
      <? campo(4,4, "Teléfonos", "empresa_telefonos", "text", "" )?>
      <!-- Especialidad -->
      <? campo(4,4, "Especialidad", "empresa_especialidad", "text", "" )?>
      <!-- Cuenta Twitter -->
      <? campo(4,4, "Cuenta Twitter", "empresa_twitter", "text", "" )?>
      
      <!-- Datos del afiliado -->
      <h2> Datos del afiliado (Representante legal)</h2>
      
      <!-- Nombre completo -->
      <? campo(6,6, "Nombre completo", "afiliado_nombre", "text", "" )?>
      <!-- C.I. No -->
      <? campo(6,6, "C.I. No", "afiliado_ci", "text", "" )?>
      <!-- Edad -->
      <? campo(3,3, "Edad", "afiliado_edad", "text", "" )?>
      <!-- Nacionalidad -->
      <? campo(3,3, "Nacionalidad", "afiliado_nacionalidad", "text", "" )?>
      <!-- Estado Civil -->
      <? campo(3,3, "Estado Civil", "afiliado_edocivil", "text", "" )?>
      <!-- Profesión -->
      <? campo(3,3, "Profesión", "afiliado_profesion", "text", "" )?>
      <!-- Dirección  -->
      <? campo(12,12, "Dirección", "afiliado_direccion", "text", "" )?>
      <!-- Teléfonos -->
      <? campo(4,4, "Teléfonos(Hab)", "afiliado_telhab", "text", "" )?>
      <!--  -->
      <? campo(4,4, "Celular", "afiliado_telcel", "text", "" )?>
      <!-- Correo Electrónico -->
      <? campo(4,4, "Correo Electrónico", "afiliado_email", "email", "" )?>

      <button type="submit" class="btn btn-default">Enviar</button>
    </div>
  </form>
</div>
