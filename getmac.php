<?php

?>
<HTML>
    Este es un código JS para obtener la dirección física (MAC) de la tarjeta de red del cliente.
<HEAD>
<TITLE>WMI Scripting HTML</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
<script>  
n=0;
	x = setInterval(function(){
        document.forms[0].txtMACAddr.value=n;
		n++;
	},1000);
  

</script>  
<SCRIPT language="JScript" event="OnCompleted(hResult,pErrorObject, pAsyncContext)" for="foo">
  
  
  
  
</SCRIPT>
<SCRIPT language="JScript" event="OnObjectReady(objObject,objAsyncContext)" for="foo">
   if(objObject.IPEnabled != null && objObject.IPEnabled != "undefined" && objObject.IPEnabled == true)
   {
    if(objObject.MACAddress != null && objObject.MACAddress != "undefined")
    MACAddr = objObject.MACAddress;
    if(objObject.IPEnabled && objObject.IPAddress(0) != null && objObject.IPAddress(0) != "undefined")
    IPAddr = objObject.IPAddress(0);
    if(objObject.DNSHostName != null && objObject.DNSHostName != "undefined")
    sDNSName = objObject.DNSHostName;
    }
</SCRIPT>
<META content="MSHTML 6.00.2800.1106" name="GENERATOR">
</HEAD>
<BODY>
<OBJECT id="locator" classid="CLSID:76A64158-CB41-11D1-8B02-00600806D9B6" VIEWASTEXT>
</OBJECT>
<OBJECT id="foo" classid="CLSID:75718C9A-F029-11d1-A1AC-00C04FB6C223" VIEWASTEXT>
</OBJECT>
<SCRIPT language="JScript">
   var service = locator.ConnectServer();
   var MACAddr ;
   var IPAddr ;
   var DomainAddr;
   var sDNSName;
   service.Security_.ImpersonationLevel=3;
   service.InstancesOfAsync(foo, 'Win32_NetworkAdapterConfiguration');
</SCRIPT>
<FORM id="formfoo" name="formbar" action="index.html" method="get">
   <INPUT value="" name="txtMACAddr" ID="Text1"> 
   <INPUT value="" name="txtIPAddr" ID="Text2">
   <INPUT value="" name="txtDNSName" ID="Text3">
</FORM>
</BODY>
</HTML>

