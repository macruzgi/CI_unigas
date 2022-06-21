<?php

?>


<hr>
<span class = navegacion>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevoCheque/">Nuevo Cheque </a> | 
</span>
<hr>

<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/BuscarCuentasBancos/">
<li>
                    <label class="desc">Digite el # del cheque o el nombre de quien fue emitido</label>
                    <div>
                        <input name="textbox1" type="text" class="field text medium" id="textbox1" value="" maxlength="255" size = 60/>
                   <input type = submit name = buscar value = "Buscar">
                    </div>
                </li>
<br>

</form>

<div class="datagrid"><table>
<thead><tr><th>header</th><th>header</th><th>header</th><th>header</th></tr></thead>
<tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot>
<tbody><tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
<tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
<tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
<tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
<tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
</tbody>
</table></div>

</div>