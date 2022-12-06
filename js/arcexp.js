function init(){
	document.getElementById("btquit").addEventListener("click",cerrar_pantalla_principal,false);
    document.getElementById("btsave").addEventListener("click",guardar,false);
	// contenedor
	document.getElementById("cconno").addEventListener("change",valid_ckeyid,false);
	document.getElementById("btcconno").addEventListener("click",function(){
        get_menu_list("arconm","showmenulist","cconno","valid_ckeyid");
    },false);

}
// cerrar pantalla principal
function cerrar_pantalla_principal(){
	document.getElementById("arcexp").style.display="none";
}
// guardar registro principal
function guardar(){
	var oform = document.getElementById("arcexp");
	// validaciones de campos obligatorios.
	if(document.getElementById("cconno").value ==""){
		getmsgalert("No indico Contenedor");
		return ;
	}
	if(document.getElementById("cwhseno").value ==""){
		getmsgalert("No indico bodega destino");
		return ;
	}
	if(document.getElementById("dtrndate").value ==""){
		getmsgalert("No indico Fecha de requisa");
		return ;
	}
	if(document.getElementById("ccateno").value ==""){
		getmsgalert("No indico tipo de requisa");
		return ;
	}
	
	oform.submit();
}
function valid_ckeyid(){
	var lcxkeyvalue = document.getElementById("cconno").value;
	if(lcxkeyvalue != ""){
		update_window(lcxkeyvalue,"btcconno");
	}
}
function update_window(pckeyid){
	// --------------------------------------------------------------------------------------
	// Con esta funcion se hace una peticion al servidor para obtener un JSON, con los 
	// datos de la persona un solo objeto json que sera el cliente.
	// --------------------------------------------------------------------------------------
	var oRequest = new XMLHttpRequest();
	// Creando objeto para empaquetado de datos.
	var oDatos   = new FormData();
	// adicionando datos en formato CLAVE/VALOR en el objeto datos para enviar como parametro a la consulta AJAX
	oDatos.append("cconno",pckeyid);
	oDatos.append("accion","JSON");
	// obteniendo el menu
	oRequest.open("POST","../modelo/crud_arconm.php",false); 
	oRequest.send(oDatos);
	// desplegando pantalla de menu con su informacion.
	var odata = JSON.parse(oRequest.response);
	//cargando los valores de la pantalla.
	if (odata != null){
		document.getElementById("cconno").value  = odata.cconno;
		document.getElementById("cdesc").value 	 = odata.cdesc;
		//estado_key("I");
	}else{
        getmsgalert("Este codigo de contenedor no existe");
	}
}


window.onload=init;