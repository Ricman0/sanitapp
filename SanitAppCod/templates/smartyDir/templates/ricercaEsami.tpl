<h4>Ricerca Esame</h4>
<br>
<form id="formRicercaEsami" method="POST">
    <div  id="inputRicercaEsami">
        <input type="hidden" name="controller" value="esami" id="controllerFormRicercaEsami"/> 
        <label for="esame" class="ricerca">Nome Esame</label>
        <input type="text" name="esame" class="ricerca"  target="_blank" id="nomeEsameFormRicercaEsami"
               placeholder="Raggi"/>
        <label for="clinica" class="ricerca">Clinica</label>
        <input type="text" name="clinica" class="ricerca" target="_blank" id="nomeClinicaFormRicercaEsami"
               placeholder="Villa Serena"/>
        <label for="luogo" class="ricerca">Luogo</label>
        <input type="text" name="luogo" class="ricerca" target="_blank" id="luogoClinicaFormRicercaEsami"
               placeholder="Roma"/>
        <br>
        <input type="button" id="ricercaEsamiCerca" value="Cerca">
        
    </div>
</form>
