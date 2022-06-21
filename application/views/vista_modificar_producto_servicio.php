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
						"required,idproductoservivio,Debe haber un ID del producto/servicio.",
						"required,codigo,Debe haber un codigo del producto/servicio.",
						"required,codigo2,Debe haber un codigo del producto/servicio seleccionado.",
						"required,unidad,Escriba la unidad del producto/servicio 0 si no aplica.",
						"required,costo,Escriba el coso del producto $.",
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
| <i>Modificar Producto/Servicio</i>
</span>
<hr>

  <br>
 

<?php

$segmento 				= $this->uri->segment(4,0);
$codigoServicioProucto  = $this->uri->segment(5,0);
$claseEstilo = "";
$mensaje = "";
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 1030)
	{
		 $claseEstilo = "error_box";
   $mensaje = "El c&oacute;digo ingresado <b>$codigoServicioProucto</b> ya existe.  Verifique porfavor...";
	}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<fieldset class = fieldset1>
<legend class = legend1>Modificar Producto/Servicio</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/ModificarProductoServicio/" name = "cuentabancos">
		 
					<br>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
		
				<input name="idproductoservivio" type="hidden" size =25  id="idproductoservivio" value = "<?php echo $listarProductoServicioAmodificar[0]->id;?>" readonly maxlength="255" readOnly /><!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->

				<!--fin campos hidden ocultos-->
			<td align = center>		
                <li>
				
                    <label class="desc">C&oacute;digo Producto/Servicio:<span class ="req">*</span></label>
                    <div>
						<input name="codigo" type="text" size =25  id="codigo" value = "<?php echo $listarProductoServicioAmodificar[0]->codigo;?>" maxlength="255"/><!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->
						<input name="codigo2" type="text" size =25  id="codigo2" value = "<?php echo $listarProductoServicioAmodificar[0]->codigo;?>" readOnly maxlength="255"/><!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->

					</div>
                </li>
			</td>
			<td align = center>		
                <li>
				
                    <label class="desc">Unidad de Medida:<span class="req">*</span></label>
                    <div>
					<input name="unidad" type="text"  class="field text medium"  id="unidad" value ="<?php echo $listarProductoServicioAmodificar[0]->unidad;?>"  maxlength="255"/>

					</div>
                </li>
			</td>
         </tr>
		 <tr>
			<td align = center>		
                <li>
				
                    <label class="desc">Costo $:<span class="req">*</span></label>
                    <div>
					<input name="costo" type="text"  class="field text medium"  id="costo" value ="<?php echo $listarProductoServicioAmodificar[0]->costo;?>"  maxlength="255" />
					

					</div>
                </li>
			</td>
		   <td align = center>		
                <li>
				
                    <label class="desc">Descripci&oacute;n:<span class="req">*</span></label>
                    <div>
					<textarea name ="descripcion" cols = "25" rows ="8"><?php echo $listarProductoServicioAmodificar[0]->descripcion;?></textarea>
					

					</div>
                </li>
			</td>
		 </tr>
		 
				
		
		 </table>
               
            </ul>
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button" onClick="location.replace('<?php echo base_url();?>micontrolador/VistaMateriales/');">Cancelar</button>
          </div>
        </form>
       
 </fieldset>
 </div>
 