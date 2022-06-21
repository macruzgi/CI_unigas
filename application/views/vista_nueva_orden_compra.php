
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
                "required,centrocosto,Seleccione algun centro de costo.",
                //"required,codigo, Debe ingesar el código del proveedor.",
				        "required,nombreprove,Ingrese el nombre del proveedor.",
					      //"required,tipopartida,Ingrese el tipo de partida a realizar",
				        "required,fecha,Ingese la fecha.",
				        "required,solicitadapor,Ingrese quien solicitó la compra."
                //"required,cuentacontable,Ingrese el codigo de la cuenta contable."               
            ]
        });
    });
    //no se esta ocupando
   function findClient(idObjDest){
		urlDestino = "<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaCrheque/"+idObjDest;
		winClientes = window.open(urlDestino,"wFiendClient","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=600");
		}

/*para poner el id de las condiciones de pago si se selecciona algo del combo
distinta a la predeterminada para el proveedor*/

function ponerIdCondicionesPagoDelCombo(idCondicioesPago)
	{
		//para separar los datos de las comas ya que envio el id de condiciones de pago y la cantidad de dias por si selecciona otra
		//opcion de condicion de pago
		var strCompleta=idCondicioesPago;//la variable enviada a la funcion
		var buscoSeparadorPartes=strCompleta.split(",");//busco la coma en la variable idCondicoesPago
		//var adelante=buscoSeparadorPartes[0];
		//coloco el id de las condicones de pago en la caja de texto idcondicionpago para llavarla a la hora de guadar
		document.cuentabancos.idcondicionpago.value = buscoSeparadorPartes[0];//0 es el indice que contiene el id de las condiciones de pago
		//pongo el texto seleccionado del combox a la caja de text condicionpago
		var seleccion=document.getElementById('condicionpagoCombo');
		document.getElementById('condicionpago').value=seleccion.options[seleccion.selectedIndex].text;
		///pongo el predeterminado dias credito diascredito buscoSeparadorPartes[1] que es el indice que trae la cantidad de dias credito si se
		//elijio otra opcion
		document.cuentabancos.diascredito.value = buscoSeparadorPartes[1];
		
		
		
//alert(adelante);
		return;
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
  sList = window.open("<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaNuevaOrdenCompra/", "list", "width=750,height=510");
}
function remLink() {
  if (window.sList && window.sList.open && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!-- 
/*FUNION SIN USO LA PASE PARA EL FORMULARIO DONDE SE HACEN LOS DETALLES DE LA COMPRA*/
function abrirVentanaCuentasContablesNuevaOrdenCompra() {
//var codigoProveedor = document.getElementById("codigo").value //obtiene el valor de la caja de texto codio y lo envia a la vista
//var idProveedor = document.getElementById("idproveedor").value //obtiene el valor de la caja de texto codio y lo envia a la vista
 sList = window.open("<?php echo base_url();?>micontrolador/VistaBuscarCuentasContablesNuevaOrdenCompra/", "list", "width=980,height=580");
}
function remLink() {
  if (window.sList && window.sList.open && !window.sList.closed)
    window.sList.opener = null;
}
// -->
</SCRIPT>
<hr>
<span class = navegacion>
COMPRAS:: | 
<a href ="<?php echo base_url();?>micontrolador/VistaCompras/">Compras</a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a>
</span>
<hr>
<h1>Nueva Orden de Compra</h1>
<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(4,0);
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
<legend class = legend1>Nueva orden de Compra</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarOrdenDeCompra/" name = "cuentabancos">
		
     

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
	  <!--campos hidden-->
	  <input name="idcondicionpago" type="hidden"    id="idcondicionpago"  maxlength="255" value = "0" /><!--id de la condiciones de pago-->
	  <input name="formapago" type="hidden"    id="formapago"  maxlength="255"value = "0" /><!--letra de la forma de pago-->
	  <input name="diascredito" type="hidden"    id="diascredito"  maxlength="255" value = "0" /><!--numero de dias credito-->
	  <input name="tamannocontribuyente" type="hidden"    id="tamannocontribuyente"  maxlength="255" value = "0" /><!--letra del tamaño del cotribuyente-->
	<!--fin campso hidden-->	
		<ul>
		<tr>
			<td>
				<li>
                    <label class="desc">Centro de Costo:<span class="req">*</span></label>
                    <div>
                      <select name = "centrocosto" id="centrocosto">
                      <?php
                        foreach($listarCentrosDeCostos as $centroCostosEncontradas):
                        
                      ?>
                        <option value = <?php echo $centroCostosEncontradas->id;?>><?php echo $centroCostosEncontradas->codigo." - ".$centroCostosEncontradas->descripcion?> </option>
                      
                      <?php endforeach;?>
                      </select>
                    </div>
          </li>
			</td>
			<td>
				<label class="desc">Tipo Documento:<span class="req">*</span></label>
				<div>
                      <select name = "tipocomprobante" id="tipocomprobante">
						<option value = "1">Comprobante de Cr&eacute;dito Fiscal</option>
						<!--option value = "2">Nota de Cr&eacute;dito</option-->
						<option value = "3">Nota de D&eacute;bito</option>
						<option value = "4">Factura</option>
						<option value = "5">Recibo</option>
                      </select>
                    </div>
			</td>
		</tr>
      <tr>
        <td>
  
           <li>
            <label class="desc">Codigo proveedor:</label>    
                    <div>
                        <input name="codigo" type="text" class="field text medium" id="codigo" value="000000" maxlength="255" readonly />
                        <input name="idproveedor" type="hidden" class="field text medium" id="idproveedor" value="000000" maxlength="255"/> <!--este ide se lo mando cuendo voi a buscar las cuentas por pagar al proveedor-->
                          <a href = "#" onClick="abrirVentanaProveedores()"> <img src = "<?php echo base_url();?>images/buscar.png" align  = middle title ="Buscar"></a>
                    </div>
            </li>
        </td>
		<td>
               <li>
            <label class="desc">Nombre<span class="req">*</span></label>
                    <div>
                        <input name="nombreprove" type="text" class="field text large"   id="nombreprove" value="" maxlength="255" />
                    </div>
            </li>
            

        </td>

      </tr>
	<tr>
		<td width = "35%">
			    <li>
            <label class="desc">NIT<span class="req">*</span></label>
                    <div>
                        <input name="nit" type="text" class="field text large"  id="nit" value="" maxlength="255" />
                    </div>
            </li>
		</td>
	   <td>
			    <li>
            <label class="desc">NRC<span class="req">*</span></label>
                    <div>
                        <input name="nrc" type="text" class="field text large"   id="nrc" value="" maxlength="255" />
                    </div>
            </li>
		</td>
	</tr>
  </FORM>	
      <tr>
		 <td>
		    <li>
           
						 <label class="desc">Condiciones de Pago Predeterminda:<span class="req">*</span></label>
						<input name="condicionpago" type="text" class="field text large"   id="condicionpago" value="" maxlength="255" readOnly />
                    </div>
            </li>
		  </td>
		  <td width ="30%">
			<li>
				 <label class="desc">Otras Condiciones de Pago:<span class="req">*</span></label>
                    <div>
						<select name ="condicionpagoCombo" id ="condicionpagoCombo" onchange ='ponerIdCondicionesPagoDelCombo(this.value)'>
							<option value ="">Seleccione...</option>
							<?php 
								foreach($listarCondicionesDePago as $condicionesEncontradas):
							?>
							<option value = "<?php echo $condicionesEncontradas->id.",".$condicionesEncontradas->dias;?>">
							<?php 
							if($condicionesEncontradas->id == 1)
								{
									$texto	= "CONTADO";
								}
							else
								{
									$texto = "CREDITO";
								}
							echo $texto.= " ".$condicionesEncontradas->dias." DIAS";
							//echo $condicionesEncontradas->descripcion;
							?></option>
							<?php
								endforeach;
							?>
						</select>
			</li>
		  </td>
         <!--td  width ="30%">
        
  			         <li>
                      <label class="desc">Cuenta Contable del gasto:<span class="req">*</span></label>
                      <div>
                          <input name="cuentacontable" type="text" class="field text medium" id="cuentacontable" value="" maxlength="255" readOnly />
						  <a href = "#" onClick="abrirVentanaCuentasContablesNuevaOrdenCompra()" class ="css3button2" style="text-decoration:none">
						  <img src = "<?php echo base_url();?>images/buscar.png" align = middle>
						  </a>
                          <input name="idcuentacontable" type="text" class="field text medium" id="idcuentacontable" value="" maxlength="255" readOnly />

                      </div>
                  </li>
          </td--> 
           <!--td>
               <li> 
                     <label class="desc">Tipo de Partida:<span class="req">*</span></label>
                    <div>
                     <input name="tipopartida" type="hidden" class="field text medium" id="tipopartida" value="1" readonly  maxlength="255"/>
                      <input name="ti" type="text" class="field text medium" id="ti" value="Egreso" readonly maxlength="255"/>
                     
                    </div>
                </li>
          </td--> 
		 
			</tr>
				<tr>
         
          <td>
				    <li>
                    <label class="desc">Fecha<span class="req">*</span></label>
                    <div>
                     <input name="fecha" type="text" size =10  id="fecha" value = <?php echo date("Y-m-d");?> maxlength="255"/>
                    </div> 
          </TD>
		    <td>
				    <li>
                    <label class="desc">Solicitada por:<span class="req">*</span></label>
                    <div>
                     <input name="solicitadapor" type="text" size ="25"  id="solicitadapor" maxlength="255"/>
                    </div> 
          </TD>
       
			  
      </tr>
			<!--tr>
        <td colspan = 2 align= center>
				        <li>
                    <label class="desc">Concepto:<span class="req">*</span></label>
                    <div>
                          <textarea class="catalogo"  rows="5" cols="60" name = "concepto" id = "concepto"></textarea>
                    </div>
                </li>
				    </td>
      </tr-->
             
		   </ul>
         
				</table>
        
                
            
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = "Procesar">
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 <?php

$segmento = $this->uri->segment(4,0);
$idComprobante = $this->uri->segment(3,0);
if($segmento == 1029)
{
@session_start();
unset($_SESSION["carro"]);//elimino la ssion del carro
?>
<script>alert('La operación a sido completada, se ha credo el registro de compra')
 window.location = "<?php echo base_url();?>micontrolador/VistaCrearDetallesNuevaOrdenCompra/<?php echo $idComprobante;?>/";
 </script>
<?php
}

?>

 