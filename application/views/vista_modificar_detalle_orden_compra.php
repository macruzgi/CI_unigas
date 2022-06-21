
<?php 
header('Content-Type: text/html; charset=UTF-8');
@session_start();
//PARA MOSTRAR LOS DATOS DE LA SESION
			if(isset($_SESSION["carro2"]) || is_array($_SESSION["carro2"])) {
			   $productosEnElCarro= $_SESSION["carro2"];
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
				        "required,cuentacontable,Busque la cuenta contable.",
					      "required,idcuentacontable,Debe buscar una cuenta contable",
						"required,observaciones,Debe ingresar algún comentario."             
            ]
        });
    });
    //funcion para preguntar si desea guardar el detalle de la compra SIN USARLA
   function guardarDetalleSolicitudCompra()
		{
			var pregunta = confirm("Está apunto de pedir una Compra, está seguro?");
			if(pregunta)//si la respuesta es afirmativa
				{
					window.location = "<?php echo base_url();?>micontrolador/RegistrarDetalleCompra/";
				}
		}
//funcion que abre un formulario tipo popup para agregar un nuevo producto / servicio
function abrirVentanaNuevoProductoServicio() {
//var codigoProveedor = document.getElementById("codigo").value //obtiene el valor de la caja de texto codio y lo envia a la vista
//var idProveedor = document.getElementById("idproveedor").value //obtiene el valor de la caja de texto codio y lo envia a la vista
 sList = window.open("<?php echo base_url();?>micontrolador/VistaNuevoProductoServicioDesdeCompras/2/", "list", "width=980,height=580");
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

<script type="text/javascript">

/*Espero que sea de su agrado este conjunto de archivos si desea compartirlo en cualquier blog o en su pagina porfavor de darmes los creditos y asi seguir yo compartiendo mis conocimientos con ustedes.
---------GRACIAS--------------------

Mi blog: http://misscripts.blogspot.mx/
Twitter http://twitter.com/daniel_brena
Facebook http://ww.facebook.com/juanito.farias
Gmail danihhelb@gmail.com
*/ 
$(document).ready(function(){

$(".buscar").keyup(function() 
{
var idCompra = document.getElementById("idcompra").value;//para que envie estos datos a la funcion IneractivoProductos para que los agregue al carro
var idCodigoProducto = document.getElementById("idcodigoproducto").value;//para que envie estos datos a la funcion IneractivoProductos para que los agregue al carro
var cajabusqueda = $(this).val();
var dataString = 'buscarpalabra='+ cajabusqueda;

if(cajabusqueda=='')
{
}
else
{

$.ajax({
type: "POST",
url: "<?php echo base_url();?>micontrolador/InteractivoProductosOrdenAmodificar/" + idCompra + "/" + idCodigoProducto + "/",
data: dataString,
cache: false,
success: function(html)
{

$("#display").html(html).show();
	
	
	}




});
}return false;    


});
});

jQuery(function($){
   $("#cajabusqueda").Watermark("Buscar");
   });
</script>
<style type="text/css">
body
{
font-family:"Lucida Sans";

}

#cajabusqueda
{
width:250px;
border:solid 1px #000;
padding:3px;
}
#display
{
width:450px;
display:none;
float:right; margin-right:30px;
border-left:solid 1px #dedede;
border-right:solid 1px #dedede;
border-bottom:solid 1px #dedede;
overflow:hidden;
}
.display_box
{
padding:4px; border-top:solid 1px #dedede; font-size:12px; height:30px;
}

.display_box:hover
{
background:#e8edff; /*cuando paso encima el mause*/
color:#FFFFFF;
}
#shade
{
background-color:#00CCFF;

}


</style> 

<hr>



<body  OnLoad="document.cuentabancos.descripcion.focus()";>
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
Modificar Orden de Compra</h1>
<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(4,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 301)
{
 $claseEstilo = "error_box";
   $mensaje = "La compra seleccionada no ha sido despachada ni impresa o puda que ya se haya contabilizado, revise por favor.";
}
elseif($segmento == 1029)
{

?>
 <script>alert('La operación a sido guardada.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCrearDetallesNuevaOrdenCompra/";
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

<table class="tablecss" width="90%" border="1">
<thead class="odd">                        
<tr>

  <th>ITEM</th>
  <th>C&oacute;digo</th>
  <th>Descripci&oacute;n/Producto</th>
  <th>Cantidad</th>
  <!--th>UM</th-->
  <th>Precio Unitario USD</th>
  <th>Valor Neto USD</th>
  <th colspan ="2">Acci&oacute;n</th>
  </tr></thead>
<tbody>

<?php
$idCompra	 = $this->uri->segment(3,0);
//print_r($productosEnElCarro);
$totalNeto	 = 0;
$correlativo = 0;
	foreach($productosEnElCarro as $filasEncontradas):
	//echo $filasEncontradas["id"];
	$correlativo = $correlativo + 1;
	
?>
<form action = "<?php echo base_url();?>micontrolador/AgregarProductosAlCarroOrdenAmodificar/<?php echo $idCompra."/".$filasEncontradas["id"]."/";?>" METHOD = POST>

<tr>

	<td><?php echo $correlativo;?></td>
	<td><?php echo $filasEncontradas["codigo"];?></td>
	<td><input type = "text" value ="<?php echo $filasEncontradas["descripcion"];?>" size = "55" name ="descripcion" id ="descripcion"></td>
   <td><input type ="text" value ="<?php echo $filasEncontradas["cantidad"];?>" size ="9" name ="cantidad" id ="cantidad"></td>
   <!--td></td-->
   <td><input type="text" value="<?php echo $filasEncontradas["costo"];?>" size ="9" name ="costo"></td>
   <td><?php 
		echo $filasEncontradas["subtotal"];
	$subTotal	=  $filasEncontradas["subtotal"];
	$totalNeto = $totalNeto + $subTotal;
	?>
   <td align ="center"><input type = "submit" name = "boton" value = "Aplicar"></td>
   <td align ="center">
    <a href = "<?php echo base_url();?>micontrolador/EliminarLineaProductoCarro2/<?php echo $filasEncontradas["id"]."/".$this->uri->segment(3,0)."/";?>">
      <img src = "<?php echo base_url();?>images/icondel.png" title = "Quitar">
   </td>

   <tr>
    </form>
  <?php
	endforeach;
	
  ?>

	<tr>
		<td align = center colspan ="3"  rowspan="4"> 
	
           <a href="<?php echo base_url();?>micontrolador/EliminarProductosDelCarro2/<?php echo $this->uri->segment(3,0)."/";?>"><img src="<?php echo base_url();?>images/error.png" border="0" title="Quitar todos" align = middle width = "25"></a>
       </td>
	  
	
	<td>
		<b>Total Neto</b>
	</td>
	<td align = "right" colspan ="2">
	<b><?php echo number_format($totalNeto, 2);?></b>
	</td>
	</tr>
	<tr>
	
		<td>
		 <B>IVA 13%</B>
		</td>
		<td colspan ="2" align = "right">
		<B>
			<?php 
				 $iva = $totalNeto * 0.13;
				echo number_format($iva, 2);
				
			
			?>

			</B>
		</td>
	</tr>
	<tr>
		<td>
			<b>IVA Retenido 1%</b>
		</td>
		<td colspan ="2" align ="right">
			<?php
				if($tamannioProveedor != 'G' && $totalNeto > 100)//distintos a G son pequeños y medianos, que calcule el 1%
					{
						$ivaRetenido = $totalNeto * 0.01;
					}
				else
					{
						$ivaRetenido = 0;
					}
			echo "<b>".number_format($ivaRetenido, 2)."</b>";
			?>
		</td>
	</tr>
	<tr>
		<td>
			<b>TOTAL + IVA</B>
		<td colspan ="2" align = "right">
			<B>
				<?php echo $totalNetoMasIva	= number_format(($totalNeto + $iva - $ivaRetenido), 2);?>
			</B>
				<input type = "hidden" name ="totalcompra" value ="<?php echo $totalNetoMasIva;?>"><!-- este campo no lo utilizo en nada ya que los calculos los hago en el controlador-->
		</td>
	</tr>
	<tr>
	
		<td colspan = "6" align = "right">
			<!--pra mostrar la busqueda intereactiva-->
				 <div  style=" padding:6px; height:23px;;   background: left no-repeat #RED ">

				<div style=" width:300px; float:center; margin-right:30px" align="left">
				<span class = interacitvo>Escriba el nombre o codigo del producto/servicio:</span><input type="text" class="buscar" id="cajabusqueda" />
				<input type="hidden"  id="idcompra" value="<?php echo $this->uri->segment(3,0);?>" />
				<input type="hidden"  id="idcodigoproducto" value="<?php echo $this->uri->segment(4,0);?>" /><br /><br />

				<div id="display">
				</div>

				</div>

				</div>
				<div style="margin-top:20px; margin-left:20px">



				</div>

				<!--fin de mostrar la busqueda interactiva-->	
	 
		</td>
		<td align ="center">
			<a href="#" onClick ="abrirVentanaNuevoProductoServicio()"><img src="<?php echo base_url();?>images/edit_add.png" border="0" title="Agregar nuevo Producto/Servicio" align = "middle">
		</td>
	</tr>

</tbody>
</table>
      

<?php
if(count($productosEnElCarro)>0)
{
?>    
<br>
<br>        
           <!--div align = center> 
 <input type ="button" onClick ="guardarDetalleSolicitudCompra()" value ="Solicitar compra">
          </div-->
	
<fieldset class = fieldset1>
<legend class = legend1>Otros Datos</legend>
<form action ="<?php echo base_url();?>micontrolador/ActualizarDetalleCompra/" method = "POST" name = "cuentabancos" id = "cuentabancos">

   <li>
                      <label class="desc">Cuenta Contable:<span class="req">*</span></label>
                      <div>
                          <B>C&oacute;digo: </B><input name="cuentacontable" type="text" class="field text small" id="cuentacontable" value="<?php echo $listarCuentaContableProductos[0]->codigo_cuenta_contable;?>" maxlength="255" readOnly /><!--codigo de la cuenta contable-->
						  <B>Nombre: </B><input name="nombrecuentacontable" type="text" class="field text small" id="nombrecuentacontable" value="<?php echo $listarCuentaContableProductos[0]->nombre_cuenta_contable;?>" maxlength="255" readOnly />
						  <a href = "#" onClick="abrirVentanaCuentasContablesNuevaOrdenCompra()" class ="css3button2" style="text-decoration:none">
						  <img src = "<?php echo base_url();?>images/buscar.png" align = middle>
						  </a>
                          <input name="idcuentacontable" type="hidden" class="field text small" id="idcuentacontable" value="<?php echo $listarCuentaContableProductos[0]->id_cuenta_contable;?>" maxlength="255" readOnly /><!--id de la cuenta contable-->

                      </div>
                  </li>
	<input type = "hidden" name ="totalsiniva" id="totalsiniva"  value ="<?php echo $totalNeto;?>" readOnly><!--total del neto-->
	<input name="idcompra" type="hidden" value ="<?php echo $this->uri->segment(3,0);?>"  class="field text small" id="idcompra" value="" maxlength="255" readOnly /><!--id de la compra pra enviarlo por post-->
	<br>
	<br>
	<label class="desc">Observaciones:<span class="req">*</span></label>
                      <div>
	<textarea name ="observaciones" cols ="50" rows ="5" id ="observaciones"><?php echo $listarCuentaContableProductos[0]->observaciones;?></textarea>
	</div>
	<br>
  <input type = submit name=boton value ="Guardar Cambios" class =css3button2>
</form>
</fieldset>
<?php
}
?>
 </div>
 