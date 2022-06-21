<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<head>
<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}

table.gridtable2 {
	font-family: verdana,arial,sans-serif;
	font-size:8px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}

</style>
<?php
$desdeDondeSeEnvioAimprimir = $this->uri->segment(4,0);
if($desdeDondeSeEnvioAimprimir != 2)//se ha mandao a imprimir desde la cracion de la conciliacion
{
?>
<!--funcion que redireciona despues que imprime-->
<script>
setTimeout("print();",1500);
setTimeout("window.location = '<?php echo base_url();?>micontrolador/VistaListarConciliacinesFormulario/'",3000);
</script>
<?php 
}
else//se imprimio desde la vista Listado de conciliaciones
{
?>
<!--funcion que redireciona despues que imprime-->
<script>
setTimeout("print();",1500);
setTimeout("window.close();",3000);
</script>
<?php 
}
?>
</head>


 <?php
 if(count($listarDatosParaImprimirConciliacion) > 0)
 {
 $annio = date("Y");
/*array para buscar y poner en los textbox mes el nombre del mes
segun el numero de la fecha acutal*/
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");

//$numeroMes = date("m");  //busco el numero del mes


$mesAmostrar = $mes[$listarDatosParaImprimirConciliacion[0]->mes-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
$fechaConciliacion = $listarDatosParaImprimirConciliacion[0]->annio."-".$listarDatosParaImprimirConciliacion[0]->mes."-".date("d");  
 ?>
<div align = center>
<table style="width:90%;margin:auto; border:1px solid black;"  align="center"  class = gridtable>
 <tr>
  <td align = right colspan = 5>
    Hoja de conciliaci&oacute;n de la cuenta bancaria:
    <br>
    <?php echo $listarDatosParaImprimirConciliacion[0]->nombre_banco_cuenta." - ".$listarDatosParaImprimirConciliacion[0]->numero_cuenta_bancaria;?> a la fecha: <?php echo $fechaConciliacion;?>
    <br>
    <b>Moneda:</b>US$
  </td>
</tr>
<tr>
  <td colspan = 5>
    <b>A. Saldo Bancario Seg&uacute;n Estado Cuenta</b>
  </td>
</tr>
<tr style="font-weight:bold;">
  <td>
    Banco
  </td>
  <td>
    Cuenta Bancaria
  </td>
  <td>
    Cuenta Contable
  </td>
  <td>
    Fecha
  </td>
  <td>
    Valor
  </td>
</tr>
<tr>
    <td>
      <?php echo $listarDatosParaImprimirConciliacion[0]->nombre_banco_cuenta;?>
  </td>
  <td>
      <?php echo $listarDatosParaImprimirConciliacion[0]->numero_cuenta_bancaria;?>
  </td>
  <td>
      <?php echo $listarDatosParaImprimirConciliacion[0]->codigo;?>
  </td>
  <td>
      <?php echo $fechaConciliacion;?>
  </td>
  <td align = "right">
      <?php echo $listarDatosParaImprimirConciliacion[0]->saldo_banco;?>
  </td>
</tr>
<tr>
  <td colspan = 4> <br>
    <span style ='font-weight:bold;'>-CHEQUES EMITIDOS Y NO COBRADOS</span> <hr style="border:1px solid #000;" />
  </td>
  <td align = "right">
    <span style ='font-weight:bold;'>  <?php echo $listarDatosParaImprimirConciliacion[0]->cheques_pendientes;?></span>
  </td>
 </tr>

 <?php

    //echo "tipo 3 <hr>";
  foreach($listarDatosParaImprimirConciliacion as $filasEncontradas):
  if($filasEncontradas->tipo == 4)
    {
 ?>
   <tr>    
  <td colspan =2><?php echo $filasEncontradas->fecha;?></td>
  <td colspan = 2><?php    echo " ".$filasEncontradas->referencia." ".$filasEncontradas->concepto;?></td>
  <td align = "right"><?php    echo " ".$filasEncontradas->valor;?></td>
   </tr>

<?php
    }
  
 endforeach;
?>

<tr>
  <td colspan = 4> <br>
    <span style ='font-weight:bold;'>+Remesas contabilizadas en el diario, pero a&uacute;n no aplicadas en cuenta</span>
  <hr style="border:1px solid #000;" />
  </td>
  <td align = "right">
    <span style ='font-weight:bold;'>  <?php echo $listarDatosParaImprimirConciliacion[0]->depositos_pendientes;?></span>
  </td>
</tr>

 
 <?php

    //echo "tipo 3 <hr>";
  foreach($listarDatosParaImprimirConciliacion as $filasEncontradas):
  if($filasEncontradas->tipo == 3)
    {
 ?>
  <tr>     
  <td colspan = 2><?php echo $filasEncontradas->fecha;?></td>
  <td colspan =2><?php    echo " ".$filasEncontradas->referencia." ".$filasEncontradas->concepto;?></td>
  <td align = "right"><?php    echo " ".$filasEncontradas->valor;?></td> 
  </tr>
<?php
  }

  endforeach;
?>

<tr>
  <td colspan = 5 align = center> <br><br>
<hr style="border:2px solid #000;" />
<span style ='font-weight:bold;'>Saldo Conciliado a la fecha:<?php echo $fechaConciliacion;?></span>

    <span style ='font-weight:bold;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $<?php echo  $listarDatosParaImprimirConciliacion[0]->saldo_banco - $listarDatosParaImprimirConciliacion[0]->cheques_pendientes;?></span>

<hr style="border:2px solid #000;" />
  </td>
</tr>
<tr>
  <td colspan = 5>
    <b>B. SALDO CONTABLE</b>
   <br><br>
  </td>
  </tr>
<tr  height =50>
  <td colspan = 4>
     <span style ='font-weight:bold;'>Saldo banciario seg&uacute;n Diario</span> 
  </td>
   <td align = right>
    <span style ='font-weight:bold;'>  <?php echo $listarDatosParaImprimirConciliacion[0]->saldo_contable;?></span>
     
  </td>
 
</tr> 

<tr>

  <td colspan = 4>  
    <span style ='font-weight:bold;'>+Remesas pendientes de contabilizar</span><hr style="border:1px solid #000;"/>
  </td>
  <td align = "right">
    <span style ='font-weight:bold;'>  <?php echo $listarDatosParaImprimirConciliacion[0]->depositos_no_contables;?></span>
  </td>
</tr>


 <?php

    //echo "tipo 3 <hr>";
  foreach($listarDatosParaImprimirConciliacion as $filasEncontradas):
  if($filasEncontradas->tipo == 1)
    {
 ?>
  <tr>     
  <td colspan = 2><?php echo $filasEncontradas->fecha;?></td>
  <td colpsan = 2><?php    echo " ".$filasEncontradas->referencia." ".$filasEncontradas->concepto;?></td>
  <td align = "right"><?php    echo " ".$filasEncontradas->valor;?></td>
  </tr>
<?php
  }

   
  endforeach;
?>

<tr>
  <td colspan = 4><br>
    <span style ='font-weight:bold;'>-Cargos en cuenta aun no contabilizados.</span> <hr style="border:1px solid #000;" />
  </td>
  <td align = "right">
    <span style ='font-weight:bold;'>  <?php echo $listarDatosParaImprimirConciliacion[0]->cargos_no_contables + $listarDatosParaImprimirConciliacion[0]->cargos_pendientes;?></span>
  </td>
</tr>

 
 <?php

   
  foreach($listarDatosParaImprimirConciliacion as $filasEncontradas):
  if($filasEncontradas->tipo == 2)
    {
 ?>
  <tr>     
  <td colspan = 2><?php echo $filasEncontradas->fecha;?></td>
  <td colspan =2><?php    echo " ".$filasEncontradas->referencia." ".$filasEncontradas->concepto;?></td>
  <td align = "right"><?php    echo " ".$filasEncontradas->valor;?></td>
  </tr>
<?php
  }

  endforeach;
?>


<?php

   
  foreach($listarDatosParaImprimirConciliacion as $filasEncontradas):
  if($filasEncontradas->tipo == 5)
    {
 ?>
  <tr>     
  <td colspan = 2><?php echo $filasEncontradas->fecha;?></td>
  <td colspan =2><?php    echo " ".$filasEncontradas->referencia." ".$filasEncontradas->concepto;?></td>
  <td align = "right"><?php    echo " ".$filasEncontradas->valor;?></td>
  </tr>
<?php
  }

  endforeach;
?>

 <td colspan = 5 align = center> <br><br>
<hr style="border:2px solid #000;" />
<span style ='font-weight:bold;'>Saldo Conciliado a la fecha:<?php echo $fechaConciliacion;?></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp; 
<span style ='font-weight:bold;'>$<?php echo  ($listarDatosParaImprimirConciliacion[0]->saldo_contable + $listarDatosParaImprimirConciliacion[0]->depositos_no_contables) - ($listarDatosParaImprimirConciliacion[0]->cargos_no_contables + $listarDatosParaImprimirConciliacion[0]->cargos_pendientes);?></span>
<hr style="border:2px solid #000;" />
  </td>
</tr>

 </table>
 <?php 
	}
else
	{
		echo "NO HAY REGISTROS PARA ESTA CONCILIACI&Iacute;N";
	}
 ?>
</div>
         