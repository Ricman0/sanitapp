<form class="form" id="formRicercaCliniche" method="POST">
    <div class="elementiForm" id="elementiFormRicercaCliniche">
        <div class="form" id="inputRicercaCliniche">
            <input type="hidden" name="controller" value="cliniche"/>        
            <label for="clinica">Nome Clinica</label>
            <input type="text" name="clinica" class="form" target="_blank" 
                   placeholder="Villa Serena"/>
            <label for="luogo">Luogo</label>
            <input type="text" name="luogo" class="form" target="_blank" 
                   placeholder="Roma"/>
            <input type="submit" class="form" id="ricercaClinicheCerca" value="Cerca">
        </div>
    </div>
</form>