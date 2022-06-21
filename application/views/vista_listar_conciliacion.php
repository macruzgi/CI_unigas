<?php
 /*array para buscar y poner en los textbox mes el nombre del mes
segun el numero de la fecha acutal*/
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");


?>

<script type="text/javascript">
<!--
function cerrarConciliacion(iConciliacion, nombreBanco, cuentaBancaria, mes, annio, idCuentaBancaria) {   
	var answer = confirm("Está apunto de cerrar la conciliación. \n Este proceso es irreversible, ¿desea continuar? Click en Cancelar para abortar.")
	if (answer){ 
      alert("Se cerrará la conciliación No. " + iConciliacion + " para la cuenta bancaria " + nombreBanco +  " - " + cuentaBancaria + " para " + mes + " de " + annio)   
		window.location = "<?php echo base_url();?>micontrolador/CerrarConciliacion/" + iConciliacion + "/" + mes + "/" + annio + "/" + idCuentaBancaria + "/";
	}
	/*else{
		 
		window.location = "<?php echo base_url();?>micontrolador/VistaChequePorCuentaPorPagar/";
	
	} */
}

//imprimir conciliacion
function imprimirConciliacion(idConciliacion) {
    alert("Se imprimirá la Conciliación con ID. " + idConciliacion + ", colóque la hoja en la bandeja.")
		urlDestino = "<?php echo base_url();?>micontrolador/VistaImprimirReporteConciliacion/"+ idConciliacion + "/2/";
		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
    window.location.reload();	
}
//-->
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
<hr>
<span class = navegacion>
BACO::Conciliaci&oacute;n:
<a href ="<?php echo base_url();?>micontrolador/VistaPrepararDatosConciliacion/">Preparar Conciliaci&oacute;n </a> | 
<!--a href ="<?php echo base_url();?>micontrolador/VistaCheque/">Cheques </a>|
<a href ="<?php echo base_url();?>micontrolador/VistaTransacciones/">Transacciones </a> |
<a href ="<?php echo base_url();?>micontrolador/VistaPrepararDatosConciliacion/">Conciliaci&oacute;n </a-->
</span>
<hr>

 <?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}

?>

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaListarConciliacinesFormulario/">
<li>
 <label class="desc">Elija las opciones para buscar: <span class="req"></span></label>
   <div>
      <select name = cuenta id="cuenta">
        <option>Elija...</option>
                      <?php
                        foreach($listarCuentasBancairas as $cuentasEncontradas):
                        
                      ?>
                        <option value = <?php echo $cuentasEncontradas->id_cuenta_bancaria;?>><?php echo $cuentasEncontradas->nombre_banco_cuenta." - ".$cuentasEncontradas->numero_cuenta_bancaria?> </option>
                      
                      <?php endforeach;?>
                      </select>
                    <select name =annio>
                     <option>Elija...</option>
                    <?php 
                      foreach($listarAnniosConciliacion as $anniosEncontradosConciliacion):
                    ?>
                      <option value ="<?php echo $anniosEncontradosConciliacion->annio;?>"> <?php echo $anniosEncontradosConciliacion->annio;?>   </option>
                    <?php
                      endforeach;
                    ?>
                  </select>
                   <input type = submit name = buscar value = "" class = btnbuscar>
                    </div>
                </li>
<br>

</form>
<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->
<div class="datagrid"><div class="datagrid"><table class="tablecss" width="80%" border="1">
<thead class="odd"><tr><th>Id</th>
<th>Cuenta bancaria</th>
<th>Mes</th><th>Año</th>
<th align = center>Acciones</th>


</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php
if(isset($_POST["cuenta"]) && isset($_POST["annio"]))
{

foreach($listarConciliaciones as $conciliacionesEncontradas):
?>
  <td><?php echo $conciliacionesEncontradas->correlativo;?></td>
  <td><?php echo $conciliacionesEncontradas->nombre_banco_cuenta;?></td>
   <td><?php 
            $numeroMes = $conciliacionesEncontradas->mes;  //busco el numero del mes


            $mesAmostrar = $mes[$numeroMes-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
 
   
   echo $mesAmostrar;?></td>
   <td><?php echo $conciliacionesEncontradas->annio;?></td>
   <td align = center>
    <a href = "#" onClick="imprimirConciliacion('<?php echo $conciliacionesEncontradas->correlativo;?>')">Imprimir </a> |
    <?php
      if($conciliacionesEncontradas->conciliacion_cerrada == 0)
        {
    ?>
      Conciliaci&oacute;n Cerrada |
    <?php
        }
      else
        {
    ?>
    <a href ="#" onClick="cerrarConciliacion('<?php echo $conciliacionesEncontradas->correlativo;?>', '<?php echo $conciliacionesEncontradas->nombre_banco_cuenta;?>', '<?php echo $conciliacionesEncontradas->numero_cuenta_bancaria;?>', '<?php echo $conciliacionesEncontradas->mes;?>', '<?php echo $conciliacionesEncontradas->annio;?>', '<?php echo $conciliacionesEncontradas->id_cuenta_bancaria;?>')">Cerrar Conciliaci&oacute;n </a> |
    <?php
        }
    ?>
   </td>

  </tr> 
<?php endforeach;
}
?>
</tbody> 
</table></div>
 <?php

if($this->uri->segment(3,0) == 900)
{

?>
 <script>alert('La conciliación ha sido aceptada y cerrada')
 window.location = "<?php echo base_url();?>micontrolador/VistaListarConciliacinesFormulario/";
 </script>
<?php
}
?>
</div>