<div>
    <p>Nome Clinica: {$nomeClinica}</p>
    <input type="hidden" id="partitaIVAClinicaPrenotazioneEsame" name="partitaIVAClinicaPrenotazioneEsame" value="{$partitaIVA}" />
    <br>
    <p>Nome Esame: {$nomeEsame}</p>
    <input type="hidden" id="idEsame" name="idEsame" value="{$idEsame}" />
</div>
    <p> Scegli la data della tua prenotazione: </p>
<div id="calendarioPrenotazioneEsame">   
</div>
<div id="orariDisponibili">
</div>

<input type="button" id="nextPrenotazioneEsame" value="next" data-idEsame="{$idEsame}" data-idClinica="{$partitaIVA}" data-orario="" data-data="" />