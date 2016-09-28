<form name="inserisciMedico" method="post" id="inserisciMedico">

    <input type="hidden" name="controller" value="registrazione"/>
    <input type="hidden" name="task" value="medico"/>

    <label for="nomeMedico" class="elementiForm">Nome</label>
    <input type="text" name="nomeMedico" class="elementiForm" id="nomeMedico" placeholder="Mario" value="{if isset($datiValidi.nome)}{$datiValidi.nome}{/if}" required/>

    <br>

    <label for="cognomeMedico" class="elementiForm">Cognome</label>
    <input type="text" name="cognomeMedico" class="elementiForm" id="cognomeMedico" placeholder="Rossi" value="{if isset($datiValidi.cognome)}{$datiValidi.cognome}{/if}" required/>

    <br>
    <label for="codiceFiscaleMedico" class="elementiForm">Codice Fiscale</label>
    <input type="text" name="codiceFiscaleMedico" class="elementiForm" id="codiceFiscaleMedico" placeholder="MRARSS67S42G438S" value="{if isset($datiValidi.codiceFiscale)}{$datiValidi.codiceFiscale}{/if}" required/>

    <br>

    <label for="indirizzoMedico" class="elementiForm">Indirizzo</label>
    <input type="text" name="indirizzoMedico" class="elementiForm" id="indirizzoMedico" placeholder="Via/C.da Acquaventina"  value="{if isset($datiValidi.via)}{$datiValidi.via}{/if}"/>

    <br>

    <label for="numeroCivicoMedico" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivicoMedico" class="elementiForm" id="numeroCivicoMedico" min="0" max="1000" placeholder="30" value="{if isset($datiValidi.numeroCivico)}{$datiValidi.numeroCivico}{/if}" required/>

    <br>
    <label for="CAPMedico" class="elementiForm">CAP</label>
    <input type="text" name="CAPMedico" class="elementiForm" id="CAPMedico" placeholder="65017" value="{if isset($datiValidi.CAP)}{$datiValidi.CAP}{/if}" required/>

    <br>
    <label for="numeroIscrizione" class="elementiForm">Numero Iscrizione</label>
    <input type="text" name="numeroIscrizione" class="elementiForm" id="numeroIscrizione" placeholder="03693" value="{if isset($datiValidi.numeroIscrizione)}{$datiValidi.numeroIscrizione}{/if}" required/>

    <br>

    <label for="provinciaAlbo" class="elementiForm">Provincia Albo</label>
    <input type="text" name="provinciaAlbo" class="elementiForm" id="provinciaAlbo" placeholder="PE" value="{if isset($datiValidi.provinciaAlbo)}{$datiValidi.provinciaAlbo}{/if}" required/>

    <br>

    <!--type=email non supportato da safari-->
    <label for="emailMedico" class="elementiForm">Email</label>
    <input type="email" name="emailMedico" class="elementiForm" id="emailMedico" placeholder="mario.rossi@example.it" value="{if isset($datiValidi.email)}{$datiValidi.email}{/if}" required>

    <br>
    <label for="PECMedico" class="elementiForm">PEC</label>
    <input type="email" name="PECMedico" class="elementiForm" id="PECMedico" placeholder="mario.rossi@pec.it" value="{if isset($datiValidi.PEC)}{$datiValidi.PEC}{/if}" required>

    <br>

    <div class="username">            
        <label for="usernameMedico" class="elementiForm">Username</label>
        <input type="text" name="usernameMedico" class="elementiForm" id="usernameMedico" pattern="^[a-z0-9]*$" title="Inserisci elementi alfanumerici" placeholder="Mario" value="{if isset($datiValidi.username)}{$datiValidi.username}{/if}" required />
        <br>
    </div>
    <div class="password"> 
        <label for="passwordMedico" class="elementiForm">Password</label>
        <input type="password" name="passwordMedico" class="elementiForm" id="passwordMedico" required >

        <br>
        <label for="ripetiPasswordMedico" class="elementiForm">Ripeti Password</label>
        <input type="password" name="ripetiPasswordMedico" class="elementiForm" id="ripetiPasswordMedico" required >

        <br>
    </div>

    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneMedico">
    </div>
    <!-- vedere la selezione dell'albo provincia perchè usa jquery-->
</form>