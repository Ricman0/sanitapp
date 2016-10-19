<div>
    <p class="affiancati">Nome Clinica: {$nomeClinica}</p>
    <input type="hidden" id="partitaIVAClinicaPrenotazioneEsame" name="partitaIVAClinicaPrenotazioneEsame" value="{$partitaIVA}" />
    <p class="affiancati">Nome Esame: {$nomeEsame}</p>
    <input type="hidden" id="idEsame" name="idEsame" value="{$idEsame}" />
</div>
<br>
    <p> Scegli la data della tua prenotazione: </p>
    
    <div id="dateEOrariDisponibili">
<span id="calendarioPrenotazioneEsame" class="affiancati">   
</span>
<span id="orariDisponibili" class="affiancati">
    <div id="colonna1" class="colonna"></div>
</span>
</div>
    <br>
    <br>
<input type="button" id="nextPrenotazioneEsame" value="next" data-idEsame="{$idEsame}" data-idClinica="{$partitaIVA}" data-orario="" data-data="" />