<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<head>
<script type="text/javascript">
$(function() {
	$("#fechabanco").datepicker();
  $("#fechabancohasta").datepicker();

;
});

function abrirVentanaProveedores() {
  sList = window.open("<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaCrheque/", "list", "width=750,height=510");
}
fu
</script> 
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /><!--MUESTRA TILDES Y ѴS-->             
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<hr>
<span class = navegacion>
COMPRAS:: | 
<a href ="<?php echo base_url();?>micontrolador/VistaCompras/">Compras</a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a>
|
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a>
| <a href ="<?php echo base_url();?>micontrolador/VistaCentroCostos/">Centros Costos</a>

</span>
<hr>
<h1>
Reportes Hist&oacute;rico x Proveedor</h1>



<div align = center>
<form name = "cuentabancos" method = "POST" action = "<?php echo base_url();?>micontrolador/ReporteHistoricoXProveedor/">
<li>
                    <label class="desc">Seleccione para filtrar</label>
                    <div>
                    
						C&oacute;digo proveedor: <input name="codigo" type="text" size ="15" id="codigo" maxlength="255" />
						<!-- campos hidden que no se necesitan pero que como abro la misma poput 
						esta espera enviarle estos datos al formulario padre-->
                       <input name="idproveedor" type="hidden" class="field text medium" id="idproveedor" value="000000" maxlength="255"/> <!--este ide se lo mando cuendo voi a buscar las cuentas por pagar al proveedor!-->
						<input name="anombrede" type="hidden" size = 60  id="anombrede" value="" maxlength="255"/>
						<!--aqui no lo necesito los campos hidden pero los pongo pero xque aabro la misma popu y 
					   en esta espera enviarlde estos datos al formulario padre-->
                          <a href = "#" onClick="abrirVentanaProveedores()"> <img src = "<?php echo base_url();?>images/lupa.png" align  = middle title ="Buscar Proveedor" width ="40"></a>
                   
                     Desde: <input name="fechabanco" type="text" size =10  id="fechabanco" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                     Hasta: <input name="fechabancohasta" type="text" size =10  id="fechabancohasta" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                   <input type = submit name = buscar class = btnbuscar value = "">
                    </div>
                </li>
<br>

</form>
<br>
<?php


if(isset($_POST["fechabanco"])) /*inicio*/
//tdoo esto para el reporte
{  
if(count($listarCompraHistoricoXProveedor) > 0)
{
?>
  
<?php
}
/*fin*/
?>
<div class="datagrid"><div class="datagrid">
<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Historico_x_proveedor" />  
</form>
<table  class="reports" cellspacing="0" border="0" id="reportTable" width ="100%">
<thead class="odd">
<tr height="25" bgcolor="#a3c159">
    <th>N&uacute;mero Doc.</th>
    <th>Producto</th>
    <th>&Uacute;timo precio</th>
	<th>Cantidad</th>
    <th>Fecha</th>
    
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>

<?php

if(isset($_POST["fechabanco"]))
{
$idProveedorComoBandera = "";
foreach($listarCompraHistoricoXProveedor as $filasEncontradas):

?>
 
<?php if($idProveedorComoBandera != $filasEncontradas->id_proveedor)
		{
		?>
	<tr> 
	<td colspan ="5" align ="center"><b>Proveedor:</b><i> <?php echo $filasEncontradas->codigo_proveedor." - ".$filasEncontradas->nombre;?></i>
	</td>
	</tr>
	<?php
		}
?>

<tr>
   <td><?php echo $filasEncontradas->numero;?></td>
   <td  align = "left"><?php echo $filasEncontradas->descripcion;?></td>
   <td align = center><?php echo $filasEncontradas->precio_unitario;?></td>
   <td align = center><?php echo $filasEncontradas->cantidad;?></td>
 <td align = center><?php echo $filasEncontradas->fecha_contable;?></td>

  
   
   
  
  </tr>

<?php
$idProveedorComoBandera = $filasEncontradas->id_proveedor;///para que agarre el valor del proveedor
 endforeach;?>
</tbody>

<?php
}
?>
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
<?php
}
?>             