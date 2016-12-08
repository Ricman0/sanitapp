<div>
    <h3>{$messaggio}</h3>
    {if isset($homePage)}
        <h4>Clicca su ok per tornare alla Home Page.</h4>
        <input type="button" id="tornaHomePageButton"  value="OK" />
    {else}
        <h4>Clicca su ok per tornare alla pagina personale.</h4>
        <input type="button" id="tornaAreaPersonaleButton"  value="OK" />
    {/if}
</div>