<?php

    // ------------------------------------------------------------------------------------------------------------------	
// DESCRIPCION: <RPT_ARADJT>
    // Este escript genera un reporte detallado de las requisas permitiendo salir varias requisas en la misma hoja.
    // ------------------------------------------------------------------------------------------------------------------	

    // ------------------------------------------------------------------------------------------------------------------	
// A)- Coneccion a la base de datos.
	// ------------------------------------------------------------------------------------------------------------------	
	include("../modelo/vc_funciones.php");
	include("../modelo/pdf.php");
	vc_funciones::Star_session();
	// creando la coneccion.
	$oConn = vc_funciones::get_coneccion("CIA");
	// ------------------------------------------------------------------------------------------------------------------	
	// B- Recibiendo parametros de filtros.
	// ------------------------------------------------------------------------------------------------------------------	
// B)- Variables y Parametos recibidos
    $lcrptname  = "rpt_arinvt1_r";
    $lctitle    = "Resumen de Comisiones Por Vendedor";
    $lcsubtitle = "";
	$lcwhere    = " arinvc.cstatus = 'OP' and arinvc.lvoid = 0 "; // solo requisas no compras.
    // Configurando titulo del reporte. 
    $lctitle = $lctitle.$lcsubtitle;

// D)- Area de Filtros
/*
    $lcrespno = mysqli_real_escape_string($oConn,$_POST["crespno"]);
	if(!empty($lcrespno)){
		$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.crespno >= '". $lcrespno ."'";
	}
*/    
    // fecha de emision de recibo.
	$dstar_1 = mysqli_real_escape_string($oConn,$_POST["dstar_1"]);
	$dstar_2 = mysqli_real_escape_string($oConn,$_POST["dstar_2"]);
	if (!empty($_POST["dstar_1"])){
		if($dstar_1 == $dstar_2 or empty($dstar_2)) {
			$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.dstar = '". $dstar_1 ."' ";
		}else{
			$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.dstar >= '". $dstar_1 ."' and ".
								  " arinvc.dstar <= '". $dstar_2 ."' ";
		}
 	}

     $cwhseno_1 = mysqli_real_escape_string($oConn,$_POST["cwhseno_1"]);
     $cwhseno_2 = mysqli_real_escape_string($oConn,$_POST["cwhseno_2"]);
     if(!empty($cwhseno_1)){
         if($cwhseno_1 == $cwhseno_2 or empty($cwhseno_2)) {
             $lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.cwhseno = '". $cwhseno_1 ."' ";
         }else{
             $lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.cwhseno >= '". $cwhseno_1 ."' and ".
                                   " arinvc.cwhseno <= '". $cwhseno_2 ."' ";
         }
     }

    $crespno_1 = mysqli_real_escape_string($oConn,$_POST["crespno_1"]);
	$crespno_2 = mysqli_real_escape_string($oConn,$_POST["crespno_2"]);
	if(!empty($crespno_1)){
		if($crespno_1 == $crespno_2 or empty($crespno_2)) {
			$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.crespno = '". $crespno_1 ."' ";
		}else{
			$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arinvc.crespno >= '". $crespno_1 ."' and ".
								  " arinvc.crespno <= '". $crespno_2 ."' ";
		}
	}


	// armando filtro final
	if ($lcwhere != ""){
		$lcwhere = " where " . $lcwhere; 
	}
	//--------------------------------------------------------------------------------------------------------

// E)- Obteniendo datos segun sea el caso.
	//--------------------------------------------------------------------------------------------------------
	// detalle de los articulos
    $lcsqlcmd = " select   
            arinvc.crespno ,
            arwhse.cdesc,
            arresp.cfullname,
            arresp.cmetodo,
            arresp.cwhseno,
            (select sum(arinvc.nsalesamt - arinvc.ndesamt) as nvtaswhse from arinvc where arinvc.cwhseno = arresp.cwhseno) as vtabod,
            arresp.ncomision, 
            arresp.ncomision1, 
            arresp.ncomision2, 
            sum(arinvc.nsalesamt - arinvc.ndesamt) as nvtastot
            from arinvc
            left outer join arresp on arresp.crespno = arinvc.crespno
            left outer join arwhse on arwhse.cwhseno = arinvc.cwhseno
            $lcwhere group by 1,2 ";

    $lcresult = mysqli_query($oConn,$lcsqlcmd);	
    // numero de registros que tiene el conjunto de datos
    if (gettype($lcresult) == "object"){
        $lnQtyRow = $lcresult->num_rows;
    }else{
        echo "<h1>No hay datos para este reporte</h1>";
        return ;
    }
    // determinando si hay datos o no en la consulta.
	if (mysqli_num_rows($lcresult)== 0){
		echo "<h1>No hay datos para este reporte.</h1>";
		return;
	}
	// ----------------------------------------------------------------------------------------------------------------
    $lnratecomi = 0;
    $lntotcom   = 0;
    $lnVtastype = 0;
// D)- Generando el reporte 
	// ----------------------------------------------------------------------------------------------------------------
	$ofpdf = new PDF();
    $ofpdf->AddPage("P","Letter");	
    // llenando las lineas del reporte.
	while($row = mysqli_fetch_assoc($lcresult)){
            $ofpdf->SetFillColor(0,0,0);
            $ofpdf->SetTextColor(0,0,0);
            $ofpdf->setfont("arial","",9);
            // Impresion detalle general de requisas sumarizada
            $ofpdf->cell(60,5, $row["cfullname"],0,0,"L");  			
            $ofpdf->cell(30,5, ($row["cmetodo"] == "V")?"Vendedor":"Administrador",0,0,"L");  			
            $ofpdf->cell(30,5, $row["cdesc"],0,0,"L");  			
            $ofpdf->cell(30,5, $row["ncomision"],0,0,"R");  		
            $ofpdf->cell(30,5, ($row["cmetodo"] == "V")?$row["nvtastot"]:$row["vtabod"],0,0,"R");  					
            
            // montos para calculos segun sea administrador o vendedor normal.
            if($row["cmetodo"] == "V"){
                $lnratecomi = ($row["nvtastot"] >= $row["ncomision"])?$row["ncomision2"] / 100: $row["ncomision1"] /100;
                $lnVtastype = $row["nvtastot"];

            }else{
                $lnratecomi = ($row["vtabod"] >= $row["ncomision"])?$row["ncomision2"] / 100: $row["ncomision1"] /100;
                $lnVtastype = $row["vtabod"];
            }
            //determinando el valor acumulado de la comision
            $lntotcom  += $lnratecomi * $lnVtastype ;
            $ofpdf->cell(20,5, $lnVtastype * $lnratecomi ,0,1,"R");  					
    }  
    // ----------------------------------------------------------------------------------------------------------------
// Final de Reporte.
	// ----------------------------------------------------------------------------------------------------------------
	$ofpdf->Ln(15);
    $ofpdf->cell(180,5,"Totales generales ",0,0,"R"); 
    $ofpdf->cell(20,5,$lntotcom,"TB",0,"R"); 
    // termino el reporte y pone el gran total.
	$ofpdf->output();

?>		