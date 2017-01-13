<div id="infoReferto">
    <h3>
        INFORMAZIONI REFERTO 
    </h3>
    <div>

        {if ($tipoUser==='clinica')}
            
            <span class="grassetto">ID REFERTO:</span><span>  {$referto->getIDRefertoReferto()}</span>
            <br>
            <span class="grassetto">ID PRENOTAZIONE:</span><span>  {$referto->getIDPrenotazioneReferto()}</span>
            <br>
            <span class="grassetto">ID ESAME:</span><span>  {$referto->getIDEsameReferto()}</span>
            <br>
            
        {/if}
        
        <span class="grassetto">NOME:</span><span>  {$utente->getNomeUtente()}</span>
        <br>
        <span class="grassetto">COGNOME:</span><span>  {$utente->getCognomeUtente()}</span>
        <br>
        <span class="grassetto">CODICE FISCALE:</span><span>  {$utente->getCodiceFiscaleUtente()}</span>
        <br>
        <span class="grassetto">ESAME:</span><span>  {$esame->getNomeEsameEsame()}</span>
        <br>
        
        {if ($tipoUser!=='clinica')}
            <span class="grassetto">CLINICA:</span><span>  {$clinica->getNomeClinica()}</span>
            <br>
            <span class="grassetto">PROVINCIA CLINIA:</span><span>  {$clinica->getProvinciaClinica()}</span>
            <br>
        {/if}
        
        <span class="grassetto">DATA E ORA PRENOTAZIONE:</span><span>  {$prenotazione->getDataEOraPrenotazione()}</span>
        <br>
        <span class="grassetto">DATA REFERTO:</span><span>  {$referto->getDataRefertoReferto()}</span>
        <br>
        <span class="grassetto">MEDICO:</span><span>  {$referto->getMedicoRefertoReferto()}</span>
        <br>
        <span class="grassetto">CONDIVISO CON MEDICO CURANTE:</span><input type="checkbox" id="refertoCondivisoConMedico" name="refertoCondivisoConMedico" {if $referto->getCondivisoConMedicoReferto()== TRUE} checked{/if} />
        <br>
         
        <input type="button" id="scaricaRefertoButton2" class="scaricaReferto" value="Scarica Referto" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
        <!-- <input type="button" id="condividiRefertoButton"  value="Condividi Referto" data-idPrenotazione="{$referto->getIDPrenotazioneReferto()}" /> -->
    </div>
</div>