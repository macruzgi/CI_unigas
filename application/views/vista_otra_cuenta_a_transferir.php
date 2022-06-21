
<?php 


?>

<b>Cuenta a transferir fondos:</b>
<br>
 <select name = "cuentaOtro" id="cuentaOtro">
                      <?php
                        foreach($listarDatosParaConciliar as $cuentasEncontradas):
                        
                      ?>
                        <option value = <?php echo $cuentasEncontradas->id_cuenta_bancaria;?>><?php echo $cuentasEncontradas->nombre_banco_cuenta." - ".$cuentasEncontradas->numero_cuenta_bancaria?> </option>
                      
                      <?php endforeach;?>
                      </select>




 