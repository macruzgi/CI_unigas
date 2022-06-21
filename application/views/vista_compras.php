<?php

?>
<script type="text/javascript">
$(function() {
	$("#fechadesde").datepicker();
  $("#fechahasta").datepicker();

;
});

</script>

<hr>
<span class = navegacion>
COMPRAS::
<!--a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> |--> 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaCentroCostos/">Centros Costos</a>

</span>
<hr>
<?php

$segmento = $this->uri->segment(3,0);
$claseEstilo = "";
$mensaje = "";
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 111000)
{
   $claseEstilo = "error_box";
   $mensaje = "No es posible anular un registro que no est&eacute; contabilizado.";
}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>


<div align = center>
<form name = buscarCuenta method = "POST" ACTION = "<?php echo base_url();?>micontrolador/VistaCompras/">
<li>
                    <label class="desc">Filtre para buscar<span class="req"></span></label>
                    <div>
                     Fecha Desde:<input name="fechadesde" type="text" size =10  id="fechadesde"  maxlength="255"/>
                     Fecha Hasta:<input name="fechahasta" type="text" size =10  id="fechahasta"  maxlength="255"/>
                
                   <input type = submit name = buscar class = btnbuscar value = "">
                    </div>
                </li>
<br>

</form>
<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->
<div class="datagrid">
<table class="tablecss" width="80%" border="1">
<thead class="odd"><tr><th>ID</th>
<th>Tipo Documento</th>
<th>Fecha</th>
<th>Proveedor</th>
<th>Total $</th>
<th  colspan ="4">
  Acciones
  </th>
</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php

$aleatoria = time();
if(isset($_POST["fechadesde"]))
{

foreach($listarOrdenesCompras as $ordenesEncontradas):
?>
  <td>
  <?php 
	if($ordenesEncontradas->estado_compra == 2)//esta esperando quedan comprabante de credito fiscal en fisico para la CXP sino no podra actualizar el encabezado
		{
  ?>
  <a href = "<?php echo base_url();?>micontrolador/VistaActualizarEncabezadoOrdenCompra/<?php echo $ordenesEncontradas->id_comprobante;?>/ " title = "Actualizar Encabezado"><?php echo $ordenesEncontradas->id_comprobante;?></a>
	<?php 
		}
	else
		{
			echo $ordenesEncontradas->id_comprobante;
		}
	?>
  </td>
  <td><?php 
		if($ordenesEncontradas->id_tipo_comprobante == 1)
			{
				$documento ="CCF";
			}
		elseif($ordenesEncontradas->id_tipo_comprobante == 2)
			{
				$documento ="Nota C.";
			}
		elseif($ordenesEncontradas->id_tipo_comprobante == 3)
			{
				$documento ="Nota D.";
			}
		elseif($ordenesEncontradas->id_tipo_comprobante == 4)
			{
				$documento ="Factura";
			}
		elseif($ordenesEncontradas->id_tipo_comprobante == 5)
			{
				$documento ="Recibo";
			}
		echo $documento;
		
		?></td>
   <td><?php echo $ordenesEncontradas->fecha;?></td>
   <td><?php echo $ordenesEncontradas->nombre;?></td>
   <td><?php 
		if($ordenesEncontradas->estado_compra == 10)
			{
				echo "<font color = red>ANULADA</font>";
			}
		else
			{
				echo $ordenesEncontradas->total_comprobante;
				
			}
		?></td>
  <td align ="center" width ="30%">
		<?php 
			if($ordenesEncontradas->estado_compra ==1)
				{
		?>
		
		<?php 
				}
			elseif($ordenesEncontradas->estado_compra == 2)//esta esperando quedan comprabante de credito fiscal en fisico para la CXP
				{
				
				
		?>
		
			 <a href = "<?php echo base_url();?>micontrolador/VistaProcesarAlaCXP/<?php echo $ordenesEncontradas->id_comprobante."/".$ordenesEncontradas->id_tipo_comprobante;?>/">
				<img src = "<?php echo base_url();?>images/Dollar.png" title = "Procesar a la CXP"></a>
				
			&nbsp;
			&nbsp;&nbsp;
			<a href = "<?php echo base_url();?>micontrolador/BuscarDetallesOrdenCompraModificar/<?php echo $ordenesEncontradas->id_comprobante;?>/">
				<img src = "<?php echo base_url();?>images/Notes.png" title = "Editar Items"></a>
			&nbsp;
			&nbsp;&nbsp;
			<a href = "#" onClick="anularOrdenCompra('<?php echo $ordenesEncontradas->id_comprobante;?>')">
				<img src = "<?php echo base_url();?>images/wrong.gif" title = "Anular" width ="10%"></a>
		<?php
				}
			
			elseif($ordenesEncontradas->estado_compra == 0)
				{
		?>
		 <a href = "<?php echo base_url();?>micontrolador/VistaCrearDetallesNuevaOrdenCompra/<?php echo $ordenesEncontradas->id_comprobante;?>/">
			<img src = "<?php echo base_url();?>images/Llenacanasta.png" title = "Agregar Items"></a>
		&nbsp;
			&nbsp;&nbsp;
			<a href = "#" onClick="anularOrdenCompra('<?php echo $ordenesEncontradas->id_comprobante;?>')">
				<img src = "<?php echo base_url();?>images/wrong.gif" title = "Anular" width ="10%"></a>
		<?php
		
				}
			//elseif()
			elseif($ordenesEncontradas->total_comprobante > 0)
				{
					echo "CONTABILIZADA";
		?>
		
		<?php
					
				}
		?>
			&nbsp;
			&nbsp;&nbsp;
		 <a href = "#" onClick="imprimirOrdenCompra('<?php echo $ordenesEncontradas->id_comprobante;?>')">
			<img src = "<?php echo base_url();?>images/Print32.png" title = "Iprimir">
		</a> 
	</td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr> 
    <script type="text/javascript">
<!--


//imprimir orden de compra
function imprimirOrdenCompra(idComprobante) {
    alert("Se imprimirá la órden de compra con ID. " + idComprobante + ", colóque la hoja en la bandeja.")
		urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirOrdenDeCompra/"+ idComprobante + "/";
		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
    window.location.reload();//re cargo el origen que abrio esta popup
   
	
}

//anular orden de compra
function anularOrdenCompra(idComprobante) 
	{
		var respuesta = confirm("Está seguro de anular la orden de compra con ID. " + idComprobante + "?")
		if(respuesta)//si la respuesta es afirmativa
			{
				window.location = "<?php echo base_url();?>micontrolador/AnularOrdenCompraSinCotabilizar/"+ idComprobante + "/";
			}
	}

//-->
</script>
<?php endforeach;
}
?>
</tbody> 
</table></div>
<?php

