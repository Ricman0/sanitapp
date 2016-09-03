<form class="formInserisci" name="inserisciMedico" method="post" id="inserisciMedico">
    <div>
            <input type="hidden" name="controller" value="registrazione"/>
            <input type="hidden" name="task" value="medico"/>
    </div>
    <div class="informazioni"> 
        <div class="nome">            
            <input type="text" name="nomeMedico" id="nomeMedico" placeholder="Mario" required/>
            <label for="nomeMedico">Nome</label>
            <br>
        </div>
        <div class="cognomeMedico"> 
            <input type="text" name="cognomeMedico" id="cognomeMedico" placeholder="Rossi" required/>
            <label for="cognomeMedico">Cognome</label>
            <br>
        </div>
        <div class="codiceFiscale"> 
            <input type="text" name="codiceFiscaleMedico" id="codiceFiscaleMedico" placeholder="MRARSS67S42G438S" required/>
            <label for="codiceFiscaleMedico">Codice Fiscale</label>
            <br>
        </div>
    </div>
    <div class ="indirizzo">
        <div class="via">              
            <input type="text" name="indirizzoMedico" id="indirizzoMedico" placeholder="Via/C.da Acquaventina" />
            <label for="indirizzoMedico">Indirizzo</label>
            <br>
        </div>
        <div class="numeroCivico">              
            <input type="number" name="numeroCivicoMedico" id="numeroCivicoMedico" placeholder="30" required/>
            <label for="numeroCivicoMedico">Numero Civico</label>
            <br>
        </div>
        <div class="CAP"> 
            <input type="text" name="CAPMedico" id="CAPMedico" placeholder="65017" required/>
            <label for="CAPMedico">CAP</label>
            <br>
        </div>
    </div>
    <div class="numeroIscrizione"> 
        <input type="text" name="numeroIscrizione" id="numeroIscrizione" placeholder="03693" required/>
        <label for="numeroIscrizione">Numero Iscrizione</label>
        <br>
    </div>
    <div class="provinciaAlbo"> 
        <input type="text" name="provinciaAlbo" id="provinciaAlbo" placeholder="PE" required/>
        <label for="provinciaAlbo">Provincia Albo</label>
        <br>
    </div>
        <!--type=email non supportato da safari-->
    <div class="accesso">
        <div class="email"> 
            <input type="email" name="emailMedico" id="emailMedico" placeholder="mario.rossi@example.it" required>
            <label for="emailMedico">Email</label>
            <br>
        </div>
        <div class="PEC"> 
            <input type="email" name="PECMedico" id="PECMedico" placeholder="mario.rossi@pec.it" required>
            <label for="PECMedico">PEC</label>
            <br>
        </div>
        <div class="username">            
            <label for="usernameMedico">Username</label>
            <input type="text" name="usernameMedico" id="usernameMedico" pattern="^[a-z0-9]*$" title="Inserisci elementi alfanumerici" placeholder="Mario" required />
            <br>
        </div>
        <div class="password"> 
            <input type="password" name="passwordMedico" id="passwordMedico" required >
            <label for="passwordMedico">Password</label>
            <br>
            <input type="password" name="ripetiPasswordMedico" id="ripetiPasswordMedico" required >
            <label for="ripetiPasswordMedico">Ripeti Password</label>
            <br>
        </div>
    </div>
    
    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneMedico">
    </div>
    <!-- vedere la selezione dell'albo provincia perchè usa jquery-->
</form>