<div id="infoPrenotazione">
    <br>
    <br>
    <h3>
        INFORMAZIONI PRENOTAZIONE 
    </h3>
    <hr>
    <br>
    <div>
        {if ($tipoUser==='clinica' || $tipoUser==='medico')}
            {if isset($nomeUtente)}
                <span class="grassetto">NOME:</span><span>  {$nomeUtente}</span>
                <br>
            {/if}
            {if isset($cognomeUtente)}
                <span class="grassetto">COGNOME:</span><span>  {$cognomeUtente}</span>
                <br>
            {/if}
        {/if}
        <span class="grassetto">ID PRENOTAZIONE:</span><span>  {$prenotazione->getIDPrenotazionePrenotazione() }</span>
        <br>
        <span class="grassetto">ESAME:</span><span>  {$nomeEsame}</span>
        <br>
        <span class="grassetto">DATA E ORA:</span><span>  {$prenotazione->getDataEOraPrenotazione()}</span>
        <br>
        <span class="grassetto">MEDICO:</span><span>  {$medicoEsame}</span>
        <br>
            
        {if ($tipoUser==='utente')}
            <div id="divConfermaPrenotazioneUtente" >
                <span class="grassetto">PRENOTAZIONE:  </span> 
                {if ($prenotazione->getConfermataPrenotazione()==TRUE)} 

                    Confermata 
                {else} 

                    Non Confermata 
                    <br>
                    <input type="button" id="confermaPrenotazioneUtente" value="Conferma Prenotazione" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
                {/if}
            </div>

           <span class="grassetto">PRENOTAZIONE EFFETTUATA DA:</span><span>  {$nome} {$cognome}</span>
            <br>
            
        {/if}
            <span class="grassetto">ESAME ESEGUITO:  </span>
            <span> 
                {if ($tipoUser==='clinica')}
                    {if ($prenotazione->getEseguitaPrenotazione()== TRUE)}
                        <i id="esameEseguito" class="fa fa-check fa-lg verde modificaNonEseguito cliccabile" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" aria-hidden="true"></i>
                    {else} 
                        <i id="esameNonEseguito" class="fa fa-times fa-lg rosso modificaEseguito cliccabile" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" aria-hidden="true"></i>
                    {/if}
                {else}
                    {if ($prenotazione->getEseguitaPrenotazione()== TRUE) }
                        <i class="fa fa-check fa-lg verde" aria-hidden="true"></i>
                    {else} 
                        <i class="fa fa-times fa-lg rosso" aria-hidden="true"></i>
                    {/if}
                {/if} 
                
            </span>
            <br>
        <div>
            {if isset($idReferto)}
                <span class="grassetto">CODICE REFERTO:  </span><span>{$idReferto}</span> 
                <br>
                <input type="button" id="scaricaRefertoButton" class="scaricaReferto" value="Scarica Referto" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
            {/if}
        </div> 
    </div>
    {if ($tipoUser==='utente' || $tipoUser==='medico')}
        <h3>INFORMAZIONI CLINICA CHE ESEGUE LA PRENOTAZIONE</h3>
        <span class="grassetto">CLINICA:</span><span>  {$eClinica->getNomeClinicaClinica()}</span>
        <br>
        <span class="grassetto">INDIRIZZO CLINICA:</span><span>  {$eClinica->getViaClinica()} , {$eClinica->getLocalitaClinica()} ({$eClinica->getProvinciaClinica()}) </span>
        <br>
        <span class="grassetto">TELEFONO:</span><span>  {$eClinica->getTelefonoClinica()}</span>
        <br>
        <span class="grassetto">EMAIL:</span><span>  {$eClinica->getEmailUser()}</span>
        <br>
       
    {/if}        

    {if ($tipoUser==='clinica' && !isset($idReferto) && $cancellaPrenota===FALSE && ($prenotazione->getEseguitaPrenotazione()))}
        <input type="button" id="aggiungiRefertoButton" value="Aggiungi Referto" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
    {/if}
    <br>      
    {if ($cancellaPrenota===TRUE && $prenotazione->getEseguitaPrenotazione()== FALSE)}
        <input type="button" id="cancellaPrenotazione" value="Cancella Prenotazione" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
        <input type="button" id="modificaPrenotazione" value="Modifica Prenotazione" data-idPrenotazione="{$prenotazione->getIDPrenotazionePrenotazione()}" />
    {/if}
</div>