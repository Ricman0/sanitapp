<form class="formInserisci" name="inserisciMedico" method="post" id="inserisciMedico">
    <!-- form uguale a inseirsci utente inizialmente per cui ora non lo scrivo-->
    <div class="PEC"> 
        <input type="email" name="PECMedico" id="PECMedico" placeholder="mario.rossi@pec.it" required>
        <label for="PECMedico">PEC</label>
        <br>
    </div>
    <div class="numeroIscrizione"> 
        <input type="text" name="numeroIscrizione" id="numeroIscrizione" placeholder="03693" required/>
        <label for="numeroIscrizione">Numero Iscrizione</label>
        <br>
    </div>
    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneMedico">
    </div>
    <!-- vedere la selezione dell'albo provincia perchè usa jquery-->
</form>