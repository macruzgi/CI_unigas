
<?php 


?>
 
<div align = center>
<div class="datagrid"><div class="datagrid"><table class="tablecss" width="80%" border="1">
<thead class="odd"><tr>
<th>No. Che.</th>
<th>A nombre de</th>
<th>Fecha emisi&oacute;n</th>
<th>Valor</th>
<th>CONCILIADA</th>
</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php

foreach($listarDatosParaConciliar as $datosEcnontrados):
?>
  <td><?php echo $datosEcnontrados->numero_cheque;?></td>
   <td><?php echo $datosEcnontrados->a_nombre_de;?></td>
   <td><?php echo $datosEcnontrados->fecha_emision;?></td>
   <td><?php echo $datosEcnontrados->monto_cheque;?></td>
    <td align = center>
      <input type='checkbox' name='seleccion[]' value='<?php echo $datosEcnontrados->id_cheque.",".$datosEcnontrados->numero_cheque;?>' checked>
      <input type='hidden' name='idtransCheqe[]' value='<?php echo $datosEcnontrados->id_cheque;?>' id = "idtransCheqe">
      <!--el textbox hidden name=idtransCheque[] no lo ocupo el problem ade mandar para
      ver si se conciliaba o no lo arregle de otra manera
      lo dejo ak pora no ir a buscar al controlador y quitar el post
      de la vaiable que manda pero no se ocupa para nada-->
    </td>
  </tr> 
<?php endforeach;

?>
</tbody> 
</table></div>

</div>
<br>
<?php
if(count($listarDatosParaConciliar)>0)//si hay registros que muetre los botones de guardar
{
?>
 <div align = center> 
         
                  <input type="submit" name="" class="css3button2" value = Guardar>
                  <button type="button" name="" value="" class="css3button">Cancelar</button>
          </div>
<?php
 }
?>

 