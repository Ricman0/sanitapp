<form name="modulo" method="post" id="formprova">
    <div>
                    <input type="hidden" name="controller" value="registrazione" id="controller"/>
                    <input type="hidden" name="task" value="utente" id="task"/>
    </div>
            <p>Nome</p>
            <p><input type="text" name="nome" id="nome" required=""/></p>
            
    <p>Cognome</p>
    <p><input type="text" name="cognome" id="cognome" required=""/></p>
    <p>codice</p>
    <p><input type="text" name="codiceFiscale" id="codiceFiscale" required=""/></p>
    <p>via</p>
    <p><input type="text" name="via" id="via" required=""/></p>
    <p>CAP</p>
    <p><input type="text" name="CAP" id="CAP" required=""/></p>
    <p>email</p>
    <p><input type="email" name="email" id="email" required=""/></p>
    <p>username</p>
    <p><input type="text" name="username" id="usernameUtente" required=""/></p>
    <p>password</p>
    <p><input type="password" name="password" id="passwordUtente" required=""/></p>
    <input type="button" id="bottone" value="Invia i dati">
</form>

<div id="risultato"></div>