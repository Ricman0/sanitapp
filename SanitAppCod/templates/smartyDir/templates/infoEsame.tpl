{if {$servizi}===TRUE}
    <div id="infoEsame">
        <form name="modificaEsame" method="post" id="modificaEsame"> 

            <input type="hidden" name="controller" value="servizi" />
            <input type="hidden" name="task" value="modifica" />

            <label for="nomeEsame" class="elementiForm">Nome</label>
            <input type="text" name="nomeEsame" id="nomeEsame" class="elementiForm" value="{$esame->getNomeEsame()}" required disabled />
            <br>

            <label for="medicoEsame" class="elementiForm">Medico</label>
            <input type="text" name="medicoEsame" id="medicoEsame" class="elementiForm" value="{$esame->getMedicoEsame()}" required disabled />
            <br>

            <label for="categoriaEsame" class="elementiForm">Categoria</label>
            <select  name="categoriaEsame" id="categoriaEsame" class="elementiForm" required disabled>
                <option disabled selected  value=""> {$esame->getNomeCategoriaEsame()} </option>
                {foreach from=$categorie item=curr_row}
                    <option value="{$curr_row['Nome']}">{$curr_row['Nome']}</option>
                {/foreach}

            </select>

            <br>

            <label for="prezzoEsame" class="elementiForm">Prezzo</label>    
            <input type="text" name="prezzoEsame" id="prezzoEsame" class="elementiForm" value="{$esame->getPrezzoEsame()}" disabled required/>
            <br>

            <div class="time">
                <label for="durataEsame" class="elementiForm">Durata</label>
                <input type="text" name="durataEsame" id="durataEsame" class="elementiForm" value="{$esame->getDurataEsame()}" disabled required/>
                <br>
            </div>

            <label for="numPrestazioniSimultanee" class="elementiForm">Numero Prestazioni Simultanee</label>
            <input type="number" name="numPrestazioniSimultanee" id="numPrestazioniSimultanee" class="elementiForm" value="{$esame->getNumeroPrestazioniSimultaneeEsame()}" min="1" max="1000" disabled required>
            <br>

            <label for="descrizioneEsame" class="elementiForm">Descrizione Esame</label>    
            <textarea form="aggiungiEsame" name="descrizioneEsame" id="descrizioneEsame" class="elementiForm" value="{$esame->getDescrizioneEsame()}" maxlength="200" disabled required ></textarea>
            <br>

         <!--   <button id="modificaEsameButton">Modifica</button>
            <button id="disattibaEsameButton">Disattiva</button>
            <button id="eliminaEsameButton">Elimina</button>
            <br>
            <button id="indietroEsameButton">Indietro</button> -->


        </form>
    </div>


    {else}
        <div id="infoEsame">
            {if isset($informazioniClinica)}
                {$informazioniClinica}
            {/if}
            <h3>INFORMAZIONI ESAME</h3>
            <span class="grassetto">NOME:</span><span>  {$esame->getNomeEsame()}</span>
            <br>
            <span class="grassetto">CATEGORIA:</span><span>  {$esame->getNomeCategoriaEsame()}</span>
            <br>
            <span class="grassetto">PREZZO:</span><span>  {$esame->getPrezzoEsame()}</span>
            <br>
            <span class="grassetto">DURATA:</span><span>  {$esame->getDurataEsame()}</span>
            <br>
            <span class="grassetto">MEDICO RESPONSABILE:</span><span>  {$esame->getMedicoEsame()}</span>
            <br>
            <!--
            <span class="grassetto">NUMERO PRESTAZIONI SIMULTANEE:</span><span>  {$esame->getNumeroPrestazioniSimultaneeEsame()}</span>
            <br>
            -->
            <span class="grassetto">DESCRIZIONE:</span><span>  {$esame->getDescrizioneEsame()}</span>
            <br>
            
            <input type="button" id="modificaEsame" value="Modifica Esame  " data-idEsame="{$esame->getIDEsame()}" data-idClinica="{$esame->getPartitaIVAClinicaEsame()}" />
            <input type="button" id="disattivaEsame" value="Disattiva Esame  " data-idEsame="{$esame->getIDEsame()}" data-idClinica="{$esame->getPartitaIVAClinicaEsame()}" /> 
            <input type="button" id="eliminaEsame" value="Elimina Esame  " data-idEsame="{$esame->getIDEsame()}" data-idClinica="{$esame->getPartitaIVAClinicaEsame()}" />          
            <input type="button" id="aggiungiPrenotazioneButton" value="Prenota"  data-idEsame="{$esame->getIDEsame()}" data-idClinica="{$esame->getPartitaIVAClinicaEsame()}" {if isset($codiceFiscale)} data-codiceFiscale="{$codiceFiscale}"{/if} />
        </div>
{/if}
