<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:32:36
  from "/membri/sanitapp/templates/smartyDir/templates/inserisciMedico.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8af64e9d197_22348470',
  'file_dependency' => 
  array (
    '58d1830db2787e20e579f51f12c38a3f33e76567' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/inserisciMedico.tpl',
      1 => 1487443620,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8af64e9d197_22348470 ($_smarty_tpl) {
?>
<h3>INSERISCI I DATI PER REGISTRARTI IN SANITAPP</h3>
<hr>
<br>
<form name="inserisciMedico" method="POST" id="inserisciMedico">

 <!--   <input type="hidden" name="controller" value="registrazione"/>
    <input type="hidden" name="task" value="medico"/> -->

    <label for="nomeMedico" class="elementiForm">Nome</label>
    <input type="text" name="nomeMedico" class="elementiForm" id="nomeMedico" placeholder="Mario" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['nome'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['nome'];
}?>" required/>

    <br>

    <label for="cognomeMedico" class="elementiForm">Cognome</label>
    <input type="text" name="cognomeMedico" class="elementiForm" id="cognomeMedico" placeholder="Rossi" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['cognome'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['cognome'];
}?>" required/>

    <br>
    <label for="codiceFiscaleMedico" class="elementiForm">Codice Fiscale</label>
    <input type="text" name="codiceFiscale" class="elementiForm upperCase" id="codiceFiscaleMedico" maxlength="16" placeholder="MRARSS67S42G438S" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['codiceFiscale'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['codiceFiscale'];
}?>" required/>

    <br>

    <label for="indirizzoMedico" class="elementiForm">Indirizzo</label>
    <input type="text" name="indirizzoMedico" class="elementiForm" id="indirizzoMedico" placeholder="Via/C.da Acquaventina"  value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['via'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['via'];
}?>"/>

    <br>

    <label for="numeroCivicoMedico" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivicoMedico" class="elementiForm" id="numeroCivicoMedico" min="0" max="1000" placeholder="30" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'];
}?>" required />

    <br>
    <label for="CAPMedico" class="elementiForm">CAP</label>
    <input type="text" name="CAPMedico" class="elementiForm" id="CAPMedico" maxlength="5" placeholder="65017" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['CAP'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['CAP'];
}?>" required/>

    <br>
    <label for="numeroIscrizione" class="elementiForm">Numero Iscrizione</label>
    <input type="text" name="numeroIscrizione" class="elementiForm" id="numeroIscrizione" placeholder="036938" maxlength="6" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['numeroIscrizione'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['numeroIscrizione'];
}?>" required/>

    <br>

    <label for="provinciaAlbo" class="elementiForm">Provincia Albo</label>
    <select type="text" name="provinciaAlbo" class="elementiForm" id="provinciaAlbo" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['provinciaAlbo'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['provinciaAlbo'];
}?>" required >
        <option disabled selected value=""> -- select an option -- </option>
        <option>AGRIGENTO</option>
        <option>ALESSANDRIA</option>
        <option>ANCONA</option>
        <option>AOSTA</option>
        <option>AREZZO</option>
        <option>ASCOLI PICENO</option>
        <option>ASTI</option>
        <option>AVELLINO</option>
        <option>BARI</option>
        <option>BARLETTA-ANDRIA-TRANI</option>
        <option>BELLUNO</option>
        <option>BENEVENTO</option>
        <option>BERGAMO</option>
        <option>BIELLA</option>
        <option>BOLOGNA</option>
        <option>BOLZANO</option>
        <option>BRESCIA</option>
        <option>BRINDISI</option>
        <option>CAGLIARI</option>
        <option>CALTANISSETTA</option>
        <option>CAMPOBASSO</option>
        <option>CARBONIA-IGLESIAS</option>
        <option>CASERTA</option>
        <option>CATANIA</option>
        <option>CATANZARO</option>
        <option>CHIETI</option>
        <option>COMO</option>
        <option>COSENZA</option>
        <option>CREMONA</option>
        <option>CROTONE</option>
        <option>CUNEO</option>
        <option>ENNA</option>
        <option>FERMO</option>
        <option>FERRARA</option>
        <option>FIRENZE</option>
        <option>FOGGIA</option>
        <option>FORLI’-CESENA</option>
        <option>FROSINONE</option>
        <option>GENOVA</option>
        <option>GORIZIA</option>
        <option>GROSSETO</option>
        <option>IMPERIA</option>
        <option>ISERNIA</option>
        <option>LA SPEZIA</option>
        <option>L’AQUILA</option>
        <option>LATINA</option>
        <option>LECCE</option>
        <option>LECCO</option>
        <option>LIVORNO</option>
        <option>LODI</option>
        <option>LUCCA</option>
        <option>MACERATA</option>
        <option>MANTOVA</option>
        <option>MASSA-CARRARA</option>
        <option>MATERA</option>
        <option>MEDIO CAMPIDANO</option>
        <option>MESSINA</option>
        <option>MILANO</option>
        <option>MODENA</option>
        <option>MONZA E DELLA BRIANZA</option>
        <option>NAPOLI</option>
        <option>NOVARA</option>
        <option>NUORO</option>
        <option>OGLIASTRA</option>
        <option>OLBIA-TEMPIO</option>
        <option>ORISTANO</option>
        <option>PADOVA</option>
        <option>PALERMO</option>
        <option>PARMA</option>
        <option>PAVIA</option>
        <option>PERUGIA</option>
        <option>PESARO E URBINO</option>
        <option>PESCARA</option>
        <option>PIACENZA</option>
        <option>PISA</option>
        <option>PISTOIA</option>
        <option>PORDENONE</option>
        <option>POTENZA</option>
        <option>PRATO</option>
        <option>RAGUSA</option>
        <option>RAVENNA</option>
        <option>REGGIO DI CALABRIA</option>
        <option>REGGIO NELL’EMILIA</option>
        <option>RIETI</option>
        <option>RIMINI</option>
        <option>ROMA</option>
        <option>ROVIGO</option>
        <option>SALERNO</option>
        <option>SASSARI</option>
        <option>SAVONA</option>
        <option>SIENA</option>
        <option>SIRACUSA</option>
        <option>SONDRIO</option>
        <option>TARANTO</option>
        <option>TERAMO</option>
        <option>TERNI</option>
        <option>TORINO</option>
        <option>TRAPANI</option>
        <option>TRENTO</option>
        <option>TREVISO</option>
        <option>TRIESTE</option>
        <option>UDINE</option>
        <option>VARESE</option>
        <option>VENEZIA</option>
        <option>VERBANO-CUSIO-OSSOLA</option>
        <option>VERCELLI</option>
        <option>VERONA</option>
        <option>VIBO VALENTIA</option>
        <option>VICENZA</option>
        <option>VITERBO</option>
    </select>
    
    <br>

    <!--type=email non supportato da safari-->
    <label for="emailMedico" class="elementiForm">Email</label>
    <input type="email" name="email" class="elementiForm" id="emailMedico" placeholder="mario.rossi@example.it" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['email'];
}?>" required>

    <br>
    <label for="PECMedico" class="elementiForm">PEC</label>
    <input type="email" name="PEC" class="elementiForm" id="PECMedico" placeholder="mario.rossi@pec.it" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['PEC'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['PEC'];
}?>" required>

    <br>

    <div class="username">            
        <label for="usernameMedico" class="elementiForm">Username</label>
        <input type="text" name="username" class="elementiForm" id="usernameMedico" pattern="^[a-z0-9]*$" title="Inserisci elementi alfanumerici" placeholder="Mario" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['username'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['username'];
}?>" required />
        <br>
    </div>
    <div class="password"> 
        <label for="passwordMedico" class="elementiForm">Password</label>
        <input type="password" name="passwordMedico" maxlength="10" class="elementiForm" id="passwordMedico" required >

        <br>
        <label for="ripetiPasswordMedico" class="elementiForm">Ripeti Password</label>
        <input type="password" name="ripetiPasswordMedico" maxlength="10" class="elementiForm" id="ripetiPasswordMedico" required >

        <br>
    </div>
    <br>
    <input type="checkbox" id="terminiServizio" name="terminiServizio" /><span class="grassetto">  ACCETTO I <span class="grassetto link cliccabile">TERMINI DEL SERVIZIO</span></span>
    <br>
    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneMedico">
    </div>
    <!-- vedere la selezione dell'albo provincia perchè usa jquery-->
</form><?php }
}
