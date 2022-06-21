
<?php 

 header('Content-Type: text/html; charset=UTF-8');
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
                "required,cuentacontable,Seleccione alguna cuenta contable.",
				        "required,banco,Ingrese el nombre del Banco.",
					      "required,numerocuenta,Ingrese el número de cuenta.",
				        "required,ultimocheque,Ingrese el # del último cheque emitido.",
				        //"required,formatocheque,Ingrese el telefono de contacto.",
                "required,tipopartida,Seleccione el tipo de partida.",
                "required,tipoimpresion,Seleccione el tipo de impresión.",
                //"required,inactiva,Ingrese el telefono de contacto.",
                "required,nombreemite,Ingrese el nombre del emisor de cheques.",
                "required,cargoemite,Ingrese el cargo del emisor de cheques.",
                "required,nombrerevisa,Ingrese el nombre del revisa de cheques.",
                "required,cargorevisa,Ingrese el cargo del revisa de cheques.",
                "required,nombreautoriza,Ingrese el nombre del autorizador de cheques.",
                "required,cargoautoriza,Ingrese el cargo del autorizador de cheques."
                            
            ]
        });
    });



</script>

<script type="text/javascript">
$(function() {
	$("#fechaininew").datepicker();
	$("#fechafinnew").datepicker();
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
<h1>Nueva Cuenta Bancaria</h1>
<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 100)
{
  $claseEstilo = "error_box";
  $mensaje = "El # de cuenta ingresado ya existe verifique por favor.";

}
elseif($segmento == 200)
{
   $claseEstilo = "valid_box";
   $mensaje = "Registro almacenado exitosamente";
   echo "<META HTTP-EQUIV=REFRESH CONTENT=4;URL=".base_url()."micontrolador/VistaNuevaCuenta/".">";
}
elseif($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "Error inesperado.";
}

/*echo $fecha = date("d-m-Y")."<br>";
 echo $mes  = substr($fecha,3,2); //extraigo la porcion del mes
 echo "<br>".$annio = substr($fecha,6,4);
 */
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<div align = center>
<fieldset class = fieldset1>
<legend class = legend1>Nueva cuenta Bancaria</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarCuentaBanco/" name = "cuentabancos">
		<li>
                    <label class="desc">Cuenta Contable:</label>
                    <div>
                      <select name = cuentacontable id="cuentacontable">
                      <?php
                        foreach($listarCuentasContables as $filasEncontradas):
                        
                      ?>
                        <option value = <?php echo $filasEncontradas->id;?>><?php echo $filasEncontradas->codigo."-".$filasEncontradas->nombre;?> </option>
                      <?php endforeach;?>
                      </select>
                    </div>
          </li>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
			<td>		
                <li>
                    <label class="desc">Banco donde se apertura la cuenta:<span class="req">*</span></label>
                    <div>
                        <input name="banco" id = "banco" type="text" class="field text large" id="codigo" 
                        maxlength="255"/>
                    </div>
                </li>
			</td>
			<td>
                <li>
                    <label class="desc">No. de la Cuenta (sin guiones): <span class="req">*</span></label>
                    <div>
                        <input name="numerocuenta" type="text" class="field text large" id="numerocuenta" 
                        value="<?php if(isset($_POST["numerocuenta"]))echo $_POST["numerocuenta"]; //para que quede grabado
    // el nombre que escribo en la busquedea y lo mantenga visible ?>" maxlength="255"/>
                    </div>
                </li>
				</td>
		  </tr>
			<tr>
					
				<td>
			     <li>
                    <label class="desc">&Uacute;ltimo cheque a emitir(solo n&uacute;meros):<span class="req">*</span></label>
                    <div>
                        <input name="ultimocheque" type="text" class="field text large" id="ultimocheque" 
                        value="<?php if(isset($_POST["ultimocheque"]))echo $_POST["ultimocheque"]; //para que quede grabado
    // el nombre que escribo en la busquedea y lo mantenga visible ?>" maxlength="255"/>
                    </div>
                </li>
        
				</td>
         <td>
				        <li>
                    <label class="desc">Tipo de Partida a utilizar en cheque:<span class="req">*</span></label>
                    <div>
                       <select name = tipopartida id = "tipopartida">
                       <?php
                        foreach($listarTipoPartidas as $tipoPartidasEncontradas):
                        
                      ?>
                        <option value = <?php echo $tipoPartidasEncontradas->id;?>><?php echo $tipoPartidasEncontradas->codigo."-".$tipoPartidasEncontradas->descripcion;?> </option>
                      <?php endforeach;?>
                      </select>
                    </div>
                </li>
				</td>
        </tr>
				
			
				<tr><td>
				<li>
                    <label class="desc">Tipo de Impresi&oacute;n:<span class="req">*</span></label>
                    <div>
                       <select name = tipoimpresion id = tipoimpresion>
                        <option value = 1>Cheque Vaucher</option>
                        <option value = 2>Cheque Normal</option>
                      </select>
                    </div>
                </li>
				</td>
				<td>
				<li>
                   <label class="desc">Estado de la cuenta:<span class="req">*</span></label>
                    <div>
                       <select name = inactiva id = inactiva>
                        <option value = 1>ACTIVA</option>
                        <option value = 0>INACTIVA</option>
                      </select>
                    </div>
                </li>
				</td>
      </tr>
				<tr>
        <td>
        <fieldset>
          <legend>Persona que emite el cheque</legend>
			         <li>
                    <label class="desc">Nombre: <span class="req">*</span></label>
                    <div>
                        <input name="nombreemite" type="text" class="field text large" id="nombreemite" value="<?php if(isset($_POST["nombreemite"]))echo $_POST["nombreemite"]; //para que quede grabado
    // el nombre que escribo en la busquedea y lo mantenga visible ?>" maxlength="255"/>
                    </div>
                
                </li>
                <li>
                   <label class="desc">Cargo: <span class="req">*</span></label>
                  <div>
                        <input name="cargoemite" type="text" class="field text large" id="cargoemite" maxlength="255"/>    
                </div>
              </li>
                
        </fieldset>
				</td>
        <td>
        <fieldset>
          <legend>Persona que revisa el cheque</legend>
			         <li>
                    <label class="desc">Nombre: <span class="req">*</span></label>
                    <div>
                        <input name="nombrerevisa" type="text" class="field text large" id="nombrerevisa" maxlength="255"/>
                    </div>
                
                </li>
                <li>
                   <label class="desc">Cargo: <span class="req">*</span></label>
                  <div>
                        <input name="cargorevisa" type="text" class="field text large" id="cargorevisa" maxlength="255"/>    
                </div>
              </li>
                
        </fieldset>
				</td>
			</tr>
				<tr>
        <td colspan = 2>
        <fieldset>
          <legend>Persona que autoriza el cheque</legend>
			         <li>
                    <label class="desc">Nombre: <span class="req">*</span></label>
                    <div>
                        <input name="nombreautoriza" type="text" class="field text large" id="nombreautoriza" maxlength="255"/>
                    </div>
                
                </li>
                <li>
                   <label class="desc">Cargo: <span class="req">*</span></label>
                  <div>
                        <input name="cargoautoriza" type="text" class="field text large" id="cargoautoriza" maxlength="255"/>    
                </div>
              </li>
                
        </fieldset>
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
 