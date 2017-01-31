<h3 class="grigio" >Ricerca clinica</h3>
<hr>
<br>
<form class="form" id="formRicercaCliniche" method="GET">
    <div class="elementiForm" id="elementiFormRicercaCliniche">
        <div class="form" id="inputRicercaCliniche">
            <input type="hidden" name="controller" value="cliniche" id="controllerFormRicercaCliniche"/>        
            <label for="clinica" class="ricerca">Nome Clinica</label>
            <input type="text" name="clinica" class="ricerca" target="_blank" 
                   placeholder="Villa Serena" id="nomeClinicaFormRicercaCliniche"/>
            <label for="luogo" class="ricerca">Luogo</label>
            <input type="text" name="luogo" class="ricerca" target="_blank" 
                   placeholder="Roma" id="luogoClinicaFormRicercaCliniche"/>
            <br>
            <input type="button" class="form" value="Cerca" id="bottoneRicercaCliniche">
            <!--
            <input type="submit" class="form" id="ricercaClinicheCerca" value="Cerca">
            -->
        </div>
    </div>
</form>