$segmento = $this->uri->segment(3,0);
$idComprobante	= $this->uri->segment(4,0);
$idPartida		= $this->uri->segment(5,0);

if($segmento == 1029)
{
@session_start();
unset($_SESSION["carro"]);

?>
 <script>alert('La operación a sido guardada, se ha generado la orden de compra con el ID:  <?php echo $idComprobante;?> . Coloque la hoja en la bandeja de impresión.')
 window.location = "<?php echo base_url();?>micontrolador/VistaImprimirOrdenDeCompra/<?php echo $idComprobante?>/2/";
 </script>
<?php
  
}
elseif($segmento == 1030)
{
?>
 <script>alert('La operación a sido guardada, se ha generado la partida con el ID:  <?php echo $idPartida;?>.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCompras/";
 </script>
<?php
  
}
elseif($segmento == 1300)
{
?>
 <script>alert('Se ha anulado la orden con el ID:  <?php echo $idComprobante;?>.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCompras/";
 </script>
<?php
  
}
elseif($segmento == 11102587)
{
@session_start();
unset($_SESSION["carro2"]);//elimino la sesion del carro2

?>
 <script>alert('Se han guardado los datos modificados, de la orden de compra con el ID:  <?php echo $idComprobante;?> . Coloque la hoja en la bandeja de impresión.')
 window.location = "<?php echo base_url();?>micontrolador/VistaImprimirOrdenDeCompra/<?php echo $idComprobante?>/2/";
 </script>
<?php 
}
elseif($segmento == 1400)
{
?>
<script>alert('Se han Modificados los datos, de la orden de compra con el ID:  <?php echo $idComprobante;?> . \n Verifique los detalles de la compra, pueda ser que con los cambios realizados afecten de forma erronea \n el IVA, IVA retenido o las condiciones de pago.')
 </script>
 <?php 
}
 ?>
</div>