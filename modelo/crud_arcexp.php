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


if($lcaccion=="NEW"){
    $lcmsg = "";
	// haciendo la coneccion.
	//$oConn = get_coneccion("CIA");
	if (isset($_POST["cconno"])){
		$lcconno    = mysqli_real_escape_string($oConn,$_POST["cconno"]);
        $lcwhseno   = mysqli_real_escape_string($oConn,$_POST["cwhseno"]);
        $lccateno   = mysqli_real_escape_string($oConn,$_POST["ccateno"]);
        $lmnotas    = mysqli_real_escape_string($oConn,$_POST["mnotas"]);
		$ldtrndate  = mysqli_real_escape_string($oConn,$_POST["dtrndate"]);
        $lcadjno    = "";
        // verificando que el codigo exista o no 
		$lcsql   = " select cconno from arconm where cconno = '$lcconno' ";
		$lresult = mysqli_query($oConn,$lcsql);	
		$lnCount = mysqli_num_rows($lresult);
        if ($lnCount == 0){
            $lcmsg = "Contenedor no existe en los registros";
        }else{
            // obteniendo datos del detalle de articulos no procesados.
            $lcsqlcmd = "select arcont2.id, arcont2.cservno , 
                                 arcont2.nqty , 
                                  arserm.cdesc, 
                                   arserm.ncost 
                        from arcont2
                        left outer join arserm on arserm.cservno = arcont2.cservno
                        where lexport = FALSE and cconno = '$lcconno' ";
            
            $lresult  = mysqli_query($oConn,$lcsqlcmd);	    
            $lnCount  = mysqli_num_rows($lresult);
            // cargando a la bodega.
            if ($lnCount == 0){
                $lcmsg = "No hay que procesar en este contenedor";
            }else{
                // haciendo la exportacion.
                // cargando el encabezado de requisas
                // ------------------------------------------------------------------------------------------------------
                $lcadjno   = GetNewDoc($oConn,"ARADJM");
                $lnveces   = 1;
                $lnfactor  = 1;
                $llupdcost = false;
               	// Determinando el factor de movimiento en la requisa.
                $lcsql_factor = " select ctypeadj , lupdcost from arcate where ccateno = '". $lccateno ."' ";
                $lcresultf  = mysqli_query($oConn,$lcsql_factor);
                $ofactor    = mysqli_fetch_assoc($lcresultf);
                if ($ofactor["ctypeadj"] == "S"){
                    $lnfactor = -1;
                }
                $llupdcost = $ofactor["lupdcost"];

                // encabezado de la requisa.
                $lcsql1  = "insert into aradjm(cadjno,crefno, ccateno, crespno, dtrndate,mnotas,cwhseno, ntc, usuario)
                            values('$lcadjno','Exportacion Automatizada','". $lccateno ."','01','" . $ldtrndate .
                                    "','".$lmnotas."','". $lcwhseno."',1,'" . $_SESSION["cuserid"]. "')";
                // actualizando la requisa
                $lcresulth = mysqli_query($oConn,$lcsql1);
                if (!$lcresulth){
                    $lcmsg = "No se pudo guardar el encabezado de la requisa ";
                    return ;
                }

                // cargando detalles de los articulos a exportar.
                while( $row = mysqli_fetch_assoc($lresult)){
                    if ($lnveces == 1){
                        $lcsql_d1 = "insert into aradjt(cadjno,cservno,cdesc, ncost,ncostu,nqty,usuario)
                                    values ('$lcadjno','". $row["cservno"] ."','". $row["cdesc"] ."',". $row["ncost"] .",". $row["ncost"] .",$lnfactor * ". $row["nqty"] .",'".$_SESSION["cuserid"]."')";
                        $lnveces = 2;
                    }else{
                        $lcsql_d1 = $lcsql_d1 . " ,('$lcadjno','". $row["cservno"] ."','". $row["cdesc"] ."',". $row["ncost"] .",". $row["ncost"] .",$lnfactor * ". $row["nqty"] .",'".$_SESSION["cuserid"]."')";
                    }
                    // Actualizando costo si es el caso.
                    if($llupdcost){
						//	B) Determinando las cantidades existentes si es costo promedio.
						$lnonhand = get_inventory_onhand($oConn,$row["cservno"],"R");
						//  C) Determinando costo promedio para cargarlo en la linea del articulo.
						$lnCost_master = $row["ncost"];	
						// determinando costo promedio.
						$lnExist_amt_act   = $lnonhand * $lnCost_master;
						// costo actual de la compra.
						$lnExist_amt_buy   = $row["nqty"] * $row["ncost"] ;
						// costo promedio
						$lnCostPromd       = ($lnExist_amt_act + $lnExist_amt_buy) / ($lnonhand + $row["nqty"] );
						$lnlast_price_buy  =  $row["ncost"];
						$lcsqlserupd = " update arserm set  nlastcost = ".  $lnlast_price_buy. ", ncost = ".$lnCostPromd . " where arserm.cservno = '". $row["cservno"]."'";
						$llcont = $llcont and mysqli_query($oConn,$lcsqlserupd);
					}
                    // cerrando la linea para que no la vuelva a reprocesar.
                    $lcupdt_cont = "update arcont2 set lexport = true , cadjno = '". $lcadjno ."' where id =". $row['id'];
                    mysqli_query($oConn,$lcupdt_cont);

                }
                mysqli_query($oConn,$lcsql_d1);
                $lcmsg = "Traslado exitoso...Requisa No ". $lcadjno;
            }
		}
		// ------------------------------------------------------------------------------------------------
		// Generando coneccion y procesando el comando.
		// ------------------------------------------------------------------------------------------------
	} 
	header("location:../view/arcexp.php?mensaje=".$lcmsg);		
}  		//if($lcaccion=="NEW")

// ------------------------------------------------------------------------------------------------
// JSON, - Informacion detallada de un solo registro.
// ------------------------------------------------------------------------------------------------
//Cerrando la coneccion.
mysqli_close($oConn);
?>
