<?php 

	
?>
<link href="css/form.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validator.js"></script>
<script type="text/javascript" src="js/wufoo.js"></script>
<script>
  
	
	function addFila(){
		tablaCuentas = $('#detallepartida');
		newRow = $(document.createElement('tr'));
		
		newCodigo = $(document.createElement('td'));
		newTxt = $('#codigocuenta0').clone();
		newTxt.attr('value','');
		idNewTxt = 'codigocuenta'+$(":input[id^=codigocuenta]").length;
		focusTxt = idNewTxt;
		newTxt.attr('id',idNewTxt);
		newTxt.attr('onblur','');
		newTxt.attr('onkeyup','');
		newTxt.onkeyup='';
		newTxt.bind('blur',function() {
 		 	getDataCuenta($(":input[id^=codigocuenta]").length-1);
		});
		
		newCodigo.append(newTxt);
		
		
		newDescripcion = $(document.createElement('td'));
		newTxt = $('#descripcion0').clone();
		newTxt.attr('value','');
		idNewTxt = 'descripcion'+$(":input[id^=descripcion]").length;
		newTxt.attr('id',idNewTxt);
		newDescripcion.append(newTxt);	
		
		newConcepto = $(document.createElement('td'));
		newTxt = $('#concepto0').clone();
		newTxt.attr('value',document.getElementById('conceptopartida').value);
		idNewTxt = 'concepto'+$(":input[id^=concepto]").length;
		newTxt.attr('id',idNewTxt);
		newConcepto.append(newTxt);		
		
		newCargo = $(document.createElement('td'));
		newTxt = $('#cargo0').clone();
		newTxt.attr('value','');
		idNewTxt = 'cargo'+$(":input[id^=cargo]").length;
		newTxt.attr('id',idNewTxt);
		newTxt.bind('blur',function() {
 		 	setTotales($(":input[id^=cargo]").length-1);
		});
		newCargo.append(newTxt);		
		
		newAbono = $(document.createElement('td'));
		newTxt = $('#abono0').clone();
		newTxt.attr('value','');
		idNewTxt = 'abono'+$(":input[id^=abono]").length;
		newTxt.attr('id',idNewTxt);
		newTxt.bind('blur',function() {
 		 	setTotales($(":input[id^=abono]").length-1);
		});
		newAbono.append(newTxt);		
	
		
		newRow.append(newCodigo);
		newRow.append(newDescripcion);
		newRow.append(newConcepto);
		newRow.append(newCargo);
		newRow.append(newAbono);
		
		tablaCuentas.append(newRow);	
		$("#"+focusTxt).focus();	
	}
	
	function setTotales(control){
		sumCargos = 0.00;
		sumAbonos = 0.00;
		vCargo = 0;
		vAbono = 0;
		for(i=0;i<$(":input[id^=codigocuenta]").length;i++){
			if((document.getElementById('cargo'+i).value)!=''){
				vCargo = parseFloat(document.getElementById('cargo'+i).value);
			}	
			else{
				vCargo = 0;
			}
			sumCargos = sumCargos + vCargo;	
			if((document.getElementById('abono'+i).value)!=''){
				vAbono = parseFloat(document.getElementById('abono'+i).value);
			}	
			else{
				vAbono = 0;
			}
			sumAbonos = sumAbonos + vAbono;
		}
			
		document.getElementById('totalcargos').value = number_format(sumCargos,2);
		document.getElementById('totalabonos').value = number_format(sumAbonos,2);
		document.getElementById('diferencia').value = number_format(sumCargos-sumAbonos,2);
	}
	
	function redondear(num){ 		
		var original=parseFloat(num); 		
		var result=Math.round(original*100)/100 ; 		
		return result; 	
	}
	
	function number_format (number, decimals, dec_point, thousands_sep) {
	  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
		  var k = Math.pow(10, prec);
		  return '' + Math.round(n * k) / k;
		};
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	  if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	  }
	  return s.join(dec);
	}
	
	function setMunicipios(cbxDepto){
	codigo = cbxDepto.options[cbxDepto.selectedIndex].value;
	$.ajax({
      type: "GET",
	  data: "name=municipio&dpto="+codigo,
      url: "functions/fcnGetListMunicipios.php",
      dataType: "html",
      async:false,
	  success: function(datos){
            $('#spanMunicipios').html(datos);
        }
	});
	}
	
	
	
	function getDataCuenta(control){
	codCuenta = document.getElementById('codigocuenta'+control).value;
	if(codCuenta!=''){
		$.ajax({
		  type: "GET",
		  data: "id="+codCuenta+"&idobj="+control,
		  url: "functions/fcnGetCuentaPartida.php",
		  dataType: "script",
		  async:false,
		  success: function(datos){

			}
		});
		}
	}
	
	function getDataCC(cbxCC){
	codigo = cbxCC.options[cbxCC.selectedIndex].value;
	$.ajax({
      type: "GET",
	  data: "cc="+codigo,
      url: "functions/fcnGetDataCC.php",
      dataType: "script",
      async:false,
	  success: function(datos){
            
        }
	});
	}

