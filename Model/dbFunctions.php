<?php
class Model{
  private $db;

  // Constructor - open DB connection
  function __construct($location) {
    if ($location =="local"){
      $DB_NAME = "robotdb_web";	
      $HOST="localhost";
      $DB_USER="root";
      $DB_PWD="mysqlpass";
    }else 
    if ($location =="remote"){
      $DB_NAME = "robotdb";	
      $HOST="robotdb.db.11907545.hostedresource.com";
      $DB_USER="robotdb";
      $DB_PWD="robotDB77!";
    }
    $this->db = new mysqli($HOST, $DB_USER, $DB_PWD, $DB_NAME);

    if($this->db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $this->db->query("SET NAMES 'utf8'");
  }

  // Destructor - close DB connection
  function __destruct() {
    $this->db->close();
  }

  function query($sql) {
    if(!$result = $this->db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
    }
    return $result;
  }

  // fields :: array(string)
  // table :: string
  // where :: array(array(string))
  function select($fields,$table,$where) {
    $str_fields=implode(",",$fields);
    $arr_where = [];
    $str_where = "";

    foreach($where as $instruction){
      array_push($arr_where, implode(" ", $instruction));
    }
    $str_where = implode(" AND ", $arr_where);
    $sql = ("SELECT $str_fields FROM $table WHERE $str_where");

    return $this->query($sql);
  }

  //Example of use:
  //$data = array(
  //    "field1"=>"value1",
  //    "field2"=>"value2",
  //    "field3"=>"value3",
  //);
  //insert("mytable",$data,$extras);
  function insert($table,$data,$extras) {
    $fields=""; 
    $values="";
    $i=1;
    foreach($data as $key=>$val)
    {
      if($i!=1) { $fields.=", "; $values.=", "; }
      $fields.="$key";
      $values.="'$val'";
      $i++;
    }
    $sql = "INSERT INTO $table ($fields) VALUES ($values) $extras;";
    if($this->db->query($sql)==true) { 
      return true; }
    else { 
      die("SQL Error: ".$sql."".$this->db->error); return false;}
    }

  function insertFecha($fecha) {
    $data = array(
      "id" => "1",
      "fecha_act" => "$fecha",
    );
    $duplicates = "
      ON DUPLICATE KEY UPDATE fecha_act='$fecha'";

    $this->insert( "info",$data, $duplicates);
  }

  function insertViaje( 
      $destino_id, $compania_id, $fechaSalida, $fechaLlegada, $fechaRegistro, 
      $precio, $url 
    ){
    
    $data = array(
      "id" => "null",
      "destino_id" => "$destino_id",
      "compania_id" => "$compania_id",
      "fechaSalida" => "$fechaSalida",
      "fechaLlegada" => "$fechaLlegada",
      "fechaRegistro" => "$fechaRegistro",
      "precio" => "$precio",
      "url" => "$url",
    );
    $duplicates = "
      ON DUPLICATE KEY UPDATE 
        precio='$precio', fechaRegistro='$fechaRegistro',
        url='$url'";
    
    $this->insert( "contenido",$data, $duplicates);
  }

  //Example of use:
  //delete("mytable","myfieldid = 1");
  function delete($table, $where) {
    $sql = "DELETE FROM $table WHERE $where";
    if($this->query($sql)) { return true; }
    else {
      die("SQL Error: ".$sql."".$this->db->error); return false;}
  }

  function deleteViaje($id){
    return $this->delete("contenido", "id=$id");
  }

  function deleteViajes($viajes){
    foreach ($viajes as &$viaje) { 
      $deleted = deleteViaje($viaje["id"]);
      if ($deleted == false){
        die("Error: No se pudo eliminar el Viaje con id ". $viaje["id"]); 
        return false; 
      };
    };
    return true;
  }

  function deleteOutdatedViajes(){
    $viajes = $this->select(
            array('id'),
            'contenido', 
            array(
              array(
                'fechaRegistro','!=','(select fecha_act from info)')
              )
            );
    deleteViajes($viajes);
  }

  function getAllViajes(){
    return $this->select(
            array('d.etiqueta as destEtiqueta', 'c.etiqueta as compEtiqueta', 
              'precio', 'url'),
            "contenido join destino d join compania c", 
            array(
              array( "destino_id", "=", "d.id"),
              array( "compania_id", "=", "c.id")
            )
    );
  }
}
/*
$robotWebModel = new RobotWebModel('local');

$fecha_act = "3000-05-31 00:00:00";
$duplicates = "ON DUPLICATE KEY UPDATE fecha_act='$fecha_act'";

$robotWebModel->insertFecha($fecha_act);

$result = $robotWebModel->query("select fecha_act from info");
while($row = $result->fetch_assoc()){
  echo $row['fecha_act'] . "\n";
}*/



//Example of use:
//connect();
/*
function dbConnect($location) {
	if ($location =="local"){
		$DB_NAME = "robotdb_web";	
		$HOST="localhost";
		$DB_USER="root";
		$DB_PWD="mysqlpass";
	}else 
	if ($location =="remote"){
		$DB_NAME = "robotdb";	
		$HOST="robotdb.db.11907545.hostedresource.com";
		$DB_USER="robotdb";
		$DB_PWD="robotDB77!";
	}
	$DB_CONN = mysql_connect($HOST,$DB_USER,$DB_PWD)or die(mysql_error());
	return $connection = mysql_select_db( $DB_NAME,$DB_CONN);
}


//Example of use:
//$sql = "USE mydb";
//query($sql);
function query($sql) {
    if(mysql_query($sql)) { 
     return true; 
    }
    else { die("SQL Error: ".$sql."".mysql_error()); return false; }
}

//Example of use:
//$newdata = array(
//    "field1"=>"newvalue1",
//    "field2"=>"newvalue2",
//    "field3"=>"newvalue3",
//);
//update("mytable",$newdata,"myfieldid = 1");

function update($table,$data,$where) {
	$modifs="";
	$i=1;
	foreach($data as $key=>$val)
	{
			if($i!=1) { $modifs.=", "; }
			if(is_numeric($val)) { $modifs.=$key.'='.$val; }
			else { $modifs.=$key.' = "'.$val.'"'; }
			$i++;
	}
	$sql = ("UPDATE $table SET $modifs WHERE $where");
	if(mysql_query($sql)) { return true; }
	else { die("SQL Error: ".$sql."".mysql_error()); return false; }
}

//Example of use:
//$sql = "SELECT * FROM mytable";
//$results = select($sql);
//print_r($results);
function select($sql) {
    $result=array();
    $req = mysql_query($sql) or die("SQL Error: ".$sql."".mysql_error());
    while($data= mysql_fetch_assoc($req)) {
        $result[]=$data;
    }
    return $result;
}

function selectFrWr($fields,$table,$conditions){
	return select("SELECT $fields FROM $table WHERE $conditions;");
}

//Example of use:
//$data = array(
//    "field1"=>"value1",
//    "field2"=>"value2",
//    "field3"=>"value3",
//);
//insert("mytable",$data,$extras);
function insert($table,$data,$extras) {
	$fields=""; 
	$values="";
	$i=1;
	foreach($data as $key=>$val)
	{
			if($i!=1) { $fields.=", "; $values.=", "; }
			$fields.="$key";
			$values.="'$val'";
			$i++;
	}
	$sql = "INSERT INTO $table ($fields) VALUES ($values) $extras";
	if(mysql_query($sql)) { 
		return true; }
	else { 
		die("SQL Error: ".$sql."".mysql_error()); return false;}
}

function insertFecha($fecha) {
  $data = array(
    "id" => "1",
    "fecha_act" => "$fecha",
  );
  $duplicates = "
    ON DUPLICATE KEY UPDATE fecha_act='$fecha'";

  insert( "info",$data, $duplicates);
}

function insertViaje( 
		$destino_id, $compania_id, $fechaSalida, $fechaLlegada, $fechaRegistro, 
		$precio, $url 
	){
  
  $data = array(
    "id" => "null",
    "destino_id" => "$destino_id",
    "compania_id" => "$compania_id",
    "fechaSalida" => "$fechaSalida",
    "fechaLlegada" => "$fechaLlegada",
    "fechaRegistro" => "$fechaRegistro",
    "precio" => "$precio",
    "url" => "$url",
  );
  $duplicates = "
    ON DUPLICATE KEY UPDATE 
      precio='$precio', fechaRegistro='$fechaRegistro',
      url='$url'";
  
  insert( "contenido",$data, $duplicates);
}

//Example of use:
//delete("mytable","myfieldid = 1");
function delete($table, $where) {
	$sql = "DELETE FROM $table WHERE $where";
	if(mysql_query($sql)) { return true; }
	else { die("SQL Error: ".$sql."".mysql_error()); return false; }
}

function deleteViaje($id){
  return delete("contenido", "id=$id");
}

function deleteViajes($viajes){
	foreach ($viajes as &$viaje) { 
    $deleted = deleteViaje($viaje["id"]);
    echo $deleted;
    echo "Entré\n";
		if ($deleted == false){
      die("Error: No se pudo eliminar el Viaje con id ". $viaje["id"]); 
      return false; 
    };
  };
  return true;
}

function deleteOutdatedViajes(){
  $viajes = selectFrWr(
					'id','contenido', 'fechaRegistro != (select fecha_act from info)'
					);
  deleteViajes($viajes);
}

function getAllViajes(){
	return selectFrWr(
    "d.etiqueta as destEtiqueta, c.etiqueta as compEtiqueta, precio, url ",
    " contenido join destino d join compania c", 
    " destino_id = d.id and compania_id = c.id"
  );
}

*/

?>
