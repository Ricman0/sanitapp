<form class="formInserisci" name="inserisci" method="post">
    <p class="sceltaUtente"> 
        <label for="scelta">Scegli il tipo di registrazione che desideri effettuare</label>
        <br>
        <select class="sceltaUtente" name="sceltaUtente" id="scelta">
            <option value="utente">Utente</option>
            <option value="medico">Medico</option>
            <option value="clinica">Clinica</option>
        </select>
    </p>
    <div>
        {$formScelta}
    </div>
</form>