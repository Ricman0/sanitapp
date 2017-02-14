<h3>AGGIUNGI SERVIZIO</h3>
<hr>
<h4>Riempi il seguente form e clicca su 'Aggiungi' per aggiungere un nuovo servizio alla tua clinica.</h4>
<h4>Clicca su 'Annulla' per annullare l'operazione.</h4>
<form name="aggiungiEsame" method="post" id="aggiungiEsame"> 

    <label for="nomeEsame" class="elementiForm">Nome</label>
    <input type="text" name="nomeEsame" id="nomeEsame" class="elementiForm" placeholder="Raggi Schiena" value="{if isset($datiValidi.nome)}{$datiValidi.nome}{/if}" required />
    <br>
    
    <label for="medicoEsame" class="elementiForm">Medico</label>
    <input type="text" name="medicoEsame" id="medicoEsame" class="elementiForm" placeholder="Mario Rossi" value="{if isset($datiValidi.medico)}{$datiValidi.medico}{/if}" required/>
    <br>
    
    <label for="categoriaEsame" class="elementiForm">Categoria</label>
    <select  name="categoriaEsame" id="categoriaEsame" class="elementiForm" required>
            
        {foreach from=$categorie item=curr_row}
            <option value="{$curr_row['Nome']}">{$curr_row['Nome']}</option>
        {/foreach}
        
        {if isset($datiValidi.categoria)}
            <option selected value="{$datiValidi.categoria}">{$datiValidi.categoria}</option>
        {else}
            <option disabled selected value=""> -- select an option -- </option>
        {/if}

    </select>

    <br>
    
    <label for="prezzoEsame" class="elementiForm">Prezzo</label>    
    <input type="text" name="prezzoEsame" id="prezzoEsame" class="elementiForm" placeholder="35.50" value="{if isset($datiValidi.prezzo)}{$datiValidi.prezzo}{/if}" required/>
    <br>
    
    <label for="durataEsame" class="elementiForm">Durata</label>
    <input type="text" name="durataEsame" id="durataEsame" class="elementiForm time"  placeholder="00:15" value="{if isset($datiValidi.durata)}{$datiValidi.durata}{/if}" required/>
    <br>
    
    <label for="numPrestazioniSimultanee" class="elementiForm">Numero Prestazioni Simultanee</label>
    <input type="number" name="numPrestazioniSimultanee" id="numPrestazioniSimultanee" class="elementiForm" value="1" readonly >
    <br>
      
    <label for="descrizioneEsame" class="elementiForm">Descrizione Esame</label>    
    <textarea form="aggiungiEsame" name="descrizioneEsame" id="descrizioneEsame" class="elementiForm" maxlength="600" placeholder="Breve descrizione dell'esame" required>{if isset($datiValidi.descrizione)}{$datiValidi.descrizione}{/if}</textarea>
    <br>

    <span id="aggiungiEsame" >
        <input type="submit" value="Aggiungi" id="submitAggiungiEsame">
    </span>
    
    <span id="annullaEsame" >
        <input type="button" value="Annulla" id="annullaAggiungiEsame">
    </span>
</form>