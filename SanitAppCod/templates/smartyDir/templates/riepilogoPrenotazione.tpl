<h3>Riepilogo Prenotazione</h3>
<div>
    <span>Nome Esame:{$esame->getNomeEsame()}</span>
    <br>
    <span>Data:{$data}</span>
    <br>
    <span>Orario:{$orario}</span>
    <br>
    <span>Durata:{$esame->getDurataEsame()}</span>
    <br>
    <span>Prezzo:{$esame->getPrezzoEsame()}</span>
    <br>
    <span>Clinica:{$clinica->getNomeClinica()}</span>
    <br>
    <span>Indirizzo:{$clinica->getViaClinica()}</span>
    <br>  
    <span>Telefono:{$clinica->getTelefonoClinica()}</span>
    <br>  
    
</div>
<div>
    
    <span>Utente:{$utente->getNomeUtente()}</span>
    <span>{$utente->getCognomeUtente()}</span>
    <br>
    <span>Codice Fiscale:{$utente->getCodiceFiscaleUtente()}</span>
    <br>
    <span>Email:{$utente->getEmailUtente()}</span>
    <br>
    <span>Indirizzo:{$utente->getViaUtente()}</span>
    <br>
</div>
<input type="button" id="confermaPrenotazione" value="Conferma" />