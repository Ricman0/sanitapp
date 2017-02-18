<div id="infoClinica">
    <h3>INFORMAZIONI CLINICA</h3>
    
    <div>
        <span class="grassetto">NOME:</span><span>  {$clinica->getNomeClinicaClinica()}</span>
        <br>
        <span class="grassetto">INDIRIZZO:</span><span>  {$clinica->getIndirizzoClinica()}</span>
        <br>
        <span class="grassetto">TELEFONO:</span><span>  {$clinica->getTelefonoClinica()}</span>
        <br>
        <span class="grassetto">EMAIL:</span><span>  {$clinica->getEmailUser()}</span>
        <br>
    </div>

    
    {if !isset($buttonEsami)}
        <input type="button" id="esamiClinicaButton" value="Esami" data-nomeClinica="{$clinica->getNomeClinicaClinica()}"  data-idClinica="{$clinica->getPartitaIVAClinica()}"  />
    {/if}
    <br>
</div>