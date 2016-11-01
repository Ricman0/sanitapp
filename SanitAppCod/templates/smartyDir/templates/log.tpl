{if isset($user)}
    <div class="log">
        <span>Ciao {$user}</span>
        <button id="logOutButton" class="logButton">Logout</button>
    </div>
{else}
    <div id="logInFormDiv">
        <form class="log logInForm" id="logInForm">
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn">Username</label>
            <input type="text" id="usernameLogIn" placeholder="Enter Username" name="usernameLogIn" required >

            <label for="passwordLogIn">Password</label>
            <input type="password" id="passwordLogIn" placeholder="Enter Password" name="passwordLogIn" required>

            <button type="submit" id="submitLogIn" class="loginButton">Login</button>
            <input type="checkbox" checked="checked"> Remember me &nbsp

            <a href="#"> Forgot password?</a>

        </form>
    </div>
{/if}


<div id="dialog-form" title="Login">
    <form method="dialog" class="logInForm" id="loginForm2">
        <input type="hidden" name="controller" value="autenticazione"/>
        <label for="usernameLogIn">Username</label>
        <input type="text" name="usernameLogIn" placeholder="Enter Username" class="text ui-widget-content ui-corner-all elementiForm" required >
        <label for="passwordLogIn">Password</label>
        <input type="password" name="passwordLogIn" placeholder="Enter Password" class="text ui-widget-content ui-corner-all elementiForm" required >
        <!-- Allow form submission with keyboard without duplicating the dialog button -->
        <button type="submit" id="submitLogIn2" class="elementiForm loginButton">Accedi</button>
    </form>
</div>