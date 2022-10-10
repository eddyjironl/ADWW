<html>
	<head>
		<title>Resumen de Comisiones</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/vc_estilos.css"> 
 		<script src="../js/vc_funciones.js"></script> 
 		<script src="../js/arinvc1_r.js"></script> 
	</head>
	<body>
		<form target="_blank" method="POST" action="../reports/rpt_arinvc1_r.php" id="arinvc1_r" name="arinvc1_r" class= "form2">
			<script> get_barraprint("Resumen de comisiones","Ayuda Formulario de Comisiones.");</script>
    		<br>
			<div class="contenedor_objetos">
				<label class = "labelfiltro">Vendedor ID</label>
				<input type="text" id="crespno_1"  name="crespno_1" class="ckey">
				<script>get_btmenu("btcrespno_1","Lista de Proveedores"); </script>
				<input type="text" id="crespno_2"  name="crespno_2" class="ckey">
				<script>get_btmenu("btcrespno_2","Lista de Proveedores"); </script>
   				<br>
                <label class = "labelfiltro">Bodega</label>
				<input type="text" id="cwhseno_1"  name="cwhseno_1" class="ckey">
				<script>get_btmenu("btcwhseno_1","Lista de Bodegas"); </script>
				<input type="text" id="cwhseno_2"  name="cwhseno_2" class="ckey">
				<script>get_btmenu("btcwhseno_2","Lista de Bodegas"); </script>
				<br>
                <label class = "labelfiltro">Fecha Emision</label>
				<input type="date" id="dstar_1" name="dstar_1">
                <input type="date" id="dstar_2" name="dstar_2">
                <br>
			</div>
		</form>

		<div id="showmenulist"></div>
		<script>get_msg();</script>
		
	</body>
</html>