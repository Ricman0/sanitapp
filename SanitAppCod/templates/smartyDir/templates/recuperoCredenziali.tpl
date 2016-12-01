<div id="divRecuperoPassword">
    <h3>Inserisci la tua email. Ti verrà inviata la nuova password.</h3>
    <form class="" id="formRecuperoPassword">
        <input type="hidden" name="controller" value="recuperaPassword"/>

        <label for="email" class="elementiForm">Email</label>
        <input type="email" name="email" class="elementiForm" placeholder="mario.rossi@example.it" value="{if isset($datiValidi.email)}{$datiValidi.email}{/if}" required />
        <br>

        <button type="submit" id="submitRecuperaPassword" class="">Recupera</button>
    </form>
</div>