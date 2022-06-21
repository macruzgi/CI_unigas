<?php

?>

<!--link type="text/css" href="<?php echo base_url();?>css/solo_para_menu_desplegable.css" rel="stylesheet" /-->
<script type="text/javascript">

$(document).ready(function(){///////////SIN USO TODO ESTO ERA PAR LA PRUEBA DEL MENU DESPLEGABLE
//PERO POR ALGUNOS PARAMETROS QUE HE HECHO NO CONBIENE

	$("#nicemenu img.arrow").click(function(){ 
								
		$("span.head_menu").removeClass('active');
		
		submenu = $(this).parent().parent().find("div.sub_menu");
		
		if(submenu.css('display')=="block"){
			$(this).parent().removeClass("active"); 	
			submenu.hide(); 		
			$(this).attr('src','<?php echo base_url();?>images/arrow_hover.png');									
		}else{
			$(this).parent().addClass("active"); 	
			submenu.fadeIn(); 		
			$(this).attr('src','<?php echo base_url();?>images/arrow_select.png');	
		}
		
		$("div.sub_menu:visible").not(submenu).hide();
		$("#nicemenu img.arrow").not(this).attr('src','<?php echo base_url();?>images/arrow.png');
						
	})
	.mouseover(function(){ $(this).attr('src','<?php echo base_url();?>images/arrow_hover.png'); })
	.mouseout(function(){ 
		if($(this).parent().parent().find("div.sub_menu").css('display')!="block"){
			$(this).attr('src','<?php echo base_url();?>images/arrow.png');
		}else{
			$(this).attr('src','<?php echo base_url();?>images/arrow_select.png');
		}
	});

	$("#nicemenu span.head_menu").mouseover(function(){ $(this).addClass('over')})
								 .mouseout(function(){ $(this).removeClass('over') });
	
	$("#nicemenu div.sub_menu").mouseover(function(){ $(this).fadeIn(); })
							   .blur(function(){ 
							   		$(this).hide();
									$("span.head_menu").removeClass('active');
								});		
								
	$(document).click(function(event){ 		
			var target = $(event.target);
			if (target.parents("#nicemenu").length == 0) {				
				$("#nicemenu span.head_menu").removeClass('active');
				$("#nicemenu div.sub_menu").hide();
				$("#nicemenu img.arrow").attr('src','<?php echo base_url();?>images/arrow.png');
			}
	});			   
							   
								   
});

</script>

<!--div id="nicemenu">
    <ul>
        <li><span class="head_menu"><a href="<?php echo base_url();?>micontrolador/VistaBanco/">Banco</a><img src="<?php echo base_url();?>images/arrow.png" width="18" height="15" align="top" class="arrow" /></span>
            <div class="sub_menu">
                 <a href="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/">Nueva Cuenta</a>
            
            </div>
        </li>
		<li><span class="head_menu"><a href="<?php echo base_url();?>micontrolador/VistaCheque/">Cheques</a><img src="<?php echo base_url();?>images/arrow.png" width="18" height="15" align="top" class="arrow" /></span>
            <div class="sub_menu">
                 <a href="<?php echo base_url();?>micontrolador/VistaNuevoCheque/">Nuevo Cheque</a>
				 <a href = "#" onClick="chequeOtrasfeencia()">Abono a CXP</a>
				 
            </div>
        </li>
    </ul>
</div-->
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
<div align = center>
<form name = buscarCuenta method = "POST" ACITON = "<?php echo base_url();?>micontrolador/BuscarCuentasBancos/">
<li>
                    <label class="desc">Digite el nombre del banco o el # de la cuenta <span class="req"></span></label>
                    <div>
                        <input name="filtro" type="text" class="field text medium" id="textbox1" value="" maxlength="255" size = 60/>
                   <input type = submit name = "buscar"  class = "btnbuscar" value = "">
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
<table class="tablecss" width="80%" border="1">
<thead class="odd"><tr><th>Id</th><th>Banco</th>
<th>No. Cuenta</th>
<th>&Uacute;ltimo Cheque a Emitir</th>
<th>
  Acci&oacute;n
  </th>
</tr></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>
<?php
$aleatoria = time();
if(isset($_POST["filtro"]))
{

foreach($listarCuentasBanco as $cuantasEncontradas):
?>
  <td><?php echo $cuantasEncontradas->id_cuenta_bancaria;?></td>
   <td><?php echo $cuantasEncontradas->nombre_banco_cuenta;?></td>
   <td><?php echo $cuantasEncontradas->numero_cuenta_bancaria;?></td>
   <td><?php echo $cuantasEncontradas->ultimo_numero_cheque;?></td>
   <td><a href = "<?php echo base_url();?>micontrolador/VistaEditarCuentaBancaria/<?php echo $aleatoria."/".$cuantasEncontradas->id_cuenta_bancaria."/";?>">
        Editar</a>
  </td>

  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
  </tr> 
<?php endforeach;
}
?>
</tbody> 
</table></div>

</div>