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

</script> 
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /><!--MUESTRA TILDES Y ѴS-->             
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<hr>
<span class = navegacion>
BACO::
<a href ="<?php echo base_url();?>micontrolador/VistaBanco/">Banco </a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/">Nueva Cuenta </a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaCheque/">Cheques </a>|
<a href ="<?php echo base_url();?>micontrolador/VistaTransacciones/">Transacciones </a> |
<a href ="<?php echo base_url();?>micontrolador/VistaListarConciliacinesFormulario/">Conciliaci&oacute;n </a>|
<a href ="<?php echo base_url();?>micontrolador/VistaReportes/">Reportes</a>
</span>
<hr>
<span class = navegacion>
BANCO::Reporte: Reporte Cheques

</span>
<hr>

<div align = center>
<form name = buscarCuenta method = "POST" action = "<?php echo base_url();?>micontrolador/VistaReporteChques/">
<li>
                    <label class="desc">Seleccione para filtrar</label>
                    <div>
                    

                    <select name =idcuentabanco>
                       <option>Elija...</option>
                      <?php 
                        foreach($listarCuetnasBancarias as $bancosEncotrados):
                      ?>
                        <option value ="<?php echo $bancosEncotrados->id_cuenta_bancaria;?>"> <?php echo $bancosEncotrados->nombre_banco_cuenta." - ".$bancosEncotrados->numero_cuenta_bancaria;?>   </option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                     <input name="fechabanco" type="text" size =10  id="fechabanco" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                     <input name="fechabancohasta" type="text" size =10  id="fechabancohasta" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                   <input type = submit name = buscar class = btnbuscar value = "">
                    </div>
                </li>
<br>

</form>
<br>
<?php
if(count($listarCheques) > 0)
{
if(isset($_POST["idcuentabanco"])) /*inicio*/
//tdoo esto para el reporte
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
<input type="hidden"  name="nombre" value="Listado_de_cheques" />  
</form>
<table  class="reports" cellspacing="0" border="0" id="reportTable">
<thead class="odd">
<tr height="25" bgcolor="#a3c159">
    <th width = "10%">ID</th>
    <th width = "10%">No. Cheque</th>
    <th width = "15%">Fecha</th>
    <th>Monto $</th>
    <th width = "30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;A Nombre de</th>
    <th width = "15%">Banco</th>
    <th width = "15%">No. Cuenta</th>
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
  <td colspan = "7" >
      <b><i> NC:  </b></i>No Contabilizado

  </td>

</tr>
<tr>   
<?php
if(isset($_POST["idcuentabanco"]))
{

foreach($listarCheques as $chequesEncontrados):
?>
  <td><?php echo $chequesEncontrados->id_cheque;
	if($chequesEncontrados->id_partida == -1029)
		{
			echo "<b> - NC -</b>";//cheque no contabilizadao
		}
  ?>
  </td>
   <td><?php echo $chequesEncontrados->numero_cheque;?></td>
   <td><?php echo $chequesEncontrados->fecha_emision;?></td>
   <td  align = right><?php echo $chequesEncontrados->monto_cheque;?></td>
   <td align = center><?php echo $chequesEncontrados->a_nombre_de;?></td>
   <td><?php echo $chequesEncontrados->nombre_banco_cuenta;?></td>
   <td><?php echo $chequesEncontrados->numero_cuenta_bancaria;?></td>

  
   
   
  
  </tr>

<?php endforeach;?>
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