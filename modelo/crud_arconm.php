<?php
// ------------------------------------------------------------------------------------------------
// Descripcion.
// 	Definiendo funciones que se realizaran .
//	$lcaccion = isset($_POST["accion"])? $_POST["accion"],$_GET["accion"];
// ------------------------------------------------------------------------------------------------

include("../modelo/armodule.php");
include("../modelo/vc_funciones.php");
vc_funciones::Star_session();
$oConn = vc_funciones::get_coneccion("CIA");


if(isset($_POST["accion"])){
	$lcaccion = $_POST["accion"]; 	
}else{
	$lcaccion = $_GET["accion"]; 	
}

if (isset($_POST["cconno"])){
	$lcconno =mysqli_real_escape_string($oConn,$_POST["cconno"]);
}
$lnRowsAfect = 0;

// ------------------------------------------------------------------------------------------------
// DELETE, Borrando los datos.
// ------------------------------------------------------------------------------------------------
if($lcaccion=="DELETE"){
	// borrando los detalles
	$lcsqlcmd = " delete from arcont1 where cconno = '" . $lcconno . "' ";
	$lresultF = mysqli_query($oConn,$lcsqlcmd);	
	$lcsqlcmd = " delete from arcont2 where cconno = '" . $lcconno . "' ";
	$lresultF = mysqli_query($oConn,$lcsqlcmd);	
	//$oConn = get_coneccion("CIA");
	$lcsqlcmd = " delete from arconm where cconno = '" . $lcconno . "' ";
	$lresultF = mysqli_query($oConn,$lcsqlcmd);	
}
if($lcaccion=="DELETE_ROW1"){
	$lnid    = $_POST["id1"];
	$lcalias = ($_POST["nopc"]==1)?"arcont1":"arcont2";
	// borrando los detalles
	$lcsqlcmd = " delete from $lcalias where id = '" . $lnid . "' ";
	$lresultF = mysqli_query($oConn,$lcsqlcmd);	
}

// ------------------------------------------------------------------------------------------------
// INSERT / UPDATE, guardando datos existentes o nuevos.
// -----------------------------------------------------------------------------------------------
if($lcaccion=="NEW"){
	// haciendo la coneccion.
	//$oConn = get_coneccion("CIA");
	if (isset($_POST["cconno"])){
		$lcconno    = mysqli_real_escape_string($oConn,$_POST["cconno"]);
		$lcdesc     = mysqli_real_escape_string($oConn,$_POST["cdesc"]);
		$lmnotas    = mysqli_real_escape_string($oConn,$_POST["mnotas"]);
		$ldtrndate  = mysqli_real_escape_string($oConn,$_POST["dtrndate"]);
	
		// verificando que el codigo exista o no 
		$lcsql   = " select cconno from arconm where cconno = '$lcconno' ";
		$lresult = mysqli_query($oConn,$lcsql);	
		$lnCount = mysqli_num_rows($lresult);
		if ($lnCount == 0){
			// este codigo de cliente no existe por tanto lo crea	
			// ejecutando el insert para la tabla de clientes.
			$lcsqlcmd = " insert into arconm (cconno,cdesc,dtrndate,mnotas)
							values('$lcconno','$lcdesc','$ldtrndate','$lmnotas')";
		}else{
			// el codigo existe lo que hace es actualizarlo.	
			$lcsqlcmd = " update arconm set dtrndate = '$ldtrndate', cdesc = '$lcdesc',mnotas = '$lmnotas'  where cconno = '$lcconno' ";
		}
		// ------------------------------------------------------------------------------------------------
		// Generando coneccion y procesando el comando.
		// ------------------------------------------------------------------------------------------------
		$lresultF = mysqli_query($oConn,$lcsqlcmd);	
		//mysqli_query($oConn,$lcsqlcmd);
		$lnRowsAfect = mysqli_affected_rows($oConn);
	}  	// if (isset($_POST["ccateno"])){
	header("location:../view/arconm.php");		
}  		//if($lcaccion=="NEW")

