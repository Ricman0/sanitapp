{if !isset($feedbacks)}
    <h3>Riepilogo Prenotazione</h3>
    <div>
        {if isset($idPrenotazione)}
            <span id="idPrenotazione">ID Prenotazione: {$idPrenotazione}</span>
            <br>
        {/if}
        <span>Nome Esame:{$esame->getNomeEsame()}</span>
        <br>
        <span id="dataPrenotazione">Data:{$data}</span>
        <br>
        <span id="orarioPrenotazione">Orario:{$orario}</span>
        <br>
        <span>Durata:{$esame->getDurataEsame()}</span>
        <br>
        <span>Prezzo:{$esame->getPrezzoEsame()}</span>
        <br>
        <span>Clinica:{$clinica->getNomeClinica()}</span>
        <br>
        <span>Indirizzo:{$clinica->getViaClinica()}</span>
        <br>  
        <span>Telefono:{$clinica->getTelefonoClinica()}</span>
        <br>  

    </div>
    <div>

        <span>Utente:{$utente->getNomeUtente()}</span>
        <span>{$utente->getCognomeUtente()}</span>
        <br>
        <span>Codice Fiscale:{$utente->getCodiceFiscaleUtente()}</span>
        <br>
        <span>Email:{$utente->getEmail()}</span>
        <br>
        <span>Indirizzo:{$utente->getViaUtente()}</span>
        <br>
    </div>
        {if ($modifica)===FALSE }
            <input type="button" id="confermaPrenotazione" value="Conferma" data-codice="{$codice}" data-idClinica="{$clinica->getPartitaIVAClinica()}" data-idEsame="{$esame->getIDEsame()}"/>
        {else}
            <input type="button" id="confermaModificaPrenotazione" value="Conferma Modifica" />
        {/if}
{else}
    {$feedbacks}
{/if}