<div id="divSideNavBarUtente">
    
    <ul class="sideNavBar" id="sideNavBarUtente">
        <li><a id="prenotazioniAreaPersonaleUtente" >Prenotazioni</a></li>
        <li><a id="refertiAreaPersonaleUtente" class="active" >Referti</a></li>
        <li id="pulsanteDropdown">
            <a id="impostazioniAreaPersonaleUtente" >Impostazioni</a>
            <div class="dropside-content">
                <a id="#modificaCredenzialiUtente" >Modifica Credenziali</a>
                <a id="#modificaMedicoCurante" >Modifica Medico Curante</a>
                <a id="#modificaDatiUtente" >Modifica dati personali</a>
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


