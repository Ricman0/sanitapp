<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:44:16
  from "/membri/sanitapp/templates/smartyDir/templates/areaPersonaleGenerale.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b22081eb64_21256090',
  'file_dependency' => 
  array (
    '47faa02908ad00532127ff1b73fc5683bc327a33' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/areaPersonaleGenerale.tpl',
      1 => 1487443617,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b22081eb64_21256090 ($_smarty_tpl) {
?>
<div class="sideNavBar affiancato verticalmenteAllineato" id="divSideNavBar">
    <ul  id="sideNavBarList">
        <?php
$_from = $_smarty_tpl->tpl_vars['tastiLaterali']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_tasto_0_saved_item = isset($_smarty_tpl->tpl_vars['tasto']) ? $_smarty_tpl->tpl_vars['tasto'] : false;
$__foreach_tasto_0_saved_key = isset($_smarty_tpl->tpl_vars['id']) ? $_smarty_tpl->tpl_vars['id'] : false;
$_smarty_tpl->tpl_vars['tasto'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['id'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['tasto']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['tasto']->value) {
$_smarty_tpl->tpl_vars['tasto']->_loop = true;
$__foreach_tasto_0_saved_local_item = $_smarty_tpl->tpl_vars['tasto'];
?>
            <li><a id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['tasto']->value;?>
</a></li>
        <?php
$_smarty_tpl->tpl_vars['tasto'] = $__foreach_tasto_0_saved_local_item;
}
if ($__foreach_tasto_0_saved_item) {
$_smarty_tpl->tpl_vars['tasto'] = $__foreach_tasto_0_saved_item;
}
if ($__foreach_tasto_0_saved_key) {
$_smarty_tpl->tpl_vars['id'] = $__foreach_tasto_0_saved_key;
}
?>         
    </ul>   
</div>    

<div class="contenutoAreaPersonale affiancato verticalmenteAllineato " id="contenutoAreaPersonale">
    <?php if (isset($_smarty_tpl->tpl_vars['contenutoAreaPersonale']->value)) {?>
        <?php echo $_smarty_tpl->tpl_vars['contenutoAreaPersonale']->value;?>

    <?php } else { ?>
        <?php if (count($_smarty_tpl->tpl_vars['tastiLaterali']->value) == 3) {?>
            <br>
            <br>
            <h1>Ciao UTENTE </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni 
                e consultare i referti o,<br> se vuoi, condividerli con il tuo medico curante</p>
        <?php } elseif (count($_smarty_tpl->tpl_vars['tastiLaterali']->value) == 7) {?>
            <br>
            <br>
            <h1>Ciao CLINICA </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire i servizi, le prenotazioni, 
                i pazienti, i referti e le tue impostazioni.</p>
        <?php } else { ?>
            <?php if (isset($_smarty_tpl->tpl_vars['tastiLaterali']->value['prenotazioniAreaPersonaleMedico'])) {?>
            <br>
            <br>
                <h1>Ciao DOTTORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire le prenotazioni, 
                i pazienti e i referti.</p>
            <?php } else { ?>
            <br>
                <h1>Ciao AMMINISTRATORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire gli user dell'applicazione</p>
            <?php }?>
        <?php }?>        
    <?php }?>    
</div>
<?php }
}
