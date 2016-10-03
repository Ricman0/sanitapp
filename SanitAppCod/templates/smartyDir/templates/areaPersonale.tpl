<div id="divSideNavBarUtente">
    
    <ul class="sideNavBar" id="sideNavBarUtente">
        <li><a id="prenotazioniAreaPersonaleUtente" href="#">Prenotazioni</a></li>
        <li><a id="refertiAreaPersonaleUtente" class="active" href="#">Referti</a></li>
        <li id="pulsanteDropdown">
            <a id="impostazioniAreaPersonaleUtente" href="#">Impostazioni</a>
            <div class="dropside-content">
                <a id="#modificaCredenzialiUtente" href="#">Modifica Credenziali</a>
                <a id="#modificaMedicoCurante" href="#">Modifica Medico Curante</a>
                <a id="#modificaDatiUtente" href="#">Modifica dati personali</a>
            </div>
        </li>
    </ul>
    
</div>    
    

<div class="contenutoAreaPersonale" id="contenutoAreaPersonaleUtente">
    
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        <h1>Ciao   <h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni
                e consultare i referti o, se vuoi, condividerli con il tuo medico curante</p>
    {/if}
    
</div>


