    {if isset($informazioniGenerali)}
        <div id="informazioniGeneraliUtente">
            <h4>
                INFORMAZIONI GENERALI
            </h4>
            {if isset($utente)}
                <label for="nome">Nome :</label>
                <input type="text" name="nome" value ="{$utente->getNomeUtente()}" readonly />
                <br>
                <label for="cognome">Cognome :</label>
                <input type="text" name="cognome" value ="{$utente->getCognomeUtente()}" readonly />
                <br>
                <label for="codice">Codice Fiscale :</label>
                <input type="text" name="codice" value ="{$utente->getCodiceFiscaleUtente()}" readonly />
                <br>
                <label for="email">Email :</label>
                <input type="text" name="email" value ="{$utente->getEmail()}" readonly />
                <br>
                    {if isset($modificaInformazioni)}
                        <form id="formModificaInformazioni">
                            <label for="via">Indirizzo :</label>
                            <input type="text" name="Via" value ="{$utente->getViaUtente()}" />
                            <label>, </label>
                            <input type="text" name="NumCivico" value="{$utente->getNumCivicoUtente()}" />
                            <br>
                            <label for="CAP">CAP :</label>
                            <input type="text" name="CAP" value="{$utente->getCAPUtente()}" />
                            <br>
                            <input type="submit" id="modificaIndirizzoUtenteFatto" value="OK" />
                        </form>
                    {else}
                        <label for="via">Indirizzo :</label>
                        <input type="text" name="Via" value="{$utente->getViaUtente()}" readonly />
                        <label>, </label>
                        <input type="text" name="NumCivico" value="{$utente->getNumCivicoUtente()}" readonly />
                        <br>
                        <label for="CAP">CAP :</label>
                        <input type="text" name="CAP" value="{$utente->getCAPUtente()}" readonly />
                        <br>
                        <input type="button" id="modificaIndirizzoUtente" value="Modifica Indirizzo" />  
                    {/if}
            {/if}
        </div>
    {/if}

    {if isset($medicoCurante)}
        <div id="medicoCurante">
            <h4>
                MEDICO CURANTE
            </h4>
            {if isset($modificaMedicoCurante)}
                <form id='formModificaMedico'>
                    <input id ='inverti' type="hidden" name="inverti" value="si" />
                    <label for="codiceFiscale">Medico :</label>
                    <input type="text" name="codiceFiscale" value ="{$utente->getMedicoCurante()}" />
                    <br>
                    <input type="submit" id="medicoUtenteModificato" value="OK" />
                </form>
            {else}
                {if NULL !== $utente->getMedicoCurante()}
                    <label for="codiceFiscale">Medico :</label>
                    <input type="text" name="codiceFiscale" value ="{$utente->getMedicoCurante()}" readonly />
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
            <h4>
                CREDENZIALI
            </h4>
            {if isset($utente)}                    
                {if isset($modificaCredenziali)}
                    <form id="formModificaPassword" >                    
                        <label for="username">Username :</label>
                        <input type="text" name="username" value ="{$utente->getUsername()}"readonly />
                        <label for="password">Password :</label>
                        <input type="password" name="password" id='nuovaPassword'/>
                        <label for="ripetiPassword">Ripeti Password :</label>
                        <input type="password" name="ripetiPassword" />
                        <br>
                        <input type="submit" id="inviaNuovaPasswordUtente" value="Invia Nuova Password" />
                    </form>
                {else}  
                    <label for="username">Username :</label>
                    <input type="text" name="username" value ="{$utente->getUsername()}" readonly />
                    <br>
                    <input type="button" id="modificaPasswordUtente" value="Modifica Credenziali" />
                {/if}
            {/if}
        </div>
        
    {/if}