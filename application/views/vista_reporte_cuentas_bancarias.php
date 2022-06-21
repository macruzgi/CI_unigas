
<?php 


?>
 
<div align = center>
<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Listado_de_cuetnas_bancarias" />  
</form>
<div class="datagrid"><div class="datagrid">

<table class="reports" cellspacing="0" border="0" id="reportTable">
<thead class="odd">
<tr height="25" bgcolor="#a3c159">
<th width = "15%">ID</th>
<th width = "15%">Banco</th>
<th width = "15%">No. Cuenta</th>

</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php

foreach($listarCuetnasBancarias as $datosEcnontrados):
?>
  <td><?php echo $datosEcnontrados->id_cuenta_bancaria;?></td>

   <td><?php echo $datosEcnontrados->nombre_banco_cuenta;?></td>
   <td><?php echo $datosEcnontrados->numero_cuenta_bancaria;?></td>
   
  </tr> 
<?php endforeach;

?>
</tbody> 
</table></div>

</div>
<br>
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

 