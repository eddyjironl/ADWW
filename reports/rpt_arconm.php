<?php
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
	// solo facturas activas por defecto.
    $lcrptname  = "rpt_arconm";
    $lctitle    = "Resumen de Contenedores / Recepciones";
    $lcsubtitle = "";

	$lcwhere  = "";

    if(isset($_GET["cconno"])){
        $lccodno = mysqli_real_escape_string($oConn,$_GET["cconno"]); 
    }else{
        $lccodno = mysqli_real_escape_string($oConn,$_POST["cconno"]);
    }
	// filtrando cliente.	

	if(!empty($lccodno)){
		$lcwhere = $lcwhere . (empty($lcwhere)?"":" and ") . " arconm.cconno = '". $lccodno ."' ";
	}
    
	
    // armando filtro final
	if ($lcwhere != ""){
		$lcwhere = " where " . $lcwhere; 
	}else{
        echo "Indique numero de contenedor";
        return ;
    }
	//--------------------------------------------------------------------------------------------------------
	// C- Obteniendo datos segun sea el caso.
	//--------------------------------------------------------------------------------------------------------
	// detalle de los articulos
    $lcsqlcmd = " select arconm.dtrndate as dtrndate0,
                         arconm.cdesc as cdesc0,
                         arconm.mnotas as mnotas0,
                         arconm.nlibras_in as nlibras_in0,
                         arconm.nlibras_out as nlibras_out0
                         arcont1.*
                    from arconm
                    join arcont1 on arcont1.cconno = arconm.cconno 
                    left outer join artser on artser.ctserno = arcont1.ccateno
					$lcwhere order by arconm.cconno , arcont1.dtrndate ";

	$lcresult = mysqli_query($oConn,$lcsqlcmd);	
    // determinando si hay datos o no en la consulta.
	if (mysqli_num_rows($lcresult)== 0){
		echo "<h1>No hay datos para este reporte.</h1>";
		return;
	}
	// ----------------------------------------------------------------------------------------------------------------
	// D- Generando el reporte 
	// ----------------------------------------------------------------------------------------------------------------
	$ofpdf = new PDF();
    // llenando las lineas del reporte.
	while($row = mysqli_fetch_assoc($lcresult)){
		
        $ofpdf->SetFillColor(0,0,0);
        $ofpdf->SetTextColor(0,0,0);
       // $ofpdf->cell(30,5, $row["cconno"],0,0,"");   	
        //$ofpdf->Cell(60,5, $row["cdesc0"] ,0,1,"R");   
       // $ofpdf->cell(30,5, $row["dtrndate0"],0,0,"");   	
       // $ofpdf->Cell(30,5, $row["nlibras_in"],0,0,"R");   	
		$ofpdf->Cell(30,5, $row["nlibras_out"],0,0,"R");   	
    	$ofpdf->MultiCell(60,5, $row["mnotas0"],1,"L","");   	
        $lningresos = $lningresos + round($row["nlibras_in0"],2);
        $lnsalidas  = $lnsalidas  + round($row["nlibras_out0"],2);
    }  //while($lcgrp = mysqli_fetch_assoc($lcrestgrp)){r
	// ----------------------------------------------------------------------------------------------------------------
	// Final de Reporte.
	// ----------------------------------------------------------------------------------------------------------------
	$ofpdf->Ln(15);
    $ofpdf->cell(150,5,"Total general ",0,0,"R"); 
    $ofpdf->cell(30,5,$lningresos,"TB",0,"R"); 
    $ofpdf->cell(30,5,$lnsalidas,"TB",1,"R"); 
    
    // termino el reporte y pone el gran total.
	$ofpdf->output();
?>		