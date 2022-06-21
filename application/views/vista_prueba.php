<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Busqueda de facebook</title>
<script type="text/javascript" src="<?php echo base_url();?>jsBusqueda/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jsBusqueda/jquery.watermarkinput.js"></script>
<script type="text/javascript">

/*Espero que sea de su agrado este conjunto de archivos si desea compartirlo en cualquier blog o en su pagina porfavor de darmes los creditos y asi seguir yo compartiendo mis conocimientos con ustedes.
---------GRACIAS--------------------

Mi blog: http://misscripts.blogspot.mx/
Twitter http://twitter.com/daniel_brena
Facebook http://ww.facebook.com/juanito.farias
Gmail danihhelb@gmail.com
*/ 
$(document).ready(function(){

$(".buscar").keyup(function() 
{
var cajabusqueda = $(this).val();
var dataString = 'buscarpalabra='+ cajabusqueda;

if(cajabusqueda=='')
{
}
else
{

$.ajax({
type: "POST",
url: "http://127.0.0.1/CI_unigas/micontrolador/Busqueda/",
data: dataString,
cache: false,
success: function(html)
{

$("#display").html(html).show();
	
	
	}




});
}return false;    


});
});

jQuery(function($){
   $("#cajabusqueda").Watermark("Buscar");
   });
</script>
<style type="text/css">
body
{
font-family:"Lucida Sans";

}
*
{
margin:0px
}
#cajabusqueda
{
width:250px;
border:solid 1px #000;
padding:3px;
}
#display
{
width:250px;
display:none;
float:right; margin-right:30px;
border-left:solid 1px #dedede;
border-right:solid 1px #dedede;
border-bottom:solid 1px #dedede;
overflow:hidden;
}
.display_box
{
padding:4px; border-top:solid 1px #dedede; font-size:12px; height:30px;
}

.display_box:hover
{
background:#3b5998;
color:#FFFFFF;
}
#shade
{
background-color:#00CCFF;

}


</style>
</head>

<body>
<div  style=" padding:6px; height:23px; background:#3b5998; margin-left:15px; margin-right:15px; background: left no-repeat #3b5998 ">
<div style="float:left; width:300px; font-size:12px; font-weight:bold; color:#FFFFFF; margin-left:150px; margin-top:6px"><a href="http://twitter.com/daniel_brena" style="color:#FFFFFF; text-decoration:none">Twitter</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.facebook.com/juanito.farias" style="color:#FFFFFF; text-decoration:none">Facebook</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div style=" width:300px; float:right; margin-right:30px" align="right">
<input type="text" class="buscar" id="cajabusqueda" /><br />
<div id="display">
</div>

</div>

</div>
<div style="margin-top:20px; margin-left:20px">



</div>
<?php 
foreach($listarInteractiva as $interactiva):
?>
<div class="display_box" align="left">


<?php echo $interactiva->codigo; ?>&nbsp;<?php echo $interactiva->nombre; ?><br/>
<span style="font-size:9px; color:#999999"><?php echo $interactiva->id; ?></span></div>
<?php
endforeach;
?>
</body>
</html>
