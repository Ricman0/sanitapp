<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:44:16
  from "/membri/sanitapp/templates/smartyDir/templates/headerMain.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b220844a33_81112006',
  'file_dependency' => 
  array (
    '008955103c966ab61970a1f1c0c2901d432f406d' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/headerMain.tpl',
      1 => 1487443618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b220844a33_81112006 ($_smarty_tpl) {
?>
<div class="header" id="header">

    <img id="logoSanitApp" class='logoBig' src="Immagini/logoSanitApp.png" alt="logoSanitApp">

    <?php echo $_smarty_tpl->tpl_vars['log']->value;?>

    <?php echo $_smarty_tpl->tpl_vars['navigationBar']->value;?>
    <!-- Navigation bar della pagina-->
</div>
<br>
<!-- Main della pagina-->

<div id="main">
    <?php if (isset($_smarty_tpl->tpl_vars['main']->value)) {?>
        <?php echo $_smarty_tpl->tpl_vars['main']->value;?>

    <?php }?>    
</div> <?php }
}
