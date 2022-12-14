<?php 
// iniciando validacion de session
include("../modelo/vc_funciones.php");
//--------------------------------------------------------------------------------------------------------------
if (vc_funciones::Star_session() == 1){
	return;
}
?>
<html>
	<head>
		<title>Sistema Visual Control v2020</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<link   rel="stylesheet" href="../css/escritorio.css?v1"> 
		<link   rel="stylesheet" href="../css/vc_estilos.css?v1">
		<script src="../js/vc_funciones.js?v1"></script>
		<script src="../js/escritorio.js?v1" ></script>
		<link rel="shortcut icon" type="image/x-icon" href="../photos/vc2009.ico" />
	</head>
<style>
	body{
		background: #44A08D;  /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #093637, #44A08D);  /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #093637, #44A08D); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	}
  	#helps{
    	display: inline-block;
	}
</style>
	<!-- background="../photos/fondo3.png" -->

	<body id="espacio" >
		<iframe id="ventana"> </iframe>	

		<div id="barra_small">
			<img src="../photos/vc2009.ico" id="logo_min">
			<img src="../photos/transacciones.ico" id="transacciones" class="botones" title="Transacciones">
			<img src="../photos/reportes.ico" id="reportes" class="botones" title="Reportes del modulo">
			<img src="../photos/catalogo.ico" id="catalogos" class="botones" title="Catalogos del sistema">
			<img src="../photos/herramientas.ico" id="Modulos" class="botones" title="Configuraciones del modulo">
			<img src="../photos/ayuda.ico" id="ayuda" class="botones" title="Ayuda">
			<br>
			
			<div id="info_small">
				<br>
				<label class="labelnormal">Compañia</label>
				<!-- <label class="labeltitle">Compañia de pruebas</label> -->
				<input type="text" id="cia_desc_small"  readonly value=" <?php ECHO  $_SESSION["compdesc"] ?>">
				<script>get_btmenu("btcias_samall","Listado de Compañias");</script>
				<br>
				<label class="labelnormal">Usuario</label>
				<!-- <label class="labeltitle">Compañia de pruebas</label> -->
				<input type="text" id="cfullname_small"  readonly value=" <?php ECHO  $_SESSION["cfullname"] ?>">
				<br>
				<label class="labelnormal">Modulos</label>
				<select class="listas" id="cmodule_select_small">
						<option value=""> Elija un Modulo de trabajo</option>
						<option value="SY"> Administracion</option>
						<option value="AR"> Facturacion y Cuentas por cobrar</option>
						<option value="IN"> Control de inventario y Cuentas por pagar</option>
						<option value="CT"> Contabilidad General</option>
				</select>
				<br>
				<H1>    ATENCION.....!!!</H1>
				
				<P><strong>1)- PARA INICIAR SELECCIONE EL MODULO</strong><br><BR>
				No podra realizar ninguna operacion si no elige el modulo, despues de seleccionar modulo puede dar click en boton Aceptar <br><br>
				
				2)- Tambien puede cambiar de compañia si desea cambiar dar click en boton de la lupa amarilla.<br><br>

				3)- Si desea cerrar este mensaje dar click en Boton Aceptar.<br><br>

				3)- Si desea ver este mensaje de nuevo dar click en primer boton rueda amarilla dentada.
				</P>
				<br>
				<input type="button" value="Aceptar" title="Click para ocultar" id="close_info">
			</div>
			
			<div id="area_menu_small"></div>
		</div>
		
		<div id="barra1"> 
			<div id="divlogo">
				<img id="logovc" src="../photos/LOGITO11.jpg" id="icono">
			</div>
			<div id="barra1-a">
				Autorizado a: <strong>Modulo de Evaluacion</strong>
			</div>
			<br>
			<div id="area_menu">
				<nav id="bmenu"></nav>
			</div>
		</div>
		
		<footer> 
			<label class="labelnormal">Compañia</label>
			<!-- <label class="labeltitle">Compañia de pruebas</label> -->
			<input type="text" id="cia_desc"  readonly value=" <?php ECHO  $_SESSION["compdesc"] ?>">
			<script>get_btmenu("btcias","Listado de Compañias");</script>
			<br>
			<label class="labelnormal">Usuario</label>
			<!-- <label class="labeltitle">Compañia de pruebas</label> -->
			<input type="text" id="cfullname"  readonly value=" <?php ECHO  $_SESSION["cfullname"] ?>">
			<br>
			<label class="labelnormal">Modulos del Sistema</label>
			<select class="listas" id="cmodule_select">
					<option value=""> Elija un Modulo de trabajo</option>
					<option value="SY"> Administracion</option>
					<option value="AR"> Facturacion y Cuentas por cobrar</option>
					<option value="IN"> Control de inventario y Cuentas por pagar</option>
					<option value="PL"> Recursos Humanos</option>
					<option value="CT"> Contabilidad General</option>
				</select>
			<div id="helps" class="contenedor_objetos">
				<a href="../manuales.pdf" target="_blank" placeholder = "Descarga los manuales actualizados del sistema"><strong>Manual del sistema</strong></a>
			
			</div>
		</footer>
		<script>
			get_xm_menu();
			get_msg();

		</script>
	</body>
</html>