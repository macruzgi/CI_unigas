
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
                "required,cuenta,Seleccione alguna cuenta bancaria.",
                "required,concepto, Debe digitar el concepto.",
				        "required,fechabanco,Ingrese la fecha del banco.",
					      "required,fechacontable,Ingrese la fecha a contabilizar.",
				        "required,tipotransaccion,Seleccione el tipo de transacción.",
				       // "required,tipopartida,Seleccione el tipo de partida.",
                "required,monto,Ingrese el monto en $."               
            ]
        });
    });


	function mostrarLaOtraCuentaBancariaAtransferir()
		{
		//agaro el value del cechbox que contiene el id de la cuenta banciaria abajo ejelido en
			//la funcion ponerIdCuentaCotnableCexbox
          var idCuentaBancaria = document.getElementById("tranferenciaentrecuentas").value
          //var fecha = document.getElementById("fecha").value
          //if(idCuentaContable != 0)
           // {
            //var url= 
			if(document.getElementById('tranferenciaentrecuentas').checked) //sichqueo el chexkbox que lo mustre sino que lo oculte 
				{
					document.getElementById('tabla').style.display = "block";
				} 
			else 
				{
					document.getElementById('tabla').style.display = "none";
				}
				$.ajax({   
					type: "POST",
					url:"<?php echo base_url();?>micontrolador/VistaOtraCuentaBancariaAtransferir/" + idCuentaBancaria + "/",
					data:{},
					success: function(datos){       
						$('#tabla').html(datos);
					}
				});
		
		
            //}
        }
 
/*para poner el ide de la cuenta bancaria elejida y que no muestre esta elejida en el otro chexk*/
function ponerIdCuentaCotnableCexbox(idCuentaContable)
	{
		//si el chexsbox de las cuentas bancaciras cabio a otro cuenta que el chex se vuelba false
		//para que acutalice las otras cuentas a mostrar con la nueva cuenta elejida
		if(document.getElementById('cuenta').onchange)
			{
				document.cuentabancos.tranferenciaentrecuentas.checked=0;//se pone  false el checkbox para mostrar las otras cuentas banciaras
				document.getElementById('tabla').style.display = "none";//y no se oculta el combobox de las otras cuentas bancarias
			}
		//al cabiar de de estado el combobox de las cuentas contables que ponga en el id de la
		//cuenta bancaria en el value del cechbox tranferenciaentrecuentas para que lo lleve a la funcion de arriba
		//mostrarLaOtraCuentaBancariaAtransferir para filtrar las cuentas contables menos la elejida por el primer combobox
		document.cuentabancos.tranferenciaentrecuentas.value = idCuentaContable;
		return;
	} 
</script>

<script type="text/javascript">
$(function() {
	$("#fechabanco").datepicker();
  $("#fechacontable").datepicker();
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
<h1> Nueva Transacci&oacute;n</h1>

<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "Error al tratar de guardar los datos verifique por favor.";   
}
elseif($segmento == 400)
{
?>

 <script>alert('La operación a sido gurdada exitosamente. ')
 window.location = "<?php echo base_url();?>micontrolador/VistaTransacciones/";
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
<legend class = legend1>Nueva transacci&oacute;n bancaria</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarTransaccionBancaria/" name = "cuentabancos">
		<li>
                    <label class="desc">Banco/Cuenta bancaria:<span class="req">*</span></label>
                    <div>
                      <select name = cuenta id="cuenta"  onchange ='ponerIdCuentaCotnableCexbox(this.value)'>
                      <?php
                        foreach($listarCuentasBancairas as $cuentasEncontradas):
                        
                      ?>
                        <option value = <?php echo $cuentasEncontradas->id_cuenta_bancaria;?>><?php echo $cuentasEncontradas->nombre_banco_cuenta." - ".$cuentasEncontradas->numero_cuenta_bancaria?> </option>
                      
                      <?php endforeach;?>
                      </select>
                    </div>
          </li>
       
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
      <tr>
   
  
         
                <td width = "50%">
      				    <li>
                          <label class="desc">Fecha de Banco:<span class="req">*</span></label>
                          <div>
                           <input name="fechabanco" type="text" size =10  id="fechabanco" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                          </div> 
                  </li> 
      			   	</td>
			  
             
         
                <td width = "50%">
      				    <li>
                          <label class="desc">Fecha de Contable:<span class="req">*</span></label>
                          <div>
                           <input name="fechacontable" type="text" size =10  id="fechacontable" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                          </div> 
                  </li> 
      			   	</td>
			  
    

      
    </tr>
		
      <tr>
        
          <td>
                <li>
                    <label class="desc">Tipo Transacci&oacute;n:<span class="req">*</span></label>
                    <div>
                      <select name = tipotransaccion id="tipotransaccion"><!-- onchange="cargaDebeHaber(this.value)"-->
                      <?php
                        foreach($listarTiposTransaccionParaNuevaTransaccion as $tipoTransaccionEncontrada):
                        
                      ?>
                        <option value = <?php echo $tipoTransaccionEncontrada->id_tipo;?>><?php echo $tipoTransaccionEncontrada->nombre." - (Partida de ".$tipoTransaccionEncontrada->descripcion.")";?> </option>
                      
                      <?php endforeach;?>
                      </select>
                    </div>
              </li>
			  
          </td>
		 	<td>
					<label class="desc">Transferencia entre cuentas:</label>
						<div>
						<input name="tranferenciaentrecuentas" type="checkbox" id="tranferenciaentrecuentas" onclick="mostrarLaOtraCuentaBancariaAtransferir();" value ="<?php echo $listarCuentasBancairas[0]->id_cuenta_bancaria;?>">
						Transferencia entre cuentas
						</div>
						<br>
						<div id="tabla"> <!--AQUI SE MUESTRAN LOS DATOS DE LA OTRA VISTA QUE LISTA LOS DATOS A CONCILIAR-->
    
						</div> <!--FIN DONDE SE MUESTRAN LOS DATOS DE LA OTRA VISTA-->
				</td>
			</tr>
			<tr>
           <td>
        
  			         <li>
                      <label class="desc">Monto $(solo n&uacute;meros):<span class="req">*</span></label>
                      <div>
                          <input name="monto" type="text" class="field text medium" id="monto" value="" maxlength="255"/>
                      </div>
                  </li>
          </td>
          <td>
                  <b>Contabilizar:</b>
                      
                          <input name="contabilizar" type="checkbox" id="contabilizar" value = "1" checked maxlength="255"/>
                     
                 
                      <b>Incluir en Conciliacion:</b>
                      
                          <input name="incluirconciliacion" type="checkbox"  id="incluirconciliacion"  checked maxlength="255"/>
                     
                  
          </td>
      </tr>
      	
			<tr>
        <td colspan = 2 align = center>
				        <li>
                    <label class="desc">Concepto:<span class="req">*</span></label>
                    <div>
                          <textarea class="catalogo"  rows="5" cols="60" name = "concepto" id = "concepto"></textarea>
                    </div>
                </li>
				    </td>
      </tr>
             
		   </ul>
        <!--input name="trasaccionhaberodebe" type="text" class="field text medium" id="trasaccionhaberodebe" value="" maxlength="255"/--> 
				</table>
        
                
            
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 