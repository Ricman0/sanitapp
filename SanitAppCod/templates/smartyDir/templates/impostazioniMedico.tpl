{if isset($informazioniGenerali)}
    <div id="informazioniGenerali">
        <h4>
            INFORMAZIONI GENERALI
        </h4>
        {if isset($medico)}
            <label for="nome">Nome :</label>
            <input type="text" name="nome" value ="{$medico->getNomeMedico()}" readonly />
            <br>
            <label for="cognome">Cognome :</label>
            <input type="text" name="cognome" value ="{$medico->getCognomeMedico()}" readonly />
            <br>
            <label for="codice">Codice Fiscale :</label>
            <input type="text" name="codice" maxlength="16" value ="{$medico->getCodiceFiscaleMedico()}" readonly />
            <br>
            <label for="email">Email :</label>
            <input type="text" name="email" value ="{$medico->getEmail()}" readonly />
            <br>
                {if isset($modificaInformazioni)}
                    <form id="formModificaInformazioni">
                        <label for="Via">Indirizzo :</label>
                        <input type="text" name="Via" value ="{$medico->getViaMedico()}" />
                        <label>, </label>
                        <input type="text" name="NumCivico" value="{$medico->getNumCivicoMedico()}" />
                        <br>
                        <label for="CAP">CAP :</label>
                        <input type="text" name="CAP" maxlength="5" value="{$medico->getCAPMedico()}" />
                        <br>
                        <input type="submit" id="modificaIndirizzoMedicoFatto" value="OK" />
                    </form>
                {else}
                    <label for="Via">Indirizzo :</label>
                    <input type="text" name="Via" value="{$medico->getViaMedico()}" readonly />
                    <label>, </label>
                    <input type="text" name="NumCivico" value="{$medico->getNumCivicoMedico()}" readonly />
                    <br>
                    <label for="CAP">CAP :</label>
                    <input type="text" name="CAP" maxlength="5" value="{$medico->getCAPMedico()}" readonly />
                    <br>
                    <input type="button" id="modificaIndirizzoMedico" value="Modifica Indirizzo" />  
                    <br>
                {/if}
                {if isset($modifica)}
                    <label for="ProvinciaAlbo">Provincia Albo :</label>
                    <input type="text" name="ProvinciaAlbo" value="{$medico->getProvinciaAlboMedico()}" />
                    <br>
                    <label for="NumIscrizione">Numero Iscrizione :</label>
                    <input type="text" name="NumIscrizione"  value="{$medico->getNumIscrizioneMedico() }" />
                    <br>
                    <input type="button" id="modificaMedicoFatto" value="OK" />  
                {else}
                    <label for="ProvinciaAlbo">Provincia Albo :</label>
                    <input type="text" name="ProvinciaAlbo" value="{$medico->getProvinciaAlboMedico()}" readonly />
                    <br>
                    <label for="NumIscrizione">Numero Iscrizione :</label>
                    <input type="text" name="NumIscrizione" maxlength="5" value="{$medico->getNumIscrizioneMedico() }" readonly />
                    <br>
                    <input type="button" id="modificaMedico" value="Modifica" />  
                {/if}
        {/if}
    </div>
{/if}


{if isset($credenziali)}
    <div id="credenziali">
        <h4>
            CREDENZIALI
        </h4>
        {if isset($medico)}                    
            {if isset($modificaCredenziali)}
                <form id="formModificaPassword" >                    
                    <label for="username">Username :</label>
                    <input type="text" name="username" value ="{$medico->getUsername()}" readonly />
                    <label for="password">Password :</label>
                    <input type="password" name="password" id='nuovaPassword'/>
                    <label for="ripetiPassword">Ripeti Password :</label>
                    <input type="password" name="ripetiPassword" />
                    <br>
                    <input type="submit" id="inviaNuovaPassword" value="Invia Nuova Password" />
                </form>
            {else}  
                <label for="username">Username :</label>
                <input type="text" name="username" value ="{$medico->getUsername()}" readonly />
                <br>
                <input type="button" id="modificaPassword" value="Modifica Credenziali" />
            {/if}
        {/if}
    </div>

{/if}