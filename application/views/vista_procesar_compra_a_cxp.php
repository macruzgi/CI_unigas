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
          
				        "required,idcomprobante,Debe elegir una compra.",
						//"required,seriedocumento,Escriba el número de serie del documento",
						"required,numerodocumento,Escriba el número del documento",
						"required,fecha,Elija una fecha"
						//"required,seriedocumento,Escriba el numero de serie del documento",
					      
                            
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
COMPRAS:: | 
<a href ="<?php echo base_url();?>micontrolador/VistaCompras/">Compras</a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a>
</span>
<hr>
<h1>
Procesar compra a la CXP o Contado</h1>

<?php

$segmento = $this->uri->segment(4,0);
$claseEstilo = "";
$mensaje = "";
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 1212)
{
   $claseEstilo = "error_box";
   $mensaje = "La compra seleccionada no existe.  Verifique por favor.";
}
elseif($segmento == 1213)
{
   $claseEstilo = "error_box";
   $mensaje = "Posiblemente la compra no ha sido autorizada. Verifique por favor.";
}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<fieldset class = fieldset1>
<legend class = legend1>Procesar compra a la CXP o Contado</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/ProCesarCompraYcontabilizar/" name = "cuentabancos">
	
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
		<!--campos hidden-->
				<input name="idcomprobante" type="hidden" size =25  id="idcomprobante" value = "<?php echo $this->uri->segment(3,0);?>" readonly maxlength="255"/><!--id de la compra-->
				<!--fin campos hidden ocultos-->
			<td align = center>		
                <li>
				
                    <label class="desc">Serie del Documento:</label>
                    <div>
					<input name="seriedocumento" type="text"    class="field text medium" id="seriedocumento"  maxlength="255"/>

					</div>
                </li>
			</td>
			<td align = center>		
                <li>
				
                    <label class="desc">N&uacute;mero del Documento:<span class="req">*</span></label>
                    <div>
					<input name="numerodocumento" type="text"  class="field text medium"  id="numerodocumento"  maxlength="255"/>

					</div>
                </li>
			</td>
         </tr>
		 <tr>
			<td align = center>		
                <li>
				
                    <label class="desc">Fecha del Documento:<span class="req">*</span></label>
                    <div>
					<input name="fecha" type="text"  class="field text medium"  id="fecha"  maxlength="255" readOnly />

					</div>
                </li>
			</td>
		 </tr>
		 
		 </table>
               
            </ul>
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button" onClick="location.replace('<?php echo base_url();?>micontrolador/VistaBanco/');">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 