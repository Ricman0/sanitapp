{if isset($user)}
    <div class="log">
        <span>Ciao {$user} &nbsp</span>
        <button id="logOutButton" class="logOutButton sottile">Logout</button>
    </div>
{else}
    <div id="logInFormDiv">
        <form class="log logInForm" id="logInForm">
            <input type="hidden" name="controller" value="autenticazione"/>

            <label for="usernameLogIn">Username</label>
            <input type="text" id="usernameLogIn" placeholder="Enter Username" name="usernameLogIn" required >

            <label for="passwordLogIn">Password</label>
            <input type="password" id="passwordLogIn" placeholder="Enter Password" name="passwordLogIn" required>

            <button type="submit" id="submitLogIn" class="loginButton sottile">Login</button>
            <input type="checkbox" checked="checked"> Remember me &nbsp

            <a  id='recuperaPassword'> Password dimenticata?</a>

        </form>
    </div>
{/if}