// ------------------------------------------------------------------------------------------------
// JSON, - Informacion detallada de un solo registro.
// ------------------------------------------------------------------------------------------------
if ($lcaccion == "JSON"){
	if (isset($_POST["cconno"])){
		$lcconno = mysqli_real_escape_string($oConn,$_POST["cconno"]);
 		// Consulta unitaria
		$lcSqlCmd = " select * from arconm where cconno ='". $lcconno ."'";
		// obteniendo datos del servidor
		$lcResult = mysqli_query($oConn,$lcSqlCmd);
		// convirtiendo estos datos en un array asociativo
		$ldata = mysqli_fetch_assoc($lcResult);
		// convirtiendo este array en archivo jason.
		$jsondata = json_encode($ldata,true);
		// retornando objeto json
		echo $jsondata;
	}	
}
if($lcaccion == "GET_DETAIL"){
	$lcalias  = ($_POST["pcopc"]=="btinfo1")? "arcont1":"arcont2";
	if(($_POST["pcopc"]=="btinfo1")){
		$lcSqlCmd = "select arcont1.* ,artser.cdesc as ctsernodesc 
					from $lcalias 
					left outer join artser on artser.ctserno = arcont1.ccateno
					where cconno ='". $_POST["cconno"] ."' ";

	}else{
		$lcSqlCmd = "select arcont2.* ,arwhse.cdesc as cwhsenodesc 
					from $lcalias 
					left outer join arwhse on arwhse.cwhseno = arcont2.cwhseno
					where cconno ='". $_POST["cconno"] ."' ";
	}
	$lcResult = mysqli_query($oConn,$lcSqlCmd);
	$lnveces  = 0;
	$ldata    = "";

	if(($_POST["pcopc"]=="btinfo1")){
		// convirtiendo estos datos en un array asociativo
		while ($row = mysqli_fetch_assoc($lcResult)){
			if($lnveces == 0){
				$ldata = '[{"id":"'.$row["id"].'", "dtrndate":"'.$row['dtrndate'].'", "ccateno":"'.$row["ccateno"].'", "ctsernodesc":"'.$row["ctsernodesc"].'", "mnotas":"'.$row["mnotas"].'", "nlibras_in":'.$row["nlibras_in"]. '}';
			}else{
				$ldata = $ldata . ',{"id":"'.$row["id"].'", "dtrndate":"'.$row['dtrndate'].'", "ccateno":"'.$row["ccateno"].'", "ctsernodesc":"'.$row["ctsernodesc"].'", "mnotas":"'.$row["mnotas"].'", "nlibras_in":'.$row["nlibras_in"]. '}';
			}
			$lnveces += 1;
		}
	}else{
		// convirtiendo estos datos en un array asociativo
		while ($row = mysqli_fetch_assoc($lcResult)){
			if($lnveces == 0){
				$ldata = '[{"id":"'.$row["id"].'", "dtrndate":"'.$row['dtrndate'].'", "cwhseno":"'.$row["cwhseno"].'", "cwhsenodesc":"'.$row["cwhsenodesc"].'", "mnotas":"'.$row["mnotas"].'", "nlibras_out":'.$row["nlibras_out"]. '}';
			}else{
				$ldata = $ldata . ',{"id":"'.$row["id"].'", "dtrndate":"'.$row['dtrndate'].'", "cwhseno":"'.$row["cwhseno"].'", "cwhsenodesc":"'.$row["cwhsenodesc"].'", "mnotas":"'.$row["mnotas"].'", "nlibras_out":'.$row["nlibras_out"]. '}';
			}
			$lnveces += 1;
		}
	}
	if ($lcResult->num_rows <> 0){
		$ldata = $ldata . "]";
	}else{
		$ldata = "[{}]";
	}
// convirtiendo este array en archivo jason.
	//$jsondata = json_encode($ldata,true);
	// retornando objeto json
	echo $ldata;
	//echo $jsondata;
}
if($lcaccion == "INSERT_IN"){

	$lcalias  = ($_POST["pcopc"]=="btinfo1")? "arcont1":"arcont2";
	if(($_POST["pcopc"]=="btinfo1")){
		$lnid      = mysqli_real_escape_string($oConn,$_POST["id1"]);
		$lcconno   = mysqli_real_escape_string($oConn,$_POST["cconno"]);
		$ldtrndate = mysqli_real_escape_string($oConn,$_POST["dtrndate1"]);
		$lmnotas   = mysqli_real_escape_string($oConn,$_POST["mnotas1"]);
		$lccateno  = mysqli_real_escape_string($oConn,$_POST["ccateno1"]);
		$lnlibras  = mysqli_real_escape_string($oConn,$_POST["nlibras_in1"]);
		if ($lnid){
			$lcsqlcmd  = "update arcont1 set ccateno = '$lccateno',
												mnotas     = '$lmnotas',
												dtrndate   = '$ldtrndate',
												nlibras_in =  $lnlibras where id = $lnid ";
		}else{
			$lcsqlcmd  = "insert into arcont1 (cconno, ccateno, mnotas, dtrndate,nlibras_in) values('$lcconno','$lccateno','$lmnotas','$ldtrndate',$lnlibras)";
		}
	}else{
		$lnid      = mysqli_real_escape_string($oConn,$_POST["id2"]);
		$lcconno   = mysqli_real_escape_string($oConn,$_POST["cconno"]);
		$ldtrndate = mysqli_real_escape_string($oConn,$_POST["dtrndate2"]);
		$lmnotas   = mysqli_real_escape_string($oConn,$_POST["mnotas2"]);
		$lcwhseno  = mysqli_real_escape_string($oConn,$_POST["cwhseno"]);
		$lnlibras  = mysqli_real_escape_string($oConn,$_POST["nlibras_out"]);
		if ($lnid){
			$lcsqlcmd  = "update arcont2 set cwhseno = '$lcwhseno',
												mnotas     = '$lmnotas',
												dtrndate   = '$ldtrndate',
												nlibras_out =  $lnlibras where id = $lnid ";
		}else{
			$lcsqlcmd  = "insert into arcont2 (cconno, cwhseno, mnotas, dtrndate,nlibras_out) 
			              values('$lcconno','$lcwhseno','$lmnotas','$ldtrndate',$lnlibras)";
		}
		
	}
	$lcResult = mysqli_query($oConn,$lcsqlcmd);
}

//Cerrando la coneccion.
mysqli_close($oConn);
?>
