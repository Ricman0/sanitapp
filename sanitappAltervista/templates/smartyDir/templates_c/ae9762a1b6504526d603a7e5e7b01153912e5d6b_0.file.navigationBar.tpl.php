<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:44:18
  from "/membri/sanitapp/templates/smartyDir/templates/navigationBar.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b222d73308_76921981',
  'file_dependency' => 
  array (
    'ae9762a1b6504526d603a7e5e7b01153912e5d6b' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/navigationBar.tpl',
      1 => 1487443621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b222d73308_76921981 ($_smarty_tpl) {
?>
<nav id="navigationBar">
    <ul class="nav">
        <li class="nav" id="home">
            <a class="nav homepage"  id="homeNavBar">
                <i class="fa fa-home fa-2x" id="icona-home" aria-hidden="true" ></i>
            </a>
        </li>
        <li class="nav" id="cliniche">    
            <a class="nav" href="ricercaCliniche"><i class="fa fa-hospital-o fa-lg" id="icona-cliniche" aria-hidden="true"></i> Cliniche</a> 
        </li>
        <li class="nav" id="esami">
            <a  class="nav" >
                <i class="fa fa-file-text-o fa-lg" id="icona-esami" aria-hidden="true"></i> Esami</a>
        </li>
        <?php if (isset($_smarty_tpl->tpl_vars['username']->value)) {?>
            <li class="nav mySanitApp" id="mySanitApp">
                <a class="nav" ><i class="fa fa-user fa-lg" id="icona-mySanitApp" aria-hidden="true"></i> MySanitApp</a>
            </li>
        <?php } else { ?>
            <li class="nav" id="registrazione">
                <a class="nav" ><i class="fa fa-user-plus fa-lg" id="icona-registrazione" aria-hidden="true"></i> Registrazione</a>
               <div class="dropdown-content">
                   <a id="registrazioneUtente" class="registrazioneUtente" ><i class="fa fa-user fa-lg" id="icona-esami" aria-hidden="true"></i> Utente</a>
                    <a id="registrazioneMedico" ><i class="fa fa-user-md fa-lg" id="icona-esami" aria-hidden="true"></i> Medico</a>
                    <a id="registrazioneClinica" ><i class="fa fa-hospital-o fa-lg" id="icona-esami" aria-hidden="true"></i> Clinica</a>
                </div>
            </li>
        <?php }?>
    </ul>
</nav><?php }
}
