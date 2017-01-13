<div id="infoReferto">
    <h3>
        INFORMAZIONI REFERTO 
    </h3>
    <div>

        {if ($tipoUser==='clinica')}
            
            <span class="grassetto">ID REFERTO:</span><span>  {$referto->getIDReferto()}</span>
            <br>
            <span class="grassetto">ID PRENOTAZIONE:</span><span>  {$referto->getIDPrenotazione()}</span>
            <br>
            <span class="grassetto">ID ESAME:</span><span>  {$referto->getIDEsame()}</span>
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
        
        <span class="grassetto">DATA E ORA PRENOTAZIONE:</span><span>  {$prenotazione->getDataEOra()}</span>
        <br>
        <span class="grassetto">DATA REFERTO:</span><span>  {$referto->getDataReferto()}</span>
        <br>
        <span class="grassetto">MEDICO:</span><span>  {$referto->getMedicoReferto()}</span>
        <br>
        <span class="grassetto">CONDIVISO CON MEDICO CURANTE:</span><input type="checkbox" id="refertoCondivisoConMedico" name="refertoCondivisoConMedico" {if $referto->getCondivisoConMedicoReferto()== TRUE} checked{/if} />
        <br>
         
        <input type="button" id="scaricaRefertoButton2" class="scaricaReferto" value="Scarica Referto" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
        <!-- <input type="button" id="condividiRefertoButton"  value="Condividi Referto" data-idPrenotazione="{$referto->getIDPrenotazione()}" /> -->
    </div>
</div>