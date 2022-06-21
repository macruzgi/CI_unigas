<?php
header('Content-Type: text/html; charset=UTF-8'); 
//header('Content-Type: text/html; charset=ISO-8859-1'); 

?>
<head>
<script type="text/javascript">
<!--
function chequeOtrasfeencia() {
	var answer = confirm("¿El proceso sera por transferencia?")
	if (answer){ 
    
		window.location = "<?php echo base_url();?>micontrolador/VistaChequePorCuentaPorPagarTransferencia/";
	}
	else{
		 
		window.location = "<?php echo base_url();?>micontrolador/VistaChequePorCuentaPorPagar/";
	
	}
}
/*anular transferencia o cheque*/
function anularTransOcheque(idRegistro, aleatorio) {
  //var motivoAnulacion;//variable para pedir el motivo de la anulacion
  /*var tipo;
  if(numeroCheOtrans != 0)
    {
      tipo  = "el Cheque";
    }
  else
    {
      tipo = "la Transferencia";
    }	
	*/
	var answer = confirm("Esta apunto de anular este registro, esto es irreversible, ¿esta seguro?")
	if (answer){//si se da la confirmacion, es decir doy clic en Acepta del diaglo emergente
    //motivoAnulacion = prompt('¿Por qué motivo anulara ' + tipo + ' ?', '');
    //if(motivoAnulacion != "" && motivoAnulacion != null)//si el motivo de la anulacion es distinto a nada, es decir tiene algo
     // { 
        alert("Se procede a anular el registro con ID " + idRegistro);
    		window.location = "<?php echo base_url();?>micontrolador/VistaAnularChequeTrasferencia/" + idRegistro + "/" + aleatorio  + "/";// + motivoAnulacion + "/";
	   // }
    //else
     // {
        //anularTransOcheque(idRegistro, numeroCheOtrans);
     // }
  }
	
}
//-->
</script> 
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
BANCO::Cheque::
<a href ="<?php echo base_url();?>micontrolador/VistaNuevoCheque/">Nuevo Cheque </a> | 
<!--a href ="<?php echo base_url();?>micontrolador/VistaChequePorCuentaPorPagar/">Abono a CxP </a> |-->
<a href = "#" onClick="chequeOtrasfeencia()">Abono a CxP </a> |
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
elseif($segmento == 111000)
{
   $claseEstilo = "error_box";
   $mensaje = "No es posible anular un registro que no est&eacute; contabilizado.";
}
elseif($segmento == 301)
	{
		$claseEstilo = "error_box";
		$mensaje = "El n&uacute;mero de cheque que intento ingresar ya ha sido asignado. Verifique porfavor...";

?>
<script>
setTimeout("window.close();",4000);
</script>
<?php
	}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<div align = center>

<form name = buscarCuenta method = "POST" action = "<?php echo base_url();?>micontrolador/VistaCheque/">
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
if(isset($_POST["idcuentabanco"])) /*inicio*/
//tdoo esto para el reporte
{  
?>
  
<?php
}
/*fin*/
?>
<div class="datagrid"><div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>No. Cheque</th>
    <th>Fecha</th>
    <th>Monto $</th>
    <th>A</th>
    <th>Banco</th>
    <th>No. Cuenta</th>
    <th colspan = 3>Acci&oacute;n</th>

  </tr>
</thead>

