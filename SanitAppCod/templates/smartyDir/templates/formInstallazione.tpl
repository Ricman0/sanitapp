{if isset($errore)}
    {foreach from=$errore item=curr_mess}
        <span ><b class="rosso">! </b>{$curr_mess}<b class="rosso"> !</b></span><br>
    {/foreach}
{/if} 
<form id="formInstallazione">
    <div id="databaseEmailConfig" class="affiancato verticalmenteAllineato">
        <h3>Configurazione</h3>
        <br>
        Database
        <br>
        <br>
        <label for="host" class="elementiForm">Host</label>
        <input type="text" name="host" id="host" class="elementiForm" value="{if isset($datiInstallazione.host)}{$datiInstallazione.host}{/if}" required/>
        <br>

        <label for="userDb" class="elementiForm">User db</label>
        <input type="text" name="userDb" id="userDb" class="elementiForm" value="{if isset($datiInstallazione.userDb)}{$datiInstallazione.userDb}{/if}" required/>
        <br>

        <label for="passwordDb" class="elementiForm">Password Database</label>
        <input type="password" name="passwordDb" id="passwordDb" class="elementiForm" required/>
        <br>

        <label for="confermapasswordDb" class="elementiForm">Conferma password</label>
        <input type="password" name="confermaPasswordDb" id="confermapasswordDb" class="elementiForm" required/>
        <br>
        <br>
        Server SMTP
        <br>
        <br>
        <label for="smtp" class="elementiForm">Server SMTP</label>
        <input type="text" name="smtp" id="smtp" class="elementiForm" value="{if isset($datiInstallazione.smtp)}{$datiInstallazione.smtp}{/if}" required/>
        <br>
        <label for="emailSmtp" class="elementiForm">E-mail</label>
        <input type="email" name="emailSmtp" id="emailSmtp" class="elementiForm" value="{if isset($datiInstallazione.email)}{$datiInstallazione.email}{/if}" required/>
        <br>
        <label for="passwordEmail" class="elementiForm">Password E-mail</label>
        <input type="password" name="passwordEmail" id="passwordEmail" class="elementiForm"  required/>
        <br>
        <br>
    </div>
        <div id="adminConfig" class="affiancato verticalmenteAllineato">


        <h3>Amministratore</h3>
        <br>
        <br>  <br>  

        <label for="nome" class="elementiForm">Nome</label>
        <input type="text" name="nome" id="nome" class="elementiForm" maxlength="20" value="{if isset($datiInstallazione.nome)}{$datiInstallazione.nome}{/if}" required/>
        <br>

        <label for="cognome" class="elementiForm">Cognome</label>
        <input type="text" name="cognome" id="cognome" class="elementiForm" maxlength="20" value="{if isset($datiInstallazione.cognome)}{$datiInstallazione.cognome}{/if}" required/>
        <br>

        <label for="emailAdmin" class="elementiForm">E-mail</label>
        <input type="email" name="emailAdmin" id="emailAdmin" class="elementiForm" value="{if isset($datiInstallazione.email)}{$datiInstallazione.email}{/if}" required/>
        <br>

        <label for="pecAdmin" class="elementiForm">PEC</label>
        <input type="email" name="pecAdmin" id="pecAdmin" class="elementiForm" value="{if isset($datiInstallazione.email)}{$datiInstallazione.email}{/if}" required/>
        <br>

        <label for="telefono" class="elementiForm">Telefono</label>
        <input type="text" name="telefono" id="telefono" class="elementiForm"  maxlength="10" value="{if isset($datiInstallazione.telefono)}{$datiInstallazione.telefono}{/if}" required/>
        <br>

        <label for="username" class="elementiForm">Username</label>
        <input type="text" name="username" id="username" class="elementiForm" maxlength="15" value="{if isset($datiInstallazione.username)}{$datiInstallazione.username}{/if}" required/> 
        <br>

        <label for="password" class="elementiForm">Password</label>
        <input type="password" name="password" id="password" class="elementiForm" required/>
        <br>

        <label for="confermaPassword" class="elementiForm">Conferma password</label>
        <input type="password" name="confermaPassword" id="confermaPassword" class="elementiForm" required/>
        <br>

    </div>
        <input type="submit" class="centrato nuovaRiga" id="installazione" value="Installa" />
    <br>
</form>