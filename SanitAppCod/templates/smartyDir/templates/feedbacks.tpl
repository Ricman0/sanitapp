<br><br>
<div>
    {if (is_array($messaggio))}
        {foreach from=$messaggio item=curr_mess}
            <h3>{$curr_mess}</h3>
        {/foreach}
    {else}
        <h3>{$messaggio}</h3>
    {/if}

    {if isset($homePage)}
        <h4>Clicca su ok per andare alla Home Page.</h4>
        <input type="button" class ="homepage" id="tornaHomePageButton"  value="OK" />
    {else}
        <h4>Clicca su ok per tornare alla pagina personale.</h4>
        <input type="button" class="mySanitApp" id="tornaAreaPersonaleButton"  value="OK" />
    {/if}
</div>