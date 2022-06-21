<?php

?>
<head>
<script>
    function myOnComplete()
    {
        $('#signup').submit();
    }
    $(document).ready(function() {
        $("#signup").RSV({
            onCompleteHandler: myOnComplete,
            rules: [
                "required,usuario,Ingrese el nombre de usuario.",
                "required,contrasena,Ingrese una contraseña válida."
            ]
        });
    });
</script>
</head>
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css">

<div class="post" align = center>
    <div class="header">
      <h3>Inicio de Sesi&oacute;n</h3>
    </div>
    <div class="content">
        <form method="post" id="signup" class="wufoo" action="<?php echo base_url();?>micontrolador/IniciarSesion/">
            <ul>
                <li>
                    <label class="desc">Usuario<span class="req">*</span></label>
                    <div>
                        <input name="usuario" type="text" class="field text medium" id="usuario" value="" maxlength="255"/>
                    </div>
                </li>
                <li>
                    <label class="desc">Contraseña<span class="req">*</span></label>
                    <div>
                        <input name="contrasena" type="password" class="field text medium" id="contrasena" value="" maxlength="255"/>
                    </div>
					<?php
						if(isset($error))
              {
					?>
						<label class="error"><?php echo $error;?></label>
					<?php 
						}
					?>
                </li>
                <li class="buttons">
                    <input name="guardar" type="submit" class="css3button2" id="saveForm" value="Enviar" />
                </li>
            </ul>
        </form>
        <p><a href="index.php?m=recover&amp;type=enterprises"><strong>Recuperar Contrase&ntilde;a</strong></a></p>
  </div></div>
	<p>&nbsp;</p>
    <!--p><img src="<?php echo base_url();?>images/Home-icon.gif" width="192"></p-->
	<p>&nbsp;</p>



