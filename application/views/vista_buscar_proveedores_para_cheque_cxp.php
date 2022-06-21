<?php
header('Content-Type: text/html; charset=UTF-8'); 
@session_start();
//PARA MOSTRAR LOS DATOS DE LA SESION
			if(isset($_SESSION["agregarAbonos"]) || is_array($_SESSION["agregarAbonos"])) {
			   $abonosAgregados= $_SESSION["agregarAbonos"];
							}
?>

<head>
<link href="<?php echo base_url();?>css/MisEstilos.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>js/jquery-1.4.2.min.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!-- //sin funcionar esta funcion aun
function evniarDatosProveedoesApaginaPadre(toalAbonos, documento) {
  if (window.opener && !window.opener.closed)
    //cuentabancos es el nombre del formulario padre
    //codigo y anombrede son los nombre de los campos
    //que quiero que se llenen en el formualrio padre
     window.opener.document.cuentabancos.monto.value    = toalAbonos;
     window.opener.document.cuentabancos.concepto.value = documento;
     
     
     window.close();
}
// -->
</SCRIPT>
 
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>js/wufoo.js"></script>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
<title>UNIGAS | El Salvador</title>
<style type="text/css">
input:focus
{
border: 1px solid #000000;
background: #F2F5A9;
}
 </style>
</head>

<hr>
<span class = navegacion>
<i>Listado de Proveedores CXP</i>
</span>
<hr>
 <br>

<div class="datagrid">
<table class="tablecss" width="90%">
<thead class="odd">
<tr><th>C&oacute;digo</th><th>Nomb. Fiscal</th><th>Nomb. Comercial</th>
<th>Telefono</th>
</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php
//print_r($abonosAgregados);
$codigoProveedor = $this->uri->segment(3,0);//para mandarlo al controlador y luego pueda mostrar la vista
$idProveedor     = $this->uri->segment(4,0); //para mandarlo al controlador y luego pueda mostrar la vista
if($codigoProveedor != 000000 && $idProveedor != 000000)
{
foreach($listarProveedorCXP as $proveedoresEncontrados):
?>
  <td><?php echo $proveedoresEncontrados->codigo;?></td>
   <td><?php echo $proveedoresEncontrados->nombrefiscal;?></td>
   <td><?php echo $proveedoresEncontrados->nombrecomercial;?></td>
   <td><?php echo $proveedoresEncontrados->telefono;?></td>
  

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
<?php endforeach;?>
</tbody>
</table></div>

<br>

<div class="datagrid">
<table class="tablecss" width="90%">
<thead class="odd">
<tr>
<th>Doc.</th>
<th>Fecha</th>
<th>Vencimiento</th>
<th>Cargo Orig.</th>
<th>Real</th>
<th>Abono</th>
<th>Referencia</th>
<th>Acci&oacute;n</th></tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>

<?php
foreach($listarCXP as $facturasEncontradas):
?>
<form action = "<?php echo base_url();?>micontrolador/AgregarAbonoAsesion/<?php echo $facturasEncontradas->id."/".$codigoProveedor."/".$idProveedor."/";?>" METHOD = POST>
<tr>
  <td><?php echo $facturasEncontradas->documento;?></td>
   <td><?php echo $facturasEncontradas->fecha;?></td>
   <td><?php echo $facturasEncontradas->fechaquedan;?></td>
   <td><?php echo $facturasEncontradas->cargo;?></td>
   <td><?php 
   $real = $facturasEncontradas->cargo - $facturasEncontradas->abono;
   echo number_format($real,2); ?></td>
   <td><input type = text name = abono size = 20 value="<?php echo number_format($real,2);?>">
        <input type = hidden name = cargo size = 50 value="<?php echo number_format($real,2);?>" readonly></td>
   <td><input type = text name = referencia size = 10 value="Referencia"></td>
   <td>
    <input type = submit name = boton value = Aplicar>
   </td>
 

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
  </form>
<?php endforeach;?>
</tbody>
</table></div>


<br>


<div class="datagrid">
<table class="tablecss" width="90%">
<thead class="odd">
<tr>
  <th>Documento</th>
  <th>Real</th>
  <th>Abono</th>
  <th>Referencia</th>

  <th  colspan = 2>Acci&oacute;n</th></tr></thead>

<tbody>
<div align = center>
<h1>Abonos a Aplicar</h1>
</div>
 <tr> 
<?php
//print_r($cuentasAlaPartida);
$sumaAbonos = 0;
$ducumento = "";
foreach($abonosAgregados as $abonosEnLista)
{
$ducumento  = $ducumento.",".$abonosEnLista["documento"]; 
$sumaAbonos = $sumaAbonos + str_replace(',', '', $abonosEnLista["abono"]);
?>


  
   
   <td><?php echo $abonosEnLista["documento"];?></td>
   <td><?php echo $abonosEnLista["cargo"];?></td>
   <td><?php echo $abonosEnLista["abono"];?></td>
   <td><?php echo $abonosEnLista["referencia"];?></td>

  
 
   <td align = center>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = "<?php echo base_url();?>micontrolador/EliminarLineaAbonoAgregdo/<?php echo $abonosEnLista["id"]."/".$codigoProveedor."/".$idProveedor;?>">
      <img src = "<?php echo base_url();?>images/icondel.png" title = "Quitar">
    </a> 
  </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>

<?php 
  }
 $totalAbonos = number_format($sumaAbonos, 2);
 $losDocumentos = $proveedoresEncontrados->nombrefiscal.", ". "Abono a lo/s documento/s : ".$ducumento. " $ ".$totalAbonos;

?>
<tfoot>
  <tr>
   
    <td colspan="3" align = center>
     
<b>Total Abonos:$ <?php echo $totalAbonos;?></b>
                  
  </td>
<td align = center colspan ="2"> 
	
           <a href="<?php echo base_url();?>micontrolador/EliminarTodosAbonoAgregdo/<?php echo $codigoProveedor."/".$idProveedor."/";?>"><img src="<?php echo base_url();?>images/error.png" border="0" title="Quitar todos" align = middle width = "25"></a>
       
          <input type = "hidden" name = totalabonos id = "totalabonos" size = 35 value = "<?php echo $totalAbonos;?>">    
     
  </td>
  </tr>
</tfoot>
</tbody>
 

</table></div>
<br>
<?php
if($totalAbonos > 0)
{
?>
<div align = center>
 <input type ="button" onClick ="javascript:evniarDatosProveedoesApaginaPadre('<?php echo $totalAbonos;?>', '<?php echo $losDocumentos;?>')" value ="Aplicar Abonos...">
 <!--a HREF="javascript:evniarDatosProveedoesApaginaPadre('<?php //echo $totalAbonos;?>', '<?php //echo $losDocumentos;?>')">
     <b>Aplicar</b></a-->
</div>
<?php
}
}
?>
