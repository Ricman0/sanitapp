<br>
<h4>Aggiungi una prenotazione</h4>
<span>Inserisci il codice fiscale dell'utente per cui vuoi effettuare la prenotazione</span>
<br>
<span>Ricorda che puoi effettuare la prenotazione solo se l'utente è già registrato in SanitApp</span>
<br>
<form id='ricercaUtente'>
    
    <label for="codiceFiscaleRicercaUtente" class="elementiForm">Codice Fiscale</label>
    <input type="text" name="codiceFiscaleRicercaUtente" id="codiceFiscaleRicercaUtente" maxlength="16" class="elementiForm" placeholder="DMRCLD89S42G438S"  required />
    <br>
    
    <div id="submitDivRicercaUtente" >
        <input type="submit" value="Invia" id="submitRicercaUtente" {if ($tipoUser ==='clinica')} data-nomeClinica="{$nomeClinica}" {else} data-cfMedico="{$cfMedico}" {/if} />
    </div>
</form>