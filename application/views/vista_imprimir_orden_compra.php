<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Compra</title>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:10px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}

table.gridtable2 {
	font-family: verdana,arial,sans-serif;
	font-size:8px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}

-->
</style>
<?php
$seImprimeDesdeLosDetallesOVistaCompras = $this->uri->segment(4,0);
if($seImprimeDesdeLosDetallesOVistaCompras == 2)//se ha mandao a imprimir desde los detalles de la compra para que me redirija a la vista compras ya que aqui no debo abrir una popup
{
?>
<!--funcion que redireciona despues que imprime-->
<script>
setTimeout("print();",1500);
setTimeout("window.location = '<?php echo base_url();?>micontrolador/VistaCompras/'",3000);
</script>
<?php 
}
else//se imprimio desde la vista Compras
{
?>
<!--funcion que redireciona despues que imprime-->
<script>
setTimeout("print();",1500);
setTimeout("window.close();",3000);
</script>
<?php 
}
?>
</head>
<body>
<?php
//echo $totalPaginas =  ceil(count($listarDatosParaImprimirOrdenCompra) / 10);
//print_r($listarDatosParaImprimirOrdenCompra);
//$key_array = array_keys($listarDatosParaImprimirOrdenCompra);
//echo $key_array[1];
if(count($listarDatosParaImprimirOrdenCompra) > 0)
{ 
//for($i=1;$i<=$totalPaginas;$i++)
//{
?>
<div align = "center">
<table border ="0" class ="gridtable" width="95%">
<tr>
	<td>
		<img src = "<?php echo base_url();?>images/uni.jpg" align = "middle" width="50%">
	</td>
	<!--td valign="top" width = "35%">


		<table  border = "1">
		<tr>
			<td>
				<img src = "<?php echo base_url();?>images/uni.jpg" align = "middle" width="50%">
			</td>
			
		</tr>

		</table>
	</td-->
	<td valign="bottom">
		<table style="width:80%;margin:auto;"  align="right" border ="0">
			<tr>
				<td align ="right">
					<b>&Oacute;RDEN DE COMPRA</b>
				</td>
			</tr>
			
		</table>
	</td>
</tr>
<tr>
	<td width ="55%">
		<table style="width:80%;margin:auto;"  align="left" border ="0">
		  <tr>
			<th scope="col" align ="left">UNIGAS DE EL SALVADOR, S.A DE C.V.</th>
			
		  </tr>
		  <tr>
			<td><div align="left">km 24 Carretera entre Nejapa y Quezaltepeque.</div></td>
			
		  </tr>
		  <td>
		  <div align="left">Quezaltepeque, La Libertad.</div>
		  </td>
		  <tr>
			<td>
				&nbsp;
			</td>
		  </tr>
		  <tr>
			
			<td>
			<div align="left"><b>NIT: 0614-190599-103-0</b></div>
		  </td>
		  </tr>
		   <tr>
			
			<td>
			<div align="left"><b>Registro Fiscal: 112811-6</b></div>
		  </td>
		  </tr>
		   <tr>
			
			<td>
				<div align="left"><b>Giro: Venta de Combustible y Lubricantes</b></div>
			</td>
		  </tr>
		  <tr>
			
			<td>
				<div align="left">Tel&eacute;fono: (503)2314-2020</div>
			</td>
		  </tr>
		  <tr>
			
			<td>
				<div align="left">Fax: (503)2314-2091</div>
			</td>
		  </tr>
		</table>
	 </td>
	
	<td valign="top" colspan ="2">

 		<table style="width:80%;margin:auto; border:1px solid black;"  align="right">
			<tr>
				<td>
					<b>Elemento 12 I3SRS:</b>
				</td>
			</tr>
			<tr>
				<td>
					Se deber&aacute; remitir las MSDS, fichas 
					t&eacute;cnicas y/o manuales para la recepci&oacute;n de bienes y/o sustancias en Bodega.
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<table style="width:80%;margin:auto; border:1px solid black;"  align="right">
			<tr>
				<td>
					Referencia para la entrega y para la factura
				</td>
			</tr>
			<tr>
				<td align ="left">
					 <b>&Oacute;rden de Compra</b>
				</td>
				<td align ="left">
					<strong>Fecha:</strong>
				</td>
			</tr>
			<tr>
				<td align ="left">
					<?php echo $listarDatosParaImprimirOrdenCompra[0]->id_comprobante;?>
				</td>
				<td align ="left">
					<?php echo $listarDatosParaImprimirOrdenCompra[0]->fecha;?>
				</td>
			</tr>
		</table>
	</td>
  </tr>
 
  <tr>
	<td>
		<table style="width:80%;margin:auto; border:1px solid black;"  align="left">
			<tr>
				<td>
					<b>Enviar Factura a:</b>
				</td>
			</tr>
			<tr>
				<td>
					<b>Unigas de El Salvador, S.A. de C.V.</b>
					<br>
					km 24 Carretera entre Nejapa y Quezaltepeque, La Libertad.
					<br>
					<b>E-Mial:</b> recepcion@unigasca.com
				</td>
			</tr>
		</table>
	</td>

	<td colspan ="2">
		<table style="width:80%;margin:auto; border:1px solid black;"  align="right">
			<tr>
				<td>
					<b>Asignaci&oacute;n Contable:</b>
				</td>
				<td>
					<b> Grupo de Art&iacute;culos:
				</td>
			</tr>
			<tr>
				<td>
					Cuenta de Mayor: <?php echo $listarDatosParaImprimirOrdenCompra[0]->codigo_cuenta_contable." - ".$listarDatosParaImprimirOrdenCompra[0]->nombre_cuenta_contable;?>
					
				</td>
				<td>
					Centro de Costo: <?php echo $listarDatosParaImprimirOrdenCompra[0]->codigo_centro_costo." - ".$listarDatosParaImprimirOrdenCompra[0]->nombre_centro_costo;?>
				</td>
				
			</tr>
		</table>
	</td>
  </tr>
  <tr>
	<td>
		<br>
		<table style="width:80%;margin:auto; border:1px solid black;"  align="left">
			<tr>
				<td>
					<b>Solicitada por:</b>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $listarDatosParaImprimirOrdenCompra[0]->solicitada_por;?>
					
				</td>
				
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
	
		<table style="width:80%;margin:auto; border:1px solid black;"  align="left">
			<tr>
				<td>
					<b>Direcci&oacute;n de entrega:</b>
				</td>
			</tr>
			<tr>
				<td>
					<b>Unigas de El Salvador, S.A. de C.V.</b>
					<br>
					km 24 Carretera entre Nejapa y Quezaltepeque, La Libertad.
					
				</td>
				
			</tr>
		</table>
	</td>
	
	<td  colspan ="2">
		<table style="width:80%;margin:auto; border:1px solid black;"  align="right">
			<tr>
				<td>
					<?php echo $listarDatosParaImprimirOrdenCompra[0]->codigo_proveedor;?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $listarDatosParaImprimirOrdenCompra[0]->nombre;?>
					
				</td>
			
				
			</tr>
			<tr>
				<td>
					<b>NIT:</B><?php echo $listarDatosParaImprimirOrdenCompra[0]->nit;?>
					
				</td>
			
				
			</tr>
			<tr>
				<td>
					<b>NRC:</B><?php echo $listarDatosParaImprimirOrdenCompra[0]->nrc;?>
					
				</td>
			
				
			</tr>
		</table>
	</td>
  </tr>
  <tr height ="50">
	<td colspan = "3">
		Condiciones de pago: <?php 
		if($listarDatosParaImprimirOrdenCompra[0]->dias_credito != 0)
			{
				echo "CR&Eacute;DITO ".$listarDatosParaImprimirOrdenCompra[0]->dias_credito." D&Iacute;AS";
			}
		else
			{
		
		?> 
			CONTADO
		<?php 
			}
		?>
	</td>
  </tr>
 </table>
 <br>
 <!--IMPRIMO LOS DETALLES DE LOS PRODUCTOS DE LA ORDEN DE COMPRA-->
 <table border ="1" class = "gridtable" width ="90%">
	<tr>
		<td>
			<b>ITEM</b>
		</td>
		<td>
			<b>C&oacute;digo</b>
		</td>
		<td>
			<b>Descripci&oacute;n</b>
		</td>
		<td>
			<b>Cantidad</b>
		</td>
		<td>
			<b>UM</b>
		</td>
		<td>
			<b>Precio Unitario USD</b>
		</td>
		<td>
			<b>Valor Neto USD</b>
		</td>
	</tr>
	<tr>
	<?php 
		$correltivo = 0;
		foreach($listarDatosParaImprimirOrdenCompra as $detallesEncontrados):
		$correltivo = $correltivo + 1;
		//for($a = 1; $a <= $correltivo; $a++)
		//{
		 //$
		//if($a == 20)
			//{
	?>
		<td align="center"><?php echo $correltivo;?> </td>
		<td align="center"><?php echo $detallesEncontrados->codigo_producto;?></td>
		<td><?php echo $detallesEncontrados->descripcion;?></td>
		<td align="center"><?php echo $detallesEncontrados->cantidad;?></td>
		<td></td>
		<td align="right"><?php echo $detallesEncontrados->precio_unitario;?></td>
		<td align="right"><?php echo $detallesEncontrados->valor_afecto;?></td>
	</tr>	
	<?php 
		//continue;
		//}
		//}
	endforeach;?>
	<tr>
		<td colspan ="2">
			<b>Observaciones:</b>
		</td>
		<td>
			<?php echo $detallesEncontrados->observaciones;?>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
	</tr>
	<tr>
			<td colspan ="6" align ="right">
				<b>Total sin IVA</B>
			</td>
			<td align="right">
				<?php 
					//echo $detallesEncontrados->total_afecto."<br>";
					
				echo $detallesEncontrados->total_afecto - $detallesEncontrados->total_iva + $detallesEncontrados->total_impuesto2;
				
				?>
			</td>
		</tr>
		<tr>
			<td colspan ="6" align ="right">
				<b>IVA 13%</B>
			</td>
			<td align="right">
				<?php
					echo $detallesEncontrados->total_iva;
				?>
			</td>
		</tr>
		<tr>
			<td colspan ="6" align ="right">
				<b>IVA  Retenido 1%</B>
			</td>
			<td align="right">
				<?php
					echo $detallesEncontrados->total_impuesto2;
				?>
			</td>
		</tr>
		<tr>
			<td colspan ="6" align ="right">
				<b>TOTAL A PAGAR</B>
			</td>
			<td align="right">
				<?php
					echo $detallesEncontrados->total_afecto;
				?>
			</td>
		</tr>
 </table>
</div> 
<?php
//}
}
else
	{
		echo "<b><font color = red>PARA ESTA ORDEN DE COMPRA NO SE HAN AGREGADO O NO SE AGREGARON PRODUCTOS.</font></b>";
	}
?>
</body>
</html>