</script>

    <div class="header">
      <h1>Partidas Contables </h1>
    </div>
    <div class="content">
		<ul><span id="tForm">
		
		<form method="post" class="wufoo" action="functions/fcnSavePartida.php" target="frmSave">
		  <input type="hidden" name="id" id="id" value="<?php //e($id) ?>" />
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
          
              <tr>
				<td><li>
                    <label class="desc">Fecha </label>
                    <div>
					<?php if(isset($id)){
							$fecha = getDataFieldTable("contapartidas","fecha",$id);
						}
						else{
							$fecha = date("d-m-Y");
						}
					 ?>
                        <input name="fecha" type="text" class="field text large" id="fecha" value="<?php $fecha ?>" maxlength="255"/>
                    </div>
                </li>				</td>
				<td><li>
                    <label class="desc">Tipo de Partida</label>
                    <div>
					
                        <?php 
						if(isset($id)){
							$tipopartida = 1;
						}
						$tipopartida=2 ?>
                    </div>
                </li>				</td>
			  </tr>
			  <tr>
			  <?php 
			  if(isset($id)){
			  ?>
			  <td>
			  <li>
                    <label class="desc">ID Único</label>
                    <div>
					<input type="text" class="field text large" readonly="" value="<?php e($id); ?>" />
					</div>
			  </li>
			  </td>
			  <?php
			  }
			  ?>
			  <?php
			  $correlativo = 100; 
			  if($correlativo!=""){
			  ?>
			  <td>
			  <li>
                    <label class="desc">Documento</label>
                    <div>
					<input type="text" class="field text large" readonly="" value="<?php //e(llenarChar($correlativo,5,"0")); ?>" />
					</div>
			  </li>
			  </td>
			  <?php
			  }
			  ?>
			  </tr>
			  <tr>
				<td colspan="2"><li>
                    <label class="desc">Concepto </label>
                    <div>
					<?php if(isset($id)){
							$concepto = "hola";
						}
						else{
							$concepto = "";
						}
					 ?>
                        <input name="partidaconcepto" type="text" class="field text large" id="conceptopartida" value="<?php $concepto ?>"  maxlength="255"/>
                    </div>
                </li>				</td></tr>
