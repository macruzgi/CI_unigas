<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>


     

<hr>
<span class = navegacion>
COMPRAS:: | 
<a href ="<?php echo base_url();?>micontrolador/VistaCompras/">Compras</a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a>
</span>
<hr>
<h1>
Libro IVA Compras</h1>


<div align = center>

<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->

<form name = buscarCuenta method = "POST" action = "<?php echo base_url();?>micontrolador/VistaReporteLibroIVAcompras/">
<li>
                    <label class="desc">Seleccione la fecha para filtrar y generar el libro IVA de compras</label>
                    <div>
						Mes: <select name ="mes">
								<option value = "01">Enero</option>
								<option value = "02">Febrero</option>
								<option value = "03">Marzo</option>
								<option value = "04">Abril</option>
								<option value = "05">Mayo</option>
								<option value = "06">Junio</option>
								<option value = "07">Julio</option>
								<option value = "08">Agosto</option>
								<option value = "09">Septiembre</option>
								<option value = "10">Octubre</option>
								<option value = "11">Noviembre</option>
								<option value = "12">Diciembre</option>
							</select>
						A&ntilde;o: <select name = "annio">
								<?php
									$rangoAnnios  = 2080;
									//$annioInicial = 2000;
									for($annioInicial=2000; $annioInicial <= $rangoAnnios; $annioInicial++)
										{
								?>
											<option value ="<?php echo $annioInicial;?>"><?php echo $annioInicial;?></option>
								<?php 
										}
								?>
							 </select>
                   
                    
                   <input type = "submit" name = buscar class = btnbuscar value = "">
                    </div>
                </li>
<br>

</form>

<?php
//print_r($listaReporteLibroComprasIVA); 
/*array para buscar el nombre del mes
segun el numero del que elijo en el formulario */
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");
 //print_r($listaReporteLibroComprasIVA);
if($listaReporteLibroComprasIVA > 0)
{
?>
<form action="<?php echo base_url();?>micontrolador/ExportarExcel/" method="POST" target="_blank" id="FormularioExportacion">  
<p id="botonExportExcel"><img src="<?php echo base_url();?>images/icon_excel.jpg" align="absmiddle" width="22"/> <span class="links">Exportar a Excel</span> </p>  
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="nombre" value="Libro_IVA_compras_<?php echo $mesAmostrar = $mes[$_POST["mes"]-1]."_".$_POST["annio"];?>" />  
</form>
<div class="datagrid">



<table  width="100%"  style="font-size:10px;font-family: Georgia, 'Times New Roman', serif;"  cellspacing="0" cellpadding="0" border="1" id ="reportTable">
<thead style="background: #e8edff;color: #039;">
  <tr style ="border:1px solid black;">
  <td colspan = "11" style="color: #039;">
    UNIGAS DE EL SALVADOR
 
    <?php
   
   if(isset($_POST["mes"]) && isset($_POST["annio"]))
		{
			$mesAmostrar = $mes[$_POST["mes"]-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
		  echo "Libro de IVA Compras del mes de ".$mesAmostrar ." de ".$_POST["annio"];
			
		}
    ?>
  </TD>
 <TD  colspan = "5" align ="right" style="color: #039;">
	No. de Registro: 112811-6
	<br>
	NIT: 0614-190599-103-0
  </TD>
</tr>
<tr>
<th  rowspan="2">No. correlativo</th>
<th rowspan="2">Fecha Documento</th>
<th rowspan="2">Fecha Asiento</th>
<th rowspan="2">No. de Serie</th>
<th rowspan="2">Refeencia No. Factura</th>
<th rowspan="2">NRC</th>
<th rowspan="2">NIT</th>
<th rowspan="2">Nombre del Proveedor</th>


<th colspan="2">Compras EXENTAS</TH>
<th colspan="6">Compras GRAVADAS</TH>
<tr>
	<th>Internas</th>
	<th>Importaciones e Inernaciones</th>
	
	<th>Internas</th>
	<th>Importaciones e Inernaciones</th>
	<th>Credito Fiscal</th>
	<th>IVA Retenido</th>
	<th>TOTAL COMPRAS</th>
	<th>Compras a excluidos</th>
</tr>

</tr>



</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>

<tr>
<?php
$granTotalSinIVA 		= 0;
$granTotalIVA	 		= 0;
$granTotalIVARetenido	= 0;
$granTotalComrpas		= 0;
foreach($listaReporteLibroComprasIVA as $datosEcnontrados):
$granTotalSinIVA 		= $granTotalSinIVA + ($datosEcnontrados->total_afecto -  $datosEcnontrados->total_iva) + $datosEcnontrados->total_impuesto2;
$granTotalIVA	 		= $granTotalIVA + $datosEcnontrados->total_iva;
$granTotalIVARetenido	= $granTotalIVARetenido + $datosEcnontrados->total_impuesto2;
$granTotalComrpas		= $granTotalComrpas + $datosEcnontrados->total_afecto;


?>
  <td class ="celdaLibroIva"><?php echo $datosEcnontrados->correlativo;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->fecha;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->fecha_contable;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->serie;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->numero;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->nrc;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->nit;?></td>
   <td class ="celdaLibroIva"><?php echo $datosEcnontrados->nombre;?></td>
   <td></td>
   <td></td>

   <td align = "right"class ="celdaLibroIva"><?php
				$totalSinIva =  ($datosEcnontrados->total_afecto -  $datosEcnontrados->total_iva) + $datosEcnontrados->total_impuesto2;
				echo number_format($totalSinIva, 2);
				
				
				?>
	</td>
   <td align = right></td>
   <td align = right class ="celdaLibroIva"><?php echo number_format($datosEcnontrados->total_iva, 2);?></td>
   <td align = right class ="celdaLibroIva"><?php echo number_format($datosEcnontrados->total_impuesto2,2);?></td>
   <td align = right class ="celdaLibroIva"><?php echo number_format($datosEcnontrados->total_afecto, 2);?></td>
   <td align = right></td>

    
  </tr> 
<?php endforeach;

?>
<tr>
<td colspan = "8" align = "right">
	<b>TOTALES</B>
</td>
<td>
</td>
<td>
</td>
<td align = "right">
	<b>
	<?php 
		echo number_format($granTotalSinIVA, 2);
	?>
	</b>
</td>
<td>
</td>
<td align = "right">
	<b>
	<?php 
		echo number_format($granTotalIVA, 2);
	?>
	</b>
</td>
<td align = "right">
	<b>
	<?php 
		echo number_format($granTotalIVARetenido, 2);
	?>
	</b>
</td>
<td align = "right">
	<b>
	<?php 
		echo number_format($granTotalComrpas, 2);
	?>
	</b>
</td>
<td>
</td>
</tr>
</tbody> 
</table>
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
   
