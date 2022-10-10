var xMenuId = "";
function init(){
	document.getElementById("btquit").addEventListener("click",cerrar_pantalla,false);
	document.getElementById("btprint").addEventListener("click",print,false);
	document.getElementById("btnueva").addEventListener("click",clear_view,false);
	
}

function cerrar_pantalla(){
	document.getElementById("arinvc1_r").style.display="none";
}
function print(){
 document.getElementById("arinvc1_r").submit();
}

window.onload=init;