<tr height="50"></tr>
<tr>
				<td colspan="2">
				  <table width="100%" id="detallepartida" cellpadding="0" cellspacing="2" border="0">
                    <thead>
                      <tr>
                        <td colspan="7" align="center" bgcolor="#B8E89B"><h3>Detalle</h3></td>
                      </tr>
                      <tr bgcolor="#B8E89B">
                        <td align="center" width="10%">Cuenta</td>
                        
                        <td align="center" width="30%">Descripcion</td>
						<td align="center" width="30%">Concepto</td>
						<td align="center" width="15%">Cargos</td>
						<td align="center" width="15%">Abonos</td>
                      </tr>
                    </thead>
                    <?php 
					if(isset($id)){
					
					$detallePartida = 1245;
					$i = 0;
					while($detalle=mysql_fetch_array($detallePartida)){
					?>
					<tr>
                      <td align="center"><input type="text" name="codigocuenta[]" id="codigocuenta<?php e($i) ?>" class="field text large" onkeyup="if(event.keyCode==13){getDataCuenta(<?php e($i) ?>);}" onblur="getDataCuenta(<?php e($i) ?>)" value="<?php e($detalle[codigocuenta]); ?>" />
					  <script>
						  $('#codigocuenta<?php e($i) ?>').bind('blur',function() {
								getDataCuenta(<?php e($i) ?>);
							});
				
						  </script>					  </td>
                      

                      <td align="center"><input type="text" name="descripcion[]" id="descripcion<?php e($i) ?>" readonly="" class="field text large" value="<?php e($detalle[nombrecuenta]); ?>" /></td>
					  <td align="center"><input type="text" name="concepto[]" id="concepto<?php e($i) ?>" class="field text large" value="<?php e($detalle[concepto]); ?>" /></td>
					  <td align="center"><input type="text" name="cargo[]" id="cargo<?php e($i) ?>" class="field text large" value="<?php e($detalle[cargo]); ?>"/>
					   <script>
						  $('#cargo0').bind('blur',function() {
								setTotales(<?php e($i) ?>);
							});
				
						  </script>						  </td>
					  <td align="center"><input type="text" name="abono[]" id="abono<?php e($i) ?>" class="field text large" value="<?php e($detalle[abono]); ?>" />
					  <script>
						  $('#abono0').bind('blur',function() {
								setTotales(<?php e($i) ?>);
							});
				
						  </script>	
					  </td>
                    </tr>
					<?php 
							$i++;
						}
					}
					else{ ?>
                    <tr>
                      <td align="center"><input type="text" name="codigocuenta[]" id="codigocuenta0" class="field text large" onkeyup="if(event.keyCode==13){getDataCuenta(0);}" onblur="getDataCuenta(0)" />
					  <script>
						  $('#codigocuenta0').bind('blur',function() {
								getDataCuenta(0);
							});
				
						  </script>					  </td>
             <?php 
              $preciodirecto = 199;
             ?>         

                      <td align="center"><input type="text" name="descripcion[]" id="descripcion0" readonly="" class="field text large" /></td>
					  <td align="center"><input type="text" name="concepto[]" id="concepto0" class="field text large" /></td>
					  <td align="center"><input type="text" name="cargo[]" id="cargo0" class="field text large"  <?php if($preciodirecto!="1"){ "readonly";}?>/>
					   <script>
						  $('#cargo0').bind('blur',function() {
								setTotales(0);
							});
				
						  </script>						  </td>
					  <td align="center"><input type="text" name="abono[]" id="abono0" class="field text large" />
					  <script>
						  $('#abono0').bind('blur',function() {
								setTotales(0);
							});
				
						  </script>	
					  </td>
                    </tr>
					<?php } ?>
                  </table>
				  <table width="100%"  cellpadding="0" cellspacing="2" border="0">
			<tr>
                        <td align="center" width="10%">&nbsp;</td>
                        
                        <td align="center" width="30%">&nbsp;</td>
						<td align="center" width="29%">&nbsp;</td>
						<td align="center" width="15%"><input type="text" name="totalcargo" id="totalcargos" class="field text large" readonly=""  <?php if($preciodirecto!="1"){ "reodonly";}?>/></td>
						<td align="center" width="15%"><input type="text" name="totalabono" id="totalabonos" class="field text large" readonly="" /></td>
                      </tr>
					  <tr>
                        <td align="center" width="10%">&nbsp;</td>
                        
                        <td align="center" width="30%">&nbsp;</td>
						<td align="center" width="29%">&nbsp;</td>
						<td align="center" width="15%" class="error">Diferencia</td>
						<td align="center" width="15%"><input type="text" name="diferencia" id="diferencia" class="field text large" readonly="" /></td>
                      </tr>
					  <script>setTotales();</script>
			</table>
				  	<br /><a href="javascript:addFila();" accesskey="a" title="Alt + A">Agregar [Alt+A]</a>			</td>
			  </tr>
          </table>
		  <table width="100%" id="materiales" cellpadding="0" cellspacing="2" border="0">
			  <tr>
				<td colspan="5" align="right">&nbsp;</td>
			  </tr>
			</table>
			
		  
			<li class="buttons">
                <input name="guardar" type="button" onclick="form.submit()" class="btTxt" id="saveForm" value="Guardar Partida" />
				 <input name="btPrint" type="button" onclick="printPartida()" class="btTxt" id="btPrint" value="Imprimir" />
				 <input name="salir" type="button" class="btTxt" id="salir" onclick="window.location = 'index.php?m=clientesdex';" value="Salir" />
            </li>
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
		</table>
        </form>
	  </span>
	  </ul>
  </div></div>
</td>
<script>
function printPartida(){
		idPartida = document.getElementById('id').value;
		if(confirm("¿Desea incluir las firmas?")){
			firmas = "1";
		}
		else{
			firmas = "0";
		}
		urlDestino = "reports/repPartidas.php?id="+idPartida+"&firmas="+firmas;
		winDetalles = window.open(urlDestino,"wPrintReport","dependent= yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=950, height=690");
}
</script>
<iframe name="frmSave" id="frmSave" src="" class="hidden">
