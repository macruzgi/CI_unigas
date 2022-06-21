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


<!--funcion que redireciona despues que imprime-->
<script>
setTimeout("print();",1500);
setTimeout("window.close();",3000);
</script>

</head>
<?php
if(count($listarDatosParaImprimirChequeProcesado)>0)//si hay resultados
{
function numAletras($num, $fem = false, $dec = true) { 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis"; 
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 
	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 
	
	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	   
	   //Zi hack
	   $float=explode('.',$num);
	   $num=$float[0];
	
	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
		  $neg = 'menos '; 
		  $num = substr($num, 1); 
	   }else 
		  $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
		  $n = $num[$c]; 
		  if (! (strpos(".,'''", $n) === false)) { 
			 if ($punt) break; 
			 else{ 
				$punt = true; 
				continue; 
			 } 
	
		  }elseif (! (strpos('0123456789', $n) === false)) { 
			 if ($punt) { 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			 }else 
	
				$ent .= $n; 
		  }else 
	
			 break; 
	
	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
		  $fin = ' coma'; 
		  for ($n = 0; $n < strlen($fra); $n++) { 
			 if (($s = $fra[$n]) == '0') 
				$fin .= ' cero'; 
			 elseif ($s == '1') 
				$fin .= $fem ? ' una' : ' un'; 
			 else 
				$fin .= ' ' . $matuni[$s]; 
		  } 
	   }else 
		  $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
		  $ent = substr($ent, 0, -3); 
		  if (++$sub < 3 and $fem) { 
			 $matuni[1] = 'una'; 
			 $subcent = 'as'; 
		  }else{ 
			 $matuni[1] = $neutro ? 'un' : 'uno'; 
			 $subcent = 'os'; 
		  } 
		  $t = ''; 
		  $n2 = substr($num, 1); 
		  if ($n2 == '00') { 
		  }elseif ($n2 < 21) 
			 $t = ' ' . $matuni[(int)$n2]; 
		  elseif ($n2 < 30) { 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  }else{ 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  } 
		  $n = $num[0]; 
		  if ($n == 1) { 
			 $t = ' ciento' . $t; 
		  }elseif ($n == 5){ 
			 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
		  }elseif ($n != 0){ 
			 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
		  } 
		  if ($sub == 1) { 
		  }elseif (! isset($matsub[$sub])) { 
			 if ($num == 1) { 
				$t = ' mil'; 
			 }elseif ($num > 1){ 
				$t .= ' mil'; 
			 } 
		  }elseif ($num == 1) { 
			 $t .= ' ' . $matsub[$sub] . '?n'; 
		  }elseif ($num > 1){ 
			 $t .= ' ' . $matsub[$sub] . 'ones'; 
		  }   
		  if ($num == '000') $mils ++; 
		  elseif ($mils != 0) { 
			 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
			 $mils = 0; 
		  } 
		  $neutro = true; 
		  $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   //Zi hack --> return ucfirst($tex);
	   $end_num=ucfirst($tex).' '.$float[1].'/100';
	   return $end_num; 
	}  
$listarDatosParaImprimirChequeProcesado[0]->id_cheque;
 
 //yyy/m/d
function dater($x,$tipoLitras) {
   $year = substr($x, 0, 4);
   $mon = substr($x, 5, 2);
   switch($mon) {
      case "01":
         $month = "Enero";
         break;
      case "02":
         $month = "Febrero";
         break;
      case "03":
         $month = "Marzo";
         break;
      case "04":
         $month = "Abril";
         break;
      case "05":
         $month = "Mayo";
         break;
      case "06":
         $month = "Junio";
         break;
      case "07":
         $month = "Julio";
         break;
      case "08":
         $month = "Agosto";
         break;
      case "09":
         $month = "Septiembre";
         break;
      case "10":
         $month = "Octubre";
         break;
      case "11":
         $month = "Noviembre";
         break;
      case "12":
         $month = "Diciembre";
         break;
   }
   $day = substr($x, 8, 2);
   if($tipoLitras == 1)
    {
      return $day." de ".$month." de ".$year;
    }
   else
    {
        return "&nbsp;".$day."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;".$month."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;".$year;
    }
}

?>



<div align = center>
    <table style="border:1px solid #000;" border = "0" width = 90% class = gridtable>
<td colspan =2 align = center> 
Documento de Transferencia
<hr style="border:1px solid #000;" />
</td>
</tr>
<tr>

    
        <td style="text-align:left" height = "25" width=84%>
          &nbsp;&nbsp; &nbsp; &nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
          
           Quezaltepeque, <?php echo dater($listarDatosParaImprimirChequeProcesado[0]->fecha_emision, 1);?>
        </td>

        <td style="text-align:left;">
          Por $ <?php echo $listarDatosParaImprimirChequeProcesado[0]->monto_cheque;?>
        </td>
   </tr>     
 <tr>
          <td style="text-align:letf"  colspan = 2>
           &nbsp;&nbsp; &nbsp; &nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
          
          A favor de: &nbsp;<?php echo $listarDatosParaImprimirChequeProcesado[0]->a_nombre_de;?> *********************
        </td>
