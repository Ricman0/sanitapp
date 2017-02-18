<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:15:20
  from "/membri/sanitapp/templates/smartyDir/templates/logIn.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8ab5832e122_74327804',
  'file_dependency' => 
  array (
    'afbc7aafc1c564a33f92e1f5d9544a79e7071c9c' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/logIn.tpl',
      1 => 1487443621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8ab5832e122_74327804 ($_smarty_tpl) {
?>
<div id="logInFormDiv2" class="verticalmenteAllineato">
    <?php if (isset($_smarty_tpl->tpl_vars['errore']->value)) {?>
        <div id="erroreLogIn"><h4><?php echo $_smarty_tpl->tpl_vars['errore']->value;?>
</h4></div>  
    <?php }?>
    <div id="logInDiv" class="bordo centrato">
   <i class="fa fa-user fa-4x sanitAppColor" id="icona-logInForm" aria-hidden="true"></i>
        <form  id="logInForm2">
            
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn2">Username</label>
            <br>
            <input type="text" id="usernameLogIn2" placeholder="Enter Username" name="usernameLogIn" class='elementiForm' required />
            <br>
            <label for="passwordLogIn2">Password</label>
            <br>
            <input type="password" id="passwordLogIn2" maxlength="10" placeholder="Enter Password" name="passwordLogIn" class='elementiForm' required />
            <br>
            <button type="submit" id="submitLogIn2" class="loginButton normalSize">Login</button>

        </form>
    </div>
    <div>Non sei ancora registrato?</div>
    <div>Registrati subito cliccando su Registrati</div>
    <button type="submit" id="submitRegistratiLogIn" class="normalSize registrazioneUtente">Registrati</button>
</div>
    
<br>
<?php }
}
