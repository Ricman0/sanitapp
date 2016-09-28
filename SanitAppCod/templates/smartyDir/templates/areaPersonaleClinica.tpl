<div id="divSideNavBarClinica">
    
    <ul class="sideNavBar" id="sideNavBarClinica">
      <li><a id="serviziAreaPersonaleClinica" href="#">Servizi</a></li>
      <li><a id="prenotazioniAreaPersonaleClinica" href="#">Prenotazioni</a></li>
      <li><a id="refertiAreaPersonaleClinica" class="active" href="#">Referti</a></li>
      <li><a id="clientiAreaPersonaleClinica" href="#">Clienti</a></li>
      <li><a id="impostazioniAreaPersonaleClinica" href="#">Impostazioni</a></li>
    </ul>
    
</div>


<div class="contenutoAreaPersonale" id="contenutoAreaPersonaleClinica">
    
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        <h1>Ciao CLINICA<h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire i servizi, le prenotazioni, 
            i pazienti, i referti e le tue impostazioni.</p>
    {/if}
            
</div>