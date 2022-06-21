<style type="text/css">
a:link {text-decoration:none; color: #99CC00;} /* Link no visitado*/
/*a:visited {text-decoration:none; color:#99CC66} /*Link visitado*/
/*a:active {text-decoration:none; color:#99FF00; background:#EEEEEE} /*Link activo*/
/*a:hover {text-decoration:underline; color:#99FF00; background: #EEEEEE} /*Mause sobre el link*/
</style>
<?php
/*Espero que sea de su agrado este conjunto de archivos si desea compartirlo en cualquier blog o en su pagina porfavor de darmes los creditos y asi seguir yo compartiendo mis conocimientos con ustedes.
---------GRACIAS--------------------

Mi blog: http://misscripts.blogspot.mx/
Twitter http://twitter.com/daniel_brena
Facebook http://ww.facebook.com/juanito.farias
Gmail danihhelb@gmail.com
*/ 




$idCompra = $this->uri->segment(3,0);
//$idCheque = $this->uri->segment(4,0);
foreach($busquedaInteractivaMateriales as $filas):
?>
<div class="display_box" align="left">

<a href="<?php echo base_url();?>micontrolador/AgregarProductosAlCarro/<?php echo $idCompra."/".$filas->id."/";?>">&nbsp;<?php echo $filas->descripcion; ?> <br>
<span style="font-size:9px; color:#999999"><?php echo $filas->codigo; ?></span>  
 </a>
</div>



<?php
endforeach;


?>
