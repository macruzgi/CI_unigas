
<?php 


?>

<script>
    function myOnComplete()
    {
        $('#cuentabancos').submit();
    }
    $(document).ready(function() {
        $("#cuentabancos").RSV({
            onCompleteHandler: myOnComplete,
            rules: [
                "required,cuenta,Seleccione alguna cuenta bancaria.",
				        "required,mes,Debe haber un mes.",
					      "required,annio,Debe haber un año.",
				        "required,saldobanco,Ingrese el saldo en $ según el estado de cuenta del banco."
                            
            ]
        });
    });



</script>

<script> 
        function cargarDatosConciliacion(){
          var idCuentaContable = document.getElementById("idcuentabancaria").value
          var fecha = document.getElementById("fecha").value
          if(idCuentaContable != 0)
            {
            //var url= 
            $.ajax({   
                type: "POST",
                url:"<?php echo base_url();?>micontrolador/VistaDatosConciliacion/" + idCuentaContable + "/" + fecha + "/",
                data:{},
                success: function(datos){       
                    $('#tabla').html(datos);
                }
            });
            }
        }
      
        /*function ActualizarTabla(idCheOtrasn, esChequeOtransacion){
          //var idCuentaContable = document.getElementById("idcuentabancaria").value
          //var fecha = document.getElementById("fecha").value
          //if(idCuentaContable != 0)
            //{
            //var url= 
            $.ajax({   
                type: "POST",
                url:"<?php echo base_url();?>micontrolador/ActualizarEstadoChequeOtransaccion/" + idCheOtrasn + "/" + esChequeOtransacion + "/",
                data:{},
                success: function(datos){       
                    $('#tabla').html(datos);
                }
            });
            //}
           // cargarDatosConciliacion(1, '2013-12-06')
           */
           
       
     </script>
     


<script language="javascript"> 
function ponerIdCuentaCotnable(idCuentaContable){
    document.cuentabancos.idcuentabancaria.value = idCuentaContable;
    //document.form1.TXTid_producto.value = parseFloat(IdSelect.substring(1,11));
    return;
}
</script>
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
<h1> Preparar Conciliaci&oacute;n </h1>

<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "Los datos que intenta registrar ya existe verifique por favor.";   
}
elseif($segmento == 405)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO";  
}
elseif($segmento == 1029)
{
?>

 <script>alert('La operación a sido gurdada exitosamente. ')
 window.location = "<?php echo base_url();?>micontrolador/VistaPrepararDatosConciliacion/";
 </script>
<?php
}


$annio = $listarUltimoAnnioMesConciliacion[0]->annio;//traigo el año de la tabla conciliacion
/*array para buscar y poner en los textbox mes el nombre del mes
segun el numero de la fecha acutal*/
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");

$numeroMes = $listarUltimoAnnioMesConciliacion[0]->mes;//traigo el numero del mes de la tabla conciliacion



$mesAmostrar = $mes[$numeroMes-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
 //pruebas
//$diaInicial = "01";
//$diaActual  = date("d");

//$fechaInicio = $annio."-".$numeroMes."-".$diaInicial;
//$fechaFinal  = $annio."-".$numeroMes."-".$diaActual;
$fechaArreglada = $annio."-".$numeroMes."-".date("d");

?>

<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div>

<div align = center>
<fieldset class = fieldset1>
<legend class = legend1>Preparar Datos Conciliaci&oacute;n</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/ProcesarDatosConciliacion/" name = "cuentabancos">
		
       
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
      <tr>
        <td width = "45%">
            <li>
                    <label class="desc">Banco/Cuenta bancaria:<span class="req">*</span></label>
                    <div>
                      <select name = cuenta id="cuenta"  onchange ='ponerIdCuentaCotnable(this.value)'>
                        <option value = 0>Seleccione...</option>
                       <?php
                        foreach($listarCuentasBancairas as $cuentasEncontradas):
                        
                      ?>
                        <option value = <?php echo $cuentasEncontradas->id_cuenta_bancaria;?>><?php echo $cuentasEncontradas->nombre_banco_cuenta." - ".$cuentasEncontradas->numero_cuenta_bancaria?> </option>
                      
                      <?php endforeach;?>
                      </select>
                      <input name="idcuentabancaria" type="hidden" size =10  id="idcuentabancaria" value = "0" readOnly maxlength="255"/>
                      <input name="fecha" type="hidden" size =15  id="fecha" value = "<?php echo $fechaArreglada;?>" readOnly maxlength="255"/>
                      <!-- estos dos text (idcuentabancaria, fecha) los pongo
                      invisibles (hidden) para que no se vea en el formulario
                      ya que no son necesarios que el usuario los vea
                      solo son necesarios para la programacion-->
                    </div>
            </li>

        </td>
        <td  width = "30%">
				    <li>
                    <label class="desc">Mes:<span class="req">*</span></label>
                    <div>
                     <input name="mes" type="text" size =10  id="mes" value = "<?php echo $mesAmostrar;?>" readonly maxlength="255"/>
                     
                    </div> 
            </li> 
				</td>
        <td>
            <li>
                    <label class="desc">Año:<span class="req">*</span></label>
                    <div>
                     <input name="annio" type="text" size =10  id="annio" value = "<?php echo $annio;?>" readonly maxlength="255"/>
                    </div> 
            </li> 
        </td>
       </tr>
       <tr>
       <td>
        <label class="desc">Saldo del banco seg&uacute;n estado de cuenta:<span class="req">*</span></label>
                    <div>
                     <input name="saldobanco" type="text"   id="saldobanco"  class="field text medium"   maxlength="255"/>
                    </div> 
        </td>
        </tr>
		   </ul>
         
				</table>
        
            <br>


              
<div align = center>
  <table boreder = "0" width ="55%">
  <tr>
    <td width = "15">
    <a href="#" onclick="cargarDatosConciliacion();"><img src = "<?php echo base_url();?>images/buscar.png" align  = middle title ="Cargar Datos"></a>
    </td>
    <td  width = "15">
      <input name="checkall" type="checkbox" id="checkall" value="checkall" onclick="checkAll();" checked>Marcar Todos  Los registros
     
    </td>
  </tr>
  </table>
   </div>
   <br>
   <div id="tabla"> <!--AQUI SE MUESTRAN LOS DATOS DE LA OTRA VISTA QUE LISTA LOS DATOS A CONCILIAR-->
    
   </div> <!--FIN DONDE SE MUESTRAN LOS DATOS DE LA OTRA VISTA-->
  



   <br>
   
        </form>
  <br>    
 </fieldset>
 </div>
 