<div id="impostazioniUtente">
    <div>
        <h4>
            INFORMAZIONI GENERALI
        </h4>
        {if isset($utente)}
            <label for name="nome">Nome :</label>
            <input type="text" name="nome" value ="{$utente->getNomeUtente()}" readonly>
            <br>
            <label for name="cognome">Cognome :</label>
            <input type="text" name="cognome" value ="{$utente->getCognomeUtente()}" readonly>
            <br>
            <label for name="codice">Codice Fiscale :</label>
            <input type="text" name="codice" value ="{$utente->getCodiceFiscaleUtente()}" readonly>
            <br>
            <label for name="email">Email :</label>
            <input type="text" name="email" value ="{$utente->getEmailUtente()}" readonly>
            <br>
            {if isset($modificaInformazioni)}
                <label for name="via">Indirizzo :</label>
                <input type="text" name="Via" value ="{$utente->getViaUtente()}">
                <label>, </label>
                <input type="text"  value ="{$utente->getNumCivicoUtente()}">
                <br>
                <label for name="CAP">CAP :</label>
                <input type="text" name="CAP" value ="{$utente->getCAPUtente()}" >
            {else}
                <label for name="via">Indirizzo :</label>
                <input type="text" name="Via" value ="{$utente->getViaUtente()}" >
                <label>, </label>
                <input type="text"  value ="{$utente->getNumCivicoUtente()}" readonly>
                <br>
                <label for name="CAP">CAP :</label>
                <input type="text" name="CAP" value ="{$utente->getCAPUtente()}" readonly>
                <br>
                <input type="button" id="#modificaIndirizzoUtente" value="Modifica Indirizzo">  
            {/if}
        {/if}
    </div>

    <div>
        <h4>
            MEDICO CURANTE
        </h4>
        {if NULL !== $utente->getMedicoUtente()}
            <label for name="medicoUtente">Medico :</label>
            <input type="text" name="medicoUtente" value ="{$utente->getMedicoUtente()}" readonly>
            <br>
            <input type="button" id="#modificaMedicoUtente" value="Modifica Medico">  
        {else}
            <input type="button" id="#aggiungiMedicoUtente" value="Aggiungi Medico">     
        {/if}
    </div>

    <div>
        <h4>
            CREDENZIALI
        </h4>
        {if isset($utente)}                    
            {if isset($modificaCredenziali)}
                <label for name="username">Username :</label>
                <input type="text" name="username" value ="{$utente->getUsernameUtente()}"readonly>
                <label for name="password">Password :</label>
                <input type="password" name="password">
                <label for name="ripetiPassword">Ripeti Password :</label>
                <input type="password" name="ripetiPassword" >
                <br>
                <input type="button" id="#inviaNuovaPasswordUtente" value="Invia Nuova Password">
            {else}  
                <label for name="username">Username :</label>
                <input type="text" name="username" value ="{$utente->getUsernameUtente()}" readonly>
                <br>
                <input type="button" id="#modificaPasswordUtente" value="Modifica Credenziali">
            {/if}
        {/if}
    </div>
</div>