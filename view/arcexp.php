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
		<title>Exportarcion de Articulos</title>
		<link rel="stylesheet" href="../css/vc_estilos.css?v1">
		<script src="../js/vc_funciones.js?v1"></script>
		<script src="../js/arcexp.js?v1"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		<script>get_msg();</script>

		<?php 
			if(isset($_GET["mensaje"])){		
				echo "<script> getmsgalert('". $_GET["mensaje"]."');</script>";
			}
		?>

		<form class="form2" id="arcexp" name="arcexp" method="post" action="../modelo/crud_arcexp.php?accion=NEW">
            <div class="barra_info">
                <strong>Exportacion de Inventarios de Contenedor a Bodega</strong>
			</div>
            <div class="contenedor_objetos">
			<label class="labelnormal">Contendor Id</label>
				<input type="text" id="cconno" name="cconno" class="textkey" autocomplete="off" autofocus>
				<script>get_btmenu("btcconno","Listado de Contenedores");</script>
				<input type="text" id="cdesc" class="textcdescreadonly" >
				<br>
				<label class="labelnormal">Bodega Id</label>
				<script> get_lista_arwhse();</script>
				<br>
				<label class="labelnormal">Tipo Movimiento</label>
				<script> get_lista_arcate();</script>
				<br>
				<label class="labelnormal">Fecha Ingreso</label>
				<input type="date" id="dtrndate" name="dtrndate" >
				<br>
				<label class="labelsencilla">Comentarios Generales</label><br>
				<textarea id="mnotas" name="mnotas" class="mnotas" rows=8 cols=72> </textarea>

            </div>

			<div class="contenedor_objetos">
                <input type="button" class="btlinks" id="btsave" value="Exportar" placeholder="Exportar Articulos a Bodega">
                <input type="button" class="btlinks" id="btquit" value="Salir" placeholder="Cierra la pantalla">
			</div>			
		</form>

		<div id="showmenulist"></div>
	</body>
</html>