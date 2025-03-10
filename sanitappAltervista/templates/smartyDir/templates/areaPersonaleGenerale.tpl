<div class="sideNavBar affiancato verticalmenteAllineato" id="divSideNavBar">
    <ul  id="sideNavBarList">
        {foreach from=$tastiLaterali key=id item=tasto}
            <li><a id="{$id}" >{$tasto}</a></li>
        {/foreach}         
    </ul>   
</div>    

<div class="contenutoAreaPersonale affiancato verticalmenteAllineato " id="contenutoAreaPersonale">
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        {if count($tastiLaterali)==3}
            <br>
            <br>
            <h1>Ciao UTENTE </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni 
                e consultare i referti o,<br> se vuoi, condividerli con il tuo medico curante</p>
        {elseif count($tastiLaterali)==7}
            <br>
            <br>
            <h1>Ciao CLINICA </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire i servizi, le prenotazioni, 
                i pazienti, i referti e le tue impostazioni.</p>
        {else}
            {if isset($tastiLaterali['prenotazioniAreaPersonaleMedico'])}
            <br>
            <br>
                <h1>Ciao DOTTORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire le prenotazioni, 
                i pazienti e i referti.</p>
            {else}
            <br>
                <h1>Ciao AMMINISTRATORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire gli user dell'applicazione</p>
            {/if}
        {/if}        
    {/if}    
</div>
