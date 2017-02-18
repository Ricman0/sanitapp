<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:32:24
  from "/membri/sanitapp/templates/smartyDir/templates/ricercaCliniche.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8af58558715_18622019',
  'file_dependency' => 
  array (
    '62ab6e0be24c7aa79b670c7701d2003137789b7b' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/ricercaCliniche.tpl',
      1 => 1487443622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8af58558715_18622019 ($_smarty_tpl) {
?>
<h3 class="grigio" >RICERCA CLINICA</h3>
<hr>
<br>
<form class="form" id="formRicercaCliniche" method="GET">
    <div class="elementiForm" id="elementiFormRicercaCliniche">
        <div class="form" id="inputRicercaCliniche">
            <input type="hidden" name="controller" value="cliniche" id="controllerFormRicercaCliniche"/>        
            <label for="clinica" class="ricerca">Nome Clinica</label>
            <input type="text" name="clinica" class="ricerca" target="_blank" 
                   placeholder="Villa Serena" id="nomeClinicaFormRicercaCliniche"/>
            <label for="luogo" class="ricerca">Luogo</label>
            <input type="text" name="luogo" class="ricerca" target="_blank" 
                   placeholder="Roma" id="luogoClinicaFormRicercaCliniche"/>
            <br>
            <input type="button" class="form" value="Cerca" id="bottoneRicercaCliniche">
        </div>
    </div>
</form><?php }
}
