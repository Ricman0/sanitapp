
<div id="logInFormDiv" class="verticalmenteAllineato">
    {if isset($errore)}
        <div id="erroreLogIn">{$errore}</div>  
    {/if}
    
    <form  id="logInForm">
        <fieldset>
            <legend><i class="fa fa-user fa-lg" id="icona-logInForm" aria-hidden="true"></i></legend>
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn">Username</label>
            <input type="text" id="usernameLogIn" placeholder="Enter Username" name="usernameLogIn" class='elementiForm' required />
            <label for="passwordLogIn">Password</label>
            <input type="password" id="passwordLogIn" placeholder="Enter Password" name="passwordLogIn" class='elementiForm' required />

            <button type="submit" id="submitLogIn" class="loginButton">Login</button>
            <a href="#"> Forgot password?</a>
        </fieldset>
    </form>
    
        <div>Non sei ancora registrato?</div>
        <div>Registrati subito cliccando su Registrati</div>
        <button type="submit" id="submitRegistratiLogIn" class="loginButton">Registrati</button>
</div>
