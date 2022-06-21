<?php 
@session_start();
			if(isset($_SESSION["cuentasAlaPartida"]) || is_array($_SESSION["cuentasAlaPartida"])) {
			   $cuentasAlaPartida= $_SESSION["cuentasAlaPartida"];
							}
 $datosAguardarDetalle = array(
               //tabla detalle_venta_modulo
              "codigo_venta"    => 1,
              "codigo_producto" =>2,
              'cantidad'        => 3//["cantidad"] es el índice del array
              );
//print_r($datosAguardarDetalle);
//echo "<br>".$datosAguardarDetalle["codigo_venta"];//["codigo_venta"];
?>
<head>
<style type="text/css">
input:focus
{
border: 1px solid #000000;
background: #F2F5A9;
}}
 </style>
</head>
<hr>
<span class = navegacion>
<i>Navegaci&oacute;n: Banco | Cheque | Contabilizar Cheque</i>
</span>
<hr>
<?php

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
<table>
<thead><tr>
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
<table>
<thead><tr>
  <th>C&oacute;digo</th>
  <th>Cuenta</th>
  <th>Concepto</th>
  <th>Debe/Cargos</th>
  <th>Haber/Abonos</th>
  <th  colspan = 2>Acci&oacute;n</th></tr></thead>

<tbody>

<h1>Detalle de la partida</h1>

<?php
//print_r($cuentasAlaPartida);

foreach($listarPrimerDetallePartida as $primerDetalleEncontrado){
?>
 <td><?php echo $primerDetalleEncontrado->codigocuenta;?></td>
   <td><?php echo $primerDetalleEncontrado->nombrecuenta;?></td>
   <td>
     <input type = text size = 42 value="<?php echo $primerDetalleEncontrado->concepto;?>" name = concepto>
   </td>
  <td>
    <?php echo $primerDetalleEncontrado->cargo;?>
  </td>
   <td><?php echo $primerDetalleEncontrado->abono;
   ?></td>
<?php
$sumaCargos = 0;
$sumaAbonos = 0;
foreach($cuentasAlaPartida as $cuentaAlaPartidaEncontradas){ 
$sumaCargos = $sumaCargos + $cuentaAlaPartidaEncontradas["cargo"];
$sumaAbonos = $sumaAbonos + $cuentaAlaPartidaEncontradas["abono"] ;//+ $primerDetalleEncontrado->abono;
?>
<form action = "<?php echo base_url();?>micontrolador/AgregarCuentasAlaPartida/<?php echo $cuentaAlaPartidaEncontradas["id"];//eso para que uando le de enter se vala el código del producto correspondiente a cada caja de texto?>/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>" METHOD = POST>
 <tr> 
  
   <td><?php echo $cuentaAlaPartidaEncontradas["codigo"];?></td>
   <td><?php echo $cuentaAlaPartidaEncontradas["nombre"];?></td>
   <?php
    //if($cuentaAlaPartidaEncontradas["conceptoDetalle"] != "")
     // {
      
   ?>
      <td> <input type = text size = 42 value="<?php echo $cuentaAlaPartidaEncontradas["conceptoDetalle"];?>" name = conceptoDetalle>
     <?php
     //}
    //else
    //{
     ?>
 <input type = hidden value="<?php echo $primerDetalleEncontrado->concepto;?>" name = conceptoOriginal> <!--est campo es para enviar el concepto original y ponerlo en la demas textbos si no se pone concepto-->
   <?php
   //}
   ?>
   </td>
   <td><input type = text name = cargo size = 10 value = "<?php echo $cuentaAlaPartidaEncontradas["cargo"];?>" style="border: 1px solid black;"></td>
   <td><input type = text name = abono size = 10 value = "<?php echo $cuentaAlaPartidaEncontradas["abono"];?>" style="border: 1px solid black;">
   </td>
   <td>
    <input type = submit name = boton value = Aplicar>
   </td>
   <td>
    <a href = "<?php echo base_url();?>micontrolador/EliminarLineaDetallesPartidas/<?php  echo $cuentaAlaPartidaEncontradas["id"];?>/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>/">
      <img src = "<?php echo base_url();?>images/icondel.png" title = "Eliminar Cuenta">
    </a> 
  </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr>

 
  </form>
<?php 
  }
  }
 $totalAbonos = $sumaAbonos + $primerDetalleEncontrado->abono;
 $totalCargos = $sumaCargos + $primerDetalleEncontrado->cargo;
 $diferencia  = $totalAbonos - $totalCargos;

?>
<tfoot>
  <tr>
   
    <td colspan="7">
      <div id="paging"> 
      
        <ul> 
        <li>
     

              <a href="<?php echo base_url();?>micontrolador/EliminarDetallesPartidas/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>"><img src="<?php echo base_url();?>images/error.png" border="0" title="Eliminar Detalles" align = middle></a>
         </li>
          <li>
     

              <a href ="<?php echo base_url();?>micontrolador/VistaBuscarCuentasContables/<?php echo $idPartida  = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>"> <img src = "<?php echo base_url();?>images/buscar.png" title = "Buscar Cuenta" align = middle></a>
         </li>
          <li>
            <a><span>Cargos:$ <?php echo $totalCargos;?></span></a>
          </li>
          <li>
            <a class="active"><span>Abonos:$ <?php echo $totalAbonos;?></span></a>
          </li>
          <li>
            <a><span>Diferencia:$ <?php echo $diferencia;?></span></a>
          </li>
       </ul>
    </div>
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
<form action ="<?php echo base_url();?>micontrolador/GuardarYcontabilizar/<?php echo $idPartida = $this->uri->segment(3,0);?>/" method = "POST">
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