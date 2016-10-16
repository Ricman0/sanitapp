<div>
    <p>Nome Clinica: {$nomeClinica}</p>
    <input type="hidden" name="partitaIVAClinica" value="" />
    <br>
    <p>Nome Esame: {$nomeEsame}</p>
    <input type="hidden" name="idEsame" value="" />
</div>
    <p> Scegli la data della tua prenotazione: </p>
<div id="calendarioPrenotazioneEsame">
    {ldelim} var prenotazioni ={$prenotazioni}; {rdelim}
    {ldelim} var workingPlan ={$workingPlan}; {rdelim}
    {ldelim} var durata ={$durataEsame}; {rdelim}
</div>
<div>
    ciclo per ottenere tutti gli orari
    <!--
    {$workingPlan}  
    {$prenotazioni} -->
</div>
<input type="button" id="nextPrenotazioneEsame" value="next" />