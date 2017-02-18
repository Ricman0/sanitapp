<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:44:18
  from "/membri/sanitapp/templates/smartyDir/templates/log.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8b222d4c5e8_04467821',
  'file_dependency' => 
  array (
    '496c3ee55143f862f69190518a40b4a50ed6f297' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/log.tpl',
      1 => 1487443621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8b222d4c5e8_04467821 ($_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['user']->value)) {?>
    <div class="log">
        <span>Ciao <?php echo $_smarty_tpl->tpl_vars['user']->value;?>
 &nbsp</span>
        <button id="logOutButton" class="logOutButton sottile">Logout</button>
    </div>
<?php } else { ?>
    <div id="logInFormDiv">
        <form class="log logInForm" id="logInForm">
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn">Username</label>
            <input type="text" id="usernameLogIn" placeholder="Enter Username" name="usernameLogIn" required >

            <label for="passwordLogIn">Password</label>
            <input type="password" id="passwordLogIn" maxlength="10" placeholder="Enter Password" name="passwordLogIn" required>

            <button type="submit" id="submitLogIn" class="loginButton sottile">Login</button>
            &nbsp &nbsp

            <a  id='recuperaPassword'> Password dimenticata?</a>

        </form>
    </div>
<?php }
}
}
