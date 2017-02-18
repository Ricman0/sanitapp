<form>
    <h3>CONFERMA ACCOUNT</h3>
    <hr>
    <br>
    <h4>Per poter utilizzare l'applicazione devi inserire il codice conferma che ti è stato inviato sulla email</h4>
    <br>
    <label for="codiceConferma" class="elementiForm">Codice conferma: </label>
    <input type="text" id="codiceConferma" class="elementiForm" placeholder="codice conferma che hai ricevuto sulla email" required>
    <br>
    <input type="button" value="Conferma" id="submitCodiceConferma" data-username="{$username}">
</form>