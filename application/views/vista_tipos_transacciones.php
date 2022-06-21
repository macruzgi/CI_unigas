<head>
 

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
BANCO::TRANSACCIONES::Tipos transacci&oacute;n:
<a href ="<?php echo base_url();?>micontrolador/VistaCrearTipoTransaccion/">Crear tipo </a> | 

</span>
<hr>

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaTiposTransacciones/">
<li>
                    <label class="desc">Tipo de partida</label>
                    <div>
                        <select name=filtro class="field text small" >
                          <option>Elija...</option>
                         <?php 
                          foreach ($listarTiposPartidas as $tiposPartidas):
                         ?> 
                            <option value ="<?php echo $tiposPartidas->id;?>"><?php echo $tiposPartidas->codigo."-". $tiposPartidas->descripcion;?></option>
                          <?php
                            endforeach;
                          ?>
                      </select>

                   <input type = submit name = buscar class = btnbuscar value = "">
                    </div>
                </li>
<br>

</form>
<div class="datagrid"><div class="datagrid"><table class="tablecss" width="80%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>Tipo transacci&oacute;n</th>
    <th>Descripci&oacute;n</th>
    
    <th>Acci&oacute;n</th>
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>   
<?php
if(isset($_POST["filtro"]))
{

foreach($listarTiposTransacciones as $tiposEncontrados):
?>
  <td><?php echo $tiposEncontrados->id_tipo;?></td>
   <td><?php echo $tiposEncontrados->nombre;?></td>
   <td><?php echo $tiposEncontrados->descripcion;?>
   </td>

   
   
   <td>
   <a href ="<?php echo base_url();?>micontrolador/VistaActualizarTipoTransaccion/<?php echo time()."/".$tiposEncontrados->id_tipo;?>">
  	EDITAR
  </a>
    </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
  <script type="text/javascript">
<!--
function confirmation(idCheque,numeroCheque,tipoImpresion) {
	var answer = confirm("¿El cheque será NO NEGOCIABLE?")
	if (answer){ 
    alert("Se imprimirá el cheque No. " + numeroCheque + " " +tipoImpresion + ", colóquelo en la bandeja")
		window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/2/" + tipoImpresion;
	}
	else{
		 alert("Se imprimirá el cheque No. " + numeroCheque +", colóquelo en la bandeja")
		window.location = "<?php echo base_url();?>micontrolador/VistaImprimirChequeProcesado/"+ idCheque + "/1/" + tipoImpresion;
	
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
unset($_SESSION["cuentasAlaPartida"]);

?>
 <script>alert('La operación a sido gurdada, se ha generado la partida No. <?php echo $idPartida; ?>, el cheque está listo para ser impreso. ')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
   
}
?>
</div>              