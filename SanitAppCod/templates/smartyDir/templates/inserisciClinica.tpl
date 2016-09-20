<form class="formInserisci" name="inserisciClinica" method="post" id="inserisciClinica">

    <input type="hidden" name="controller" value="registrazione"/>
    <input type="hidden" name="task" value="clinica"/>

    <label for="nomeClinica" class="elementiForm">Nome</label>
    <input type="text" name="nomeClinica" class="elementiForm" id="nomeClinica" placeholder="Villa Serena" required/>

    <br>

    <label for="titolare" class="elementiForm">Titolare</label>
    <input type="text" name="titolare" class="elementiForm" id="titolare" placeholder="Mario Rossi" required/>

    <br>
    <label for="partitaIVA" class="elementiForm">Partita IVA</label>
    <input type="text" name="partitaIVA" class="elementiForm" id="partitaIVA" placeholder="JAJF59382YHC3930" required/>

    <br>
    <label for="emailClinica" class="elementiForm">Email</label>
    <input type="email" name="emailClinica" class="elementiForm" id="emailClinica" placeholder="villaserena@gmail.it" required>

    <br>
    <label for="PECClinica" class="elementiForm">PEC</label>
    <input type="email" name="PECClinica" class="elementiForm" id="PECClinica" placeholder="villaserena@pec.it" required>

    <br>
    <label for="telefonoClinica" class="elementiForm">Telefono</label>
    <input type="tel" name="telefonoClinica" class="elementiForm" id="telefonoClinica" placeholder="085821345" required/>

    <br>
    <label for="capitaleSociale" class="elementiForm">Capitale Sociale</label>
    <input type="text" name="capitaleSociale" class="elementiForm" id="capitaleSociale" placeholder="320.000€" />

    <br>

    <label for="indirizzoClinica" class="elementiForm">Indirizzo</label>
    <input type="text" name="indirizzoClinica" class="elementiForm" id="indirizzoClinica" placeholder="Via/C.da Acquaventina" required/>

    <br>
    <label for="mumeroCivicoClinica" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivicoClinica" class="elementiForm" id="numeroCivicoClinica" min="0" max="1000" placeholder="3"/>

    <br>
    <label for="CAPClinica" class="elementiForm">CAP</label>
    <input type="text" name="CAPClinica" class="elementiForm" id="CAPClinica" placeholder="65017" required/>

    <br>
    <label for="localitàClinica" class="elementiForm">Località</label>
    <input type="text" name="localitàClinica" class="elementiForm" id="localitàClinica" placeholder="Penne" required/>

    <br>
    <label for="provinciaClinica" class="elementiForm">Provincia</label>
    <input type="text" name="provinciaClinica" class="elementiForm" id="provinciaClinica" placeholder="Pescara" required/>

    <br>

    <div class="orarioContinuato">            

        <label for="orarioContinuato" class="elementiForm">Orario Continuato</label>
        <input type="checkbox"  name="orarioContinuato" class="elementiForm" id="orarioContinuato" value="Orario Continuato"/>

        <br>
    </div>
    <div>
        <div class="orario">            
            <label for="orarioAperturaMattina" class="elementiForm">Orario Apertura Mattina</label>
            <input type="time" name="orarioAperturaMattina" class="elementiForm" id="orarioAperturaMattina" class="orario" placeholder="09:00"/>

            <br>
        </div>
        <div class="orario">            
            <label for="orarioAperturaPomeriggio" class="elementiForm">Orario Apertura Pomeriggio</label>
            <input type="time" name="orarioAperturaPomeriggio" class="elementiForm" id="orarioAperturaPomeriggo" class="orario" placeholder="15:00"/>

            <br>
        </div>
        <div class="orario">            
            <label for="orarioChiusuraMattina" class="elementiForm">Orario Chiusura Mattina</label>
            <input type="time" name="orarioChiusuraMattina" class="elementiForm" id="orarioChiusuraMattina" class="orario" placeholder="13:00"/>

            <br>
        </div>
        <div class="orario">            
            <label for="orarioChiusuraPomeriggio" class="elementiForm">Orario Chiusura Pomeriggio</label>
            <input type="time" name="orarioChiusuraPomeriggio" class="elementiForm" id="orarioChiusuraPomeriggo" class="orario" placeholder="19:00"/>

            <br>
        </div>
        <div class="autenticazione">
            <div class="username">            
                <label for="usernameClinica" class="elementiForm">Username</label>
                <input type="text" name="usernameClinica" class="elementiForm" id="usernameClinica" placeholder="clari" required/>

                <br>
            </div>
            <div class="password">            
                <label for="passwordClinica" class="elementiForm">Password</label>
                <input type="password" name="passwordClinica" class="elementiForm" id="passwordClinica" placeholder="R5t6sg6I" required/>

                <br>
                <label for="ripetiPasswordClinica" class="elementiForm">Ripeti Password</label>
                <input type="password" name="ripetiPasswordClinica" class="elementiForm" id="ripetiPasswordClinica" placeholder="R5t6sg6I" required/>

                <br>
            </div>
        </div>
    </div>
    <div class="submit">
        <input type="submit" value="Invia" id="submitRegistrazioneClinica">
    </div>
</form>