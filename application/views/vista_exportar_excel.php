<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
header("Content-type: application/vnd.ms-excel; name='excel'");  
header("Content-Disposition: filename=".$_POST['nombre'].".xls");  
header("Pragma: no-cache");  
header("Expires: 0"); 
?>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /><!--MUESTRA TILDES Y ѴS-->
<?php 
echo $_POST['datos_a_enviar']; 
 
?>