<head>
 
<script type="text/javascript">
$(function() {
	$("#fecha").datepicker();
  $("#fechahasta").datepicker();
;
});

</script>
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

<h1>
Reportes Transacciones
</h1>

<div align = center>
<form name = buscarCuenta method = "POST" ACTION = "<?php echo base_url();?>micontrolador/VistaReporteTransacciones/">

                   
      

                      <select name =idcuentabanco>
                     
                      <?php 
                        foreach($listarCuetnasBancarias as $bancosEncotrados):
                      ?>
                        <option value ="<?php echo $bancosEncotrados->id_cuenta_bancaria;?>"> <?php echo $bancosEncotrados->nombre_banco_cuenta." - ".$bancosEncotrados->numero_cuenta_bancaria;?>   </option>
                      <?php
                        endforeach;
                      ?>
                    </select>
                     Fecha desde:<input name="fecha" type="text" size =10  id="fecha"  value = "<?php echo date("Y-m-d");?>" maxlength="255"/>
                      Fecha Hasta:<input name="fechahasta" type="text" size =10  id="fechahasta" value = "<?php echo date("Y-m-d");?>" maxlength="255"/>
            
                               <input type = submit name = buscar class = btnbuscar value = "">      </div>

<br>

</form>
<?php
if(count($listarTransacciones) > 0)
{
?>
<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<?php
 if(isset($_POST["fecha"]) && count($listarTransacciones) > 0)
{

?>
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<?php
}
?>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Listado_de_transacciones_<?php echo $listarTransacciones[0]->nombre_banco_cuenta;?>" />  
</form>
<div align = center>

<div class="datagrid">
<table class="reports"  cellspacing="0" border="0" id="reportTable">
<thead class="odd">
<tr height="25" bgcolor="#a3c159" width = "80%">
  <td colspan = 3>
    UNIGAS DE EL SALVADOR
  </td>
  <TD>
    <?php
    echo   "Banco: ".$listarTransacciones[0]->nombre_banco_cuenta."-".$listarTransacciones[0]->numero_cuenta_bancaria;
   
    ?>
  </TD>
 <TD colspan = 3>
    <?php
    if(isset($_POST["fecha"]) && isset($_POST["fechahasta"]))
      echo "Transacciones de la fecha: ". $_POST["fecha"]. " Hasta: ".$_POST["fechahasta"] ;
   
    ?>
  </TD>
</tr>
<tr height="25" bgcolor="#a3c159">
    <th>ID</th>

    <th width = "15%">Fecha contable</th>
    <th width = "15%">Valor $</th>
    <th width = "25%">Referencia</th>
    <th width = "25%">Concepto</th>
    <th width = "12%">Debe</th>
    <th width = "25%">Haber</th>

  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>   
<?php

if(isset($_POST["fecha"]))
{

if($listarTransacciones) //no se para que lo he puesto esta demas inservible
foreach($listarTransacciones as $transaccionesEncontrados):
?>
  <td><?php echo $transaccionesEncontrados->id_transaccion;?></td>

   <td><?php echo $transaccionesEncontrados->fecha_contable;?></td>
   <td><?php echo $transaccionesEncontrados->valor;?></td>
   <td><?php echo $transaccionesEncontrados->referencia;?></td>
   <td><?php echo $transaccionesEncontrados->concepto;?></td>
   <td align = right><?php echo $transaccionesEncontrados->debe;?></td>
   <td align = right><?php echo $transaccionesEncontrados->haber;?></td>

  
   
   
   <td>
  
    </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
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
  <?php 
  }
  ?>
            