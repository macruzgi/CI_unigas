<?php 
@session_start();
			if(isset($_SESSION["cuentasAlaPartidaTransaccion"]) || is_array($_SESSION["cuentasAlaPartidaTransaccion"])) {
			   $cuentasAlaPartida= $_SESSION["cuentasAlaPartidaTransaccion"];
							}

?>


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
  <br>
  <br>
<br>
 
<a href="<?php echo base_url();?>micontrolador/VistaCrearPartidaDetallesTransaccion/<?php echo $this->uri->segment(3,0)."/".$this->uri->segment(4,0)."/";?>">Volver</a>

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaBuscarCuentasContables/">
<li>
                    <label class="desc">Digite el nombre de la cuenta o el c&oacute;digo de la cuenta <span class="req"></span></label>
                    <div>
                        <input name="filtro" type="text" class="field text medium" id="textbox1" value="" maxlength="255" size = 60/>
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
<div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>C&oacute;digo</th>
    <th>Cuenta Contable</th>
    <th>Acci&oacute;n</th>
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>   
<?php
if(isset($_POST["filtro"]))
{
foreach($listarCuentasContables as $cuentasContablesEncontradas):
?>
  <td><?php echo $cuentasContablesEncontradas->id;?></td>
   <td><?php echo $cuentasContablesEncontradas->codigo;?></td>
   <td><?php echo $cuentasContablesEncontradas->nombre;?></td>
   <td>
    <a href = "<?php echo base_url();?>micontrolador/AgregarCuentasAlaPartidaTransacciones/<?php  echo $cuentasContablesEncontradas->codigo;?>/<?php echo $idPartida  = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>">
      Seleccionar
    </a>
      
    </td>

  </tr>
<?php endforeach;?>
</tbody>
<?php 
}
?>
</table></div>

</div>