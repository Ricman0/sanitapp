<div id="logInFormDiv2" class="verticalmenteAllineato">
    {if isset($errore)}
        <div id="erroreLogIn">{$errore}</div>  
    {/if}
    <div id="logInDiv" class="bordo centrato">
   <i class="fa fa-user fa-4x faAzzurro" id="icona-logInForm" aria-hidden="true"></i>
        <form  id="logInForm2">
            
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn2">Username</label>
            <br>
            <input type="text" id="usernameLogIn2" placeholder="Enter Username" name="usernameLogIn" class='elementiForm' required />
            <br>
            <label for="passwordLogIn2">Password</label>
            <br>
            <input type="password" id="passwordLogIn2" placeholder="Enter Password" name="passwordLogIn" class='elementiForm' required />
            <br>
            <button type="submit" id="submitLogIn2" class="loginButton normalSize">Login</button>

        </form>
    </div>
    <div>Non sei ancora registrato?</div>
    <div>Registrati subito cliccando su Registrati</div>
    <button type="submit" id="submitRegistratiLogIn" class="normalSize registrazioneUtente">Registrati</button>
</div>
    
<br>