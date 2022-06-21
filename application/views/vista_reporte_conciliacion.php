<?php
 header('Content-Type: text/html; charset=ISO-8859-1'); 
 /*array para buscar y poner en los textbox mes el nombre del mes
segun el numero de la fecha acutal*/
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");


?>


<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Listado_de_conciliaciones" />  
</form>
<div align = center>

<div class="datagrid"><div class="datagrid">
<table class="reports" cellspacing="0" border="0" id="reportTable" width = "80%">
<thead class="odd">
<tr height="25" bgcolor="#a3c159">
<th width = "30%">Id</th>
<th width = "30%">Cuenta bancaria</th>
<th width = "30%">Mes</th><th width = "30%">Año</th>

</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php

foreach($listarConciliaciones as $conciliacionesEncontradas):
?>
  <td><?php echo $conciliacionesEncontradas->correlativo;?></td>
  <td><?php echo $conciliacionesEncontradas->nombre_banco_cuenta;?></td>
   <td><?php 
            $numeroMes = $conciliacionesEncontradas->mes;  //busco el numero del mes


            $mesAmostrar = $mes[$numeroMes-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
 
   
   echo $mesAmostrar;?></td>
   <td><?php echo $conciliacionesEncontradas->annio;?></td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr> 
<?php endforeach;

?>
</tbody> 
</table></div>

<script language="javascript">  
$(document).ready(function() {  
     $("#botonExportExcel").click(function(event) {  
     $("#datos_a_enviar").val( $("<div>").append( $("#reportTable").eq(0).clone()).html());  
     $("#FormularioExportacion").submit();  
});  
});  
</script>
<div id="repExcel" class="hidden"></div>

</div>
</div>