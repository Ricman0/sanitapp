<form class="form" id="formRicercaEsami" method="POST">
    <div class="elementiForm" id="elementiFormRicercaEsami">
        <div class="form" id="inputRicercaEsami">
            <input type="hidden" name="controller" value="esami" id="controllerFormRicercaEsami"/> 
            <label for="esame">Nome Esame</label>
            <input type="text" name="esame" class="form"  target="_blank" id="nomeEsameFormRicercaEsami"
                   placeholder="Raggi"/>
            <label for="clinica">Clinica</label>
            <input type="text" name="clinica" class="form" target="_blank" id="nomeClinicaFormRicercaEsami"
                   placeholder="Villa Serena"/>
            <label for="luogo">Luogo</label>
            <input type="text" name="luogo" class="form" target="_blank" id="luogoClinicaFormRicercaEsami"
                   placeholder="Roma"/>
            <input type="button" class="form" id="ricercaEsamiCerca" value="Cerca">
        </div>
    </div>
</form>
