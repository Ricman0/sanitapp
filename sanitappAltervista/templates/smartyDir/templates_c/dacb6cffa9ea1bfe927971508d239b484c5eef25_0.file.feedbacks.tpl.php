<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:40:54
  from "/membri/sanitapp/templates/smartyDir/templates/feedbacks.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b1562fc8b6_33064925',
  'file_dependency' => 
  array (
    'dacb6cffa9ea1bfe927971508d239b484c5eef25' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/feedbacks.tpl',
      1 => 1487443618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b1562fc8b6_33064925 ($_smarty_tpl) {
?>
<br><br>
<div>
    <?php if ((is_array($_smarty_tpl->tpl_vars['messaggio']->value))) {?>
        <?php
$_from = $_smarty_tpl->tpl_vars['messaggio']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_curr_mess_0_saved_item = isset($_smarty_tpl->tpl_vars['curr_mess']) ? $_smarty_tpl->tpl_vars['curr_mess'] : false;
$_smarty_tpl->tpl_vars['curr_mess'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['curr_mess']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['curr_mess']->value) {
$_smarty_tpl->tpl_vars['curr_mess']->_loop = true;
$__foreach_curr_mess_0_saved_local_item = $_smarty_tpl->tpl_vars['curr_mess'];
?>
            <h3><?php echo $_smarty_tpl->tpl_vars['curr_mess']->value;?>
</h3>
        <?php
$_smarty_tpl->tpl_vars['curr_mess'] = $__foreach_curr_mess_0_saved_local_item;
}
if ($__foreach_curr_mess_0_saved_item) {
$_smarty_tpl->tpl_vars['curr_mess'] = $__foreach_curr_mess_0_saved_item;
}
?>
    <?php } else { ?>
        <h3><?php echo $_smarty_tpl->tpl_vars['messaggio']->value;?>
</h3>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['homePage']->value)) {?>
        <h4>Clicca su ok per andare alla Home Page.</h4>
        <input type="button" class ="homepage" id="tornaHomePageButton"  value="OK" />
    <?php } else { ?>
        <h4>Clicca su ok per tornare alla pagina personale.</h4>
        <input type="button" class="mySanitApp" id="tornaAreaPersonaleButton"  value="OK" />
    <?php }?>
</div><?php }
}
