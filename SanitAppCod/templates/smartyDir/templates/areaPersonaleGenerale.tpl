<div class="sideNavBar affiancato verticalmenteAllineato" id="divSideNavBar">
    <ul  id="sideNavBarList">
        {foreach from=$tastiLaterali key=id item=tasto}
            <li><a id="{$id}" >{$tasto}</a>
                {if $tasto=="Impostazioni"}
                    <div class="dropside-content">
                        <a id="modificaCredenzialiUtente" > Modifica Credenziali</a>
                        <a id="modificaMedicoCurante" > Modifica Medico Curante</a>
                        <a id="modificaDatiUtente" > Modifica dati personali</a>
                    </div>
                {/if}
            </li>
        {/foreach}         
    </ul>   
</div>    

<div class="contenutoAreaPersonale affiancato" id="contenutoAreaPersonale">
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        {if count($tastiLaterali)==3}
            <h1>Ciao UTENTE <h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni
                e consultare i referti o, se vuoi, condividerli con il tuo medico curante</p>
        {elseif count($tastiLaterali)==6}
        <h1>Ciao CLINICA <h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire i servizi, le prenotazioni, 
            i pazienti, i referti e le tue impostazioni.</p>
        {else}
        <h1>Ciao DOTTORE   <h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire le prenotazioni, 
            i pazienti e i referti.</p>
        {/if}        
    {/if}    
</div>
