
<?php 
header('Content-Type: text/html; charset=UTF-8');
@session_start();
//PARA MOSTRAR LOS DATOS DE LA SESION
			if(isset($_SESSION["agregarAbonos"]) || is_array($_SESSION["agregarAbonos"])) {
			   $abonosAgregados= $_SESSION["agregarAbonos"];
							}

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
                //"required,codigo, Debe ingesar el código del proveedor.",
				        "required,anombrede,Ingrese el nombre de la pesona a emitir el cheque.",
					      "required,tipopartida,Ingrese el tipo de partida a realizar",
				        "required,fecha,Ingese la fecha a emitir el cheque.",
				        "required,concepto,Ingrese el concepto.",
                "required,monto,Ingrese el monto en $."               
            ]
        });
    });
    //no se esta ocupando
   function findClient(idObjDest){
		urlDestino = "<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaCrheque/"+idObjDest;
		winClientes = window.open(urlDestino,"wFiendClient","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=600");
		}

</script>

<script type="text/javascript">
$(function() {
	$("#fecha").datepicker();
;
});

</script>

<SCRIPT LANGUAGE="JavaScript">
<!-- 
function abrirVentanaProveedores() {
  sList = window.open("<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaCrheque/", "list", "width=750,height=510");
}
function remLink() {
  if (window.sList && window.sList.open && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!-- 

function abrirVentanaProveedoresCxP() {
var codigoProveedor = document.getElementById("codigo").value //obtiene el valor de la caja de texto codio y lo envia a la vista
var idProveedor = document.getElementById("idproveedor").value //obtiene el valor de la caja de texto codio y lo envia a la vista
 sList = window.open("<?php echo base_url();?>micontrolador/VistaBuscarProveedorCuentaPorPagar/" + codigoProveedor + "/" + idProveedor, "list", "width=980,height=580");
}
function remLink() {
  if (window.sList && window.sList.open && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
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

<h1>Abono CxP Transferencia</h1>

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

<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<div align = center>
<fieldset class = fieldset1>
<legend class = legend1>CxP Transferencia</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarChequeCxPtransferencia/" name = "cuentabancos">
		<li>
                    <label class="desc">Banco/Cuenta bancaria:<span class="req">*</span></label>
                    <div>
                      <select name = cuenta id="cuenta">
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
        <td>
  
           <li>
            <label class="desc">Codigo:</label>    
                    <div>
                        <input name="codigo" type="text" class="field text medium" id="codigo" value="000000" maxlength="255" readonly />
                        <input name="idproveedor" type="hidden" class="field text medium" id="idproveedor" value="000000" maxlength="255"/> <!--este ide se lo mando cuendo voi a buscar las cuentas por pagar al proveedor-->
                          <a href = "#" onClick="abrirVentanaProveedores()"> <img src = "<?php echo base_url();?>images/buscar.png" align  = middle title ="Buscar"></a>
                    </div>
            </li>
        
               <li>
            <label class="desc">A nombre de:<span class="req">*</span></label>
                    <div>
                        <input name="anombrede" type="text" size = 60  id="anombrede" value="" maxlength="255" readonly />
                    </div>
            </li>
            

        </td>
       

  </FORM>


        
 
      </tr>
	
      <tr>
         <td  width =15%>
        
  			         <li>
                      <label class="desc">Monto $(solo n&uacute;meros):<span class="req">*</span></label>
                      <div>
                          <input name="monto" type="text" class="field text medium" id="nomto" value="" readOnly maxlength="255"/>
                      </div>
                  </li>
          </td> 
           <td>
               <li> 
                     <label class="desc">Tipo de Partida:<span class="req">*</span></label>
                    <div>
                     <input name="tipopartida" type="hidden" class="field text medium" id="tipopartida" value="1" readonly  maxlength="255"/>
                      <input name="ti" type="text" class="field text medium" id="ti" value="Egreso" readonly maxlength="255"/>
                     
                    </div>
                </li>
          </td> 
			</tr>
				<tr>
         
          <td>
				    <li>
                    <label class="desc">Fecha de emisi&oacute;n:<span class="req">*</span></label>
                    <div>
                     <input name="fecha" type="text" size =10  id="fecha" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                    </div> 
          </TD>
          <td>                              
            </li> 
             
                    <div>
						<input type ="button" onClick ="abrirVentanaProveedoresCxP()" value = "Cargar Documento...">
                          <!--a href = "#" onClick="abrirVentanaProveedoresCxP()" class ="css3button2" style="text-decoration:none">Cargar Documento...</a-->
                    </div>
            </li>            
				</td>
			  
      </tr>
			<tr>
        <td colspan = 2 align= center>
				        <li>
                    <label class="desc">Concepto:<span class="req">*</span></label>
                    <div>
                          <textarea class="catalogo"  rows="5" cols="60" name = "concepto" id = "concepto"></textarea>
                    </div>
                </li>
				    </td>
      </tr>
             
		   </ul>
         
				</table>
        
                
            
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 