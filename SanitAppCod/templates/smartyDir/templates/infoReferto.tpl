<div id="infoReferto">
    <h4>
        Informazioni Referto: 
    </h4>
    <div>

        {if ($tipoUser==='clinica')}
            <span>
                ID Referto: {$referto->getIDReferto()}
            </span>
            <br>
            <span>
                ID Prenotazione: {$referto->getIDPrenotazione()}
            </span>
            <br>
            <span>
                ID Esame: {$referto->getIDEsame()}
            </span>
            <br>
        {/if}
        <span>
            Nome: {$utente->getNomeUtente()}
        </span>
        <br>
        <span>
            Cognome: {$utente->getCognomeUtente()}
        </span>
        <br>

        <span>
            Codice Fiscale: {$utente->getCodiceFiscaleUtente()}
        </span>
        <br>

        <span>
            Esame: {$esame->getNomeEsame()}
        </span>
        <br>
        {if ($tipoUser!=='clinica')}
            <span>
                Clinica: {$clinica->getNomeClinica()}
            </span>
            <br>
            <span>
                Provincia Clinica: {$clinica->getProvinciaClinica()}
            </span>
            <br>
        {/if}
        <span>
            Data e Ora Prenotazione: {$prenotazione->getDataEOra()}
        </span>
        <br>
        <span>
            Data Referto: {$referto->getDataReferto()}
        </span>
        <br>
        <span>
            Medico: {$referto->getMedicoReferto()}
        </span>
        <br>
        <input type="button" id="scaricaRefertoButton2" value="Scarica Referto" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
    </div>
</div>