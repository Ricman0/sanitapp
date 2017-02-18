<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:44:18
  from "/membri/sanitapp/templates/smartyDir/templates/HomePage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b222dc35d0_05185709',
  'file_dependency' => 
  array (
    'b9b94128e0c3d0582db460d3b9f2361c3f148b62' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/HomePage.tpl',
      1 => 1487443618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b222dc35d0_05185709 ($_smarty_tpl) {
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
        <link rel="stylesheet" type="text/css" href="./Css/log.css">

        <!--       <link rel="stylesheet" type="text/css" href="./Css/inserisciUtente.css">
                <link rel="stylesheet" type="text/css" href="./Css/inserisciMedico.css">-->
        <link rel="stylesheet" type="text/css" href="./Css/navigationBar.css">
        <link rel="stylesheet" type="text/css" href="./Css/mainRicerca.css">
        <link rel="stylesheet" type="text/css" href="./Css/cartinaItalia.css"/>
        <link rel="stylesheet" type="text/css" href="./Css/areaPersonale.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>
        <link rel='stylesheet' href='plugins/fullcalendar/fullcalendar.css' />
        <link rel='stylesheet' href='./Css/tabelle.css' />
        <link rel='stylesheet' href='plugins/tablesorter/theme.blue.css' />

        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/jquery-1.12.4.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/jquery-ui/datepicker-it.js"><?php echo '</script'; ?>
>        
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/jquery.validate.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/additional-methods.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/tablesorter/jquery.tablesorter.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/tablesorter/jquery.tablesorter.widgets.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.js"><?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/gestioneCartinaItalia.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/funzioniGeneriche.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickHomePage.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickLogIn.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickEsami.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickCercaCliniche.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickCercaEsami.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/validazioneDati.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickClinica.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickUtente.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickMedico.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickPrenotazione.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="application/javascript" src="./jScript/clickAmministratore.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src='plugins/moment.js'><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src='plugins/fullcalendar/fullcalendar.js'><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src='plugins/fullcalendar/locale/it.js'><?php echo '</script'; ?>
>

    </head>

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">
            <div id="headerMain">
                <!-- Header della pagina-->

                <div class="header" id="header">
                    <img id="logoSanitApp" class="logoBig" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                    <div id="logNavBar">
                        <?php echo $_smarty_tpl->tpl_vars['logIn']->value;?>

                        <?php echo $_smarty_tpl->tpl_vars['navigationBar']->value;?>
    <!-- Navigation bar della pagina-->
                    </div>
                </div>
                <br>
                <!-- Main della pagina-->

                <div id="main">
                    <?php echo $_smarty_tpl->tpl_vars['mainRicerca']->value;?>

                </div> 

            </div>
            <div id="dialog" title="Attenzione" >
                <p id='messaggioDialogBox' ></p>
            </div>
            <div id="loadingModal" class='modal'>    
                <div id="loading" class="loading">
                    <!-- per l'animazione durante il caricamento di una pagina -->
                </div>
            </div>
            <!--Footer della pagina-->
            <div id="footer">
                <div class="centrato">
                    <a id="info" class="soloController" >Informazioni Validazione </a>  |  <a id="contatti" class="soloController" > Contatti</a>  |  <a id="privacyPolicy" class="soloController" > Privacy Policy</a>
                </div>
                <div class="copyright centrato">©2017 Copyright - SanitApp</div>
            </div>
        </div>
    </body>
</html><?php }
}
