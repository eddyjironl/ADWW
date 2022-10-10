function init(){
	document.getElementById("btquit").addEventListener("click",cerrar_pantalla_principal,false);
	document.getElementById("btguardar").addEventListener("click",guardar,false);
	document.getElementById("btnueva").addEventListener("click",get_clear_view,false);
	document.getElementById("btdelete").addEventListener("click",borrar,false);
	//document.getElementById("btccateno").addEventListener("click",getmenulist,false);
	// configurando las variables de estado.
	gckeyid   = "cconno";
	gckeydesc = "cdesc";
	gcbtkeyid = "btcconno";
	// ------------------------------------------------------------------------
	// CODIGO PARA LOS MENUS INTERACTIVOS.
	// CADA MENU
	document.getElementById("cconno").addEventListener("change",valid_ckeyid,false);
	document.getElementById("btcconno").addEventListener("click",function(){
        get_menu_list("arconm","showmenulist","cconno","valid_ckeyid");
    },false);
	// desplegando pantallas de registro
	document.getElementById("btinfo1").addEventListener("click",show_info,false);
	document.getElementById("btinfo2").addEventListener("click",show_info,false);

	document.getElementById("btshow1").addEventListener("click",show_view,false);
	document.getElementById("btshow2").addEventListener("click",show_view,false);
	
	// cerrando 
	document.getElementById("btclosed1").addEventListener("click",closed_view,false);
	document.getElementById("btclosed2").addEventListener("click",closed_view,false);
	document.getElementById("btclosed11").addEventListener("click",closed_view,false);
	document.getElementById("btclosed22").addEventListener("click",closed_view,false);


	//ejecutando datos
	document.getElementById("btadd1").addEventListener("click",addlinein, false);
	document.getElementById("btadd2").addEventListener("click",addlinein, false);
	
	// configurando las ventanas nuevas
	document.getElementById("info1_w").style.display="none";
	document.getElementById("info2_w").style.display="none";
	document.getElementById("add1").style.display="none";
	document.getElementById("add2").style.display="none";
}
function addlinein(e){
	lcopc   = e.target.id;
	lcopc2  = (e.target.id == "btadd1")?"btinfo1":"btinfo2"
	pckeyid = document.getElementById("cconno").value;
	var oRequest = new XMLHttpRequest();
	// Creando objeto para empaquetado de datos.
	var oDatos   = new FormData();
	// adicionando datos en formato CLAVE/VALOR en el objeto datos para enviar como parametro a la consulta AJAX
	oDatos.append("cconno",pckeyid);
	oDatos.append("pcopc",lcopc2);
	if (lcopc == "btadd1"){
		oDatos.append("id1",document.getElementById("id1").value);
		oDatos.append("dtrndate1",document.getElementById("dtrndate1").value);
		oDatos.append("nlibras_in1",document.getElementById("nlibras_in1").value);
		oDatos.append("ccateno1",document.getElementById("ctserno").value);
		oDatos.append("mnotas1",document.getElementById("mnotas1").value);
		document.getElementById("id1").value = "";
		document.getElementById("dtrndate1").value = get_date_comp();
		document.getElementById("nlibras_in1").value= "";
		document.getElementById("ctserno").value = "";
		document.getElementById("mnotas1").value = "";
		document.getElementById("nlibras_in1").focus();
	}else{
		oDatos.append("id2",document.getElementById("id2").value);
		oDatos.append("dtrndate2",document.getElementById("dtrndate2").value);
		oDatos.append("nlibras_out",document.getElementById("nlibras_out2").value);
		oDatos.append("cwhseno",document.getElementById("cwhseno").value);
		oDatos.append("mnotas2",document.getElementById("mnotas2").value);
		document.getElementById("id2").value = "";
		document.getElementById("dtrndate2").value = get_date_comp();
		document.getElementById("nlibras_out2").value= "";
		document.getElementById("cwhseno").value = "";
		document.getElementById("mnotas2").value = "";
		document.getElementById("nlibras_out2").focus();
	}
	oDatos.append("accion","INSERT_IN");
	// obteniendo el menu
	oRequest.open("POST","../modelo/crud_arconm.php",false); 
	oRequest.send(oDatos);
	// limpiando pantalla
	refresh_view1(lcopc2);
}
function closed_view(e){
	oview = e.target.id;
	if (oview =="btclosed1"){
		document.getElementById("info1_w").style.display="none";
	}
	if (oview =="btclosed11"){
		document.getElementById("add1").style.display="none";
	}
	if (oview =="btclosed2"){
		document.getElementById("info2_w").style.display="none";
	}
	if (oview =="btclosed22"){
		document.getElementById("add2").style.display="none";
	}
}
function edit_upd_line(ofile, pnopc){
	oData = ofile;
	if (pnopc == 1){ 
		document.getElementById("id1").value         = oData.parentElement.parentElement.children[0].innerHTML;
		document.getElementById("dtrndate1").value   = oData.parentElement.parentElement.children[1].innerHTML;
		document.getElementById("nlibras_in1").value = oData.parentElement.parentElement.children[2].innerHTML;
		document.getElementById("ctserno").value    = oData.parentElement.parentElement.children[3].innerHTML;
		document.getElementById("mnotas1").value 	 = oData.parentElement.parentElement.children[5].innerHTML;
		document.getElementById("add1").style.display="block";
	}else{
		document.getElementById("id2").value         = oData.parentElement.parentElement.children[0].innerHTML;
		document.getElementById("dtrndate2").value   = oData.parentElement.parentElement.children[1].innerHTML;
		document.getElementById("nlibras_out2").value = oData.parentElement.parentElement.children[2].innerHTML;
		document.getElementById("cwhseno").value    = oData.parentElement.parentElement.children[3].innerHTML;
		document.getElementById("mnotas2").value 	 = oData.parentElement.parentElement.children[5].innerHTML;
		document.getElementById("add2").style.display="block";
	
	}
}
function show_info(e){
	copc = e.target.id;
	// refrescando el view 1 detalle
	refresh_view1(copc);
}
function refresh_view1(copc){
	lcconno = document.getElementById("cconno").value;
	if (!lcconno){
		alert("Indique un numero de contenedor");
		return ;
	}
	// obteniendo informacion
	var oRequest = new XMLHttpRequest();
	// Creando objeto para empaquetado de datos.
	var oDatos   = new FormData();
	// adicionando datos en formato CLAVE/VALOR en el objeto datos para enviar como parametro a la consulta AJAX
	oDatos.append("cconno",lcconno);
	oDatos.append("pcopc",copc);
	oDatos.append("accion","GET_DETAIL");
	// obteniendo el menu
	oRequest.open("POST","../modelo/crud_arconm.php",false); 
	oRequest.send(oDatos);
	// desplegando pantalla de menu con su informacion.
	var odata = JSON.parse(oRequest.responseText);
	// presentando datos2
		if (copc == "btinfo1"){
			otabla  = document.getElementById("tdetalles");
			otabla.innerHTML = "";
			if (odata != null){
				for (let index = 0; index < odata.length; index++) {
					lcrow = '<tr>';
					lcrow += '<td class="rowhtext" >' + odata[index].id + '</td>';
					lcrow += '<td class="rowhtext">'  + odata[index].dtrndate + '</td>';
					lcrow += '<td class="rowhqty">'  + odata[index].nlibras_in + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].ccateno + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].ctsernodesc + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].mnotas + '</td>';
					lcrow += '<td ">';
					lcrow += '	<input type="button" value="Editar"   class="btlinks" id="btneditar1" onclick="edit_upd_line(this,1)" >';	
					lcrow += '	<input type="button" value="Eliminar" class="btlinks_warning" onclick="delete_row1(this,1)">	';
					lcrow += '</td>';
					lcrow += '</tr>';
					// insertando dato en la tabla
					if (odata[0].id != undefined){
						otabla.insertRow(-1).innerHTML = lcrow;
					}
				}
			}
			document.getElementById("info1_w").style.display="block";
		}else{
			otabla  = document.getElementById("tdetalles2");
			otabla.innerHTML = "";
			if (odata != null){
				for (let index = 0; index < odata.length; index++) {
					lcrow = '<tr>';
					lcrow += '<td class="rowhtext" >' + odata[index].id + '</td>';
					lcrow += '<td class="rowhtext">'  + odata[index].dtrndate + '</td>';
					lcrow += '<td class="rowhqty">'  + odata[index].nlibras_out + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].cwhseno + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].cwhsenodesc + '</td>';
					lcrow += '<td class="rowhtext" >' + odata[index].mnotas + '</td>';
					lcrow += '<td ">';
					lcrow += '	<input type="button" value="Editar"   class="btlinks" id="btneditar2" onclick="edit_upd_line(this,2)" >';	
					lcrow += '	<input type="button" value="Eliminar" class="btlinks_warning" onclick="delete_row1(this,2)">	';
					lcrow += '</td>';
					lcrow += '</tr>';
					// insertando dato en la tabla
					if (odata[0].id != undefined){
						otabla.insertRow(-1).innerHTML = lcrow;
					}
				}
			}
			document.getElementById("info2_w").style.display="block";
		}
}
function show_view(e){
	oview = e.target.id;
	if(oview =="btshow1"){
		document.getElementById("id1").value         = "";
		document.getElementById("dtrndate1").value   = get_date_comp()
		document.getElementById("nlibras_in1").value = "";
		document.getElementById("ctserno").value     = "";
		document.getElementById("mnotas1").value 	 = "";
		document.getElementById("add1").style.display="block";
	}else{
		document.getElementById("id2").value         = "";
		document.getElementById("dtrndate2").value   = get_date_comp()
		document.getElementById("nlibras_out2").value = "";
		document.getElementById("cwhseno").value     = "";
		document.getElementById("mnotas2").value 	 = "";
		document.getElementById("add2").style.display="block";

	}
}
// cerrar pantalla principal
function cerrar_pantalla_principal(){
	document.getElementById("arconm").style.display="none";
}
// guardar registro principal
function guardar(){
	var oform = document.getElementById("arconm");
	// validaciones de campos obligatorios.
	if(document.getElementById("cconno").value ==""){
		getmsgalert("Falta el codigo del tipo de Inventario");
		return ;
	}
	if(document.getElementById("cdesc").value ==""){
		getmsgalert("Falta la descripcion");
		return ;
	}
	
	oform.submit();
}
function delete_row1(orow,nopc){
	lnid = orow.parentElement.parentElement.children[0].innerHTML;
	// obteniendo informacion
	var oRequest = new XMLHttpRequest();
	// Creando objeto para empaquetado de datos.
	var oDatos   = new FormData();
	// adicionando datos en formato CLAVE/VALOR en el objeto datos para enviar como parametro a la consulta AJAX
	oDatos.append("id1",lnid);
	oDatos.append("nopc",nopc);
	oDatos.append("accion","DELETE_ROW1");
	// obteniendo el menu
	oRequest.open("POST","../modelo/crud_arconm.php",false); 
	oRequest.send(oDatos);
	refresh_view1((nopc == 1)?"btinfo1":"btinfo2");
}
// borrando registro principal
function borrar(){
	var xkeyid = document.getElementById("cconno").value;
	if(xkeyid != ""){
		if (!confirm("Esta seguro de borrar este registro")){
			return ;
		}
		var oRequest = new XMLHttpRequest();
		// Creando objeto para empaquetado de datos.
		var oDatos   = new FormData();
		// adicionando datos en formato CLAVE/VALOR en el objeto datos para enviar como parametro a la consulta AJAX
		oDatos.append("cconno",xkeyid);
		oDatos.append("accion","DELETE");
		// obteniendo el menu
		oRequest.open("POST","../modelo/crud_arconm.php",false); 
		oRequest.send(oDatos);
		get_clear_view();
	}else{
		getmsgalert("No ha indicado un codigo para borrar");
	}
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
		document.getElementById("cconno").value    = odata.cconno;
		document.getElementById("cdesc").value 	   = odata.cdesc;
		document.getElementById("mnotas").value    = odata.mnotas;
		document.getElementById("dtrndate").value  = odata.dtrndate;
		document.getElementById("nlibras_in").value  = odata.nlibras_in;
		document.getElementById("nlibras_out").value = odata.nlibras_out;
		estado_key("I");
	}else{
		ck_new_key();
	}
}
window.onload=init;