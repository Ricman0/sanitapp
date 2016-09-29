<div id="divSideNavBar">
    
    <ul class="sideNavBar" id="sideNavBar">
        {foreach from=$tastiLaterali key=id item=tasto}
            <li><a id="{$id}" href="#">{$tasto}</a></li>
        {/foreach}
    </ul>
    
</div>    
    

<div class="contenutoAreaPersonale" id="contenutoAreaPersonale">
    
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        <h1>Ciao   <h1>
        <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni
                e consultare i referti o, se vuoi, condividerli con il tuo medico curante</p>
    {/if}
    
</div>
