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
    <select type="text" name="provinciaClinica" class="elementiForm" id="provinciaClinica" required>
        <option disabled selected value=""> -- select an option -- </option>
        <option value=”AG”>AGRIGENTO</option>
        <option value=”AL”>ALESSANDRIA</option>
        <option value=”AN”>ANCONA</option>
        <option value=”AO”>AOSTA</option>
        <option value=”AR”>AREZZO</option>
        <option value=”AP”>ASCOLI PICENO</option>
        <option value=”AT”>ASTI</option>
        <option value=”AV”>AVELLINO</option>
        <option value=”BA”>BARI</option>
        <option value=”BT”>BARLETTA-ANDRIA-TRANI</option>
        <option value=”BL”>BELLUNO</option>
        <option value=”BN”>BENEVENTO</option>
        <option value=”BG”>BERGAMO</option>
        <option value=”BI”>BIELLA</option>
        <option value=”BO”>BOLOGNA</option>
        <option value=”BZ”>BOLZANO</option>
        <option value=”BS”>BRESCIA</option>
        <option value=”BR”>BRINDISI</option>
        <option value=”CA”>CAGLIARI</option>
        <option value=”CL”>CALTANISSETTA</option>
        <option value=”CB”>CAMPOBASSO</option>
        <option value=”CI”>CARBONIA-IGLESIAS</option>
        <option value=”CE”>CASERTA</option>
        <option value=”CT”>CATANIA</option>
        <option value=”CZ”>CATANZARO</option>
        <option value=”CH”>CHIETI</option>
        <option value=”CO”>COMO</option>
        <option value=”CS”>COSENZA</option>
        <option value=”CR”>CREMONA</option>
        <option value=”KR”>CROTONE</option>
        <option value=”CN”>CUNEO</option>
        <option value=”EN”>ENNA</option>
        <option value=”FM”>FERMO</option>
        <option value=”FE”>FERRARA</option>
        <option value=”FI”>FIRENZE</option>
        <option value=”FG”>FOGGIA</option>
        <option value=”FC”>FORLI’-CESENA</option>
        <option value=”FR”>FROSINONE</option>
        <option value=”GE”>GENOVA</option>
        <option value=”GO”>GORIZIA</option>
        <option value=”GR”>GROSSETO</option>
        <option value=”IM”>IMPERIA</option>
        <option value=”IS”>ISERNIA</option>
        <option value=”SP”>LA SPEZIA</option>
        <option value=”AQ”>L’AQUILA</option>
        <option value=”LT”>LATINA</option>
        <option value=”LE”>LECCE</option>
        <option value=”LC”>LECCO</option>
        <option value=”LI”>LIVORNO</option>
        <option value=”LO”>LODI</option>
        <option value=”LU”>LUCCA</option>
        <option value=”MC”>MACERATA</option>
        <option value=”MN”>MANTOVA</option>
        <option value=”MS”>MASSA-CARRARA</option>
        <option value=”MT”>MATERA</option>
        <option value=”VS”>MEDIO CAMPIDANO</option>
        <option value=”ME”>MESSINA</option>
        <option value=”MI”>MILANO</option>
        <option value=”MO”>MODENA</option>
        <option value=”MB”>MONZA E DELLA BRIANZA</option>
        <option value=”NA”>NAPOLI</option>
        <option value=”NO”>NOVARA</option>
        <option value=”NU”>NUORO</option>
        <option value=”OG”>OGLIASTRA</option>
        <option value=”OT”>OLBIA-TEMPIO</option>
        <option value=”OR”>ORISTANO</option>
        <option value=”PD”>PADOVA</option>
        <option value=”PA”>PALERMO</option>
        <option value=”PR”>PARMA</option>
        <option value=”PV”>PAVIA</option>
        <option value=”PG”>PERUGIA</option>
        <option value=”PU”>PESARO E URBINO</option>
        <option value=”PE”>PESCARA</option>
        <option value=”PC”>PIACENZA</option>
        <option value=”PI”>PISA</option>
        <option value=”PT”>PISTOIA</option>
        <option value=”PN”>PORDENONE</option>
        <option value=”PZ”>POTENZA</option>
        <option value=”PO”>PRATO</option>
        <option value=”RG”>RAGUSA</option>
        <option value=”RA”>RAVENNA</option>
        <option value=”RC”>REGGIO DI CALABRIA</option>
        <option value=”RE”>REGGIO NELL’EMILIA</option>
        <option value=”RI”>RIETI</option>
        <option value=”RN”>RIMINI</option>
        <option value=”RM”>ROMA</option>
        <option value=”RO”>ROVIGO</option>
        <option value=”SA”>SALERNO</option>
        <option value=”SS”>SASSARI</option>
        <option value=”SV”>SAVONA</option>
        <option value=”SI”>SIENA</option>
        <option value=”SR”>SIRACUSA</option>
        <option value=”SO”>SONDRIO</option>
        <option value=”TA”>TARANTO</option>
        <option value=”TE”>TERAMO</option>
        <option value=”TR”>TERNI</option>
        <option value=”TO”>TORINO</option>
        <option value=”TP”>TRAPANI</option>
        <option value=”TN”>TRENTO</option>
        <option value=”TV”>TREVISO</option>
        <option value=”TS”>TRIESTE</option>
        <option value=”UD”>UDINE</option>
        <option value=”VA”>VARESE</option>
        <option value=”VE”>VENEZIA</option>
        <option value=”VB”>VERBANO-CUSIO-OSSOLA</option>
        <option value=”VC”>VERCELLI</option>
        <option value=”VR”>VERONA</option>
        <option value=”VV”>VIBO VALENTIA</option>
        <option value=”VI”>VICENZA</option>
        <option value=”VT”>VITERBO</option>
    </select>
    <br>

    <div class="orarioContinuato">            

        <label for="orarioContinuato" class="elementiForm">Orario Continuato</label>
        <input type="checkbox"  name="orarioContinuato" class="elementiForm" id="orarioContinuato" value="Orario Continuato"/>

        <br>
    </div>
    <div>
        <div class="orario">            
            <label for="orarioAperturaMattina" class="elementiForm">Orario Apertura Mattina</label>
            <input type="time" name="orarioAperturaAM" class="elementiForm" id="orarioAperturaMattina" class="orario" placeholder="09:00"/>

            <br>
        </div>
        <div class="orario">            
            <label for="orarioChiusuraMattina" class="elementiForm">Orario Chiusura Mattina</label>
            <input type="time" name="orarioChiusuraAM" class="elementiForm" id="orarioChiusuraMattina" class="orario" placeholder="13:00"/>

            <br>
        </div>
        <div class="orario">            
            <label for="orarioAperturaPomeriggio" class="elementiForm">Orario Apertura Pomeriggio</label>
            <input type="time" name="orarioAperturaPM" class="elementiForm" id="orarioAperturaPomeriggo" class="orario" placeholder="15:00"/>

            <br>
        </div>
        
        <div class="orario">            
            <label for="orarioChiusuraPomeriggio" class="elementiForm">Orario Chiusura Pomeriggio</label>
            <input type="time" name="orarioChiusuraPM" class="elementiForm" id="orarioChiusuraPomeriggo" class="orario" placeholder="19:00"/>

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