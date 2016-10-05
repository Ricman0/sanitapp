{if isset($user)}
    <div class="log">
    <span>Ciao {$user}</span>
    <button id="logOutButton">Logout</button>
    </div>
{else}
    <form class="log" id="logInForm">
        <input type="hidden" name="controller" value="autenticazione"/>

        <label for="usernameLogIn">Username</label>
        <input type="text" id="usernameLogIn" placeholder="Enter Username" name="uname" required >

        <label for="passwordLogIn">Password</label>
        <input type="password" id="passwordLogIn" placeholder="Enter Password" name="psw" required>

        <button type="submit" id="submitLogIn">Login</button>
        <input type="checkbox" checked="checked"> Remember me &nbsp

        <a href="#"> Forgot password?</a>

    </form>
{/if}