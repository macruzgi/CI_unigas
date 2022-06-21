
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
          
				        "required,banco,Ingrese el motivo de la anulación del cheque/transaccion.",
                "required,idtranscheque,Debe haber un ID de cheque/transacción"
					      
                            
            ]
        });
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


<h1>Anular Cheque/Transferencia</h1>


<fieldset class = fieldset1>
<legend class = legend1>Anular Cheque/Transferencia</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/AnularChequeTransferencia/" name = "cuentabancos">
	
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
			<td align = center>		
                <li>
                    <label class="desc">Motivo par la que anular&aacute; el cheque:<span class="req">*</span></label>
                    <div>
                                                <textarea class="catalogo"  rows="5" cols="60" name = "banco" id = "banco"></textarea>
                                            <input name="idtranscheque" type="hidden" size =25  id="idtranscheque" value = "<?php echo $this->uri->segment(3,0);?>" readonly maxlength="255"/>
                       </div>
                </li>
			</td>
		
         
				</table>
               
            </ul>
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button" onClick="location.replace('<?php echo base_url();?>micontrolador/VistaBanco/');">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 