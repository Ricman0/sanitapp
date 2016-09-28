<div id="divSideNavBarMedico">
    
    <ul class="sideNavBar" id="sideNavBarMedico">
      <li><a id="pazientiAreaPersonaleMedico" href="#">Pazienti</a></li>
      <li><a id="prenotazioniAreaPersonaleMedico" href="#">Prenotazioni</a></li>
      <li><a id="refertiAreaPersonaleMedico" class="active" href="#">Referti</a></li>
      <li><a id="impostazioniAreaPersonaleMedico" href="#">Impostazioni</a></li>
    </ul>
    
</div>


<div class="contenutoAreaPersonale" id="contenutoAreaPersonaleMedico">
    
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        <h1>Ciao DOTTORE   <h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire le prenotazioni, 
            i pazienti e i referti.</p>
    {/if}

</div>