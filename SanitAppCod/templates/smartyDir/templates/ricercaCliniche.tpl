<form class="form" id="formRicercaCliniche" method="GET">
    <div class="elementiForm" id="elementiFormRicercaCliniche">
        <div class="form" id="inputRicercaCliniche">
            <input type="hidden" name="controller" value="cliniche" id="controllerFormRicercaCliniche"/>        
            <label for="clinica">Nome Clinica</label>
            <input type="text" name="clinica" class="form" target="_blank" 
                   placeholder="Villa Serena" id="nomeClinicaFormRicercaCliniche"/>
            <label for="luogo">Luogo</label>
            <input type="text" name="luogo" class="form" target="_blank" 
                   placeholder="Roma" id="luogoClinicaFormRicercaCliniche"/>
            <input type="button" class="form" value="Cerca" id="bottoneRicercaCliniche">
            <!--
            <input type="submit" class="form" id="ricercaClinicheCerca" value="Cerca">
            -->
        </div>
    </div>
</form>