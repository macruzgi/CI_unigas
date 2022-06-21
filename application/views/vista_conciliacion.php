
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
                "required,banco,Debe de haber un banco elegido.",
				        "required,mes,Debe haber un mes.",
					      "required,idcuentabancaria,Debe haber un ID de la cuenta bancaria.",
                "required,fecha,Debe haber una fecha."
				        
                            
            ]
        });
    });



</script>

<script> 
        function cargarDatosConciliacion(){
          var idCuentaContable = document.getElementById("idcuentabancaria").value
          var fecha = document.getElementById("fecha").value
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
<h1>Conciliaci&oacute;n </h1>

<?php

$claseEstilo = "";
$mensaje = "";
$segmento = $this->uri->segment(3,0);
if($segmento == 300)
{
   $claseEstilo = "error_box";
   $mensaje = "ERROR INESPERADO.";
}
elseif($segmento == 425)/*NO LO ESTOY OCUPANDO*/
{
  $claseEstilo = "error_box";
   $mensaje = "Esta conciliaci&oacute;n ha sido cerrada.";
}
if(count($listarUltimaConciliacion) > 0) //para que no de error al cargar la vista si modifico la url y no encuentra resultados
{
$annio = date("Y");
/*array para buscar y poner en los textbox mes el nombre del mes
segun el numero de la fecha acutal*/
$mes = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio",
             "Julio", "Agosto", "Septiembre", "Obtubre", "Noviembre",
              "Diciembre");

$numeroMes = $listarUltimaConciliacion[0]->mes;  //busco el numero del mes traido de la tabla conciliaciones


$mesAmostrar = $mes[$numeroMes-1]; //le mando el numero del mes al arra mes para que mustre el nombre del mes en la textbox mes el -1 es porque los array empiesan desde 0 y si no le pongo -1 dira que el indice 12 no se encuentra porque para el arrary seria hasta 11
echo $fechaArreglada = $annio."-".$numeroMes."-".date("d");
?>

<div align= center>
                          <div class = "<?php echo $claseEstilo;?>">
                          
                          <span class = requerido><center><?php  echo $mensaje;?>
                          </center><br></span>
                            </div>
                          </div> 
<div align = center>
<fieldset class = fieldset1>
<legend class = legend1>Conciliaci&oacute;n</legend>

        <form method="POST" id="cuentabancos" class="wufoo" action="<?php echo base_url();?>micontrolador/GuardarConciliacion/" name = "cuentabancos">
		   <input name="idconciliacion" type="text" size =15  id="idconciliacion" value = "<?php echo $listarUltimaConciliacion[0]->correlativo;?>" readOnly maxlength="255"/> 
      <!--idconciliacion la dejo oculta porque no necesito que el usuario al vea solo para efecto de programacion-->
  <?phh
         // foreach($listarUltimaConciliacion as $conciliacionEncontrada):
        ?>      
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
		<ul>
      <tr>
       
        <td width = "25%">
            <li>
                    <label class="desc">Banco/Cuenta bancaria:<span class="req">*</span></label>
                    <div>
                      <input name="banco" type="text" size =50  id="banco" value = "<?php echo $listarUltimaConciliacion[0]->nombre_banco_cuenta." - ".$listarUltimaConciliacion[0]->numero_cuenta_bancaria;?>" readOnly maxlength="255"/>
                      <input name="idcuentabancaria" type="text" size =10  id="idcuentabancaria" value = "<?php echo $listarUltimaConciliacion[0]->id_cuenta_bancaria;?>" readOnly maxlength="255"/>
                     <!--idcuentabancaria la dejo oculta porque no necesito que el usuario al vea solo para efecto de programacion-->
                    </div>
            </li>

        </td>
        <td  width = "30%">  
				    <li>
                    <label class="desc">Mes:<span class="req">*</span></label>
                    <div>
                    
                     <input name="mesennumero" type="text" size =15  id="mesennumero" value = "<?php echo $listarUltimaConciliacion[0]->mes;?>" readOnly maxlength="255"/>
                     <!--mesennumero la dejo oculta porque no necesito que el usuario al vea solo para efecto de programacion-->
                     <input name="mes" type="text" size =15  id="mes" value = "<?php echo $mesAmostrar;?>" readOnly maxlength="255"/> 
                     <input name="fecha" type="text" size =15  id="fecha" value = "<?php echo $fechaArreglada;?>" readOnly maxlength="255"/>
                     <!--fecha la dejo oculta porque no necesito que el usuario al vea solo para efecto de programacion-->
                    </div> 
            </li> 
          
				</td>
        <td>
              <li>
                    <label class="desc">Año:<span class="req">*</span></label>
                    <div>
                     <input name="annio" type="text" size =15  id="annio" value = "<?php echo $listarUltimaConciliacion[0]->annio;?>" readOnly maxlength="255"/>  <i><?php echo $fechaArreglada; ?> </i>

                    </div> 
            </li> 
        </td>
        </TR>
     
		   </ul>
         
				</table>
        <?php 
          //endforeach;
        ?> 
            <br>
            <br>    
            
          
 <br>
 <br>
  
<div align = center>
  <table boreder = "0" width ="55%">
  <tr>
    <td width = "15">
    <a href="#" onclick="cargarDatosConciliacion();"><img src = "<?php echo base_url();?>images/buscar.png" align  = middle title ="Cargar Datos"></a>
    </td>
    <td  width = "15">
      <input name="checkall" type="checkbox" id="checkall" value="checkall" onclick="checkAll();">Marcar Todos  Los registros
     
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
 <?php
 }
 ?>
 </div>
 