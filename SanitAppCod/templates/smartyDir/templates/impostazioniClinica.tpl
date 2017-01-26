{if isset($informazioniGenerali)}
    <div id="informazioniGenerali">
        <h4>
            INFORMAZIONI GENERALI
        </h4>
        {if isset($clinica)}
            <label for="nome" class="elementiForm">Nome :</label>
            <input type="text" name="nome" class="elementiForm" value ="{$clinica->getNomeClinicaClinica()}" readonly />
            <br>
            <label for="partitaIVA" class="elementiForm">Partita IVA :</label>
            <input type="text" name="partitaIVA" class="elementiForm" maxlength="11" value ="{$clinica->getPartitaIVAClinica()}" readonly />
            <br>
            <label for="email" class="elementiForm">Email :</label>
            <input type="text" name="email" class="elementiForm" value ="{$clinica->getEmailUser()}" readonly />
            <br>
            <label for="PEC" class="elementiForm">PEC :</label>
            <input type="text" name="PEC" class="elementiForm" value ="{$clinica->getPECUser()}" readonly />
            <br>
                {if isset($modificaInformazioni)}
                    <form id="formModificaInformazioniClinica">
                        <label for="titolare" class="elementiForm">Titolare :</label>
                        <input type="text" name="titolare" class="elementiForm" value="{$clinica->getTitolareClinica()}" />
                        <br>
                        <label for="Via" class="elementiForm">Indirizzo :</label>
                        <input type="text" name="Via" class="elementiForm" value ="{$clinica->getViaClinica()}" />
                        <label>, </label>
                        <input type="text" name="NumCivico" class="elementiForm" value="{$clinica->getNumCivicoClinica()}" />
                        <br>
                        <label for="CAP" class="elementiForm">CAP :</label>
                        <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$clinica->getCAPClinica()}" />
                        <br>
                        <label for="localitàClinica" class="elementiForm">Località :</label>
                        <input type="text" name="localitàClinica" class="elementiForm" value="{$clinica->getLocalitaClinica()}" />
                        <br>
                        <label for="provinciaClinica" class="elementiForm">Provincia  :</label>
                       <!-- <select type="text" name="provinciaAlbo" class="elementiForm" id="provinciaAlbo" value="{$clinica->getProvinciaClinica()}" required > -->
                            <select name="provinciaClinica" class="elementiForm" >
                            <!--<option disabled selected value=""> -- select an option -- </option> -->
                            <option {if ($clinica->getProvinciaClinica()==='AGRIGENTO')} selected="selected" {/if} >AGRIGENTO</option>
                            <option {if ($clinica->getProvinciaClinica()==='ALESSANDRIA')} selected="selected" {/if} >ALESSANDRIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='ANCONA')} selected="selected" {/if} >ANCONA</option>
                            <option {if ($clinica->getProvinciaClinica()==='AOSTA')} selected="selected" {/if} >AOSTA</option>
                            <option {if ($clinica->getProvinciaClinica()==='AREZZO')} selected="selected" {/if} >AREZZO</option>
                            <option {if ($clinica->getProvinciaClinica()==='ASCOLI PICENO')} selected="selected" {/if} >ASCOLI PICENO</option>
                            <option {if ($clinica->getProvinciaClinica()==='ASTI')} selected="selected" {/if} >ASTI</option>
                            <option {if ($clinica->getProvinciaClinica()==='AVELLINO')} selected="selected" {/if} >AVELLINO</option>
                            <option {if ($clinica->getProvinciaClinica()==='BARI')} selected="selected" {/if} >BARI</option>
                            <option {if ($clinica->getProvinciaClinica()==='BARLETTA-ANDRIA-TRANI')} selected="selected" {/if} >BARLETTA-ANDRIA-TRANI</option>
                            <option {if ($clinica->getProvinciaClinica()==='BELLUNO')} selected="selected" {/if} >BELLUNO</option>
                            <option {if ($clinica->getProvinciaClinica()==='BENEVENTO')} selected="selected" {/if} >BENEVENTO</option>
                            <option {if ($clinica->getProvinciaClinica()==='BERGAMO')} selected="selected" {/if} >BERGAMO</option>
                            <option {if ($clinica->getProvinciaClinica()==='BIELLA')} selected="selected" {/if} >BIELLA</option>
                            <option {if ($clinica->getProvinciaClinica()==='BOLOGNA')} selected="selected" {/if} >BOLOGNA</option>
                            <option {if ($clinica->getProvinciaClinica()==='BOLZANO')} selected="selected" {/if} >BOLZANO</option>
                            <option {if ($clinica->getProvinciaClinica()==='BRESCIA')} selected="selected" {/if} >BRESCIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='BRINDISI')} selected="selected" {/if} >BRINDISI</option>
                            <option {if ($clinica->getProvinciaClinica()==='CAGLIARI')} selected="selected" {/if} >CAGLIARI</option>
                            <option {if ($clinica->getProvinciaClinica()==='CALTANISSETTA')} selected="selected" {/if} >CALTANISSETTA</option>
                            <option {if ($clinica->getProvinciaClinica()==='CAMPOBASSO')} selected="selected" {/if} >CAMPOBASSO</option>
                            <option {if ($clinica->getProvinciaClinica()==='CARBONIA-IGLESIAS')} selected="selected" {/if} >CARBONIA-IGLESIAS</option>
                            <option {if ($clinica->getProvinciaClinica()==='CASERTA')} selected="selected" {/if} >CASERTA</option>
                            <option {if ($clinica->getProvinciaClinica()==='CATANIA')} selected="selected" {/if} >CATANIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='CATANZARO')} selected="selected" {/if} >CATANZARO</option>
                            <option {if ($clinica->getProvinciaClinica()==='CHIETI')} selected="selected" {/if} >CHIETI</option>
                            <option {if ($clinica->getProvinciaClinica()==='COMO')} selected="selected" {/if} >COMO</option>
                            <option {if ($clinica->getProvinciaClinica()==='COSENZA')} selected="selected" {/if} >COSENZA</option>
                            <option {if ($clinica->getProvinciaClinica()==='CREMONA')} selected="selected" {/if} >CREMONA</option>
                            <option {if ($clinica->getProvinciaClinica()==='CROTONE')} selected="selected" {/if} >CROTONE</option>
                            <option {if ($clinica->getProvinciaClinica()==='CUNEO')} selected="selected" {/if} >CUNEO</option>
                            <option {if ($clinica->getProvinciaClinica()==='ENNA')} selected="selected" {/if} >ENNA</option>
                            <option {if ($clinica->getProvinciaClinica()==='FERMO')} selected="selected" {/if} >FERMO</option>
                            <option {if ($clinica->getProvinciaClinica()==='FERRARA')} selected="selected" {/if} >FERRARA</option>
                            <option {if ($clinica->getProvinciaClinica()==='FIRENZE')} selected="selected" {/if} >FIRENZE</option>
                            <option {if ($clinica->getProvinciaClinica()==='FOGGIA')} selected="selected" {/if} >FOGGIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='FORLI’-CESENA')} selected="selected" {/if} >FORLI’-CESENA</option>
                            <option {if ($clinica->getProvinciaClinica()==='FROSINONE')} selected="selected" {/if} >FROSINONE</option>
                            <option {if ($clinica->getProvinciaClinica()==='GENOVA')} selected="selected" {/if} >GENOVA</option>
                            <option {if ($clinica->getProvinciaClinica()==='GORIZIA')} selected="selected" {/if} >GORIZIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='GROSSETO')} selected="selected" {/if} >GROSSETO</option>
                            <option {if ($clinica->getProvinciaClinica()==='IMPERIA')} selected="selected" {/if} >IMPERIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='ISERNIA')} selected="selected" {/if} >ISERNIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='LA SPEZIA')} selected="selected" {/if} >LA SPEZIA</option>
                            <option {if ($clinica->getProvinciaClinica()==="L’AQUILA")} selected="selected" {/if} >L’AQUILA</option>
                            <option {if ($clinica->getProvinciaClinica()==='LATINA')} selected="selected" {/if} >LATINA</option>
                            <option {if ($clinica->getProvinciaClinica()==='LECCE')} selected="selected" {/if} >LECCE</option>
                            <option {if ($clinica->getProvinciaClinica()==='LECCO')} selected="selected" {/if} >LECCO</option>
                            <option {if ($clinica->getProvinciaClinica()==='LIVORNO')} selected="selected" {/if} >LIVORNO</option>
                            <option {if ($clinica->getProvinciaClinica()==='LODI')} selected="selected" {/if} >LODI</option>
                            <option {if ($clinica->getProvinciaClinica()==='LUCCA')} selected="selected" {/if}>LUCCA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MACERATA')} selected="selected" {/if}>MACERATA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MANTOVA')} selected="selected" {/if}>MANTOVA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MASSA-CARRARA')} selected="selected" {/if}>MASSA-CARRARA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MATERA')} selected="selected" {/if}>MATERA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MEDIO CAMPIDANO')} selected="selected" {/if}>MEDIO CAMPIDANO</option>
                            <option {if ($clinica->getProvinciaClinica()==='MESSINA')} selected="selected" {/if}>MESSINA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MILANO')} selected="selected" {/if}>MILANO</option>
                            <option {if ($clinica->getProvinciaClinica()==='MODENA')} selected="selected" {/if}>MODENA</option>
                            <option {if ($clinica->getProvinciaClinica()==='MONZA E DELLA BRIANZA')} selected="selected" {/if}>MONZA E DELLA BRIANZA</option>
                            <option {if ($clinica->getProvinciaClinica()==='NAPOLI')} selected="selected" {/if}>NAPOLI</option>
                            <option {if ($clinica->getProvinciaClinica()==='NOVARA')} selected="selected" {/if}>NOVARA</option>
                            <option {if ($clinica->getProvinciaClinica()==='NUORO')} selected="selected" {/if}>NUORO</option>
                            <option {if ($clinica->getProvinciaClinica()==='OGLIASTRA')} selected="selected" {/if}>OGLIASTRA</option>
                            <option {if ($clinica->getProvinciaClinica()==='OLBIA-TEMPIO')} selected="selected" {/if}>OLBIA-TEMPIO</option>
                            <option {if ($clinica->getProvinciaClinica()==='ORISTANO')} selected="selected" {/if}>ORISTANO</option>
                            <option {if ($clinica->getProvinciaClinica()==='PADOVA')} selected="selected" {/if}>PADOVA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PALERMO')} selected="selected" {/if}>PALERMO</option>
                            <option {if ($clinica->getProvinciaClinica()==='PARMA')} selected="selected" {/if}>PARMA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PAVIA')} selected="selected" {/if}>PAVIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PERUGIA')} selected="selected" {/if}>PERUGIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PESARO E URBINO')} selected="selected" {/if}>PESARO E URBINO</option>
                            <option {if ($clinica->getProvinciaClinica()==='PESCARA')} selected="selected" {/if} >PESCARA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PIACENZA')} selected="selected" {/if} >PIACENZA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PISA')} selected="selected" {/if} >PISA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PISTOIA')} selected="selected" {/if} >PISTOIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PORDENONE')} selected="selected" {/if} >PORDENONE</option>
                            <option {if ($clinica->getProvinciaClinica()==='POTENZA')} selected="selected" {/if} >POTENZA</option>
                            <option {if ($clinica->getProvinciaClinica()==='PRATO')} selected="selected" {/if} >PRATO</option>
                            <option {if ($clinica->getProvinciaClinica()==='RAGUSA')} selected="selected" {/if} >RAGUSA</option>
                            <option {if ($clinica->getProvinciaClinica()==='RAVENNA')} selected="selected" {/if} >RAVENNA</option>
                            <option {if ($clinica->getProvinciaClinica()==='REGGIO DI CALABRIA')} selected="selected" {/if} >REGGIO DI CALABRIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='REGGIO NELL’EMILIA')} selected="selected" {/if} >REGGIO NELL’EMILIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='RIETI')} selected="selected" {/if} >RIETI</option>
                            <option {if ($clinica->getProvinciaClinica()==='RIMINI')} selected="selected" {/if} >RIMINI</option>
                            <option {if ($clinica->getProvinciaClinica()==='ROMA')} selected="selected" {/if} >ROMA</option>
                            <option {if ($clinica->getProvinciaClinica()==='ROVIGO')} selected="selected" {/if} >ROVIGO</option>
                            <option {if ($clinica->getProvinciaClinica()==='SALERNO')} selected="selected" {/if} >SALERNO</option>
                            <option {if ($clinica->getProvinciaClinica()==='SASSARI')} selected="selected" {/if} >SASSARI</option>
                            <option {if ($clinica->getProvinciaClinica()==='SAVONA')} selected="selected" {/if} >SAVONA</option>
                            <option {if ($clinica->getProvinciaClinica()==='SIENA')} selected="selected" {/if} >SIENA</option>
                            <option {if ($clinica->getProvinciaClinica()==='SIRACUSA')} selected="selected" {/if} >SIRACUSA</option>
                            <option {if ($clinica->getProvinciaClinica()==='SONDRIO')} selected="selected" {/if}>SONDRIO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TARANTO')} selected="selected" {/if} >TARANTO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TERAMO')} selected="selected" {/if} >TERAMO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TERNI')} selected="selected" {/if} >TERNI</option>
                            <option {if ($clinica->getProvinciaClinica()==='TORINO')} selected="selected" {/if} >TORINO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TRAPANI')} selected="selected" {/if} >TRAPANI</option>
                            <option {if ($clinica->getProvinciaClinica()==='TRENTO')} selected="selected" {/if} >TRENTO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TREVISO')} selected="selected" {/if} >TREVISO</option>
                            <option {if ($clinica->getProvinciaClinica()==='TRIESTE')} selected="selected" {/if} >TRIESTE</option>
                            <option {if ($clinica->getProvinciaClinica()==='UDINE')} selected="selected" {/if} >UDINE</option>
                            <option {if ($clinica->getProvinciaClinica()==='VARESE')} selected="selected" {/if} >VARESE</option>
                            <option {if ($clinica->getProvinciaClinica()==='VENEZIA')} selected="selected" {/if} >VENEZIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='VERBANO-CUSIO-OSSOLA')} selected="selected" {/if} >VERBANO-CUSIO-OSSOLA</option>
                            <option {if ($clinica->getProvinciaClinica()==='VERCELLI')} selected="selected" {/if} >VERCELLI</option>
                            <option {if ($clinica->getProvinciaClinica()==='VERONA')} selected="selected" {/if} >VERONA</option>
                            <option {if ($clinica->getProvinciaClinica()==='VIBO VALENTIA')} selected="selected" {/if} >VIBO VALENTIA</option>
                            <option {if ($clinica->getProvinciaClinica()==='VICENZA')} selected="selected" {/if} >VICENZA</option>
                            <option {if ($clinica->getProvinciaClinica()==='VITERBO')} selected="selected" {/if} >VITERBO</option>
                        </select>
                        <br>
                        <label for="telefono" class="elementiForm">Telefono :</label>
                        <input type="text" name="telefono" class="elementiForm" value="{$clinica->getTelefonoClinica()}" />
                        <br>
                        <label for="capitaleSociale" class="elementiForm">Capitale Sociale :</label>
                        <input type="text" name="capitaleSociale" class="elementiForm" value="{$clinica->getCapitaleSocialeClinica()}" />
                        <br>
                        <input type="submit" id="modificaInformazioniClinicaFatto" value="OK" />
                    </form>
                {else}
                    <label for="titolare" class="elementiForm">Titolare :</label>
                    <input type="text" name="titolare" class="elementiForm" value="{$clinica->getTitolareClinica()}" readonly />
                    <br>
                    <label for="Via" class="elementiForm">Indirizzo :</label>
                    <input type="text" name="Via" class="elementiForm" value ="{$clinica->getViaClinica()}" readonly />
                    <label>, </label>
                    <input type="text" name="NumCivico" class="elementiForm" value="{$clinica->getNumCivicoClinica()}" readonly />
                    <br>
                    <label for="CAP" class="elementiForm">CAP :</label>
                    <input type="text" name="CAP" class="elementiForm" maxlength="5" value="{$clinica->getCAPClinica()}" readonly />
                    <br>
                    <label for="localitàClinica" class="elementiForm">Località :</label>
                    <input type="text" name="localitàClinica" class="elementiForm" value="{$clinica->getLocalitaClinica()}" readonly />
                    <br>
                    <label for="provinciaClinica" class="elementiForm">Provincia  :</label>
                    <input type="text" name="provinciaClinica" class="elementiForm" value="{$clinica->getProvinciaClinica()}" readonly />
                    <br>
                    <label for="telefono" class="elementiForm">Telefono :</label>
                    <input type="text" name="telefono" class="elementiForm" value="{$clinica->getTelefonoClinica()}" readonly />
                    <br>
                    <label for="capitaleSociale" class="elementiForm">Capitale Sociale :</label>
                    <input type="text" name="capitaleSociale" class="elementiForm" value="{$clinica->getCapitaleSocialeClinica()}" readonly />
                    <br>
                    <input type="button" id="modificaInformazioniClinica" value="Modifica Informazioni" />  
                    <br>
                {/if}
                
        {/if}
    </div>
{/if}


{if isset($credenziali)}
    <div id="credenziali">
        <h4>
            CREDENZIALI
        </h4>
        {if isset($clinica)}                    
            {if isset($modificaCredenziali)}
                <form id="formModificaPassword" >                    
                    <label for="username">Username :</label>
                    <input type="text" name="username" value ="{$clinica->getUsernameUser()}" readonly />
                    <label for="password">Password :</label>
                    <input type="password" name="password" id='nuovaPassword'/>
                    <label for="ripetiPassword">Ripeti Password :</label>
                    <input type="password" name="ripetiPassword" />
                    <br>
                    <input type="submit" id="inviaNuovaPassword" value="Invia Nuova Password" />
                </form>
            {else}  
                <label for="username">Username :</label>
                <input type="text" name="username" value ="{$clinica->getUsernameUser()}" readonly />
                <br>
                <input type="button" id="modificaPassword" value="Modifica Credenziali" />
            {/if}
        {/if}
    </div>

{/if}
