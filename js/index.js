function init(){
	document.getElementById("entrar").addEventListener("click",validar_usuario,false);
}

function validar_usuario(){
	// datos a guardar 
	lcuserid  = document.getElementById("cuserid").value;
	lcpasword = document.getElementById("cpasword").value;
	
	lcCia = document.getElementById("ccompid").value;
	var oForm = document.getElementById("sysinit");
	
	if (lcuserid == "" ){
		alert("El Usuario esta vacio");
		return false ;
	}
			
	if (lcpasword ==""){
		alert("La clave de usuario esta vacio");
	  	return false;
	}
	// verificando la compañia	
	if (lcCia ==""){
		
		alert("No indico la Compañia de trabajo.");
	  	return false;
	}
	// enviando el formulario.
	oForm.submit();
}
window.addEventListener("load",init,false);
//window.addEventListener("unload",saygodbay,false);
//window.load=init;



