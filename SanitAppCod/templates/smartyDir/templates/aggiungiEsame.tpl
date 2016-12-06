<form name="aggiungiEsame" method="post" id="aggiungiEsame"> 

    <input type="hidden" name="controller" value="servizi"/>
    <input type="hidden" name="task" value="aggiungi"/>

    <label for="nomeEsame" class="elementiForm">Nome</label>
    <input type="text" name="nomeEsame" id="nomeEsame" class="elementiForm" placeholder="Raggi Schiena" required/>
    <br>
    
    <label for="medicoEsame" class="elementiForm">Medico</label>
    <input type="text" name="medicoEsame" id="medicoEsame" class="elementiForm" placeholder="Mario Rossi" required/>
    <br>
    
    <label for="categoriaEsame" class="elementiForm">Categoria</label>
    <select  name="categoriaEsame" id="categoriaEsame" class="elementiForm" required>
            <option disabled selected value=""> -- select an option -- </option>
        {foreach from=$categorie item=curr_row}
            <option value={$curr_row['Nome']}>{$curr_row['Nome']}</option>
        {/foreach}

    </select>

    <br>
    
    <label for="prezzoEsame" class="elementiForm">Prezzo</label>    
    <input type="text" name="prezzoEsame" id="prezzoEsame" class="elementiForm" placeholder="35.50" required/>
    <br>
    
    <label for="durataEsame" class="elementiForm">Durata</label>
    <input type="text" name="durataEsame" id="durataEsame" class="elementiForm time"  placeholder="00:15" required/>
    <br>
    
    <label for="numPrestazioniSimultanee" class="elementiForm">Numero Prestazioni Simultanee</label>
    <input type="number" name="numPrestazioniSimultanee" id="numPrestazioniSimultanee" class="elementiForm" value="1" readonly >
    <br>
      
    <label for="descrizioneEsame" class="elementiForm">Descrizione Esame</label>    
    <textarea form="aggiungiEsame" name="descrizioneEsame" id="descrizioneEsame" class="elementiForm" maxlength="200" placeholder="Breve descrizione dell'esame" required></textarea>
    <br>

    <span id="aggiungiEsame" >
        <input type="submit" value="Aggiungi" id="submitAggiungiEsame">
    </span>
    
    <span id="annullaEsame" >
        <input type="button" value="Annulla" id="annullaAggiungiEsame">
    </span>
</form>