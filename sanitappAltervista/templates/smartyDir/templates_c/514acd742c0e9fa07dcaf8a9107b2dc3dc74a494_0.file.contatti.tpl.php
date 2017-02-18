<?php
/* Smarty version 3.1.29, created on 2017-02-18 19:50:12
  from "/membri/sanitapp/templates/smartyDir/templates/contatti.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a897648b5f90_17181313',
  'file_dependency' => 
  array (
    '514acd742c0e9fa07dcaf8a9107b2dc3dc74a494' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/contatti.tpl',
      1 => 1487443618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a897648b5f90_17181313 ($_smarty_tpl) {
?>
<div id="divContatti" class="affiancato">
     <h3>CONTATTI</h3>
    <hr>
    <br>
    <i class="fa fa-user fa-5x sanitAppColor centrato block" id="iconaContatti" aria-hidden="true"></i>
   <div id="contattiTelefonici" class="affiancato verticalmenteAllineato margine40" >
        <i class="fa fa-phone fa-4x sanitAppColor affiancato margine20 verticalmenteAllineato" id="iconaContattiTelefonici" aria-hidden="true"></i>
        <span class="affiancato">
            <p> <?php if (isset($_smarty_tpl->tpl_vars['telefono']->value)) {?><h4>Telefono: </h4> <?php echo $_smarty_tpl->tpl_vars['telefono']->value;?>
 <?php }?></p>
        <p> <?php if (isset($_smarty_tpl->tpl_vars['fax']->value)) {?> <h4>Fax: </h4> <?php echo $_smarty_tpl->tpl_vars['fax']->value;?>
 <?php }?></p>
        </span>
    </div>
    <div id="contattiMail" class="affiancato verticalmenteAllineato margine40">
        <i class="fa fa-envelope fa-4x sanitAppColor affiancato margine20 verticalmenteAllineato" id="iconaContattiMail" aria-hidden="true"></i>
        <span class="affiancato verticalmenteAllineato">
            <p> <?php if (isset($_smarty_tpl->tpl_vars['eMail']->value)) {?><h4>E-Mail: </h4> <?php echo $_smarty_tpl->tpl_vars['eMail']->value;?>
 <?php }?></p>
        <p> <?php if (isset($_smarty_tpl->tpl_vars['pec']->value)) {?><h4>PEC: </h4> <?php echo $_smarty_tpl->tpl_vars['pec']->value;?>
 <?php }?></p>
        </span>
    </div>
        <br>
</div><?php }
}
