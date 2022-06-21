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
 
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>js/wufoo.js"></script>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
<title>UNIGAS | El Salvador</title>
</head>

<hr>
<span class = navegacion>
<i>Listado de Cuentas Contables</i>
</span>
<hr>
  <br>
 

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/VistaBuscarCuentasContables/">
<li>
                    <label class="desc">Digite el nombre de la cuenta o el c&oacute;digo de la cuenta <span class="req"></span></label>
                    <div>
                        <input name="filtro" type="text" class="field text medium" id="textbox1" value="" maxlength="255" size = 60/>
                   <input type = submit name = buscar value = "" class = btnbuscar>
                    </div>
                </li>
<br>

</form>
<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->
<div class="datagrid">
<table class="tablecss" width="95%" border="0">
<thead class="odd">
  <tr>
    <th>ID</th>
    <th>C&oacute;digo</th>
    <th>Cuenta Contable</th>
    <th>Acci&oacute;n</th>
  </tr>
</thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>   
<?php
if(isset($_POST["filtro"]))
{
foreach($listarCuentasContables as $cuentasContablesEncontradas):
?>
  <td><?php echo $cuentasContablesEncontradas->id;?></td>
   <td><?php echo $cuentasContablesEncontradas->codigo;?></td>
   <td><?php echo $cuentasContablesEncontradas->nombre;?></td>
   <td>
      <a HREF="javascript:evniarDatosCuetnasCoApaginaPadre('<?php echo $cuentasContablesEncontradas->id;?>', '<?php echo $cuentasContablesEncontradas->codigo;?>', '<?php echo $cuentasContablesEncontradas->nombre;?>')">
      Seleccionar
    </a>
      
    </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
<?php endforeach;?>
</tbody>
<?php 
}
?>
</table></div>

</div>