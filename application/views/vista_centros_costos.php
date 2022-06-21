<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<head>

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
<h1>Centros de Costos</h1>
 <?php
$segmento = $this->uri->segment(3,0);
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

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaMateriales/">

<li>
                    <label class="desc">Deigite lo que se le sugiere para filtrar</label>
                    <div>
                    
					Nombre o C&oacute;digo de centro de costo:  <input name="filtro" type="text" size ="50"  id="filtro"  maxlength="255"/>
                    <!--Categor&iacute;a: <select name ="categoria">
                       <option value ="0">Elija...</option>
					   <option value ="1">Productos</option>
					   <option value ="2">Servicios</option>
                      
                    </select-->
                    
                     
                   <input type = "submit" name = "buscar" class = "btnbuscar" value = "">
                    </div>
                </li>
<br>

</form>
<br>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevoCentroCosto/">
				<img src = "<?php echo base_url();?>images/edit_add.png" title = "Agregar nuevo Centro Costo"></a>

<br>
<br>
<div class="datagrid"><div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>C&oacute;digo</th>
    <th>Descripci&oacute;n</th>
	<th>Acci&oacute;n</th>
  </tr>
</thead>
<tbody>
<tr>   
<?php
if(isset($_POST["filtro"]))
{


foreach($listarMaterialesCentrosCostos as $centrosCostosEncontrados):

?>
  <td><?php echo  $centrosCostosEncontrados->id;?></td>
   <td><?php echo $centrosCostosEncontrados->codigo;?></td>
   <td><?php echo $centrosCostosEncontrados->descripcion;?></td>
  
   

    <td align = "center">
		<a href = "<?php echo base_url();?>micontrolador/VistaModificarCentroCosto/<?php echo $centrosCostosEncontrados->id."/".time();?>/">
				<img src = "<?php echo base_url();?>images/Notes.png" title = "Editar"></a>
    </td>

  </tr>

<?php endforeach;?>
</tbody>

<?php
}
?>
</table></div>
<?php

$segmento = $this->uri->segment(3,0);
if($segmento == 1029)
{

?>
 <script>alert('La operacin a sido gurdada exitosamente, se han modificado los datos.')
 window.location = "<?php echo base_url();?>micontrolador/VistaCentroCostos/";
 </script>
<?php
   
}
?>
</div>              