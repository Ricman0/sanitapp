<form class="formInserisci" name="inserisciClinica" method="post" id="inserisciClinica">
    <div class="informazioniClinica" >   
        <div class="nomeClinica">            
            <input type="text" name="nomeClinica" id="nomeClinica" placeholder="Villa Serena" required/>
            <label for="nomeClinica">Nome</label>
            <br>
        </div>
        <div class="titolare">            
            <input type="text" name="titolare" id="titolare" placeholder="Mario Rossi" required/>
            <label for="titolare">Titolare</label>
            <br>
        </div>
        <div class="partitaIVA">            
            <input type="text" name="partitaIVA" id="partitaIVA" placeholder="JAJF59382YHC3930" required/>
            <label for="partitaIVA">Partita IVA</label>
            <br>
        </div>
        <div class="PEC"> 
            <input type="email" name="PECClinica" id="PECClinica" placeholder="villaserena@pec.it" required>
            <label for="PECClinica">PEC</label>
            <br>
        </div>
        <div class="telefono"> 
            <input type="tel" name="telefonoClinica" id="telefonoClinica" placeholder="085821345" required/>
            <label for="telefonoClinica">Telefono</label>
            <br>
        </div>
        <div class="capitaleSociale">            
            <input type="text" name="capitaleSociale" id="capitaleSociale" placeholder="320.000€" />
            <label for="capitaleSociale">Capitale Sociale</label>
            <br>
        </div>
    </div>
    <div class="indirizzoClinica">
        <div class="indirizzo"> 
            <input type="text" name="indirizzoClinica" id="indirizzoClinica" placeholder="Via/C.da Acquaventina" required/>
            <label for="indirizzoClinica">Indirizzo</label>
            <br>
        </div>    
        <div class="numeroCivicoClinica">
            <input type="number" name="numeroCivicoClinica" id="numeroCivicoClinica" min="0" max="1000" placeholder="3"/>
            <label for="mumeroCivicoClinica">Numero Civico</label>
            <br>
        </div>
        <div class="CAP"> 
            <input type="text" name="CAPClinica" id="CAPClinica" placeholder="65017" required/>
            <label for="CAPClinica">CAP</label>
            <br>
        </div>
    </div>
    <div class="autenticazione">
        <div class="username">            
            <input type="text" name="usernameClinica" id="usernameClinica" placeholder="clari" required/>
            <label for="usernameClinica">Username</label>
            <br>
        </div>
        <div class="password">            
            <input type="text" name="passwordClinica" id="passwordClinica" placeholder="R5t6sg6I" required/>
            <label for="passwordClinica">Password</label>
            <br>
        </div>
    </div>
    <div class="orario">
        <div class="orarioAperturaMattina">            
            <input type="time" name="orarioAperturaMattina" id="orarioAperturaMattina" placeholder="09:00"/>
            <label for="orarioAperturaMattina">Orario Apertura Mattina</label>
            <br>
        </div>
        <div class="orarioAperturaPomeriggio">            
            <input type="time" name="orarioAperturaPomeriggio" id="orarioAperturaPomeriggo" placeholder="15:00"/>
            <label for="orarioAperturaPomeriggio">Orario Apertura Pomeriggio</label>
            <br>
        </div>
        <div class="orarioChiusuraMattina">            
            <input type="time" name="orarioChiusuraMattina" id="orarioChiusuraMattina" placeholder="13:00"/>
            <label for="orarioChiusuraMattina">Orario Chiusura Mattina</label>
            <br>
        </div>
        <div class="orarioChiusuraPomeriggio">            
            <input type="time" name="orarioChiusuraPomeriggio" id="orarioChiusuraPomeriggo" placeholder="19:00"/>
            <label for="orarioChiusuraPomeriggio">Orario Chiusura Pomeriggio</label>
            <br>
        </div>
    </div>
    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneClinica">
    </div>
</form>