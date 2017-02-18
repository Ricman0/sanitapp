<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:40:48
  from "/membri/sanitapp/templates/smartyDir/templates/recuperoCredenziali.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b1501c6de7_05832109',
  'file_dependency' => 
  array (
    '39f7fbc468420066dea941c1d5e6968ce8481294' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/recuperoCredenziali.tpl',
      1 => 1487443622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b1501c6de7_05832109 ($_smarty_tpl) {
?>
<div id="divRecuperoPassword">
    <h3>RECUPERO PASSWORD</h3>
    <hr>
    <br>
    <h4>Inserisci l'indirizzo email con il quale ti sei registrato. Ti verrà inviata la nuova password.</h4>
    <br>
    <form id="formRecuperoPassword">
        
        <label for="emailRecuperoPassword" class="elementiForm">Email</label>
        <input type="email" name="email" id='emailRecuperoPassword' class="elementiForm" placeholder="mario.rossi@example.it" required />
        <br>
        <br>
        <input type="submit" id="submitRecuperaPassword" value='Recupera password'>
    </form>
</div><?php }
}
