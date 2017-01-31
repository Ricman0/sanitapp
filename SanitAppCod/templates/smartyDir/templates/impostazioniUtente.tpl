    {if isset($informazioniGenerali)}
        <div id="informazioniGeneraliUtente">
            <h3>
                INFORMAZIONI GENERALI
            </h3>
            {if isset($utente)}
                <label for="nome" class="elementiForm">Nome :</label>
                <input type="text" name="nome" class="elementiForm" value ="{$utente->getNomeUtente()}" readonly />
                <br>
                <label for="cognome" class="elementiForm">Cognome :</label>
                <input type="text" name="cognome" class="elementiForm" value ="{$utente->getCognomeUtente()}" readonly />
                <br>
                <label for="codice" class="elementiForm">Codice Fiscale :</label>
                <input type="text" name="codice" class="elementiForm upperCase" maxlength="16" value ="{$utente->getCodFiscaleUtente()}" readonly />
                <br>
                <label for="email" class="elementiForm">Email :</label>
                <input type="text" name="email" class="elementiForm" value ="{$utente->getEmailUser()}" readonly />
                <br>
                {if isset($modificaInformazioni)}
                    <form id="formModificaInformazioni">
                        <label for="via" class="elementiForm">Indirizzo :</label>
                        <input type="text" name="Via" class="elementiForm" value ="{$utente->getViaUtente()}" />
                        <label>, </label>
                        <input type="text" name="NumCivico" class="elementiForm" value="{$utente->getNumCivicoUtente()}" />
                        <br>
                        <label for="CAP" class="elementiForm">CAP :</label>
                        <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$utente->getCAPUtente()}" />
                        <br>
                        <input type="submit" id="modificaIndirizzoUtenteFatto" value="OK" />
                    </form>
                {else}
                    <label for="via" class="elementiForm">Indirizzo :</label>
                    <input type="text" name="Via" class="elementiForm" value="{$utente->getViaUtente()}" readonly />
                    <label>, </label>
                    <input type="text" name="NumCivico" class="elementiForm" value="{$utente->getNumCivicoUtente()}" readonly />
                    <br>
                    <label for="CAP" class="elementiForm">CAP :</label>
                    <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$utente->getCAPUtente()}" readonly />
                    <br>
                    <input type="button" id="modificaIndirizzoUtente" value="Modifica Indirizzo" />  
                {/if}
            {/if}
        </div>
    {/if}

    {if isset($medicoCurante)}
        <div id="medicoCurante">
            <h3>
                MEDICO CURANTE
            </h3>
            {if isset($modificaMedicoCurante)}
                <form id='formModificaMedico'>
                    <input id ='inverti' type="hidden" name="inverti" value="si"  />
                    <label for="codiceFiscale" class="elementiForm">Codice Fiscale Medico :</label>
                    <input type="text" name="codiceFiscale" class="elementiForm upperCase" maxlength="16" value ="{$utente->getCodFiscaleMedicoUtente()}" />
                    <br>
                    <input type="submit" id="medicoUtenteModificato" value="OK" />
                </form>
            {else}
                {if NULL !== $utente->getCodFiscaleMedicoUtente() && isset($medico)}
                    <label for="nomeMedico" class="elementiForm">Nome Medico :</label>
                    <input type="text" name="nomeMedico" class="elementiForm" value ="{$medico->getNomeMedico()}" readonly />
                    <br>
                    <label for="cognomeMedico" class="elementiForm">Cognome Medico :</label>
                    <input type="text" name="cognomeMedico" class="elementiForm" value ="{$medico->getCognomeMedico()}" readonly />
                    <br>
                    <input type="button" id="modificaMedicoUtente" value="Modifica Medico" />  
                {else}
                    <input type="button" id="aggiungiMedicoUtente" value="Aggiungi Medico" />     
                {/if}
            {/if}
        </div>
    {/if}

    {if isset($credenziali)}
        <div id="credenziali">
            <h3>
                CREDENZIALI
            </h3>
            {if isset($utente)}                    
                {if isset($modificaCredenziali)}
                    <form id="formModificaPassword" >                    
                        <label for="username" class="elementiForm">Username :</label>
                        <input type="text" name="username" class="elementiForm" value ="{$utente->getUsernameUser()}"readonly />
                        <label for="password" class="elementiForm">Password :</label>
                        <input type="password" name="password" maxlength="10" class="elementiForm" id='nuovaPassword'/>
                        <br>
                        <label for="ripetiPassword" class="elementiForm">Ripeti Password :</label>
                        <input type="password" maxlength="10" name="ripetiPassword" />
                        <br>
                        <input type="submit" id="inviaNuovaPasswordUtente" value="Invia Nuova Password" />
                    </form>
                {else}  
                    <label for="username" class="elementiForm">Username :</label>
                    <input type="text" name="username" class="elementiForm" value ="{$utente->getUsernameUser()}" readonly />
                    <br>
                    <input type="button" id="modificaPassword" value="Modifica Credenziali" />
                {/if}
            {/if}
        </div>
        
    {/if}