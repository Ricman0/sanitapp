<div id="infoClinica">
    <h4>Informazioni Clinica</h4>
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
    {if !isset($buttonEsami)}
        <input type="button" id="esamiClinicaButton" value="Esami"  data-idClinica="{$clinica->getPartitaIVAClinica()}"  />
    {/if}
</div>