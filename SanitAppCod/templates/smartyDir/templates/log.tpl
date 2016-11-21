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