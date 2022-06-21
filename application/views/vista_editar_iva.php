
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
						"required,iva,Escriba algo en el IVA"
						//"required,fecha,Elija una fecha"
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

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a>
</span>
<hr>
<h1>
Editar IVA</h1>

<?php

$segmento = $this->uri->segment(4,0);
$claseEstilo = "";
$mensaje = "";
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 301)
{
   $claseEstilo = "error_box";
   $mensaje = "Aseg&uacute;rese de haber contabilizado esta compra, o posiblemente no exista.  Solicite ayuda a un administrador.";
}

?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<?php
if(count($traigoElIVAorigina) > 0)
{
?>
<fieldset class = fieldset1>
<legend class = legend1>Editar IVA</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/ActualizarIVAOrdenCompra/" name = "cuentabancos">
	
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
		<!--campos hidden-->
				<input name="idcomprobante" type="hidden" size =25  id="idcomprobante" value = "<?php echo $this->uri->segment(3,0);?>" readonly maxlength="255"/><!--id de la compra-->
				<!--fin campos hidden ocultos-->
			<td align = center>		
                <li>
				
                    <label class="desc">IVA DE LA COMPRA CON ID: <i><?php echo $traigoElIVAorigina[0]->id_comprobante;?></i> <span class="req">*</span></label>
                    <div>
					<input name="iva" type="text"  value="<?php echo $traigoElIVAorigina[0]->total_iva;?>"   class="field text medium" id="iva"  maxlength="255"/>

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
 <?php
 }
 ?>