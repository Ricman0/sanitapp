<?php
/* Smarty version 3.1.29, created on 2017-02-18 18:37:22
  from "/membri/sanitapp/templates/smartyDir/templates/installazione.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a88652100e57_56999461',
  'file_dependency' => 
  array (
    '22a883b11aca37779fc2c7b73f99cd0d06ead890' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/installazione.tpl',
      1 => 1487438923,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a88652100e57_56999461 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
    <head> 
        
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
        
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Fonts/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />

        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>

        <?php echo '<script'; ?>
 type="text/javascript" src="./plugins/jquery-1.12.4.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="./plugins/jquery.validate.js"><?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 type="text/javascript" src="./jScript/funzioniGeneriche.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="./jScript/clickHomePage.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="./jScript/validazioneSetup.js"><?php echo '</script'; ?>
>

    </head>

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">
            <div id="headerMain">
                <!-- Header della pagina-->
                
                
                  <div class="headerSottile" id="header">
                    <img id="logoSanitApp" class="centrato logoSmallFisso" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                </div>
                <br>
                <hr>
                <!-- Main della pagina-->
                
                <div id="main">
                    <noscript>
                        <div class="noscript">
                            Il tuo browser non supporta JavaScript, o lo hai disattivato!<br>
                            Riattivalo accedendo alle impostazioni del browser se vuoi usufruire dei nostri servizi
                        </div>
                    </noscript> 
                      
                    <?php echo $_smarty_tpl->tpl_vars['contenuto']->value;?>

                </div> 
                
            </div>
            <div id="dialog" title="Attenzione" >
                <p id='messaggioDialogBox' ></p>
            </div>
            <!--Footer della pagina-->
            
            <div id="footer">
                <span class="copyright">©2017 Copyright - SanitApp</span>
            </div>
        </div>
    </body>
</html><?php }
}
