<h3>CATEGORIE DELL'APPLICAZIONE</h3>
<hr>
<br>
<h4>Clicca sull'icona seguente per aggiungere una categoria.</h4>
<br>
<i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiCategoria" aria-hidden="true" ></i>
<br>
{if count($dati)>0}
<h4>Clicca su una riga per eliminare la categoria corrispondente.</h4>
<br>
<table id="tabellaCategorie" class="tablesorter">
    <thead>
    <th>Nome</th> 
</thead>
<tbody>  

    {foreach from=$dati item=curr_row}
        <tr id="{$curr_row['Nome']}" class="rigaCategoria cliccabile">
            <td>{$curr_row['Nome']}</td>
        </tr>
    {/foreach}
</tbody>
</table>
{/if}