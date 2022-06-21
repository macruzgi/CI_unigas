<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>


     
<script type="text/javascript">
$(function() {
	$("#fechabanco").datepicker();
  $("#fechabancohasta").datepicker();

;
});

</script> 
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
<h1>Reportes 
Libro Bancos
</h1>


<div align = center>

<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->
<div class="datagrid">
<form name = buscarCuenta method = "POST" action = "<?php echo base_url();?>micontrolador/VistaLibroBanco/">
<li>
                    <label class="desc">Seleccione para filtrar y ver el libro Banco</label>
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
<div id="tabla"> <!--AQUI SE MUESTRAN LOS DATOS DE LA OTRA VISTA QUE LISTA LOS DATOS A CONCILIAR-->
 <div align = center>
<?php 
if(count($listaReporteLibroBanco) > 0)
{
?>
<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Libro_banco_<?php echo $listaReporteLibroBanco[0]->nombre_banco_cuenta."-".$listaReporteLibroBanco[0]->numero_cuenta_bancaria;?>" />  
</form>
<div class="datagrid"><div class="datagrid">

<table class="reports" cellspacing="0" border="0" id="reportTable" width = "95%">
<thead class="odd">
<tr height="25" bgcolor="#a3c159" width = "90%">
  <td colspan = 2 width = "25%">
    UNIGAS DE EL SALVADOR
  </td>
  <TD>
    <?php
    echo   $listaReporteLibroBanco[0]->nombre_banco_cuenta."-".$listaReporteLibroBanco[0]->numero_cuenta_bancaria;
   
    ?>
  </TD>
 <TD  colspan = 3>
  <?php
    if(isset($_POST["fechabanco"]) && isset($_POST["fechabancohasta"]))
      echo "Libro Banco de la fecha: ". $_POST["fechabanco"]. " Hasta: ".$_POST["fechabancohasta"] ;
   
    ?>
  </TD>
</tr>
<tr height="25" bgcolor="#a3c159">
<th width = "10%">Fecha</th>
<th width = "15%">Concepto</th>
<th width = "10%">
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	&nbsp;
		Debe</th>
<th width = "10%">
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;Haber</th>

<th width = "9%"></th>
<th width = "9%">
	&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;
	&nbsp;Saldo</th>
</tr>




</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
  <td>
      <b><i> SALDO ANTERIOR   </b></i>

  </td>
  <td  colspan = 5 align = right>
   <b><i>
  <?php
    
    echo $saldoAnterior = ($listarSaldosAnteriores[0]->SALDO_ANTERIOR_CHEQUES + $listarSaldosAnteriores[0]->SALDO_ANTERIOR_TRANSACCIONES);
  ?>
  </b></i>
  </td>
</tr>
<tr>
<?php
 $saldo = 0;
foreach($listaReporteLibroBanco as $datosEcnontrados):
$saldo = ($saldo + $saldoAnterior + $datosEcnontrados->debe)  - $datosEcnontrados->haber; 

$textoLargo = $datosEcnontrados->concepto;
$largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
$rompeLineas = '</br>';
$romper_palabras_largas = true; // rompe una palabra si es demacido larga

?>
  <td><?php echo $datosEcnontrados->fecha_emision;?></td>

   <td><?php echo $datosEcnontrados->CHEQUE_O_TRANSFERENCIA." - ".$datosEcnontrados->concepto;?></td>
   <td align = right><?php echo $datosEcnontrados->debe;?></td>
   <td align = right><?php echo $datosEcnontrados->haber;?></td>
    <td align = right colspan = 2><?php 
         
        echo $saldo; ?></td>
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
    
<?php
}
?>
</div>
   
   </div> <!--FIN DONDE SE MUESTRAN LOS DATOS DE LA OTRA VISTA-->
   
</div>