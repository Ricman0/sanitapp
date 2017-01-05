<h4>Inserisci i dati</h4>
<form name="inserisciUtente" method="post" id="inserisciUtente"> 

    <input type="hidden" name="controller" value="registrazione" />
    <input type="hidden" name="task" value="utente" />

    <label for="nome" class="elementiForm">Nome</label>
    <input type="text" name="nome" id="nomeUtente" class="elementiForm" placeholder="Mario" value="{if isset($datiValidi.nome)}{$datiValidi.nome}{/if}" required />
    <br>
    
    <label for="cognome" class="elementiForm">Cognome</label>
    <input type="text" name="cognome" id="cognomeUtente" class="elementiForm" placeholder="Rossi" value="{if isset($datiValidi.cognome)}{$datiValidi.cognome}{/if}" required />
    <br>
    
    <label for="codiceFiscale" class="elementiForm">Codice Fiscale</label>
    <input type="text" name="codiceFiscale" id="codiceFiscaleUtente" maxlength="16" class="elementiForm" placeholder="MRARSS67S42G438S" value="{if isset($datiValidi.codiceFiscale)}{$datiValidi.codiceFiscale}{/if}" required />
    <br>
    

    <label for="indirizzo" class="elementiForm">Indirizzo</label>    
    <input type="text" name="indirizzo" id="indirizzoUtente" class="elementiForm" placeholder="Via/C.da Acquaventina" value="{if isset($datiValidi.indirizzo)}{$datiValidi.indirizzo}{/if}" required />
    <br>
    
    <label for="numeroCivico" class="elementiForm">Numero Civico</label>
    <input type="number" name="numeroCivico" id="numeroCivico" class="elementiForm" min="0" max="1000" placeholder="3" value="{if isset($datiValidi.numeroCivico)}{$datiValidi.numeroCivico}{/if}" />
    <br>
    

    <label for="CAP" class="elementiForm">CAP</label>
    <input type="text" name="CAP" id="CAP" maxlength="5" class="elementiForm" placeholder="65017" value="{if isset($datiValidi.CAP)}{$datiValidi.CAP}{/if}" required />
    <br>
    

    <label for="email" class="elementiForm">Email</label>
    <input type="email" name="email" id="email" class="elementiForm" placeholder="mario.rossi@example.it" value="{if isset($datiValidi.email)}{$datiValidi.email}{/if}" required />
    <br>
    
    <div class="username">    
        
        <label for="usernameUtente" class="elementiForm">Username</label>    
        <input type="text" name="username" id="usernameUtente" class="elementiForm" placeholder="Mario" value="{if isset($datiValidi.username)}{$datiValidi.username}{/if}" required />
        <br>
        
    </div>
    
    <div class="password">            

        <label for="passwordUtente" class="elementiForm">Password</label>
        <input type="password" name="passwordUtente" class="elementiForm" id="passwordUtente"  required />
        <br>
        
        <label for="ripetiPasswordUtente" class="elementiForm">Ripeti Password</label>
        <input type="password" name="ripetiPasswordUtente" class="elementiForm" id="ripetiPasswordUtente" required />
        <br>
        
    </div>
    
    <div id="submitUtente" >
        <input type="submit" value="Invia" id="submitRegistrazioneUtente" />
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
</form>