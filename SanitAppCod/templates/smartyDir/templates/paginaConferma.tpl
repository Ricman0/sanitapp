<form>
    <p>Per poter utilizzare l'applicazione devi inserire il codice conferma che ti è stato inviato sulla email</p>
    <br>
    <label for="codiceConferma" class="elementiForm">Codice conferma: </label>
    <input type="text" id="codiceConferma" class="elementiForm" placeholder="codice conferma che hai ricevuto sulla email" required>
    <br>
    <input type="submit" value="Conferma" id="submitCodiceConferma" data-username="{$username}">
</form>