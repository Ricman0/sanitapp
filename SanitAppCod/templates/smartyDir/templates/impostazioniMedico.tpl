{if isset($informazioniGenerali)}
    <div id="informazioniGenerali">
        <h4>
            INFORMAZIONI GENERALI
        </h4>
        {if isset($medico)}
            <label for="nome">Nome :</label>
            <input type="text" name="nome" value ="{$medico->getNomeMedico()}" readonly />
            <br>
            <label for="cognome">Cognome :</label>
            <input type="text" name="cognome" value ="{$medico->getCognomeMedico()}" readonly />
            <br>
            <label for="codice">Codice Fiscale :</label>
            <input type="text" name="codice" maxlength="16" value ="{$medico->getCodFiscaleMedico()}" readonly />
            <br>
            <label for="email">Email :</label>
            <input type="text" name="email" value ="{$medico->getEmail()}" readonly />
            <br>
                {if isset($modificaInformazioni)}
                    <form id="formModificaInformazioni">
                        <label for="Via">Indirizzo :</label>
                        <input type="text" name="Via" value ="{$medico->getViaMedico()}" />
                        <label>, </label>
                        <input type="text" name="NumCivico" value="{$medico->getNumCivicoMedico()}" />
                        <br>
                        <label for="CAP">CAP :</label>
                        <input type="text" name="CAP" maxlength="5" value="{$medico->getCAPMedico()}" />
                        <br>
                        <input type="submit" id="modificaIndirizzoMedicoFatto" value="OK" />
                    </form>
                {else}
                    <label for="Via">Indirizzo :</label>
                    <input type="text" name="Via" value="{$medico->getViaMedico()}" readonly />
                    <label>, </label>
                    <input type="text" name="NumCivico" value="{$medico->getNumCivicoMedico()}" readonly />
                    <br>
                    <label for="CAP">CAP :</label>
                    <input type="text" name="CAP" maxlength="5" value="{$medico->getCAPMedico()}" readonly />
                    <br>
                    <input type="button" id="modificaIndirizzoMedico" value="Modifica Indirizzo" />  
                    <br>
                {/if}
                {if isset($modifica)}
                    <form id="formModificaAlboNum">
                        <label for="ProvinciaAlbo">Provincia Albo :</label>
                       <!-- <select type="text" name="provinciaAlbo" class="elementiForm" id="provinciaAlbo" value="{$medico->getProvinciaAlboMedico()}" required > -->
                            <select name="provinciaAlbo" class="elementiForm" >
                            <!--<option disabled selected value=""> -- select an option -- </option> -->
                            <option selected="selected" >AGRIGENTO</option>
                            <option>ALESSANDRIA</option>
                            <option>ANCONA</option>
                            <option>AOSTA</option>
                            <option>AREZZO</option>
                            <option>ASCOLI PICENO</option>
                            <option>ASTI</option>
                            <option>AVELLINO</option>
                            <option>BARI</option>
                            <option>BARLETTA-ANDRIA-TRANI</option>
                            <option>BELLUNO</option>
                            <option>BENEVENTO</option>
                            <option>BERGAMO</option>
                            <option>BIELLA</option>
                            <option>BOLOGNA</option>
                            <option>BOLZANO</option>
                            <option>BRESCIA</option>
                            <option>BRINDISI</option>
                            <option>CAGLIARI</option>
                            <option>CALTANISSETTA</option>
                            <option>CAMPOBASSO</option>
                            <option>CARBONIA-IGLESIAS</option>
                            <option>CASERTA</option>
                            <option>CATANIA</option>
                            <option>CATANZARO</option>
                            <option>CHIETI</option>
                            <option>COMO</option>
                            <option>COSENZA</option>
                            <option>CREMONA</option>
                            <option>CROTONE</option>
                            <option>CUNEO</option>
                            <option>ENNA</option>
                            <option>FERMO</option>
                            <option>FERRARA</option>
                            <option>FIRENZE</option>
                            <option>FOGGIA</option>
                            <option>FORLI’-CESENA</option>
                            <option>FROSINONE</option>
                            <option>GENOVA</option>
                            <option>GORIZIA</option>
                            <option>GROSSETO</option>
                            <option>IMPERIA</option>
                            <option>ISERNIA</option>
                            <option>LA SPEZIA</option>
                            <option>L’AQUILA</option>
                            <option>LATINA</option>
                            <option>LECCE</option>
                            <option>LECCO</option>
                            <option>LIVORNO</option>
                            <option>LODI</option>
                            <option>LUCCA</option>
                            <option>MACERATA</option>
                            <option>MANTOVA</option>
                            <option>MASSA-CARRARA</option>
                            <option>MATERA</option>
                            <option>MEDIO CAMPIDANO</option>
                            <option>MESSINA</option>
                            <option>MILANO</option>
                            <option>MODENA</option>
                            <option>MONZA E DELLA BRIANZA</option>
                            <option>NAPOLI</option>
                            <option>NOVARA</option>
                            <option>NUORO</option>
                            <option>OGLIASTRA</option>
                            <option>OLBIA-TEMPIO</option>
                            <option>ORISTANO</option>
                            <option>PADOVA</option>
                            <option>PALERMO</option>
                            <option>PARMA</option>
                            <option>PAVIA</option>
                            <option>PERUGIA</option>
                            <option>PESARO E URBINO</option>
                            <option>PESCARA</option>
                            <option>PIACENZA</option>
                            <option>PISA</option>
                            <option>PISTOIA</option>
                            <option>PORDENONE</option>
                            <option>POTENZA</option>
                            <option>PRATO</option>
                            <option>RAGUSA</option>
                            <option>RAVENNA</option>
                            <option>REGGIO DI CALABRIA</option>
                            <option>REGGIO NELL’EMILIA</option>
                            <option>RIETI</option>
                            <option>RIMINI</option>
                            <option>ROMA</option>
                            <option>ROVIGO</option>
                            <option>SALERNO</option>
                            <option>SASSARI</option>
                            <option>SAVONA</option>
                            <option>SIENA</option>
                            <option>SIRACUSA</option>
                            <option>SONDRIO</option>
                            <option>TARANTO</option>
                            <option>TERAMO</option>
                            <option>TERNI</option>
                            <option>TORINO</option>
                            <option>TRAPANI</option>
                            <option>TRENTO</option>
                            <option>TREVISO</option>
                            <option>TRIESTE</option>
                            <option>UDINE</option>
                            <option>VARESE</option>
                            <option>VENEZIA</option>
                            <option>VERBANO-CUSIO-OSSOLA</option>
                            <option>VERCELLI</option>
                            <option>VERONA</option>
                            <option>VIBO VALENTIA</option>
                            <option>VICENZA</option>
                            <option>VITERBO</option>
                        </select>
                        <br>
                        <label for="numeroIscrizione">Numero Iscrizione :</label>
                        <input type="text" name="numeroIscrizione" maxlength="6" value="{$medico->getNumIscrizioneMedico() }" />
                        <br>
                        <input type="submit" id="modificaMedicoFatto" value="OK" />  
                    </form>
                {else}
                    <label for="ProvinciaAlbo">Provincia Albo :</label>
                    <input type="text" name="ProvinciaAlbo" value="{$medico->getProvinciaAlboMedico()}" readonly />
                    <br>
                    <label for="numeroIscrizione">Numero Iscrizione :</label>
                    <input type="text" name="numeroIscrizione" maxlength="6" value="{$medico->getNumIscrizioneMedico() }" readonly />
                    <br>
                    <input type="button" id="modificaMedico" value="Modifica" />  
                {/if}
        {/if}
    </div>
{/if}


{if isset($credenziali)}
    <div id="credenziali">
        <h4>
            CREDENZIALI
        </h4>
        {if isset($medico)}                    
            {if isset($modificaCredenziali)}
                <form id="formModificaPassword" >                    
                    <label for="username">Username :</label>
                    <input type="text" name="username" value ="{$medico->getUsername()}" readonly />
                    <label for="password">Password :</label>
                    <input type="password" name="password" id='nuovaPassword'/>
                    <label for="ripetiPassword">Ripeti Password :</label>
                    <input type="password" name="ripetiPassword" />
                    <br>
                    <input type="submit" id="inviaNuovaPassword" value="Invia Nuova Password" />
                </form>
            {else}  
                <label for="username">Username :</label>
                <input type="text" name="username" value ="{$medico->getUsername()}" readonly />
                <br>
                <input type="button" id="modificaPassword" value="Modifica Credenziali" />
            {/if}
        {/if}
    </div>

{/if}