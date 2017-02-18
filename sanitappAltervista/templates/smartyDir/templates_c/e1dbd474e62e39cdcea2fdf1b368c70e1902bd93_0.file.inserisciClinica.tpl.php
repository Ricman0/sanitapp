<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:32:39
  from "/membri/sanitapp/templates/smartyDir/templates/inserisciClinica.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8af67a2e0b0_61261787',
  'file_dependency' => 
  array (
    'e1dbd474e62e39cdcea2fdf1b368c70e1902bd93' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/inserisciClinica.tpl',
      1 => 1487443621,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8af67a2e0b0_61261787 ($_smarty_tpl) {
?>
<h3>INSERISCI I DATI PER REGISTRARTI IN SANITAPP</h3>
<hr>
<br>
<form class="formInserisci" name="inserisciClinica" method="POST" id="inserisciClinica">

 <!--   <input type="hidden" name="controller" value="registrazione" />
    <input type="hidden" name="task" value="clinica" /> -->

    <label for="nomeClinica" class="elementiForm">Nome</label>
    <input type="text" name="nomeClinica" class="elementiForm" id="nomeClinica" placeholder="Villa Serena" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['nomeClinica'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['nomeClinica'];
}?>" required />

    <br>

    <label for="titolare" class="elementiForm">Titolare</label>
    <input type="text" name="titolare" class="elementiForm" id="titolare" placeholder="Mario Rossi" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['titolare'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['titolare'];
}?>" required />

    <br>
    <label for="partitaIVA" class="elementiForm">Partita IVA</label>
    <input type="text" name="partitaIVA" class="elementiForm" id="partitaIVA" maxlength="11" placeholder="JAJF59382YHC3930" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['partitaIVA'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['partitaIVA'];
}?>" required />

    <br>
    <label for="emailClinica" class="elementiForm">Email</label>
    <input type="email" name="email" class="elementiForm" id="emailClinica" placeholder="villaserena@gmail.it" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['email'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['email'];
}?>" required />

    <br>
    <label for="PECClinica" class="elementiForm">PEC</label>
    <input type="email" name="PEC" class="elementiForm" id="PECClinica" placeholder="villaserena@pec.it" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['PEC'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['PEC'];
}?>" required />

    <br>
    <label for="telefonoClinica" class="elementiForm">Telefono</label>
    <input type="tel" name="telefonoClinica" class="elementiForm" id="telefonoClinica" maxlength="10" placeholder="085821345" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['telefono'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['telefono'];
}?>" required />

    <br>
    <label for="capitaleSociale" class="elementiForm">Capitale Sociale</label>
    <input type="text" name="capitaleSociale" class="elementiForm" id="capitaleSociale" placeholder="320.000€" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['capitaleSociale'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['capitaleSociale'];
}?>" />

    <br>

    <label for="indirizzoClinica" class="elementiForm">Indirizzo</label>
    <input type="text" name="indirizzoClinica" class="elementiForm" id="indirizzoClinica" placeholder="Via/C.da Acquaventina" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['via'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['via'];
}?>" required />

    <br>
    <label for="numeroCivicoClinica" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivicoClinica" class="elementiForm" id="numeroCivicoClinica" min="0" max="1000" placeholder="3" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['numeroCivico'];
}?>" />

    <br>
    <label for="CAPClinica" class="elementiForm">CAP</label>
    <input type="text" name="CAPClinica" class="elementiForm" id="CAPClinica" maxlength="5" placeholder="65017" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['cap'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['cap'];
}?>" required />

    <br>
    <label for="localitaClinica" class="elementiForm">Località</label>
    <input type="text" name="localitaClinica" class="elementiForm" id="localitaClinica" placeholder="Penne" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['localitaClinica'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['localitaClinica'];
}?>" required />

    <br>
    <label for="provinciaClinica" class="elementiForm">Provincia</label>
    <select type="text" name="provinciaClinica" class="elementiForm" id="provinciaClinica" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['provinciaClinica'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['provinciaClinica'];
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
<!-- 
<option value=”AGRIGENTO”>AGRIGENTO</option>
        <option value=”ALESSANDRIA”>ALESSANDRIA</option>
        <option value=”ANCONA”>ANCONA</option>
        <option value=”AOSTA”>AOSTA</option>
        <option value=”AREZZO”>AREZZO</option>
        <option value=”ASCOLIPICENO”>ASCOLI PICENO</option>
        <option value=”ASTI”>ASTI</option>
        <option value=”AVELLINO”>AVELLINO</option>
        <option value=”BARI”>BARI</option>
        <option value=”BARLETTA-ANDRIA-TRANI”>BARLETTA-ANDRIA-TRANI</option>
        <option value=”BELLUNO”>BELLUNO</option>
        <option value=”BENEVENTO”>BENEVENTO</option>
        <option value=”BERGAMO”>BERGAMO</option>
        <option value=”BIELLA”>BIELLA</option>
        <option value=”BOLOGNA”>BOLOGNA</option>
        <option value=”BOLZANO”>BOLZANO</option>
        <option value=”BRESCIA”>BRESCIA</option>
        <option value=”BRINDISI”>BRINDISI</option>
        <option value=”CAGLIARI”>CAGLIARI</option>
        <option value=”CALTANISSETTA”>CALTANISSETTA</option>
        <option value=”CAMPOBASSO”>CAMPOBASSO</option>
        <option value=”CARBONIA-IGLESIAS”>CARBONIA-IGLESIAS</option>
        <option value=”CASERTA”>CASERTA</option>
        <option value=”CATANIA”>CATANIA</option>
        <option value=”CATANZARO”>CATANZARO</option>
        <option value=”CHIETI”>CHIETI</option>
        <option value=”COMO”>COMO</option>
        <option value=”COSENZA”>COSENZA</option>
        <option value=”CREMONA”>CREMONA</option>
        <option value=”CROTONE”>CROTONE</option>
        <option value=”CUNEO”>CUNEO</option>
        <option value=”ENNA”>ENNA</option>
        <option value=”FERMO”>FERMO</option>
        <option value=”FERRARA”>FERRARA</option>
        <option value=”FIRENZE”>FIRENZE</option>
        <option value=”FOGGIA”>FOGGIA</option>
        <option value=”FC”>FORLI’-CESENA</option>
        <option value=”FR”>FROSINONE</option>
        <option value=”GE”>GENOVA</option>
        <option value=”GO”>GORIZIA</option>
        <option value=”GR”>GROSSETO</option>
        <option value=”IM”>IMPERIA</option>
        <option value=”IS”>ISERNIA</option>
        <option value=”SP”>LA SPEZIA</option>
        <option value=”AQ”>L’AQUILA</option>
        <option value=”LT”>LATINA</option>
        <option value=”LE”>LECCE</option>
        <option value=”LC”>LECCO</option>
        <option value=”LI”>LIVORNO</option>
        <option value=”LO”>LODI</option>
        <option value=”LU”>LUCCA</option>
        <option value=”MC”>MACERATA</option>
        <option value=”MN”>MANTOVA</option>
        <option value=”MS”>MASSA-CARRARA</option>
        <option value=”MT”>MATERA</option>
        <option value=”VS”>MEDIO CAMPIDANO</option>
        <option value=”ME”>MESSINA</option>
        <option value=”MI”>MILANO</option>
        <option value=”MO”>MODENA</option>
        <option value=”MB”>MONZA E DELLA BRIANZA</option>
        <option value=”NA”>NAPOLI</option>
        <option value=”NO”>NOVARA</option>
        <option value=”NU”>NUORO</option>
        <option value=”OG”>OGLIASTRA</option>
        <option value=”OT”>OLBIA-TEMPIO</option>
        <option value=”OR”>ORISTANO</option>
        <option value=”PD”>PADOVA</option>
        <option value=”PA”>PALERMO</option>
        <option value=”PR”>PARMA</option>
        <option value=”PV”>PAVIA</option>
        <option value=”PG”>PERUGIA</option>
        <option value=”PU”>PESARO E URBINO</option>
        <option value=”PE”>PESCARA</option>
        <option value=”PC”>PIACENZA</option>
        <option value=”PI”>PISA</option>
        <option value=”PT”>PISTOIA</option>
        <option value=”PN”>PORDENONE</option>
        <option value=”PZ”>POTENZA</option>
        <option value=”PO”>PRATO</option>
        <option value=”RG”>RAGUSA</option>
        <option value=”RA”>RAVENNA</option>
        <option value=”RC”>REGGIO DI CALABRIA</option>
        <option value=”RE”>REGGIO NELL’EMILIA</option>
        <option value=”RI”>RIETI</option>
        <option value=”RN”>RIMINI</option>
        <option value=”RM”>ROMA</option>
        <option value=”RO”>ROVIGO</option>
        <option value=”SA”>SALERNO</option>
        <option value=”SS”>SASSARI</option>
        <option value=”SV”>SAVONA</option>
        <option value=”SI”>SIENA</option>
        <option value=”SR”>SIRACUSA</option>
        <option value=”SO”>SONDRIO</option>
        <option value=”TA”>TARANTO</option>
        <option value=”TE”>TERAMO</option>
        <option value=”TR”>TERNI</option>
        <option value=”TO”>TORINO</option>
        <option value=”TP”>TRAPANI</option>
        <option value=”TN”>TRENTO</option>
        <option value=”TV”>TREVISO</option>
        <option value=”TS”>TRIESTE</option>
        <option value=”UD”>UDINE</option>
        <option value=”VA”>VARESE</option>
        <option value=”VE”>VENEZIA</option>
        <option value=”VB”>VERBANO-CUSIO-OSSOLA</option>
        <option value=”VC”>VERCELLI</option>
        <option value=”VR”>VERONA</option>
        <option value=”VV”>VIBO VALENTIA</option>
        <option value=”VI”>VICENZA</option>
        <option value=”VT”>VITERBO</option>
-->

        <div class="autenticazione">
            <div class="username">            
                <label for="usernameClinica" class="elementiForm">Username</label>
                <input type="text" name="username" class="elementiForm" id="usernameClinica" placeholder="clari" value="<?php if (isset($_smarty_tpl->tpl_vars['datiValidi']->value['username'])) {
echo $_smarty_tpl->tpl_vars['datiValidi']->value['username'];
}?>" required />

                <br>
            </div>
            <div class="password">            
                <label for="passwordClinica" class="elementiForm">Password</label>
                <input type="password" name="passwordClinica" maxlength="10" class="elementiForm" id="passwordClinica" placeholder="R5t6sg6I" required />

                <br>
                <label for="ripetiPasswordClinica" class="elementiForm">Ripeti Password</label>
                <input type="password" name="ripetiPasswordClinica" maxlength="10" class="elementiForm" id="ripetiPasswordClinica" placeholder="R5t6sg6I" required />

                <br>
            </div>
        </div>
        <br>
        <input type="checkbox" id="terminiServizio" name="terminiServizio" /><span class="grassetto">  ACCETTO I <span class="grassetto link cliccabile">TERMINI DEL SERVIZIO</span></span>
        <br>

    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneClinica">
    </div>
</form><?php }
}