</tr>
        
        <tr>
          <td style="margin: 30px; text-align:left"  colspan = 2 >
 
          
          &nbsp;&nbsp; &nbsp; &nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;
         
          <?php
           echo numAletras($listarDatosParaImprimirChequeProcesado[0]->monto_cheque);
          ?> &nbsp;*******************

       
        </td>
        
        </tr>

</table>
<br>
<br>
<div align = center>
       <table style="border:1px solid black;" width = 90% class = gridtable border =1>
		<tr>
        
          <td width="76%" class = celda>
          <b>Concepto:</b>&nbsp;
          <?php 
		  $textoLargo = $listarDatosParaImprimirChequeProcesado[0]->concepto;
			$largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			$rompeLineas = '</br>';
			$romper_palabras_largas = true; // rompe una palabra si es demacido larga
		   echo wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
			
		  //echo $listarDatosParaImprimirChequeProcesado[0]->concepto;?>
          
          </td>
          <td colspan =2>
        
			<b>Fecha:</b> &nbsp;
           <?php echo $listarDatosParaImprimirChequeProcesado[0]->fecha_emision;?>
          </td>
        </tr>
        <tr>
        
          <td class = celda colspan = 2>
            <b>ID partida:</b> &nbsp; 
           <?php echo $listarDatosParaImprimirChequeProcesado[0]->id;?>  
            &nbsp;
            &nbsp;
            <b>Correlativo:</b> &nbsp; 
           <?php echo $listarDatosParaImprimirChequeProcesado[0]->correlativo;?>
          &nbsp;&nbsp; <b>Tipo partida:</b> &nbsp;
           <?php echo $listarDatosParaImprimirChequeProcesado[0]->codigo." - ".$listarDatosParaImprimirChequeProcesado[0]->descripcion;?>
             
          </td>
          
        </tr>
        <tr>
        <td>
        
        <b>Nombre:</b> 
       
             <?php echo $listarDatosParaImprimirChequeProcesado[0]->a_nombre_de;?>
          </td>
          <td align = right>
            <b>Tranferencia No.:</b>
           
          
             <?php echo $listarDatosParaImprimirChequeProcesado[0]->id_cheque;?>
          </td>
        </tr>
      </table>
    </div> 

 <div align = center>
      <table border = "1" width = 90% class = gridtable>
        
        <tr>
        <td><b>Cuenta</b> 
        </td>
        <td><b>Concepto</b> 
        </td>
        <td> <b>Cargos </b>
        </td>
        <td><b>Abonos</b> 
        </td>
      
        </tr>
        <tr>
        <?php
      
          foreach($listarPartida as $partida):
        ?>
          <td><?php echo $partida->codigocuenta;
		  ?></td>
          <td><?php 
		  echo $partida->nombrecuenta."<br>";
		  $textoLargo = $partida->concepto;
			$largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			$rompeLineas = '</br>';
			$romper_palabras_largas = true; // rompe una palabra si es demacido larga
		   echo wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
		  
		  //echo $partida->concepto;
		  
		  ?></td>
          <td align = right>
			<?php 
				if($partida->cargo > 0)
					{
						echo $partida->cargo;
					}
				else
					{
						echo "&nbsp;";//imprimo un espacio en blanco
					}
			?>
		</td>
          <td align = right>
		  <?php
			if($partida->abono > 0)
				{
					echo $partida->abono;
				}
			else
				{
					echo "&nbsp;";//imprimo un espacio
				}
		  ?>
		 </td>
         
          </tr>
         
          <?php
           endforeach;
          ?>
          <tr>
			
            <td colspan = 4 align = right>
			<b>Total</b>
			&nbsp;
            &nbsp;
			&nbsp;
            &nbsp;
			&nbsp;
            &nbsp;
			&nbsp;
            &nbsp;
			&nbsp;
            &nbsp;
            <?php echo $listarDatosParaImprimirChequeProcesado[0]->monto_cheque;?>
            </td>
          </tr>
          <tr height = "150">
          </tr>
          
      </table>
      
    </div> 
   <div align = center>
        <table border = 0 width = 90% class = gridtable>
         <tr>
          <td align = center><?php echo $listarDatosParaImprimirChequeProcesado[0]->nombre_digitador;?></td>
          <td align = center><?php echo $listarDatosParaImprimirChequeProcesado[0]->nombre_revisa_cheque;?></td></td>
          <td align = center><?php echo $listarDatosParaImprimirChequeProcesado[0]->nombre_autoriza;?></td></td>
          <!--td align = center><?php echo $this->session->userdata("username");?></td></td-->
      
          
          </tr>
        <tr height =30>
          <td align = center>Hecho por </td>
          <td align = center>Revisado por</td>
          <td align = center>Autorizado por </td>
          <!--td align = center>Contabilizado por</td-->
        </tr>
       
       
      </table>
    </div>
</div>
<?php
}
else
	{
		echo "<b><i>LA TRANSFERENCIA NO EST&Aacute; CONTABILIZADA";
	}
?>