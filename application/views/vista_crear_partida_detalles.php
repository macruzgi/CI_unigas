<?php 
header('Content-Type: text/html; charset=UTF-8');
@session_start();
			if(isset($_SESSION["cuentasAlaPartida"]) || is_array($_SESSION["cuentasAlaPartida"])) {
			   $cuentasAlaPartida= $_SESSION["cuentasAlaPartida"];
							}
 /*$datosAguardarDetalle = array(
               //tabla detalle_venta_modulo
              "codigo_venta"    => 1,
              "codigo_producto" =>2,
              'cantidad'        => 3//["cantidad"] es el índice del array
              );*/
//print_r($datosAguardarDetalle);
//echo "<br>".$datosAguardarDetalle["codigo_venta"];//["codigo_venta"];
?>

 
 <script type="text/javascript" src="<?php echo base_url();?>jsBusqueda/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jsBusqueda/jquery.watermarkinput.js"></script>
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
var idPartida = document.getElementById("idpartida").value;
var idCheque = document.getElementById("idcheque").value;
var cajabusqueda = $(this).val();
var dataString = 'buscarpalabra='+ cajabusqueda;

if(cajabusqueda=='')
{
}
else
{

$.ajax({
type: "POST",
url: "<?php echo base_url();?>micontrolador/Interactivo/" + idPartida + "/" + idCheque,
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
BACO::
<a href ="<?php echo base_url();?>micontrolador/VistaBanco/">Banco </a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/">Nueva Cuenta </a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaCheque/">Cheques </a>|
<a href ="<?php echo base_url();?>micontrolador/VistaTransacciones/">Transacciones </a> |
<a href ="<?php echo base_url();?>micontrolador/VistaListarConciliacinesFormulario/">Conciliaci&oacute;n </a>|
<a href ="<?php echo base_url();?>micontrolador/VistaReportes/">Reportes</a>
</span>

<h1>Contabilizar Cheque</h1>

<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(4,0);
if($segmento == 1029)
{
  $claseEstilo = "error_box";
  $mensaje = "ERROR INESPERADO";

}
if(count($listarPrimerDetallePartida) > 0)
{

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
<thead class="odd">
<tr>
  <th>C&oacute;digo</th>
  <th>Cuenta</th>
  <th>Concepto</th>
  <th>Debe/Cargos</th>
  <th>Haber/Abonos</th>                 
  <th>Acci&oacute;n</th>
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
<form action = "<?php echo base_url();?>micontrolador/AgregarCuentasAlaPartida/<?php echo $cuentaAlaPartidaEncontradas["codigo"];//eso para que uando le de enter se vala el código del producto correspondiente a cada caja de texto?>/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>" METHOD = POST>
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
   <td width = "12%">
    <input type = submit name = boton value = Aplicar>
   &nbsp;&nbsp;
    <a href = "<?php echo base_url();?>micontrolador/EliminarLineaDetallesPartidas/<?php  echo $cuentaAlaPartidaEncontradas["codigo"];?>/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>/">
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
   
     <td colspan="3" align = center>
    

              <a href="<?php echo base_url();?>micontrolador/EliminarDetallesPartidas/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>"><img src="<?php echo base_url();?>images/error.png" border="0" title="Eliminar Detalles" align = middle></a>
      

              <a href ="<?php echo base_url();?>micontrolador/VistaBuscarCuentasContables/<?php echo $idPartida  = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>"> <img src = "<?php echo base_url();?>images/buscar.png" title = "Buscar Cuenta" align = middle></a>
      </td>
      <td colspan="3" align = right>   
             <font color = black>Cargos:$ <?php echo $totalCargos;?>
         
           Abonos:$ <?php echo $totalAbonos;?></font>
          
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class = diferencia>Diferencia:$ <?php echo $diferencia;?></span>
       
  </td>
  </tr>
</tfoot>
</tbody>
 

</table></div>
<!--pra mostrar la busqueda intereactiva-->
 <div  style=" padding:6px; height:23px;;   background: left no-repeat #RED ">

<div style=" width:300px; float:center; margin-right:30px" align="left">
<span class = "interacitvo">Buscar cuenta:</span><input type="text" class="buscar" id="cajabusqueda" />
<input type="hidden"  id="idpartida" value="<?php echo $this->uri->segment(3,0);?>" />
<input type="hidden"  id="idcheque" value="<?php echo $this->uri->segment(4,0);?>" /><br /><br />

<div id="display">
</div>

</div>

</div>
<div style="margin-top:20px; margin-left:20px">



</div>

<!--fin de mostrar la busqueda interactiva-->
<br>
<br>
<?php 
if($diferencia == 0)
{
?> 
<!--a href = "<?php echo base_url();?>micontrolador/GuardarYcontabilizar/<?php //echo $idPartida = $this->uri->segment(3,0);?>/" class = css3button2>Guardar y Contabilizar</a-->
<form action ="<?php echo base_url();?>micontrolador/GuardarYcontabilizar/<?php echo $idPartida = $this->uri->segment(3,0)."/".$this->uri->segment(4,0);?>/" method = "POST">
  <input type = hidden value = "<?php echo $totalCargos;?>" name = "totalcargos">
  <input type = hidden value = "<?php echo $totalAbonos;?>" name = "totalabonos">
  <input type = submit name=boton value ="Guardar y Contabilizar" class =css3button2>
</form>
<?php
}
}
?>
<br>
<br>
</div>