<tbody>
<tr>   
<?php
if(isset($_POST["idcuentabanco"]))
{
$aleatorero = time();
if($listarCheques)
foreach($listarCheques as $chequesEncontrados):
?>
  <td><?php echo $chequesEncontrados->id_cheque;?></td>
   <td><?php 
	if($chequesEncontrados->motivo_anulacion == -1324)///el cheque no tiene numero asigando
		{
			echo "<font color = red><i>No asignado</i></font>";
		}
	elseif($chequesEncontrados->numero_cheque > -1)
		{
			echo $chequesEncontrados->numero_cheque;
		}
	?></td>
   <td><?php echo $chequesEncontrados->fecha_emision;?></td>
   <td align = right><?php echo $chequesEncontrados->monto_cheque;?></td>
   <td><?php echo $chequesEncontrados->a_nombre_de;?></td>
   <td><?php echo $chequesEncontrados->nombre_banco_cuenta;?></td>
   <td><?php echo $chequesEncontrados->numero_cuenta_bancaria;?></td>
    <!--td><?php //echo $chequesEncontrados->id_partida;?></td-->

  
   
   
   <td>
  <?php 
      if($chequesEncontrados->impreso == 0 && $chequesEncontrados->monto_cheque > 0)
        {
  ?>
       <a href = "#" onClick="reImprimir('<?php echo $chequesEncontrados->id_cheque;?>','<?php echo $chequesEncontrados->numero_cheque;?>', '<?php echo $chequesEncontrados->tipo_impresion_cheque;?>')">
        RE-IMPRIMIR</a>
	<?php
		}
      elseif($chequesEncontrados->impreso == 1)
        {
   ?>
    <a href = "#" onClick="confirmation('<?php echo $chequesEncontrados->id_cheque;?>', '<?php echo $chequesEncontrados->tipo_impresion_cheque;?>', '<?php echo $chequesEncontrados->id_cuenta_bancaria;?>')">
      <img src = "<?php echo base_url();?>images/Print32.png" title = "Imprimir Cheque">
    </a>
    <?php
        }
	if($chequesEncontrados->impreso == 8)//
        {
      ?>
         <a href = "#" onClick="imprimirTranferencia('<?php echo $chequesEncontrados->id_cheque;?>')">
      <img src = "<?php echo base_url();?>images/Print32.png" title = "Imprimir Transferencia">
		</a>
      
      <?php
        }
	if($chequesEncontrados->id_partida == -1029)//-1029 que no esta contabilizado
      {
    ?>
		
      <a href = "<?php echo base_url();?>micontrolador/VistaCrearPartidaDetalles/<?php echo time()."/".$chequesEncontrados->id_cheque."/";?>">
      <img src = "<?php echo base_url();?>images/configuracion.png" title = "Contabilizar Cheque">
    </a>
    <?php
      }

    ?>
  

  
    </td>
    <td>
    <?php
      if($chequesEncontrados->anulado_cheque == 1)
        {
          echo "Anulado/a";
        }
      elseif($chequesEncontrados->numero_cheque > -1 && $chequesEncontrados->motivo_anulacion < 1)
        {
    ?>
      
    &nbsp;&nbsp;
    <a href = "#" onClick="anularTransOcheque('<?php echo $chequesEncontrados->id_cheque;?>','<?php echo $aleatorero;?>')">
      <img src = "<?php echo base_url();?>images/icondel.png" title = "Anular">
    </a>
      <?php
        }
      ?>
    </td>
    <td>
      <?php
       if($chequesEncontrados->anulado_cheque == 0 && $chequesEncontrados->id_partida == -1029)//no esta anulado y no esta impreso
        {
      ?>     
             <a href = "<?php echo base_url();?>micontrolador/VistaModificarChequeNormal/<?php  echo time()."/".$chequesEncontrados->id_cheque;?>">Editar</a>
      <?php
        }
      ?>
    </td>

  </tr>
  <script type="text/javascript">
<!--

function confirmation(idCheque,tipoImpresion, idCuentaBancaria) {
  var mensaje = confirm("¿Desea imprimir el cheque?, una vez lo imprima solo prodra Re-imprimir.")
	if(mensaje)//si confirma que quiere imprimir
    {
      var answer = confirm("¿El cheque sera NO NEGOCIABLE?")
    	if (answer){ 
			var numeroCheque = prompt("Escriba el numero de Cheque a imprimir, si no escribe nada se imprimira el predeterminado por la Cuenta Bancaria:");
    		urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/2/" + tipoImpresion + "/" + idCuentaBancaria + "/" + numeroCheque + "/";
    		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
        window.location.reload();
        //window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/2/" + tipoImpresion;
    	}
    	else{
    		 var numeroCheque = prompt("Escriba el numero de Cheque a imprimir, si no escribe nada se imprimira el predeterminado por la Cuenta Bancaria:");
    		urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/1/" + tipoImpresion + "/" + idCuentaBancaria + "/" + numeroCheque + "/";
    		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
        window.location.reload();
        //window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/1/" + tipoImpresion;
    	
    	}
    }
}
function reImprimir(idCheque,numeroCheque,tipoImpresion) {


      var answer = confirm("¿El cheque sera NO NEGOCIABLE?")
    	if (answer){ 
        alert("Se imprimira el cheque No. " + numeroCheque + ", coloquelo en la bandeja")
    		urlDestino = "<?php echo base_url();?>micontrolador/VistaRemprimirImprimirChequeProcesado/"+ idCheque + "/2/" + tipoImpresion +"/" + numeroCheque + "/";
    		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
        window.location.reload();
        //window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/2/" + tipoImpresion;
    	}
    	else{
    		 alert("Se imprimira el cheque No. " + numeroCheque +", coloquelo en la bandeja")
    		urlDestino = "<?php echo base_url();?>micontrolador/VistaRemprimirImprimirChequeProcesado/"+ idCheque + "/1/" + tipoImpresion +"/" + numeroCheque + "/";
    		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
        window.location.reload();
        //window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/1/" + tipoImpresion;
    	
    	}
  
}

//imprimir transferencia
function imprimirTranferencia(idTransferencia) {
    alert("Se imprimirá la transferencia con ID. " + idTransferencia + ", colóque la hoja en la bandeja")
		urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirTransferencia/"+ idTransferencia + "/";
		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
    window.location.reload();
    //window.location = "<?php echo base_url();?>micontrolador/VistaImprimirTransferencia/"+ idTransferencia + "/";
	
}

//funcion para contabilizar cheque o transferencia
//-->
</script>
<?php endforeach;?>
</tbody>

<?php
}
?>
</table></div>
<?php

$segmento = $this->uri->segment(4,0);
$idPartida = $this->uri->segment(3,0);
if($segmento == 1029)
{
@session_start();
unset($_SESSION["cuentasAlaPartida"]);

?>
 <script>alert('La operación a sido guardada, se ha generado la partida No. <?php echo $idPartida; ?>, el cheque está listo para ser impreso. ')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
   
}
elseif($segmento == 1300)  
{
?>
<script>alert('La operación a sido completada, se ha anulado el registro.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
}
elseif($segmento == -1525)  
{
?>
<script>alert('La operación a sido completada, se ha actualizado el cheque.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
}
?>




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