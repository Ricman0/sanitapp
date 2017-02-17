<div id='divAggiungiPrenotazione'>
    <h3>PRENOTAZIONE ESAME</h3>
    <hr>
    <br>
    {if $tipoUser!== 'clinica'}
    <span class="grassetto">PRENOTAZIONE PRESSO LA CLINICA:</span><span> {$nomeClinica}</span>
    <br>
    {/if}
    <input type="hidden" id="partitaIVAClinicaPrenotazioneEsame" name="partitaIVAClinicaPrenotazioneEsame" value="{$partitaIVA}" />
    <span class="grassetto">PRENOTAZIONE PER L'ESAME:</span><span> {$nomeEsame}</span>
    <input type="hidden" id="idEsame" name="idEsame" value="{$idEsame}" />
</div>
<br>
<h3 class="grassetto"> SCEGLI LA DATA DELLA TUA PRENOTAZIONE: </h3>


<div id="dateEOrariDisponibili">
    <div id="calendarioPrenotazioneEsame" class="affiancato">   
    </div>
    <div id="orariDisponibili" class="affiancato">
        <div id="colonna1" class="colonna"></div>
    </div>
</div>
<br>
<br>
<input type="button" id="nextPrenotazioneEsame" value="Next" {if isset($codiceFiscale)} data-codiceFiscale="{$codiceFiscale}"{/if} data-idEsame="{$idEsame}" data-durata="{$durataEsame}" data-idClinica="{$partitaIVA}" data-orario="" data-data="" />