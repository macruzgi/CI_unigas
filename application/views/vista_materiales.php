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
<h1>Materiales Servicios</h1>
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
                    <label class="desc">Seleccione para filtrar</label>
                    <div>
                    
					Nombre o C&oacute;digo de servicio:  <input name="filtro" type="text" size ="25"  id="filtro"  maxlength="255"/>
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
<a href ="<?php echo base_url();?>micontrolador/VistaNuevoProductoServicioDesdeCompras/">
				<img src = "<?php echo base_url();?>images/edit_add.png" title = "Agregar nuevo Producto"></a>

<br>
<br>
<div class="datagrid"><div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>C&oacute;digo</th>
    <th>Descripci&oacute;n</th>
	<th>Unidad de Medida</th>
    <th>Costo $</th>
    
    <th>Fecha</th>
	<th>Categor&iacute;a</th>
    <th>Usuario</th>
	
    
    <th colspan = 3>Acci&oacute;n</th>
  </tr>
</thead>
<tbody>
<tr>   
<?php
if(isset($_POST["filtro"]))
{


foreach($listarMaterialesServicios as $materialesServiciosEncontrados):

?>
  <td><?php echo  $materialesServiciosEncontrados->id;?></td>
   <td><?php echo $materialesServiciosEncontrados->codigo;?></td>
   <td><?php echo $materialesServiciosEncontrados->descripcion;?></td>
   <td><?php echo $materialesServiciosEncontrados->unidad;?></td>
   <td><?php echo $materialesServiciosEncontrados->costo;?></td>
   <td><?php echo $materialesServiciosEncontrados->fecha;?></td>
   <td><?php 
			if($materialesServiciosEncontrados->categoria == 1)
				{
					echo "PRODUCTO";
				}
			else
				{
					echo "SERVICIO";
				}
   ?></td>
   <td><?php echo $materialesServiciosEncontrados->nombres;?></td>
   
   

    <td>
		<a href = "<?php echo base_url();?>micontrolador/VistaModificarProductoServicioDesdeCompras/<?php echo $materialesServiciosEncontrados->id."/".time();?>/">
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
 <script>alert('La operación a sido gurdada exitosamente, se han modificado los datos.')
 window.location = "<?php echo base_url();?>micontrolador/VistaMateriales/";
 </script>
<?php
   
}
?>
</div>              