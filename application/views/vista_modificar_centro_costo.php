<?php 
 header('Content-Type: text/html; charset=UTF-8');
	?>

<head>
<link href="<?php echo base_url();?>css/MisEstilos.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>js/jquery-1.4.2.min.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
function evniarDatosCuetnasCoApaginaPadre(idCuenta, codigoCuenta, nombreCuentaContable) {
  if (window.opener && !window.opener.closed)
    //cuentabancos es el nombre del formulario padre
    //cuentacontable y idcuentacontable son los nombre de los campos
    //que quiero que se llenen en el formualrio padre
     window.opener.document.cuentabancos.cuentacontable.value = codigoCuenta;
     window.opener.document.cuentabancos.idcuentacontable.value = idCuenta;
	 window.opener.document.cuentabancos.nombrecuentacontable.value = nombreCuentaContable;
     window.close();
}
// -->
</SCRIPT>
 <script>
    function myOnComplete()
    {
        $('#cuentabancos').submit(); 
    }
    $(document).ready(function() {
        $("#cuentabancos").RSV({
            onCompleteHandler: myOnComplete,
            rules: [
          
				        //"required,categoria,La categoria no existe.",
						"required,idcentrocosto,Debe haber un ID del Centro de Costo.",
						"required,descripcion,Debe escribir alguna descripción."
					      
                            
            ]
        });
    });



</script>

</head>
<hr>
<span class = navegacion>
COMPRAS::
<!--a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> |--> 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a>
| <a href ="<?php echo base_url();?>micontrolador/VistaCentroCostos/">Centros Costos</a>

</span>
<hr>
<h1>Modificar Centros de Costos</h1>

  <br>
 

<?php

$segmento = $this->uri->segment(4,0);
$claseEstilo = "";
$mensaje = "";
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
<fieldset class = fieldset1>
<legend class = legend1>Modificar Centro Costo</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/ModificarCentroCosto/" name = "cuentabancos">
		 
					<br>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
		
				<input name="idcentrocosto" type="text" size =25  id="idcentrocosto" value = "<?php echo $listarCentroCostoAmodificar[0]->id;?>" readonly maxlength="255" readOnly /><!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->

				<!--fin campos hidden ocultos-->
			<td align = center>		
                <li>
				
                    <label class="desc">C&oacute;digo Centro Costos:<span class ="req">*</span></label>
                    <div>
						<input name="codigocentrocosto" type="text" size =25  id="codigocentrocosto" value = "<?php echo $listarCentroCostoAmodificar[0]->codigo;?>" readOnly maxlength="255"/><!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->

					</div>
                </li>
			</td>
			<td align = center>		
                <li>
				
                    <label class="desc">Descripci&oacute;n:<span class="req">*</span></label>
                    <div>
					<textarea name ="descripcion" cols = "25" rows ="8"><?php echo $listarCentroCostoAmodificar[0]->descripcion;?></textarea>
					

					</div>
                </li>
			</td>
         </tr>
		
		 
				
		
		 </table>
               
            </ul>
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button" onClick="location.replace('<?php echo base_url();?>micontrolador/VistaCentroCostos/');">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 