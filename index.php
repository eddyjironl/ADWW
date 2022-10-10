<?php
// iniciando validacion de session
include("modelo/vc_funciones.php");
//$oCia = new vc_funciones();
//--------------------------------------------------------------------------------------------------------------
vc_funciones::init_index();
//action="modelo/uservalid.php"
?>

<!DOCTYPEHTLM>
<html>
	<head>
		<title>Login de usuarios</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="css/vc_estilos.css">
		<script src="js/vc_funciones.js"></script>
		<script src="js/index.js"></script>

	</head>
	<style>
		body{
			background: #44A08D;  /* fallback for old browsers */
			background: -webkit-linear-gradient(to right, #093637, #44A08D);  /* Chrome 10-25, Safari 5.1-6 */
			background: linear-gradient(to right, #093637, #44A08D); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		}
	</style>

	<body>
		<form  id="sysinit" name="sysinit" method="post" action="modelo/uservalid.php" >
			<div id="divtitulo">
				<h2>Inicio de Session</h2>
			</div>
			<section id="seclogo">		
				<img id="logo" src="photos/LOGITO11.jpg">
			</section>
			<section id="secdatos">
				<div id="separador"></div>
				<div>
					<label>Usuario</label>
					<input type="text" id="cuserid" name="cuserid" placeholder="Codigo de usuario" title="Codigo del usuario"  autofocus autocomplete="off"/> 
				</div>
				
				<div>
					<label>Clave</label>
					<input type="password" id="cpasword" name="cpasword" placeholder="Pasword" title="Clave del usuario" autocomplete="off"/> 
				</div>
				
				<div>
					<label>Compañia</label>
					<?php
						vc_funciones::getcialist();
					?>
				</div>
			</section>
			<section id="botones">
				<button type="submit" id="entrar" name="entrar" >Entrar</button>
				<a id="btsalir" href="https://www.google.com">Salir</a>
			</section>
			<footer>
				<p>	<b>Soporte Tecnico Correo: </b> infovisualcontrol@gmail.com</p>	
			</footer>
			
		</form>
		<script>
			get_msg();

		</script>
	</body>

</html>