
<?php 
 header('Content-Type: text/html; charset=UTF-8');

?>
<head>
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
						//"required,cuentaOtro,Debe elejir otra cuenta bancaria."
            ]
        });
    });
  
   function findClient(idObjDest){//CERO QUE NO SE ESTA OCUPANDO
		urlDestino = "<?php echo base_url();?>micontrolador/VistaBuscarProveedoresParaCrheque/"+idObjDest;
		winClientes = window.open(urlDestino,"wFiendClient","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=600");
		}


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
<h1>Nuevo Cheque</h1>
<body onLoad="limpiarform()">
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
<legend class = legend1>Nuevo Cheque</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarCheque" name = "cuentabancos">
		<li>
                    <label class="desc">Banco/Cuenta bancaria:<span class="req">*</span></label>
                    <div>
                      <select name = cuenta id="cuenta" onchange ='ponerIdCuentaCotnableCexbox(this.value)'>
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
            <label class="desc">Codigo:</label>
                    <div>
                        <input name="codigo" type="text" class="field text medium" id="codigo" value="" maxlength="255"/>
                        <input name="idproveedor" type="hidden" class="field text medium" id="idproveedor" value="" maxlength="255"/>
                          <a href = "#" onClick="abrirVentanaProveedores()"> <img src = "<?php echo base_url();?>images/buscar.png" align  = middle title ="Buscar"></a>
                    </div>
            </li>
        
               <li>
            <label class="desc">A nombre de:<span class="req">*</span></label>
                    <div>
                        <input name="anombrede" type="text" size = 60  id="anombrede" value="" maxlength="255"/>
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
	  </FORM>	
      <tr>
         <td  width =15%>
        
  			         <li>
                      <label class="desc">Monto $(solo n&uacute;meros sin comas):<span class="req">*</span></label>
                      <div>
                          <input name="monto" type="text" class="field text medium" id="nomto" value="" maxlength="255"/>
                      </div>
                  </li>
          </td> 
           <td>
               <li> 
                     <label class="desc">Tipo de Partida:<span class="req">*</span></label>
                    <div>
                      <input name="tipopartida" type="hidden" class="field text medium" id="tipopartida" value="1" readonly  maxlength="255"/>
                      <input name="ti" type="text" class="field text medium" id="ti" value="Egreso" readonly maxlength="255"/>
                      <!--select name = tipopartida id = "tipopartida" readonly="readonly">
                        <?php
                        //foreach($listarTiposPartidas as $tiposEncontrados):
                        
                      ?>
                        <!--option value = <?php //echo $tiposEncontrados->id;?>><?php //echo $tiposEncontrados->codigo." - ".$tiposEncontrados->descripcion?> </option>
                      <?php //endforeach;?>
                      </select-->
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
            </li> 
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
         
				</table>
        
                
            
           <div align = center> 
                  
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 