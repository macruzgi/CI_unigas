<?php 
 header('Content-Type: text/html; charset=UTF-8');
	?>

<head>
<link href="<?php echo base_url();?>css/MisEstilos.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>js/jquery-1.4.2.min.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
function evniarDatosProveedoesApaginaPadre(symbol) {
  if (window.opener && !window.opener.closed)
    //cuentabancos es el nombre del formulario padre
    //codigo y anombrede son los nombre de los campos
    //que quiero que se llenen en el formualrio padre
     window.opener.document.cuentabancos.codigo.value = symbol;
     window.close();
}
// -->
</SCRIPT>
 
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>js/wufoo.js"></script>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
<title>UNIGAS | El Salvador</title>
</head>

<hr>
<span class = navegacion>
<i>Listado de Porductos/servicios</i>
</span>
<hr>
 <br>
 	<form class="wufoo" action="<?php echo base_url();?>micontrolador/BuscarProductos/" method = "POST">
	<table width="100%">
	<tr><td align="center">Filtro</td><td><input type="text" name="filtro" id="filtro" class="field text medium" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btTxtLess" value="Buscar"/></td></tr>
	</table>
	</form>
<div class="datagrid">
<table class="tablecss" width="95%" border="0">
<thead class="odd">
<tr><th>Id</th><th>Codigo</th><th>Descripcion</th>
<th>Seleccione</th></tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php
if(isset($_POST["filtro"]))
{
foreach($listarMateriales as $materialesEncontrados):
?>
  <td><?php echo $materialesEncontrados->id;?></td>
   <td><?php echo $materialesEncontrados->codigo;?></td>
   <td><?php echo $materialesEncontrados->descripcion;?></td>
   <td>
      <a HREF="javascript:evniarDatosProveedoesApaginaPadre('<?php echo $materialesEncontrados->codigo;?>')">
      <font color = red>Seleccionar</font></a>      
   </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
<?php endforeach;
}
?>
</tbody>
</table></div>