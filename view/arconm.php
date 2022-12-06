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
		<title>Administracion de Contenedores</title>
		<link rel="stylesheet" href="../css/vc_estilos.css?v1">
		<script src="../js/vc_funciones.js?v1"></script>
		<script src="../js/arconm.js?v1"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		<form class="form2" id="arconm" name="arconm" method="post" action="../modelo/crud_arconm.php?accion=NEW">
			<script>get_barraprinc_x("Administracion de Contenedores","Ayuda de Contenedores");</script> 	
			<div class="contenedor_objetos" style="float:left;">
				<label class="labelnormal">Contendor Id</label>
				<input type="text" id="cconno" name="cconno" class="textkey" autocomplete="off" autofocus>
				<script>get_btmenu("btcconno","Listado de Contenedores");</script>
				<br>
				<label class="labelnormal">Descripcion</label>
				<input type="text" id="cdesc" name="cdesc" class="textcdesc" autocomplete="off">
				<br>
                <label class="labelnormal" >Fecha de Ingreso</label>
				<input type="date" id="dtrndate" name="dtrndate" class="textkey">
				<br>
				<label class="labelnormal" >Libras Ingresadas</label>
				<input type="numeric" id="nlibras_in"  class="textkeyreadonly" >
				<br>
				<label class="labelnormal" >Libras Distribuidas</label>
				<input type="numeric" id="nlibras_out"  class="textkeyreadonly" >
				<br>
			</div>

            <div class="contenedor_objetos" style="float:left;">
                <label class="labelsencilla">Comentarios Generales</label><br>
				<textarea id="mnotas" name="mnotas" class="mnotas" rows=9 cols=55> </textarea>
            </div>
			<br>
			<input type="button" class="btlinks" id="btinfo1" value="Detalle de Ingresos" placeholder="Detalle de Ingresos">
			<input type="button" class="btlinks" id="btinfo2" value="Desgloce de Articulos" placeholder="Desglose de articulos">
			
		</form>
		<!-- pantalla despliegue de informacion -->
		<div id="info1_w" class="form2  area_bloqueo">
			<div class="barra_info">
				<strong>Detalle de Recepcion</strong><br>
				<input type="button" value="Agregar" class="btlinks_warning" id="btshow1" placeholder="Agregar Datos">
				<input type="button" value="Cerrar"  class="btlinks_warning" id="btclosed1" placeholder="Cerrar Pantalla">


				<form target="_blank" method="POST" action="../reports/rpt_arconm.php" style="DISPLAY: INLINE;">
					<label class="labelnormal">Contenedor</label>
					<input type="text" class="ckey" name="cconno" value="1">
					<input type="submit" class="btlinks"  value="Reporte Recepcion" placeholder="Resumen Recepciones">
				</form>

			</div>
			<br>
			<div class="contenedor_objetos">
				<table >
					<thead class="area_encabezado" >
						<tr >
							<th class="rowhtext">Id</th>
							<th class="rowhtext">Fecha</th>
							<th class="rowhqty">libras</th>
							<th class="rowhtext">Grupo Id</th>
							<th class="rowhtext">Descripcion</th>
							<th class="rowhtext">Comentarios</th>
							<th class="rowhtext">Acciones</th>
						</tr>
					</thead>
					<tbody id="tdetalles" class="formato_datos_grid">
					</tbody> 
				</table>
			</div>
		</div>
		<!-- pantalla adicion de informacion de informacion -->
		<div id="add1" class="form2 area_bloqueo">
			<div class="barra_info">
				<strong>Agregando informacion de Recepcion</strong>
				<br>
				<input type="button" value="Guardar" class="btlinks_warning" id="btadd1" placeholder="Guarda la informacion ">
				<input type="button" value="Cerrar"  class="btlinks_warning" id="btclosed11" placeholder="Cierra la pantalla">
			</div>
			<div class="contenedor_objetos">

				<label class="labelnormal">id </label>
				<input type="text" id="id1" class="saykey" readonly>
				<br>

				<label class="labelnormal">Fecha </label>
				<input type="date" id="dtrndate1" class="textdate">
				<br>

				<label class="labelnormal">Libras</label>
				<input type="number" id="nlibras_in1">
				<br>

				<label class="labelnormal">Tipo</label>
				<script> get_lista_artser();</script>
				<br>
				<llabel class="labelsencilla">Comentarios</llabel>
				<br>
				<textarea rows="5" cols="50" id="mnotas1" placeholder="si necesita poga un comentario"></textarea>
			</div>
		</div>

		<!-- pantalla despliegue de informacion -->
		<div id="info2_w" class="form2  area_bloqueo">
			<div class="barra_info">
				<strong>Detalle de Articulos</strong><br>
				<input type="button" value="Agregar" class="btlinks_warning" id="btshow2" placeholder="Agregar Datos">
				<input type="button" value="Cerrar" class="btlinks_warning" id="btclosed2" placeholder="Cerrar Pantalla">
			</div>
			<br>
			<div class="contenedor_objetos">
				<table >
					<thead class="area_encabezado" >
						<tr >
							<th class="rowhtext">Id</th>
							<th class="rowhtext">Fecha</th>
							<th class="rowhtext">Articulo Id</th>
							<th class="rowhtext">Descripcion</th>
							<th class="rowhqty">Unidades</th>
							<th class="rowhtext">Requisa #</th>
							<th class="rowhtext">Comentarios</th>
							<th class="rowhtext">Acciones</th>
						</tr>
					</thead>
					<tbody id="tdetalles2" class="formato_datos_grid">
					</tbody> 
				</table>
			</div>
		</div>
		<!-- pantalla adicion de informacion de informacion -->
		<div id="add2" class="form2 area_bloqueo">
			<div class="barra_info">
				<strong>Agregando Articulos de Inventario</strong>
				<br>
				<input type="button" value="Guardar" class="btlinks_warning" id="btadd2" placeholder="Guarda la informacion ">
				<input type="button" value="Cerrar"  class="btlinks_warning" id="btclosed22" placeholder="Cierra la pantalla">
			</div>
			<div class="contenedor_objetos">

				<label class="labelnormal">id </label>
				<input type="text" id="id2" class="saykey" readonly>
				<br>

				<label class="labelnormal">Fecha </label>
				<input type="date" id="dtrndate2" class="textdate">
				<br>

				<label class="labelnormal">Unidades</label>
				<input type="number" id="nqty">
				<br>

				<label class="labelnormal">Articulo</label>
				<select id="cservno" name="cservno">
					<option>Seleccione un Articulo </option>
					<?php 
						$lcsqlcmd = "select cservno , cdesc from arserm order by cdesc desc  ";
						$oConn = vc_funciones::get_coneccion("CIA");
						$lcresult = mysqli_query($oConn, $lcsqlcmd);
						while($lnrow = mysqli_fetch_assoc($lcresult)){
							echo "<option value=".$lnrow["cservno"] .">". $lnrow["cdesc"] ."</option>";
						}
					?>
				</select>
				<br>
				<llabel class="labelsencilla">Comentarios</llabel>
				<br>
				<textarea rows="5" cols="50" id="mnotas2" placeholder="si necesita ponga un comentario"></textarea>
			</div>
		</div>

		<script>get_msg();</script>
		<div id="showmenulist"></div>
	</body>
</html>