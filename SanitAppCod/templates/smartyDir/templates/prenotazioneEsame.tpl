<div id='divAggiungiPrenotazione'>
    <p class="affiancato">Prenotazione presso la Clinica: {$nomeClinica}</p>
    <input type="hidden" id="partitaIVAClinicaPrenotazioneEsame" name="partitaIVAClinicaPrenotazioneEsame" value="{$partitaIVA}" />
    <p class="affiancato">Prenotazione per l'Esame: {$nomeEsame}</p>
    <input type="hidden" id="idEsame" name="idEsame" value="{$idEsame}" />
</div>
<br>
<p> Scegli la data della tua prenotazione: </p>


<div id="dateEOrariDisponibili">
    <div id="calendarioPrenotazioneEsame" class="affiancato">   
    </div>
    <div id="orariDisponibili" class="affiancato">
        <div id="colonna1" class="colonna"></div>
    </div>
</div>
<br>
<br>
<input type="button" id="nextPrenotazioneEsame" value="next" data-idEsame="{$idEsame}" data-idClinica="{$partitaIVA}" data-orario="" data-data="" />