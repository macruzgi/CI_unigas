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
          
				        "required,codigocentrocosto,Debe digitar un codigo del Centro de Costo",
						"required,descripcion,Debe escribir alguna descripcion."
					      
                            
            ]
        });
    });



</script>
<?php

$segmento = $this->uri->segment(4,0);
$codigoCentroCosto = $this->uri->segment(3,0);
if($segmento == 1029)
{

?>
 <script>
 alert('Se ha creado el nuevo Centro Costo con CODIGO: <?php echo $codigoCentroCosto; ?>')
 </script>
<?php
   
}
elseif($segmento == 1300)  
{
?>
<script>alert('La operación a sido completada, se ha anulado el registro.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
}
elseif($segmento == -1525)  
{
?>
<script>alert('La operación a sido completada, se ha actualizado el cheque.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCheque/";
 </script>
<?php
}
?>

</head>
<hr>
<span class = navegacion>
COMPRAS::
<!--a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> |--> 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a> |
<a href ="<?php echo base_url();?>micontrolador/VistaCentroCostos/">Centros Costos</a>

</span>
<hr>
<h1>Nuevo Centro de Costos</h1>
  <br>
 

<?php

$segmento = $this->uri->segment(4,0);
$claseEstilo = "";
$mensaje = "";
$codigoCentroCosto = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 1030)
{	
   
   $claseEstilo = "error_box";
   $mensaje = "El c&oacute;digo $codigoCentroCosto ya existe.";
   
}

?>

<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
<fieldset class = fieldset1>
<legend class = legend1>Nuevo Centro Costo</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/RegistrarCentroCosto/" name = "cuentabancos">
		 
					<br>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
		<tr>
		
			<td align = center>		
                <li>
				
                    <label class="desc">C&oacute;digo Centro Costo:<span class="req">*</span></label>
                    <div>
					<input name="codigocentrocosto" type="text"  class="field text medium"  id="codigocentrocosto"  maxlength="255"/>

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
			<br>
			<br>
           <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
		  <button type="button" name="" value="" class="css3button" onClick="location.replace('<?php echo base_url();?>micontrolador/VistaCentroCostos/');">Cancelar</button>
		
          </div>
        </form>
       
 </fieldset>
 
 </div>
 