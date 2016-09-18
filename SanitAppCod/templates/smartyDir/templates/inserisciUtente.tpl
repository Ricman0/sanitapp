<form class= "form" name="inserisciUtente" method="post" id="inserisciUtente"> 
    <div class="form">
    <div>
            <input type="hidden" name="controller" value="registrazione"/>
            <input type="hidden" name="task" value="utente"/>
    </div>
    <div class="informazioni"> 
        <div class="nome">            
            <input type="text" name="nome" id="nome" class="elementiForm" placeholder="Mario"  required/>
            <label for="nome">Nome</label>
            <br>
        </div>
        <div class="cognome"> 
            <input type="text" name="cognome" id="cognome" class="elementiForm" placeholder="Rossi" required/>
            <label for="cognome">Cognome</label>
            <br>
        </div>
        <div class="codiceFiscale"> 
            <input type="text" name="codiceFiscale" id="codiceFiscale" class="elementiForm" placeholder="MRARSS67S42G438S" required/>
            <label for="codiceFiscale">Codice Fiscale</label>
            <br>
        </div>
    </div>
    <div class ="indirizzo">
        <div class="via">              
            <input type="text" name="indirizzo" id="indirizzo" class="elementiForm" placeholder="Via/C.da Acquaventina" required/>
            <label for="indirizzo">Indirizzo</label>
            <br>
        </div>
        <div class="numeroCivico">
            <input type="number" name="numeroCivico" id="numeroCivico" class="elementiForm" min="0" max="1000" placeholder="3"/>
            <label for="mumeroCivico">Numero Civico</label>
            <br>
        </div>
        <div class="CAP"> 
            <input type="text" name="CAP" id="CAP" class="elementiForm" placeholder="65017" required/>
            <label for="CAP">CAP</label>
            <br>
        </div>
    </div>
        <!--type=email non supportato da safari-->
    <div class="accesso">
        <div class="email"> 
            <input type="email" name="email" id="email" class="elementiForm" placeholder="mario.rossi@example.it" required>
            <label for="email">Email</label>
            <br>
        </div>
        <div class="username">        
<<<<<<< HEAD
            <input type="text" name="username" id="usernameUtente" class="elementiForm" pattern="^[a-z0-9]*$" title="Inserisci elementi alfanumerici" placeholder="Mario" required />
=======
            <input type="text" name="username" id="usernameUtente" placeholder="Mario" required />
>>>>>>> origin/master
            <label for="usernameUtente">Username</label>
            <br>
        </div>
        <div class="password"> 
            <input type="password" name="passwordUtente" class="elementiForm" id="passwordUtente" required >
            <label for="passwordUtente">Password</label>
            <br>
            <input type="password" name="ripetiPasswordUtente" class="elementiForm" id="ripetiPasswordUtente" required >
            <label for="ripetiPasswordUtente">Ripeti Password</label>
            <br>
        </div>
    </div>
    <div class="submit" >
        <input type="submit" value="Invia" id="submitRegistrazioneUtente">
    </div>
        <!-- se vogliamo possiamo aggiungerlo
        Sesso:<br>
        <input type="radio" name="sesso" value="M" checked>Maschio<br>
        <input type="radio" name="sesso" value="F">Femmina<br>                

        Encryption: <keygen name="security"><br>

        Data di nascita:<br>
-->
        <!--non supportato da firefox-->
        <!-- se vogliamo possiamo aggiungerlo
        <input type="date" name="dataNascita" required><br>

-->
    </div>
</form>