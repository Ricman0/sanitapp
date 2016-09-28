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
    <input type="text" name="categoriaEsame" id="categoriaEsame" class="elementiForm" placeholder="Raggi" required/>
    <br>
    
    <label for="prezzoEsame" class="elementiForm">Prezzo</label>    
    <input type="text" name="prezzoEsame" id="prezzoEsame" class="elementiForm" placeholder="3,50" required/>
    <br>
    
    <label for="durataEsame" class="elementiForm">Durata</label>
    <input type="text" name="durataEsame" id="durataEsame" class="elementiForm"  placeholder="3" required/>
    <br>
    
    <label for="numPrestazioniSimultanee" class="elementiForm">Numero Prestazioni Simultanee</label>
    <input type="number" name="numPrestazioniSimultanee" id="numPrestazioniSimultanee" class="elementiForm" min="1" max="1000" placeholder="1" required>
    <br>
      
    <label for="descrizioneEsame" class="elementiForm">Descrizione Esame</label>    
    <textarea form="aggiungiEsame" name="descrizioneEsame" id="descrizioneEsame" class="elementiForm" maxlength="200" placeholder="Breve descrizione dell'esame" required></textarea>
    <br>

    <div id="aggiungiEsame" >
        <input type="submit" value="Aggiungi" id="submitAggiungiEsame">
    </div>
    
    <div id="annullaEsame" >
        <input type="button" value="Annulla" id="annullaAggiungiEsame">
    </div>
</form>