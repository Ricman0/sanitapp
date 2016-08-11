<form name="modulo" method="post" id="formprova">
    <div>
        <input type="hidden" name="controller" value="registrazione" id="controller"/>
        <input type="hidden" name="task" value="utente" id="task"/>
    </div>
    <div>            
        <input type="text" name="nome" id="nome" placeholder="Mario" required/>
        <label for="nome">Nome</label>
        <br>
    </div>
    <div> 
        <input type="text" name="cognome" id="cognome" placeholder="Rossi" required/>
        <label for="cognome">Cognome</label>
        <br>
    </div>
    <div> 
        <input type="text" name="codiceFiscale" id="codiceFiscale" placeholder="MRARSS67S42G438S" required/>
        <label for="codiceFiscale">Codice Fiscale</label>
        <br>
    </div>
    <div>              
        <input type="text" name="indirizzo" id="indirizzo" placeholder="Via/C.da Acquaventina" required/>
        <label for="indirizzo">Indirizzo</label>
        <br>
    </div>
    <!--
    <div>
        <input type="number" name="numeroCivico" id="numeroCivico" min="0" max="1000" placeholder="3"/>
        <label for="mumeroCivico">Numero Civico</label>
        <br>
    </div>
    -->
    
    <div> 
        <input type="text" name="CAP" id="CAP" placeholder="65017" required/>
        <label for="CAP">CAP</label>
        <br>
    </div>
    <div> 
        <input type="email" name="email" id="email" placeholder="mario.rossi@example.it" required>
        <label for="email">Email</label>
        <br>
    </div>
    <p>email</p>
    <p><input type="email" name="email" id="email" required=""/></p>
    <p>username</p>
    <p><input type="text" name="username" id="usernameUtente" required=""/></p>
    <p>password</p>
    <p><input type="password" name="password" id="passwordUtente" required=""/></p>
    <input type="button" id="bottone" value="Invia i dati">
</form>

<div id="risultato"></div>