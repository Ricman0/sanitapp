<div id="infoPrenotazione">
            <span>
                Esame: {$nomeEsame}
            </span>
            <span>
                {if isset($nomeUtente)}Nome: {$nomeUtente}{/if}
            </span>
            <br>
            <span>
                {if isset($cognomeUtente)}Cognome: {$cognomeUtente}{/if}
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
</div>