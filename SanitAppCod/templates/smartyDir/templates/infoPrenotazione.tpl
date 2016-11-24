<div id="infoPrenotazione">
    <h4>
        Informazioni Prenotazione: 
    </h4>
    <div>
        {if ($tipoUser==='clinica' || $tipoUser==='medico')}
            {if isset($nomeUtente)}

                <span>
                    Nome: {$nomeUtente}
                </span>
                <br>
            {/if}
            {if isset($cognomeUtente)}
                <span>
                    Cognome: {$cognomeUtente}
                </span>
                <br>
            {/if}
        {/if}

        <span>
            Esame: {$nomeEsame}
        </span>
        <br>
        <span>
            Data e Ora: {$prenotazione->getDataEOra()}
        </span>
        <br>
        <span>
            Medico: {$medicoEsame}
        </span>
        <br>
        {if ($tipoUser==='utente')}
            <div id="divConfermaPrenotazioneUtente">
                Prenotazione: 
                {if ($prenotazione->getConfermataPrenotazione()==TRUE)} 

                    Confermata 
                {else} 

                    Non Confermata  
                    <input type="button" id="confermaPrenotazioneUtente" value="Conferma Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
                {/if}
            </div>

           
            <span>
                Prenotazione effettua da: {$nome} {$cognome}
            </span>
            <br>
        {/if}
         <span>
                Esame eseguito: 
                {if ($prenotazione->getEseguitaPrenotazione()== TRUE)}
                    <i class="fa fa-check fa-lg verde" aria-hidden="true"></i>
                {else} 
                   <i class="fa fa-times fa-lg rosso" aria-hidden="true"></i>
                {/if}
            </span>
            <br>
        <div>
            {if isset($idReferto)}
                Codice Referto : {$idReferto}
                <input type="button" id="scaricaRefertoButton" value="Scarica Referto" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
            {/if}
        </div> 
    </div>
    {if ($tipoUser==='utente' || $tipoUser==='medico')}
        <h4>Informazioni Clinica che esegue la prenotazione</h4>
        <span>
            Clinica: {$eClinica->getNomeClinica()}
        </span>

        <div>
            Indirizzo Clinica: {$eClinica->getViaClinica()} , {$eClinica->getLocalitaClinica()} ({$eClinica->getProvinciaClinica()})
        </div>
        <div> 
            Telefono: {$eClinica->getTelefonoClinica()} , Email: {$eClinica->getEmail()}
        </div>
    {/if}        

    {if ($tipoUser==='clinica' && !isset($idReferto))}
        <input type="button" id="aggiungiRefertoButton" value="Aggiungi Referto" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
    {/if}
    <br>      
    <input type="button" id="cancellaPrenotazione" value="Cancella Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
    <input type="button" id="modificaPrenotazione" value="Modifica Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />

</div>