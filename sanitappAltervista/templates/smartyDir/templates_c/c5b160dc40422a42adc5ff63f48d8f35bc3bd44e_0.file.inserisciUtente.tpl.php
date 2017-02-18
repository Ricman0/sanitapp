<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:32:32
  from "/membri/sanitapp/templates/smartyDir/templates/inserisciUtente.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8af60f327d4_54431126',
  'file_dependency' => 
  array (
    'c5b160dc40422a42adc5ff63f48d8f35bc3bd44e' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/inserisciUtente.tpl',
      1 => 1487443621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8af60f327d4_54431126 ($_smarty_tpl) {
?>
<h3>INSERISCI I DATI PER REGISTRARTI IN SANITAPP</h3>
<hr>
<br>
<form name="inserisciUtente" method="POST" id="inserisciUtente" > 

    <label for="nome" class="elementiForm">Nome</label>
    <input type="text" name="nome" id="nomeUtente" class="elementiForm" placeholder="Mario" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['nome'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['nome'];
}?>" required />
    <br>
    
    <label for="cognome" class="elementiForm">Cognome</label>
    <input type="text" name="cognome" id="cognomeUtente" class="elementiForm" placeholder="Rossi" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['cognome'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['cognome'];
}?>" required />
    <br>
    
    <label for="codiceFiscale" class="elementiForm">Codice Fiscale</label>
    <input type="text" name="codiceFiscale" id="codiceFiscaleUtente" maxlength="16" class="elementiForm upperCase" placeholder="MRARSS67S42G438S" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['codiceFiscale'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['codiceFiscale'];
}?>" required />
    <br>
    

    <label for="indirizzo" class="elementiForm">Indirizzo</label>    
    <input type="text" name="indirizzo" id="indirizzoUtente" class="elementiForm" placeholder="Via/C.da Acquaventina" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['indirizzo'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['indirizzo'];
}?>" required />
    <br>
    
    <label for="numeroCivico" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivico" id="numeroCivico" class="elementiForm" min="0" max="1000" placeholder="3" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'];
}?>" />
    <br>
    

    <label for="CAP" class="elementiForm">CAP</label>
    <input type="text" name="CAP" id="CAP" maxlength="5" class="elementiForm" placeholder="65017" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['CAP'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['CAP'];
}?>" required />
    <br>
    

    <label for="email" class="elementiForm">Email</label>
    <input type="email" name="email" id="email" class="elementiForm" placeholder="mario.rossi@example.it" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['email'];
}?>" required />
    <br>
    
    <div class="username">    
        
        <label for="usernameUtente" class="elementiForm">Username</label>    
        <input type="text" name="username" id="usernameUtente" class="elementiForm" placeholder="Mario" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['username'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['username'];
}?>" required />
        <br>
        
    </div>
    
    <div class="password">            

        <label for="passwordUtente" class="elementiForm">Password</label>
        <input type="password" name="passwordUtente" maxlength="10" class="elementiForm" id="passwordUtente"  required />
        <br>
        
        <label for="ripetiPasswordUtente" class="elementiForm">Ripeti Password</label>
        <input type="password" name="ripetiPasswordUtente" maxlength="10" class="elementiForm" id="ripetiPasswordUtente" required />
        <br>
        
    </div>
    <br>
    <input type="checkbox" id="terminiServizio" name="terminiServizio" /><span class="grassetto">  ACCETTO I <span class="grassetto link cliccabile">TERMINI DEL SERVIZIO</span></span>
    <br>
    
    <div id="submitUtente" >
        <input type="submit" value="Invia" id="submitRegistrazioneUtente" />
    </div>
    
    <!-- se vogliamo possiamo aggiungerlo
    Sesso:<br>
    <input type="radio" name="sesso" value="M" checked>Maschio<br>
    <input type="radio" name="sesso" value="F">Femmina<br>                

    Encryption: <keygen name="security"><br>

    Data di nascita:<br>
    -->
    <!--non supportato da firefox-->
    <!-- se vogliamo possiamo aggiungerlo
    <input type="date" name="dataNascita" required><br>

    -->
</form><?php }
}
