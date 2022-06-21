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
          
				        "required,categoria,La categoria no existe.",
						"required,codigoproductoservicio,Escriba el código del producto/servicio.",
						"required,unidad,Escriba la unidad del producto/servicio 0 si no aplica.",
						"required,costo,Escriba el coso del producto $.",
						"required,descripcion,Debe escribir alguna descripción."
					      
                            
            ]
        });
    });



</script>
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
var cajabusqueda = $(this).val();
var dataString = 'buscarpalabra='+ cajabusqueda;

if(cajabusqueda=='')
{
}
else
{

$.ajax({
type: "POST",
url: "<?php echo base_url();?>micontrolador/InteractivoVerSiExisteProductoServicio/", 
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
<script src="<?php echo base_url();?>js/jquery.validator.js"></script>

<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>js/wufoo.js"></script>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
 <script type="text/javascript">
<!--
function EnviarDatoAlaCajaDeTextoBusquedaInteractiva(codigoProductoServicio)
	{
		if (window.opener && !window.opener.closed)//si la popu esta avierda y si no esta en proceso de cerrarse
		{
			window.opener.document.getElementById('cajabusqueda').value = codigoProductoServicio;//le mando el valor al value de la caja de texto con id cajabusqueda
			window.opener.document.getElementById("cajabusqueda").focus();//pongo foco en la caja de texto con id
			//cajabusqueda
			window.close();//cierro la popup
		}
	}
//-->
</script>
<title>UNIGAS | El Salvador</title>
</head>

<hr>
<span class = navegacion>
<i>Nuevo Producto/Servicio</i>
</span>
<hr>
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
elseif($segmento == 1030)
{	
   
   $claseEstilo = "error_box";
   $mensaje = "El c&oacute;digo ingresado ya existe.";
   
}
elseif($segmento == 1029)
{
   $idDeDondeSeCreaElProductoServicio  = $this->uri->segment(3,0);
 
   $codigoProductoServicio = $this->uri->segment(5,0);
   $claseEstilo = "valid_box";
   $mensaje = "Producto/servicio guardado correctamente.";
   
     if($idDeDondeSeCreaElProductoServicio == 2)//se abrio la popup desde el modulo compras
											  //y desde la agregarcion de detalles a la onden de compra
											  //o de la edicion de los detalles de compra
											  //ejecuto esta funcion que pone el codio del producto servicio
											  //en la caja de texto busqueda de la vista correspondiente
		{
				 print "<script>
							EnviarDatoAlaCajaDeTextoBusquedaInteractiva('$codigoProductoServicio');
						</script>
						";
		
?>
				
<?php
		}
}
?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<fieldset class = fieldset1>
<legend class = legend1>Nuevo Producto/Servicio</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarProductoServicio/" name = "cuentabancos">
		 
                  
					<br>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
				<td align = center colspan ="2">		
                <li>
				
                    <label class="desc">C&oacute;digo (solo n&uacute;meros):<span class ="req">*</span></label>
                    <div>
					<!--pra mostrar la busqueda intereactiva-->
				 <div  style=" padding:6px; height:23px;;   background: left no-repeat #RED ">

				<div style=" width:300px; float:center; margin-right:30px" align="left">
				<input type="text" class="buscar" id="cajabusqueda" name = "codigoproductoservicio" />
				
				<div id="display">
				</div>

				</div>

				</div>
				<div style="margin-top:20px; margin-right:20px">



				</div>

				<!--fin de mostrar la busqueda interactiva-->
					</div>
                </li>
			</td>
			
		<tr>
		<!--campos hidden-->
				<input name="iddedondesecreaelproductoservicio" type="text" size =25  id="iddedondesecreaelproductoservicio" value = "<?php echo $this->uri->segment(3,0);?>" readonly maxlength="255"/><!--id de desde donde se esta creando el producto o servicio 1 bodega y 2 par el modulo de comrpas-->
			   
			   
				<?php
				  $desdeQueVistaSeCrea	= $this->uri->segment(3,0);
				  if($desdeQueVistaSeCrea == 2)//es desde el modulo compras la categoria sera 2 agregar detalles de productos y de la vista de la edicion de los detalles de productos en la orden de compra
					{
						$categoria = 2; //es servico o producto desde modulo compras
					}
				else
					{
						$categoria = 1; //es de bodega
					}
					
				?>
				<!--la cotegoria de materiales 1 materiales de boda y 2 producto o servicios de compras-->

				<!--fin campos hidden ocultos-->
			
			<td align = "left" width = "45%">		
                <li>
				
                    <label class="desc">Categor&iacute;a:<span class="req">*</span></label>
                    <div>
					
						<select name = "categoria">
							<option value = "1">Producto</option>
							<option value ="2">Servicio</option>
						</select>
					</div>
                </li>
			</td>
			<td align = center width="45%">		
                <li>
				
                    <label class="desc">Unidad:<span class="req">*</span></label>
                    <div>
					<input name="unidad" type="text"  class="field text medium"  id="unidad"  maxlength="255"/>

					</div>
                </li>
			</td>
         </tr>
		 <tr>
			<td align = "left">		
                <li>
				
                    <label class="desc">Costo $:<span class="req">*</span></label>
                    <div>
					<input name="costo" type="text"  class="field text medium"  id="costo"  maxlength="255" />
					

					</div>
                </li>
			</td>
		   <td align = center>		
                <li>
				
                    <label class="desc">Descripci&oacute;n:<span class="req">*</span></label>
                    <div>
					<textarea name ="descripcion" cols = "25" rows ="8"></textarea>
					

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
 