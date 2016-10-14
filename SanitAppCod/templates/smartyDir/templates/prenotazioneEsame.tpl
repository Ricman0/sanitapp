<div>
    <p>Nome Clinica: {$nomeClinica}</p>
    <input type="hidden" name="partitaIVAClinica" value="" />
    <br>
    <p>Nome Esame: {$nomeEsame}</p>
    <input type="hidden" name="idEsame" value="" />
</div>
<div id="calendarioPrenotazioneEsame">
    calendario
</div>
<div>
    ciclo per ottenere tutti gli orari
    {$workingPlan}  
    {$prenotazioni}
</div>
<input type="button" id="nextPrenotazioneEsame" value="next" />