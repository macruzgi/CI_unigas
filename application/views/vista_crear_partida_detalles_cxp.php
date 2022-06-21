<?php 
header('Content-Type: text/html; charset=UTF-8'); 
?>

 
 
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
background:#A65B1A;
color:#FFFFFF;
}
#shade
{
background-color:#00CCFF;

}


</style> 

<head>
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
<i>Navegaci&oacute;n: Banco | Cheque | Contabilizar Cheque CXP</i>
</span>
<hr>
<?php
 //print_r($abonosAgregados);
$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(4,0);
if($segmento == 1029)
{
  $claseEstilo = "error_box";
  $mensaje = "ERROR INESPERADO";

}

?>
<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>
  <br>
 <!--a href="<?php echo base_url();?>micontrolador/EliminarDetallesPartidas/<?php echo $idPartida = $this->uri->segment(3,0);?>"><img src="<?php echo base_url();?>images/eliminar.png" border="0" title="Eliminar Pedido"></a-->
 
<div align = center>

<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaBuscarCuentasContables/<?php echo $idPartida  = $this->uri->segment(3,0);?>"> <img src = "<?php echo base_url();?>images/buscar.png" title = "Buscar Cuenta" align = middle></a>
<br>
<br>
</div--->
<div class="datagrid">
<form action ="<?php echo base_url();?>micontrolador/GuardarYcontabilizarCXP/<?php echo $idPartida = $this->uri->segment(3,0);?>/" method = "POST">
<table>
<table class="tablecss" width="95%" border="1">
<thead class="odd">
<tr>
  <th>ID PARTIDA</th>
  <th>Correlativo</th><th>Concepto partida</th></tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php
foreach($listarPartidaNoProcesadaCheque as $partidaEncontrada):
?>
   <td><?php echo $partidaEncontrada->id;?></td>
   <td><?php echo $partidaEncontrada->correlativo;?></td>
   <td><?php echo $partidaEncontrada->concepto;?></td>
   

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>
<?php endforeach;?>
</tbody>
</table></div>

<br>
<br>
<div class="datagrid">
<table class="tablecss" width="95%" border="1">
<thead class="odd"><tr>
  <th>C&oacute;digo</th>
  <th>Cuenta</th>
  <th>Concepto</th>
  <th>Debe/Cargos</th>
  <th>Haber/Abonos</th>
  </tr></thead>

<tbody>

<h1>Detalle de la partida</h1>

<?php
//print_r($cuentasAlaPartida);

foreach($listarPrimerDetallePartida as $primerDetalleEncontrado){
?>
 <td><?php echo $primerDetalleEncontrado->codigocuenta;?></td>
   <td><?php echo $primerDetalleEncontrado->nombrecuenta;?></td>
   <td>
     <input type = text size = 42 value="<?php echo $primerDetalleEncontrado->concepto;?>" name = concepto readonly>
      
   </td>
  <td>
    <?php echo $primerDetalleEncontrado->cargo;?>
  </td>
   <td><?php echo $primerDetalleEncontrado->abono;
   ?></td>
<?php
$sumaCargos = 0;
$sumaAbonos = 0;
foreach($listarDatosCuentaProveedorServicios as $proveedorEncontrado){ 
?>

 <tr> 
  
   <td><?php echo $proveedorEncontrado->codigo;?></td>
   <td><?php echo $proveedorEncontrado->nombre;?></td>
   <?php
    //if($cuentaAlaPartidaEncontradas["conceptoDetalle"] != "")
     // {
      
   ?>
      <td> 
      <input type = text size = 42 value="<?php echo $primerDetalleEncontrado->concepto;?>" name = conceptodecuenta>
    <input type = hidden value = "<?php echo $idDelcheque = $this->uri->segment(4,0);?>" name = idcheque readonly>
   </td>
   <td><input type = text name = cargo size = 10 value = "<?php echo $primerDetalleEncontrado->abono;?>" style="border: 1px solid black;" readonly></td>
   <td><input type = text name = abono size = 10 value = "<?php echo $primerDetalleEncontrado->cargo;?>" style="border: 1px solid black;" readonly>
   </td>
  

  </tr>

 

<?php 
  }
  }
 $totalAbonos = $sumaAbonos + $primerDetalleEncontrado->abono;
 $totalCargos = $sumaCargos + $primerDetalleEncontrado->abono;
 $diferencia  = $totalAbonos - $totalCargos;

?>
<tfoot>
  <tr>
   
    <td colspan="7" align = right>
     
            <font color = black>Cargos:$ <?php echo $totalCargos;?>
          
           Abonos:$ <?php echo $totalAbonos;?></font>
          
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class = diferencia>Diferencia:$ <?php echo $diferencia;?></span>
      
  </td>
  </tr>
</tfoot>
</tbody>
 

</table></div>


<br>
<br>
<?php 
if($diferencia == 0)
{
?> 
<!--a href = "<?php echo base_url();?>micontrolador/GuardarYcontabilizar/<?php //echo $idPartida = $this->uri->segment(3,0);?>/" class = css3button2>Guardar y Contabilizar</a-->

  <input type = hidden value = "<?php echo $totalCargos;?>" name = "totalcargos">
  <input type = hidden value = "<?php echo $totalAbonos;?>" name = "totalabonos">
  <input type = submit name=boton value ="Guardar y Contabilizar" class =css3button2>
</form>
<?php
}
?>
<br>
<br>
</div>