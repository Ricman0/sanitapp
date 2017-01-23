<div id='divAggiungiPrenotazione'>
    {if $tipoUser!== 'clinica'}
    <span class="grassetto">Prenotazione presso la Clinica:</span><span> {$nomeClinica}</span>
    {/if}
    <input type="hidden" id="partitaIVAClinicaPrenotazioneEsame" name="partitaIVAClinicaPrenotazioneEsame" value="{$partitaIVA}" />
    <br><br>
    <span class="grassetto">Prenotazione per l'Esame:</span><span> {$nomeEsame}</span>
    <input type="hidden" id="idEsame" name="idEsame" value="{$idEsame}" />
</div>
<br>
<h3 class="grassetto"> Scegli la data della tua prenotazione: </h3>


<div id="dateEOrariDisponibili">
    <div id="calendarioPrenotazioneEsame" class="affiancato">   
    </div>
    <div id="orariDisponibili" class="affiancato">
        <div id="colonna1" class="colonna"></div>
    </div>
</div>
<br>
<br>
<input type="button" id="nextPrenotazioneEsame" value="next" {if isset($codiceFiscale)} data-codiceFiscale="{$codiceFiscale}"{/if} data-idEsame="{$idEsame}" data-durata="{$durataEsame}" data-idClinica="{$partitaIVA}" data-orario="" data-data="" />