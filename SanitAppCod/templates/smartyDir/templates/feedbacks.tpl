<div>
    {if (is_array($messaggio))}
        {foreach from=$messaggio item=curr_mess}
            <h3>{$curr_mess}</h3>
        {/foreach}
    {else}
        <h3>{$messaggio}</h3>
    {/if}
    <h4>Clicca su ok per tornare alla pagina personale.</h4>
    <input type="button" class="mySanitApp" id="tornaAreaPersonaleButton"  value="OK" />
</div>