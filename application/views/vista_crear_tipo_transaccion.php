
<?php 


?>
<script>
    function myOnComplete()
    {
        $('#cuentabancos').submit();
    }
    $(document).ready(function() {
        $("#cuentabancos").RSV({
            onCompleteHandler: myOnComplete,      
            rules: [
                "required,tipotransaccion,Escriba el nombre de la transacción.",
                //"required,codigo, Debe ingesar el código del proveedor.",
				        "required,tipopartida,IElija el tipo de partida.",
					      "required,transaccionsaldos,Elija la aplicación contable"
				                       
            ]
        });
    });
  
   

</script>

<script type="text/javascript">
$(function() {
	$("#fecha").datepicker();
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
<h1> Nuevo Tipo Transaccion</h1>

<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "Los datos que intenta registrar ya existe verifique por favor.";   
}
elseif($segmento == 400)
{
?>

 <script>alert('La operación a sido gurdada exitosamente. ')
 window.location = "<?php echo base_url();?>micontrolador/VistaCrearTipoTransaccion/";
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
<fieldset class = fieldset1>
<legend class = legend1>Nuevo Tipo Transacci&oacute;n</legend>

  <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarTipoTransaccion/" name = "cuentabancos">
		      
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
      <tr>
        <td width=15>
  
        
               <li>
            <label class="desc">Tipo trnasacci&oacute;n:<span class="req">*</span></label>
                    <div>
                        <input name="tipotransaccion" type="text"  id="tipotransaccion" size = 60 maxlength="255"/>
                    </div>
            </li>
            

        </td>
  
      </tr>
	
      <tr>
         <td>
               <li> 
                     <label class="desc">Tipo de Partida:<span class="req">*</span></label>
                    <div>
                      <select name = tipopartida id = "tipopartida">
                        <?php
                        foreach($listarTiposPartidas as $tiposEncontrados):
                        
                      ?>
                        <option value = <?php echo $tiposEncontrados->id;?>><?php echo $tiposEncontrados->codigo." - ".$tiposEncontrados->descripcion?> </option>
                      <?php endforeach;?>
                      </select>
                    </div>
                </li>
          </td> 
         <td>
        
  			         <li>
                      <label class="desc">Aplicaci&oacute;n Contable:<span class="req">*</span></label>
                      <div>
                         <select name = transaccionsaldos>
                            <option value = 1>DEBE</option>
                            <option value =0> HABER</option>
                        </select>
                      </div>
                  </li>
          </td> 
          
			</tr>
			
             
		   </ul>
         
				</table>
        <br>
        <br>
                
            
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 