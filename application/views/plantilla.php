<?php 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>UNIGAS | El Salvador</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /><!--MUESTRA TILDES Y Ñ´S-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="keywords" content="Keywords here">
<meta name="description" content="Description here">
<meta name="Author" content="MyFreeTemplates.com">
<META NAME="robots" CONTENT="index, follow"> <!-- (Robot commands: All, None, Index, No Index, Follow, No Follow) -->
<META NAME="revisit-after" CONTENT="30 days">
<META NAME="distribution" CONTENT="global"> 
<META NAME="rating" CONTENT="general">
<META NAME="Content-Language" CONTENT="english">

<script src="<?php echo base_url();?>js/jquery-1.4.2.min.js"></script>
<script language="JavaScript" type="text/JavaScript" src="<?php echo base_url();?>js/site.js"></script>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">

 <!--todos los jquereis-->
<link href="<?php echo base_url();?>css/tableZebra.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>js/jquery.validator.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/wufoo.js"></script>
<link type="text/css" href="<?php echo base_url();?>css/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker-es.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/checkall.js"></script><!--para el chequeo completo de varios chexbox-->
<link href="<?php echo base_url();?>css/MisEstilos.css" rel="stylesheet" type="text/css">


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('<?php echo base_url();?>images/btn_main_dn.gif','<?php echo base_url();?>images/btn_about_dn.gif','<?php echo base_url();?>images/btn_products_dn.gif','<?php echo base_url();?>images/btn_services_dn.gif','<?php echo base_url();?>images/btn_support_dn.gif','<?php echo base_url();?>images/btn_contactus_dn.gif','<?php echo base_url();?>images/btn_order_dn.gif')">
<table width="80%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="98"> 
    <table width="700" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="227" rowspan="2"><img src="<?php echo base_url();?>images/uni.jpg" width="227" height="81" style="border:solid thin #18154D;"></td>
          <td><img src="<?php echo base_url();?>images/toppic1.gif" width="700" height="43"></td>
        </tr>
        <tr> 
          <!-- PRIMER CORTE MENÚ-->
            <?php $this->load->view("includes/menu_superior");?>
          <!-- FIN DEL PRIMER CORTE MENÚ-->
        </tr>
		
        <tr> 
          <td colspan="2"><img src="<?php echo base_url();?>images/topcurve.gif" width="929 height="17"></td>
        </tr>
      </table> 
		 <!-- SUBMENU-->
            <?php ///$this->load->view("includes/sub_menu");?>
          <!-- FIN DEL SUB-MENÚ-->
      <!-- SEGUNDO CORTE CUERPO/CONTENIDO-->
          <?php $this->load->view($contenido);?>
      <!-- FIN SEGUNDO CORTE CUERPO/CONTENIDO-->
      </td>
  </tr>
  <tr> 
    <td><table width="775" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr 
        </tr>
      </table> <br>
    </td>
  </tr>
  <tr>
    <td>
    <!-- TERCER CORTE PIE-->
     <?php $this->load->view("includes/pie");?>
    <!-- FIN TERCER CORTE PIE-->
    </td>
  </tr>
</table>
</body>
</html>
