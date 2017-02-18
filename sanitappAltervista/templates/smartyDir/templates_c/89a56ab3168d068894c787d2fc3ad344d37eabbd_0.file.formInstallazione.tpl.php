<?php
/* Smarty version 3.1.29, created on 2017-02-18 18:37:22
  from "/membri/sanitapp/templates/smartyDir/templates/formInstallazione.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a886520d9755_56291176',
  'file_dependency' => 
  array (
    '89a56ab3168d068894c787d2fc3ad344d37eabbd' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/formInstallazione.tpl',
      1 => 1487438920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a886520d9755_56291176 ($_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['errore']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['errore']->value;
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
        <span ><b class="rosso">! </b><?php echo $_smarty_tpl->tpl_vars['curr_mess']->value;?>
<b class="rosso"> !</b></span><br>
    <?php
$_smarty_tpl->tpl_vars['curr_mess'] = $__foreach_curr_mess_0_saved_local_item;
}
if ($__foreach_curr_mess_0_saved_item) {
$_smarty_tpl->tpl_vars['curr_mess'] = $__foreach_curr_mess_0_saved_item;
}
}?> 
<form id="formInstallazione">
    <div id="databaseEmailConfig" class="affiancato verticalmenteAllineato">
        <h3>CONFIGURAZIONE</h3>
        <br>
        Database
        <br>
        <br>
        <label for="host" class="elementiForm">Host</label>
        <input type="text" name="host" id="host" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['host'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['host'];
}?>" required/>
        <br>

        <label for="userDb" class="elementiForm">User db</label>
        <input type="text" name="userDb" id="userDb" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['userDb'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['userDb'];
}?>" required/>
        <br>

        <label for="passwordDb" class="elementiForm">Password Database</label>
        <input type="password" name="passwordDb" id="passwordDb" class="elementiForm" required/>
        <br>

        <label for="confermapasswordDb" class="elementiForm">Conferma password</label>
        <input type="password" name="confermaPasswordDb" id="confermapasswordDb" class="elementiForm" required/>
        <br>
        <br>
        SERVER SMTP
        <br>
        <br>
        <label for="smtp" class="elementiForm">Server SMTP</label>
        <input type="text" name="smtp" id="smtp" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['smtp'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['smtp'];
}?>" required/>
        <br>
        <label for="emailSmtp" class="elementiForm">E-mail</label>
        <input type="email" name="emailSmtp" id="emailSmtp" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['email'];
}?>" required/>
        <br>
        <label for="passwordEmail" class="elementiForm">Password E-mail</label>
        <input type="password" name="passwordEmail" id="passwordEmail" class="elementiForm"  required/>
        <br>
        <br>
    </div>
        <div id="adminConfig" class="affiancato verticalmenteAllineato">


        <h3>AMMINISTRATORE</h3>
        <br>
        <br>  <br>  

        <label for="nome" class="elementiForm">Nome</label>
        <input type="text" name="nome" id="nome" class="elementiForm" maxlength="20" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['nome'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['nome'];
}?>" required/>
        <br>

        <label for="cognome" class="elementiForm">Cognome</label>
        <input type="text" name="cognome" id="cognome" class="elementiForm" maxlength="20" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['cognome'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['cognome'];
}?>" required/>
        <br>

        <label for="emailAdmin" class="elementiForm">E-mail</label>
        <input type="email" name="emailAdmin" id="emailAdmin" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['email'];
}?>" required/>
        <br>

        <label for="pecAdmin" class="elementiForm">PEC</label>
        <input type="email" name="pecAdmin" id="pecAdmin" class="elementiForm" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['email'];
}?>" required/>
        <br>

        <label for="telefono" class="elementiForm">Telefono</label>
        <input type="text" name="telefono" id="telefono" class="elementiForm"  maxlength="10" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['telefono'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['telefono'];
}?>" required/>
        <br>

        <label for="username" class="elementiForm">Username</label>
        <input type="text" name="username" id="username" class="elementiForm" maxlength="15" value="<?php if (isset($_smarty_tpl->tpl_vars['datiInstallazione']->value['username'])) {
echo $_smarty_tpl->tpl_vars['datiInstallazione']->value['username'];
}?>" required/> 
        <br>

        <label for="password" class="elementiForm">Password</label>
        <input type="password" name="password" maxlength="10" id="password" class="elementiForm" required/>
        <br>

        <label for="confermaPassword" class="elementiForm">Conferma password</label>
        <input type="password" name="confermaPassword" maxlength="10" id="confermaPassword" class="elementiForm" required/>
        <br>

    </div>
        <input type="submit" class="centrato nuovaRiga" id="installazione" value="Installa" />
    <br>
</form><?php }
}
