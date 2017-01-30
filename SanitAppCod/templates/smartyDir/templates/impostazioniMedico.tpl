{if isset($informazioniGenerali)}
    <div id="informazioniGenerali">
        <h4>
            INFORMAZIONI GENERALI
        </h4>
        {if isset($medico)}
            <label for="nome" class="elementiForm">Nome :</label>
            <input type="text" name="nome" class="elementiForm" value ="{$medico->getNomeMedico()}" readonly />
            <br>
            <label for="cognome" class="elementiForm">Cognome :</label>
            <input type="text" name="cognome" class="elementiForm" value ="{$medico->getCognomeMedico()}" readonly />
            <br>
            <label for="codice" class="elementiForm">Codice Fiscale :</label>
            <input type="text" name="codice" class="elementiForm" maxlength="16" value ="{$medico->getCodFiscaleMedico()}" readonly />
            <br>
            <label for="email" class="elementiForm">Email :</label>
            <input type="text" name="email" class="elementiForm" value ="{$medico->getEmailUser()}" readonly />
            <br>
                {if isset($modificaInformazioni)}
                    <form id="formModificaInformazioni">
                        <label for="Via" class="elementiForm">Indirizzo :</label>
                        <input type="text" name="Via" class="elementiForm" value ="{$medico->getViaMedico()}" />
                        <label>, </label>
                        <input type="text" name="NumCivico" class="elementiForm" value="{$medico->getNumCivicoMedico()}" />
                        <br>
                        <label for="CAP" class="elementiForm">CAP :</label>
                        <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$medico->getCAPMedico()}" />
                        <br>
                        <input type="submit" id="modificaIndirizzoMedicoFatto" value="OK" />
                    </form>
                {else}
                    <label for="Via" class="elementiForm">Indirizzo :</label>
                    <input type="text" name="Via" class="elementiForm" value="{$medico->getViaMedico()}" readonly />
                    <label>, </label>
                    <input type="text" name="NumCivico" class="elementiForm" value="{$medico->getNumCivicoMedico()}" readonly />
                    <br>
                    <label for="CAP" class="elementiForm">CAP :</label>
                    <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$medico->getCAPMedico()}" readonly />
                    <br>
                    <input type="button" id="modificaIndirizzoMedico" value="Modifica Indirizzo" />  
                    <br>
                {/if}
                {if isset($modifica)}
                    <form id="formModificaAlboNum">
                        <label for="ProvinciaAlbo" class="elementiForm">Provincia Albo :</label>
                       <!-- <select type="text" name="provinciaAlbo" class="elementiForm" id="provinciaAlbo" value="{$medico->getProvinciaAlboMedico()}" required > -->
                            <select name="provinciaAlbo" class="elementiForm" >
                            <!--<option disabled selected value=""> -- select an option -- </option> -->
                            <option {if ($medico->getProvinciaAlboMedico()=='AGRIGENTO')} selected="selected" {/if} >AGRIGENTO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ALESSANDRIA')} selected="selected" {/if} >ALESSANDRIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ANCONA')} selected="selected" {/if} >ANCONA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='AOSTA')} selected="selected" {/if} >AOSTA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='AREZZO')} selected="selected" {/if} >AREZZO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ASCOLI PICENO')} selected="selected" {/if} >ASCOLI PICENO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ASTI')} selected="selected" {/if} >ASTI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='AVELLINO')} selected="selected" {/if} >AVELLINO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BARI')} selected="selected" {/if} >BARI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BARLETTA-ANDRIA-TRANI')} selected="selected" {/if} >BARLETTA-ANDRIA-TRANI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BELLUNO')} selected="selected" {/if} >BELLUNO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BENEVENTO')} selected="selected" {/if} >BENEVENTO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BERGAMO')} selected="selected" {/if} >BERGAMO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BIELLA')} selected="selected" {/if} >BIELLA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BOLOGNA')} selected="selected" {/if} >BOLOGNA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BOLZANO')} selected="selected" {/if} >BOLZANO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BRESCIA')} selected="selected" {/if} >BRESCIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='BRINDISI')} selected="selected" {/if} >BRINDISI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CAGLIARI')} selected="selected" {/if} >CAGLIARI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CALTANISSETTA')} selected="selected" {/if} >CALTANISSETTA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CAMPOBASSO')} selected="selected" {/if} >CAMPOBASSO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CARBONIA-IGLESIAS')} selected="selected" {/if} >CARBONIA-IGLESIAS</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CASERTA')} selected="selected" {/if} >CASERTA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CATANIA')} selected="selected" {/if} >CATANIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CATANZARO')} selected="selected" {/if} >CATANZARO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CHIETI')} selected="selected" {/if} >CHIETI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='COMO')} selected="selected" {/if} >COMO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='COSENZA')} selected="selected" {/if} >COSENZA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CREMONA')} selected="selected" {/if} >CREMONA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CROTONE')} selected="selected" {/if} >CROTONE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='CUNEO')} selected="selected" {/if} >CUNEO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ENNA')} selected="selected" {/if} >ENNA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FERMO')} selected="selected" {/if} >FERMO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FERRARA')} selected="selected" {/if} >FERRARA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FIRENZE')} selected="selected" {/if} >FIRENZE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FOGGIA')} selected="selected" {/if} >FOGGIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FORLI’-CESENA')} selected="selected" {/if} >FORLI’-CESENA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='FROSINONE')} selected="selected" {/if} >FROSINONE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='GENOVA')} selected="selected" {/if} >GENOVA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='GORIZIA')} selected="selected" {/if} >GORIZIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='GROSSETO')} selected="selected" {/if} >GROSSETO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='IMPERIA')} selected="selected" {/if} >IMPERIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ISERNIA')} selected="selected" {/if} >ISERNIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LA SPEZIA')} selected="selected" {/if} >LA SPEZIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=="L’AQUILA")} selected="selected" {/if} >L’AQUILA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LATINA')} selected="selected" {/if} >LATINA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LECCE')} selected="selected" {/if} >LECCE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LECCO')} selected="selected" {/if} >LECCO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LIVORNO')} selected="selected" {/if} >LIVORNO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LODI')} selected="selected" {/if} >LODI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='LUCCA')} selected="selected" {/if}>LUCCA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MACERATA')} selected="selected" {/if}>MACERATA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MANTOVA')} selected="selected" {/if}>MANTOVA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MASSA-CARRARA')} selected="selected" {/if}>MASSA-CARRARA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MATERA')} selected="selected" {/if}>MATERA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MEDIO CAMPIDANO')} selected="selected" {/if}>MEDIO CAMPIDANO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MESSINA')} selected="selected" {/if}>MESSINA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MILANO')} selected="selected" {/if}>MILANO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MODENA')} selected="selected" {/if}>MODENA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='MONZA E DELLA BRIANZA')} selected="selected" {/if}>MONZA E DELLA BRIANZA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='NAPOLI')} selected="selected" {/if}>NAPOLI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='NOVARA')} selected="selected" {/if}>NOVARA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='NUORO')} selected="selected" {/if}>NUORO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='OGLIASTRA')} selected="selected" {/if}>OGLIASTRA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='OLBIA-TEMPIO')} selected="selected" {/if}>OLBIA-TEMPIO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ORISTANO')} selected="selected" {/if}>ORISTANO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PADOVA')} selected="selected" {/if}>PADOVA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PALERMO')} selected="selected" {/if}>PALERMO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PARMA')} selected="selected" {/if}>PARMA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PAVIA')} selected="selected" {/if}>PAVIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PERUGIA')} selected="selected" {/if}>PERUGIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PESARO E URBINO')} selected="selected" {/if}>PESARO E URBINO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PESCARA')} selected="selected" {/if} >PESCARA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PIACENZA')} selected="selected" {/if} >PIACENZA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PISA')} selected="selected" {/if} >PISA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PISTOIA')} selected="selected" {/if} >PISTOIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PORDENONE')} selected="selected" {/if} >PORDENONE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='POTENZA')} selected="selected" {/if} >POTENZA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='PRATO')} selected="selected" {/if} >PRATO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='RAGUSA')} selected="selected" {/if} >RAGUSA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='RAVENNA')} selected="selected" {/if} >RAVENNA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='REGGIO DI CALABRIA')} selected="selected" {/if} >REGGIO DI CALABRIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='REGGIO NELL’EMILIA')} selected="selected" {/if} >REGGIO NELL’EMILIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='RIETI')} selected="selected" {/if} >RIETI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='RIMINI')} selected="selected" {/if} >RIMINI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ROMA')} selected="selected" {/if} >ROMA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='ROVIGO')} selected="selected" {/if} >ROVIGO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SALERNO')} selected="selected" {/if} >SALERNO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SASSARI')} selected="selected" {/if} >SASSARI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SAVONA')} selected="selected" {/if} >SAVONA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SIENA')} selected="selected" {/if} >SIENA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SIRACUSA')} selected="selected" {/if} >SIRACUSA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='SONDRIO')} selected="selected" {/if}>SONDRIO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TARANTO')} selected="selected" {/if} >TARANTO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TERAMO')} selected="selected" {/if} >TERAMO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TERNI')} selected="selected" {/if} >TERNI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TORINO')} selected="selected" {/if} >TORINO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TRAPANI')} selected="selected" {/if} >TRAPANI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TRENTO')} selected="selected" {/if} >TRENTO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TREVISO')} selected="selected" {/if} >TREVISO</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='TRIESTE')} selected="selected" {/if} >TRIESTE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='UDINE')} selected="selected" {/if} >UDINE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VARESE')} selected="selected" {/if} >VARESE</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VENEZIA')} selected="selected" {/if} >VENEZIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VERBANO-CUSIO-OSSOLA')} selected="selected" {/if} >VERBANO-CUSIO-OSSOLA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VERCELLI')} selected="selected" {/if} >VERCELLI</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VERONA')} selected="selected" {/if} >VERONA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VIBO VALENTIA')} selected="selected" {/if} >VIBO VALENTIA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VICENZA')} selected="selected" {/if} >VICENZA</option>
                            <option {if ($medico->getProvinciaAlboMedico()=='VITERBO')} selected="selected" {/if} >VITERBO</option>
                        </select>
                        <br>
                        <label for="numeroIscrizione" class="elementiForm">Numero Iscrizione :</label>
                        <input type="text" name="numeroIscrizione" class="elementiForm" maxlength="6" value="{$medico->getNumIscrizioneMedico() }" />
                        <br>
                        <input type="submit" id="modificaMedicoFatto" value="OK" />  
                    </form>
                {else}
                    <label for="ProvinciaAlbo" class="elementiForm">Provincia Albo :</label>
                    <input type="text" name="ProvinciaAlbo" class="elementiForm" value="{$medico->getProvinciaAlboMedico()}" readonly />
                    <br>
                    <label for="numeroIscrizione" class="elementiForm">Numero Iscrizione :</label>
                    <input type="text" name="numeroIscrizione" class="elementiForm" maxlength="6" value="{$medico->getNumIscrizioneMedico() }" readonly />
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
                    <label for="username" class="elementiForm">Username :</label>
                    <input type="text" name="username" class="elementiForm" value ="{$medico->getUsernameUser()}" readonly />
                    <label for="password" class="elementiForm">Password :</label>
                    <input type="password" name="password" maxlength="10" class="elementiForm" id='nuovaPassword'/>
                    <label for="ripetiPassword" class="elementiForm">Ripeti Password :</label>
                    <input type="password" name="ripetiPassword" maxlength="10" class="elementiForm" />
                    <br>
                    <input type="submit" id="inviaNuovaPassword" value="Invia Nuova Password" />
                </form>
            {else}  
                <label for="username" class="elementiForm">Username :</label>
                <input type="text" name="username" class="elementiForm" value ="{$medico->getUsernameUser()}" readonly />
                <br>
                <input type="button" id="modificaPassword" value="Modifica Credenziali" />
            {/if}
        {/if}
    </div>

{/if}