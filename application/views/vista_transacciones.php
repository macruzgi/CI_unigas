<head>
<script type="text/javascript">
$(function() {
	$("#fechabanco").datepicker();
  $("#fechabancohasta").datepicker();

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
 <hr> 
<span class = navegacion>
BANCO::TRANSACCIONES::
<a href ="<?php echo base_url();?>micontrolador/VistaTiposTransacciones/">Tipos Transacci&oacute;n </a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaTransaccionBancaria/"> Nueva Transacci&oacute;n Bancaria </a> |
</span>
<hr>
 <?php
$segmento = $this->uri->segment(4,0);
$claseEstilo = "";
$mensaje = "";
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaTransacciones/">
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
<div class="datagrid"><div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>Feha</th>
    <th>Fecha contable</th>
    <th>Valor $</th>
    
    <th>Referencia</th>
    <th>Concepto</th>
    <th>Banco</th>
    <th>Debe</th>
    <th>Haber</th>
    <th colspan = 3>Acci&oacute;n</th>
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>   
<?php
if(isset($_POST["idcuentabanco"]))
{
$aleatorero = time();
if($listarTransacciones) //no se para que lo he puesto esta demas inservible
foreach($listarTransacciones as $transaccionesEncontrados):
if($transaccionesEncontrados->modificado_por != -1029)
{
?>
  <td><?php echo $transaccionesEncontrados->id_transaccion;?></td>
   <td><?php echo $transaccionesEncontrados->fecha;?></td>
   <td><?php echo $transaccionesEncontrados->fecha_contable;?></td>
   <td><?php echo $transaccionesEncontrados->valor;?></td>
   <td><?php echo $transaccionesEncontrados->referencia;?></td>
   <td><?php echo $transaccionesEncontrados->concepto;?></td>
   
   <td><?php echo $transaccionesEncontrados->nombre_banco_cuenta;?></td>
   <td><?php echo $transaccionesEncontrados->debe;?></td>
   <td><?php echo $transaccionesEncontrados->haber;?></td>

  
   

    <td>
	<?php
		if($transaccionesEncontrados->id_partida != -1029 && $transaccionesEncontrados->valor > 0)//ESTA CONTABILIZADA
			{
	?>
    <a href = "#" onClick="imprimirTransaccion('<?php echo $transaccionesEncontrados->id_transaccion;?>', '<?php echo time();?>')">
      <img src = "<?php echo base_url();?>images/Print32.png" title = "Imprimir Transacci&oacute;n">
    </a>
	<?php
			}
		elseif($transaccionesEncontrados->valor > 0 and $transaccionesEncontrados->contabilizar == 1)
			{
	?>
	<a href = "<?php echo base_url();?>micontrolador/VistaCrearPartidaDetallesTransaccion/<?php  echo $transaccionesEncontrados->id_partida."/".$transaccionesEncontrados->id_transaccion;?>">
      <img src = "<?php echo base_url();?>images/configuracion.png" title = "Contabilizar">
    </a>
    <?php
			}
		elseif($transaccionesEncontrados->contabilizar == 0)
			{
				echo "NO SE CONTABILIZ&Oacute;";
			}
			
	?>
    </td>
    <td align = center>
      <?php
      if($transaccionesEncontrados->valor > 0)
        {
    ?>
    &nbsp;&nbsp;
    <a href = "#" onClick="anularTransaccion('<?php echo $transaccionesEncontrados->id_transaccion;?>', '<?php echo $aleatorero;?>')">
      <img src = "<?php echo base_url();?>images/icondel.png" title = "Anular">
    </a>
      <?php
        }
      else
        {
          echo "Anulada";
        }
      ?>
    </td>

<?php
}
?>
  </tr>
  <script type="text/javascript">
<!--
//imprimir transaccion
function imprimirTransaccion(idTransaccion, distractor) {
    alert("Se imprimirá la transacción con ID. " + idTransaccion + ", colóque la hoja en la bandeja.")
		//window.location = "<?php echo base_url();?>micontrolador/VistaImprimirTranssaccion/"+ idTransaccion + "/";
	  urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirTranssaccion/"+ idTransaccion + "/" + distractor + "/";
		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
    window.location.reload();
   }
   
/*anular transaccion*/
function anularTransaccion(idRegistro, aleatorio) {

	var answer = confirm("Está apunto de ANULAR esta transacción, esto es irreversible, ¿está seguro?")
	if (answer){//si se da la confirmacion, es decir doy clic en Acepta del diaglo emergente
    
        alert("Se procede a ANULAR la transacción con ID " + idRegistro);
    		window.location = "<?php echo base_url();?>micontrolador/AnularTransaccion/" + idRegistro + "/" + aleatorio  + "/";// + motivoAnulacion + "/";
	   
  }
	
}
//-->
</script>
<?php endforeach;?>
</tbody>

<?php
}
?>
</table></div>
<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(4,0);
$idPartida = $this->uri->segment(3,0);
if($segmento == 1029)
{
@session_start();
unset($_SESSION["cuentasAlaPartidaTransaccion"]); //eliminos los datos de la sesion cuentasAlaPartidaTransaccion

?>
 <script>alert('La operación a sido gurdada exitosamente, se ha generado la partida No. <?php echo $idPartida; ?> .')
 window.location = "<?php echo base_url();?>micontrolador/VistaTransacciones/";
 </script>
<?php
   
}
elseif($segmento == 400)
{
?>
 <script>alert('La transacción a sido gurdada exitosamente.')
 window.location = "<?php echo base_url();?>micontrolador/VistaTransacciones/";
 </script>
<?php 
}
elseif($segmento == 1300)
{
?>
 <script>alert('La transacción a sido anulada exitosamente.')
 window.location = "<?php echo base_url();?>micontrolador/VistaTransacciones/";
 </script>
<?php 
}
?>
</div>              