<?php

?>

 <script> 
        function reportes(idReporte){
          /*var idCuentaContable = document.getElementById("idcuentabancaria").value
          var fecha = document.getElementById("fecha").value
          */
            //var url=
           if(idReporte == 1)
            { 
              $.ajax({   
                  type: "POST",
                  url:"<?php echo base_url();?>micontrolador/VistaReporteCuentasBancairas/",
                  data:{},
                  success: function(datos){       
                      $('#tabla').html(datos);
                  }
              });
           }
          else if(idReporte == 2)
            {
              $.ajax({   
                  type: "POST",
                  url:"<?php echo base_url();?>micontrolador/VistaReporteConciliaciones/",
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
<hr>
<span class = navegacion>
COMPRAS:: | 
<a href ="<?php echo base_url();?>micontrolador/VistaCompras/">Compras</a> | 
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaOrdenCompra/">Nueva Orden de Compra </a> | 

<a href ="<?php echo base_url();?>micontrolador/VistaReportesCompras/">Reportes</a>
|
<a href ="<?php echo base_url();?>micontrolador/VistaMateriales/">Servicios</a>
| <a href ="<?php echo base_url();?>micontrolador/VistaCentroCostos/">Centros Costos</a>

</span>
<hr>
<h1>Reportes de Compras</h1>

<div align = center>

<!--div align = center>
<a href ="<?php echo base_url();?>micontrolador/VistaNuevaCuenta/"> <img src = "<?php echo base_url();?>images/Document.png" title = "Nueva Cuenta"></a>
<br>
<br>
</div-->
<div class="datagrid"><table class="tablecss" width="80%" border="1">
<thead class="odd"><tr><th>Reporte</th><th>Descripci&oacute;n</th></thead>
<!--tfoot><tr><td colspan="4"><div id="paging"><ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul></div></tr></tfoot-->
<tbody>
<tr>

  <td>
  <a href ="<?php echo base_url();?>micontrolador/VistaReporteHistoricoXProveedor/"> 
   Hist&oacute;rico x Proveedor </a></td>
   <td>Reporte que lista los proveedores y los productos comprados ofrecidos por este.</td>
 
 </tr>
 <tr>
  <td>
    <a href ="<?php echo base_url();?>micontrolador/ReporteHistoricoXProducto/"> Hist&oacute;rico x Producto </a>
  </td>
  <td>Reporte que lista los proctos comprados por distintos proveedores
  </td>  
  </tr>
  <!--tr>
  <td>
  <a href ="<?php echo base_url();?>micontrolador/VistaReporteTransacciones/"> 
  
    Transacciones </a>
  </td>
  <td>Reporte que lista las transferencias emitidas en el modulo
  </td>  
  </tr-->
  <tr>
  <!--td>
    <a href ="<?php echo base_url();?>micontrolador/VistaLibroIVAcompras/"> IVA para Modificar</a>
  </td>
  <td>Listado de las compras para poder editar el IVA gravado.
  </td-->  
  </tr>
  <tr>
  <td>
     <a href ="<?php echo base_url();?>micontrolador/VistaReporteLibroIVAcompras/">  Libro de IVA </a>
  </td>
  <td>Reporte que genera el Libro de IVA de las compras realizadas
  </td>  
  </tr>
  <!--tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr class="alt"><td>data</td><td>data</td><td>data</td><td>data</td></tr>
  <tr><td>data</td><td>data</td><td>data</td><td>data</td-->
   

</tbody> 
</table>
<br>
<br>

<div id="tabla"> <!--AQUI SE MUESTRAN LOS DATOS DE LA OTRA VISTA QUE LISTA LOS DATOS A CONCILIAR-->
    
   </div> <!--FIN DONDE SE MUESTRAN LOS DATOS DE LA OTRA VISTA-->
  

</div>
 
</div>