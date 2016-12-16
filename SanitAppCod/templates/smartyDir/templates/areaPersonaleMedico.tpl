<div id="divSideNavBarMedico">
    
    <ul class="sideNavBar" id="sideNavBarMedico">
      <li><a id="pazientiAreaPersonaleMedico" >Pazienti</a></li>
      <li><a id="prenotazioniAreaPersonaleMedico" >Prenotazioni</a></li>
      <li><a id="refertiAreaPersonaleMedico" class="active" >Referti</a></li>
      <li><a id="impostazioniAreaPersonaleMedico" >Impostazioni</a></li>
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