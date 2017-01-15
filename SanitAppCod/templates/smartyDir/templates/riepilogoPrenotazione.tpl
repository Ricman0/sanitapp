{if !isset($feedbacks)}
    <h3>RIEPILOGO PRENOTAZIONE</h3>
    <div>
        {if isset($idPrenotazione)}
            <span class="grassetto">ID PRENOTAZIONE:</span><span>  {$idPrenotazione}</span>
            <br>
            
        {/if}
        <span class="grassetto">NOME ESAME:</span><span>  {$esame->getNomeEsameEsame()}</span>
            <br>
            <span class="grassetto">DATA:  </span><span id="dataPrenotazione"> {$data}</span>
            <br>
            <span class="grassetto">ORARIO:  </span><span id="orarioPrenotazione" > {$orario}</span>
            <br>
            <span class="grassetto">DURATA:</span><span>  {$esame->getDurataEsame()}</span>
            <br>
            <span class="grassetto">PREZZO:</span><span>  {$esame->getPrezzoEsame()}</span>
            <br>
            <span class="grassetto">CLINICA:</span><span>  {$clinica->getNomeClinicaClinica()}</span>
            <br>
            <span class="grassetto">INDIRIZZO:</span><span>  {$clinica->getViaClinica()}</span>
            <br>
            <span class="grassetto">TELEFONO:</span><span>  {$clinica->getTelefonoClinica()}</span>
            <br>
    </div>
    <div>
        <span class="grassetto">UTENTE:</span><span>  {$utente->getNomeUtente()}  {$utente->getCognomeUtente()}</span>
        <br>
        <span class="grassetto">CODICE FISCALE:</span><span>  {$utente->getCodiceFiscaleUtente()}</span>
        <br>
        <span class="grassetto">EMAIL:</span><span>  {$utente->getEmailUser()}</span>
        <br>
        <span class="grassetto">INDIRIZZO:</span><span>  {$utente->getViaUtente()}</span>
        <br>
    </div>
        {if ($modifica)===FALSE }
            <input type="button" id="confermaPrenotazione" value="Conferma" data-codice="{$codice}" data-idClinica="{$clinica->getPartitaIVAClinica()}" data-idEsame="{$esame->getIDEsameEsame()}"/>
        {else}
            <input type="button" id="confermaModificaPrenotazione" value="Conferma Modifica" />
        {/if}
{else}
    {$feedbacks}
{/if}