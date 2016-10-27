<div id="infoClinica">
    <span>
        Nome: {$clinica->getNomeClinica()}
    </span>
    <br>
    <span>
        Indirizzo: {$clinica->getIndirizzoClinica()}
    </span>
    <br>
    <span>
        Telefono: {$clinica->getTelefonoClinica()}
    </span>
    <br>
    <span>
        Email: {$clinica->getEmail()}
    </span>
    <br>
    <input type="button" id="esamiClinicaButton" value="Esami"  data-idClinica="{$clinica->getPartitaIVAClinica()}"  />
</div>